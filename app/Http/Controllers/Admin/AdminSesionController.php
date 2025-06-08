<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sesion;
use App\Models\Pelicula;
use App\Models\Sala;
use Illuminate\Support\Facades\Validator;


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
        $validator = Validator::make($request->all(), [
            'idPelicula' => 'required|exists:peliculas,id',
            'idSala' => 'required|exists:salas,id',
            'fechaHora' => 'required|date_format:Y-m-d\TH:i',
        ], [
            'idPelicula.required' => 'La película es obligatoria.',
            'idSala.required' => 'La sala es obligatoria.',
            'fechaHora.required' => 'La fecha y hora es obligatoria.',
            'fechaHora.date_format' => 'El formato de fecha y hora no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.sesiones')
                ->with('createError', $validator->errors()->first())
                ->with('openModal', 'create')
                ->withInput();
        }

        $sala = Sala::findOrFail($request->idSala);

        $butacas = [];
        $filas = range('A', chr(ord('A') + $sala->cantidadFilas - 1));
        foreach ($filas as $filaLetra) {
            $butacas[$filaLetra] = [];
            for ($col = 1; $col <= $sala->cantidadColumnas; $col++) {
                $butacas[$filaLetra][$col] = false;
            }
        }

        Sesion::create([
            'idPelicula' => $request->idPelicula,
            'idSala' => $request->idSala,
            'fechaHora' => $request->fechaHora,
            'butacasReservadas' => json_encode($butacas),
            'numButacasReservadas' => 0,
        ]);

        return redirect()->route('admin.sesiones')->with('success', 'Sesión creada correctamente.');
    }


    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'idPelicula' => 'required|exists:peliculas,id',
            'idSala' => 'required|exists:salas,id',
            'fechaHora' => 'required|date_format:Y-m-d\TH:i',
        ], [
            'idPelicula.required' => 'La película es obligatoria.',
            'idSala.required' => 'La sala es obligatoria.',
            'fechaHora.required' => 'La fecha y hora es obligatoria.',
            'fechaHora.date_format' => 'El formato de fecha y hora no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.sesiones')
                ->with('editError', $validator->errors()->first())
                ->with('openModal', 'edit-' . $id)
                ->withInput();
        }

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

