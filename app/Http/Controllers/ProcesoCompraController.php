<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Pedido;
use App\Models\LineaPedido;

class ProcesoCompraController extends Controller
{
    public function asientos(Request $request)
    {
        $idSesion = $request->query('idSesion');
        $infoPelicula = Sesion::getInfoSesion($idSesion);

        return view('procesoCompra.paso1', [
            'infoPelicula' => $infoPelicula,
            'idSesion' => $idSesion,
        ]);
    }

    public function resumen(Request $request)
    {
        $request->validate([
            'idSesion' => 'required|numeric',
            'butacas' => 'required|string',
        ]);

        //$butacas = json_decode($request->input('butacas'), true);
        $idSesion = $request->input('idSesion');
        $butacas = $request->input('butacas');

        $infoPelicula = Sesion::getInfoSesion($idSesion);

        if (!$infoPelicula || !$butacas) {
            abort(404);
        }

        $total = count(json_decode($butacas)) * $infoPelicula->precio;

        return view('procesoCompra.paso2', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
            'total' => $total
        ]);
    }

    public function pago(Request $request)
    {
        $idSesion = $request->query('idSesion');
        $butacas = $request->input('butacas');

        $infoPelicula = Sesion::getInfoSesion($idSesion);

        return view('procesoCompra.paso3', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
        ]);
    }

    public function tpv(Request $request)
    {
        $idSesion = $request->query('idSesion');
        $butacas = $request->input('butacas');

        $metodo = $request->query('metodo', 'tarjeta');
        $infoPelicula = Sesion::getInfoSesion($idSesion);

        // SE CREAN EL PEDIDO Y LAS LINEAS DE PEDIDO
        $usuario = auth()->user();
        $total = count(json_decode($butacas))* $infoPelicula->precio;
        
        $pedido = Pedido::create([
            'totalPedido' => $total,
            'metodoPago' => null,
            'fechaPago' => now(),
            'user_id' => $usuario->id,
        ]);

        // Guardar líneas de pedido por butaca
        foreach (json_decode($butacas) as $butaca) {
            LineaPedido::create([
                'pedido_id' => $pedido->id,
                'numButaca' => $butaca, 
                'sesion_id' => $idSesion,
            ]);
        }

        $orderID = $pedido->id;

        return view('procesoCompra.tpv', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
            'metodo' => $metodo,
            'orderID' => $orderID
        ]);
    }

    public function confirmacion(Request $request)
    {
        $idSesion = $request->query('idSesion');
        $butacas = $request->input('butacas');
        $orderID = $request->input('orderID');
        
        $metodo = $request->query('metodo');

        $usuario = auth()->user();

        $infoPelicula = Sesion::getInfoSesion($idSesion);

        if (is_string($butacas)) {
            $decoded = json_decode($butacas, true);
            $butacas = is_array($decoded) ? $decoded : [$butacas];
        }

        $qrContent = "Película: {$infoPelicula->titulo}\nSesión: {$infoPelicula->fechaHora}\n";
        $qrContent .= "Usuario: {$usuario->name} ({$usuario->email})\n";


        try {
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($qrContent)
                ->size(200)
                ->margin(10)
                ->build();
            $qrBase64 = base64_encode($result->getString());
        } catch (\Throwable $e) {
            dd('QR Generation failed: ' . $e->getMessage());
        }

        // Guardar PDF en storage/app/public/
        $pdf = Pdf::loadView('pdf.entrada', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
            'usuario' => $usuario,
            'qrCode' => $qrBase64,
        ]);

        $filename = 'entrada_' . uniqid() . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        //Actualizar el metodo de pago del pedido
        if ($orderID && $metodo) {
            $pedido = Pedido::find($orderID);
            if ($pedido) {
                $pedido->metodoPago = $metodo;
                $pedido->save();
            }
        }

        $total = count($butacas) * $infoPelicula->precio;

        // Actualizar mapa de butacas reservadas
        $sesion = Sesion::find($idSesion);

        if ($sesion && is_array($butacas)) {
            $mapa = json_decode($sesion->butacasReservadas, true);

            foreach ($butacas as $butaca) {
                [$fila, $col] = explode('-', $butaca); // por ejemplo "A-5"
                if (!isset($mapa[$fila])) {
                    $mapa[$fila] = [];
                }
                $mapa[$fila][$col] = true;
            }

            $sesion->butacasReservadas = json_encode($mapa);
            $sesion->numButacasReservadas += count($butacas);
            $sesion->save();
        }

        return view('procesoCompra.paso4', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
            'metodo' => $metodo,
            'pdfPath' => asset('storage/' . $filename),
            'total' => $total
        ]);
    }
}