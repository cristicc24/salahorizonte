<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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

        return view('procesoCompra.paso2', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
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

        return view('procesoCompra.tpv', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
            'metodo' => $metodo,
        ]);
    }

    public function confirmacion(Request $request)
    {
        $idSesion = $request->query('idSesion');
        $butacas = $request->input('butacas');
        $metodo = $request->query('metodo');
        $usuario = auth()->user();

        $infoPelicula = Sesion::getInfoSesion($idSesion);

        if (is_string($butacas)) {
            $decoded = json_decode($butacas, true);
            $butacas = is_array($decoded) ? $decoded : [$butacas];
        }

        $qrContent = "Película: {$infoPelicula->titulo}\nSesión: {$infoPelicula->fechaHora}\n";
        if ($usuario) {
            $qrContent .= "Usuario: {$usuario->name} ({$usuario->email})\n";
        }

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
            'qrCode' => $qrBase64,//$qrCode
        ]);

        $filename = 'entrada_' . uniqid() . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return view('procesoCompra.paso4', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
            'metodo' => $metodo,
            'pdfPath' => asset('storage/' . $filename),
        ]);
    }
}