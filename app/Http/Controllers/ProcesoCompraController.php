<?php

namespace App\Http\Controllers;

use App\Mail\EntradaPedidoMail;
use Illuminate\Http\Request;
use App\Models\Sesion;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Pedido;
use App\Models\LineaPedido;
use Str;

class ProcesoCompraController extends Controller
{
    public function asientos(Request $request)
    {
        $idSesion = $request->query('idSesion');
        
        // Validación de estado
        $sesion = Sesion::find($idSesion);
        if (!$sesion || $sesion->estado !== 'Activa') {
            return redirect()->route('cartelera')->with('error', 'Esta sesión ya no está disponible para comprar entradas.');
        }

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

        $idSesion = $request->input('idSesion');

        // Validación de estado
        $sesion = Sesion::find($idSesion);
        if (!$sesion || $sesion->estado !== 'Activa') {
            return redirect()->route('cartelera')->with('error', 'Esta sesión ya no está disponible para comprar entradas.');
        }

        $butacas = $request->input('butacas');
        if (!$this->butacasDisponibles(json_decode($butacas), $sesion)) {
            return redirect()->route('procesoCompra.paso1')->with('error', 'Una o más butacas ya están reservadas...');
        }

        $infoPelicula = Sesion::getInfoSesion($idSesion);

        if (!$infoPelicula || !$butacas) {
            abort(404);
        }

        $total = count(json_decode($butacas)) * $infoPelicula->pelicula->precio;

        return view('procesoCompra.paso2', compact('infoPelicula', 'butacas', 'total', 'idSesion'));
    }


    public function pago(Request $request)
    {
        $idSesion = $request->query('idSesion');

        // Validación de estado
        $sesion = Sesion::find($idSesion);
        if (!$sesion || $sesion->estado !== 'Activa') {
            return redirect()->route('cartelera')->with('error', 'Esta sesión ya no está disponible para comprar entradas.');
        }

        $butacas = $request->input('butacas');
        if (!$this->butacasDisponibles(json_decode($butacas), $sesion)) {
            return redirect()->route('procesoCompra.paso1')->with('error', 'Una o más butacas ya están reservadas...');
        }

        $infoPelicula = Sesion::getInfoSesion($idSesion);

        return view('procesoCompra.paso3', compact('infoPelicula', 'butacas', 'idSesion'));
    }


