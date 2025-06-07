<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;

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

        $butacas = json_decode($request->input('butacas'), true);
        $idSesion = $request->input('idSesion');

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
        $butacas = explode(',', $request->query('butacas', ''));
        $infoPelicula = Sesion::getInfoSesion($idSesion);

        return view('procesoCompra.paso3', compact('infoPelicula', 'butacas'));
    }

    public function tpv(Request $request)
    {
        $idSesion = $request->query('idSesion');
        $butacas = explode(',', $request->query('butacas', ''));
        $metodo = $request->query('metodo', 'tarjeta');
        $infoPelicula = Sesion::getInfoSesion($idSesion);

        return view('procesoCompra.tpv', compact('infoPelicula', 'butacas', 'metodo'));
    }

    public function confirmacion(Request $request)
    {
        $idSesion = $request->query('idSesion');
        $butacas = explode(',', $request->query('butacas', ''));
        $infoPelicula = Sesion::getInfoSesion($idSesion);

        return view('procesoCompra.paso4', compact('infoPelicula', 'butacas'));
    }
}