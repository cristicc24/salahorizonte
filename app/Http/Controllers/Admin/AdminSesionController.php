<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sesion;
use App\Models\Pelicula;
use App\Models\Sala;

class AdminSesionController extends Controller
{
    public function index()
    {
        $sesiones = Sesion::with(['pelicula', 'sala'])->get();
        $peliculas = Pelicula::all();
        $salas = Sala::all();

        return view('admin.sesiones', [
            'sesiones' => $sesiones, 
            'peliculas' => Pelicula::all(),
            'salas' => Sala::all(),
            'title' => 'Sesiones | Sala Horizonte',
            'administrador' => auth()->guard('admin')->user(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idPelicula' => 'required|exists:peliculas,id',
            'idSala' => 'required|exists:salas,id',
            'fechaHora' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $sala = Sala::findOrFail($request->idSala);
        // Generar butacas matriz
        $butacas = [];
        $filas = range('A', chr(ord('A') + $sala->cantidadFilas - 1));
        for ($i = 0; $i < count($filas); $i++) {
            $filaLetra = $filas[$i];
            $butacas[$filaLetra] = [];
            for ($col = 1; $col <= $sala->cantidadColumnas; $col++) {
                $butacas[$filaLetra][$col] = false;
            }
        }

        Sesion::create([
            'idPelicula' => $request->idPelicula,
            'idSala' => $request->idSala,
            'fechaHora' => $request->fechaHora,
            'butacasReservadas' => json_encode($butacas), //convertir a JSON
            'numButacasReservadas' => 0,
        ]);

        return redirect()->route('admin.sesiones')->with('success', 'Sesión creada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idPelicula' => 'required|exists:peliculas,id',
            'idSala' => 'required|exists:salas,id',
            'fechaHora' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $sesion = Sesion::findOrFail($id);
        $sesion->update($request->only('idPelicula', 'idSala', 'fechaHora'));

        return redirect()->route('admin.sesiones')->with('success', 'Sesión actualizada correctamente.');
    }

    public function destroy($id)
    {
        $sesion = Sesion::findOrFail($id);
        $sesion->delete();

        return redirect()->route('admin.sesiones')->with('success', 'Sesión eliminada correctamente.');
    }
}