    public function tpv(Request $request)
    {
        $idSesion = $request->query('idSesion');
        $sesion = Sesion::find($idSesion);

        if (!$sesion || $sesion->estado !== 'Activa') {
            return redirect()->route('cartelera')->with('error', 'Esta sesión ya no está disponible para comprar entradas.');
        }

                $sesion = Sesion::find($idSesion);
        if (!$sesion || $sesion->estado !== 'Activa') {
            return redirect()->route('cartelera')->with('error', 'Esta sesión ya no está disponible para comprar entradas.');
        }

        $butacas = $request->input('butacas');
        if (!$this->butacasDisponibles(json_decode($butacas), $sesion)) {
            return redirect()->route('procesoCompra.paso1')->with('error', 'Una o más butacas ya están reservadas...');
        }

        $butacas = json_decode($request->input('butacas'), true);
        $metodo = $request->query('metodo', 'tarjeta');
        $infoPelicula = Sesion::getInfoSesion($idSesion);
        $total = count($butacas) * $infoPelicula->pelicula->precio;

        return view('procesoCompra.tpv', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $request->input('butacas'),
            'metodo' => $metodo,
            'idSesion' => $idSesion,
            'total' => $total,
        ]);
    }

    public function procesarPago(Request $request)
    {
        $request->validate([
            'idSesion' => 'required|numeric',
            'butacas' => 'required|string',
            'metodo' => 'required|in:tarjeta,bizum,googlepay',
            // Aquí podrías validar también el número de tarjeta, etc.
        ]);

        // Validaciones según método de pago
        switch ($request->metodo) {
            case 'tarjeta':
                $request->validate([
                    'nombre' => ['required', 'regex:/^[\pL\s]+$/u', 'max:255'],
                    'numero' => 'required|digits_between:13,19',
                    'caducidad' => 'required|regex:/^\d{2}\/\d{2}$/',
                    'cvv' => 'required|digits_between:3,4',
                ]);
                $metodo = 'Tarjeta';
                break;
            case 'bizum':
                $request->validate([
                    'telefono' => 'required|digits:9',
                    'pin' => 'required|digits:6',
                ]);
                $metodo = 'Bizum';
                break;
            case 'googlepay':
                // Aquí podrías simular una validación extra si hicieras algo por JavaScript
                $metodo = 'Google play';
                break;
        }

        $idSesion = $request->input('idSesion');
        $sesion = Sesion::find($idSesion);
        if (!$sesion || $sesion->estado !== 'Activa') {
            return redirect()->route('cartelera')->with('error', 'Esta sesión ya no está disponible para comprar entradas.');
        }

        $butacas = $request->input('butacas');
        if (!$this->butacasDisponibles(json_decode($butacas), $sesion)) {
            return redirect()->route('procesoCompra.paso1')->with('error', 'Una o más butacas ya están reservadas...');
        }

        $butacas = json_decode($request->input('butacas'), true);
        $infoPelicula = Sesion::getInfoSesion($idSesion);
        $usuario = auth()->user();
        $total = count($butacas) * $infoPelicula->pelicula->precio;

        // Crear el pedido
        $pedido = Pedido::create([
            'totalPedido' => $total,
            'metodoPago' => $metodo,
            'fechaPago' => now(),
            'user_id' => $usuario->id,
            'hash_confirmacion' => Str::random(64),
        ]);

        foreach ($butacas as $butaca) {
            LineaPedido::create([
                'pedido_id' => $pedido->id,
                'numButaca' => $butaca,
                'sesion_id' => $idSesion,
            ]);
        }

        return redirect()->route('procesoCompra.paso4', ['hash' => $pedido->hash_confirmacion]);
    }

    public function confirmacion(Request $request)
    {
        $hash = $request->query('hash');

        $pedido = Pedido::where('hash_confirmacion', $hash)->first();

        if (!$pedido) {
            abort(403, 'Enlace de confirmación inválido o expirado.');
        }

        $usuario = $pedido->user;
        $lineas = $pedido->lineas; // Asegúrate de tener la relación definida en el modelo
        $butacas = $lineas->pluck('numButaca')->toArray();
        $sesion = $lineas->first()->sesion;
        $infoPelicula = Sesion::getInfoSesion($sesion->id);
        $total = count($butacas) * $infoPelicula->pelicula->precio;

        $filename = null;

        // Solo enviar correo si no se ha enviado aún
        if (!$pedido->email_enviado) {
            // Generar código QR
            $qrContent = "Película: {$infoPelicula->pelicula->titulo}\nSesión: {$infoPelicula->fechaHora}\n";
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
                return back()->with('error', 'No se pudo generar el código QR.');
            }

            // Crear PDF
            $pdf = Pdf::loadView('pdf.entrada', [
                'infoPelicula' => $infoPelicula,
                'butacas' => $butacas,
                'usuario' => $usuario,
                'qrCode' => $qrBase64,
            ]);

            $filename = 'entrada_' . uniqid() . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());

            // Enviar correo
            Mail::to($usuario->email)->send(new EntradaPedidoMail($pedido, $infoPelicula, $butacas, $usuario, $qrBase64));

            // Marcar como enviado
            $pedido->email_enviado = true;

            // Actualizar butacas reservadas
            if ($sesion && is_array($butacas)) {
                $mapa = json_decode($sesion->butacasReservadas, true) ?? [];
                foreach ($butacas as $butaca) {
                    [$fila, $col] = explode('-', $butaca);
                    $mapa[$fila][$col] = true;
                }
                $sesion->butacasReservadas = json_encode($mapa);
                $sesion->numButacasReservadas += count($butacas);
                $sesion->save();
            }
        }

        return view('procesoCompra.paso4', [
            'infoPelicula' => $infoPelicula,
            'butacas' => $butacas,
            'metodo' => $pedido->metodoPago ?? 'Desconocido',
            'pdfPath' => $filename ? asset('storage/' . $filename) : null,
            'total' => $total,
            'idSesion' => $sesion->id
        ]);
    }

    private function butacasDisponibles(array $butacas, $sesion): bool
    {
        $mapa = json_decode($sesion->butacasReservadas, true) ?? [];
        foreach ($butacas as $butaca) {
            [$fila, $col] = explode('-', $butaca);
            if (isset($mapa[$fila][$col]) && $mapa[$fila][$col] === true) {
                return false;
            }
        }
        return true;
    }
}