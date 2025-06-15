<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sala;
use Illuminate\Support\Facades\Validator;

class AdminSalaController extends Controller
{
    // Listar salas (vista principal)
    public function index()
    {
        $salas = Sala::withCount('sesiones')->get();

        return view('admin.salas', ['salas' => $salas]);
    }

    // Crear nueva sala
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idSala' => [
                'required',
                'integer',
                'min:1',
                'max:50',
                'unique:salas,idSala',
            ],
            'cantidadFilas' => [
                'required',
                'integer',
                'min:5',
                'max:13',
            ],
            'cantidadColumnas' => [
                'required',
                'integer',
                'min:5',
                'max:13',
            ],
        ], [
            'idSala.required' => 'El ID de sala es obligatorio.',
            'idSala.integer' => 'El ID de sala debe ser un número entero.',
            'idSala.min' => 'El ID de sala debe ser mayor que cero.',
            'idSala.max' => 'El ID de sala no puede ser mayor de 50.',
            'idSala.unique' => 'Ya existe una sala con ese ID.',

            'cantidadFilas.required' => 'La cantidad de filas es obligatoria.',
            'cantidadFilas.integer' => 'La cantidad de filas debe ser un número entero.',
            'cantidadFilas.min' => 'Mínimo 5 filas.',
            'cantidadFilas.max' => 'Máximo 13 filas.',

            'cantidadColumnas.required' => 'La cantidad de columnas es obligatoria.',
            'cantidadColumnas.integer' => 'La cantidad de columnas debe ser un número entero.',
            'cantidadColumnas.min' => 'Mínimo 5 columnas.',
            'cantidadColumnas.max' => 'Máximo 13 columnas.',
        ]);


        if ($validator->fails()) {
            return redirect()->route('admin.salas')
                ->with('createError', $validator->errors()->first())
                ->with('openModal', 'create')
                ->withInput();
        }

        $total = $request->cantidadFilas * $request->cantidadColumnas;

        Sala::create([
            'idSala' => $request->idSala,
            'cantidadFilas' => $request->cantidadFilas,
            'cantidadColumnas' => $request->cantidadColumnas,
            'numButacasTotales' => $total,
        ]);

        return redirect()->route('admin.salas')->with('success', 'Sala creada correctamente.');
    }

    // Actualizar una sala existente
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'idSala' => [
                'required',
                'integer',
                'min:1',
                'max:50',
                'unique:salas,idSala,' . $id, // Ignora la sala actual
            ],
            'cantidadFilas' => [
                'required',
                'integer',
                'min:5',
                'max:13',
            ],
            'cantidadColumnas' => [
                'required',
                'integer',
                'min:5',
                'max:13',
            ],
        ], [
            'idSala.required' => 'El ID de sala es obligatorio.',
            'idSala.integer' => 'El ID de sala debe ser un número entero.',
            'idSala.min' => 'El ID de sala debe ser mayor que cero.',
            'idSala.max' => 'El ID de sala no puede ser mayor de 50.',
            'idSala.unique' => 'Ya existe otra sala con ese ID.',

            'cantidadFilas.required' => 'La cantidad de filas es obligatoria.',
            'cantidadFilas.integer' => 'La cantidad de filas debe ser un número entero.',
            'cantidadFilas.min' => 'Mínimo 5 filas.',
            'cantidadFilas.max' => 'Máximo 13 filas.',

            'cantidadColumnas.required' => 'La cantidad de columnas es obligatoria.',
            'cantidadColumnas.integer' => 'La cantidad de columnas debe ser un número entero.',
            'cantidadColumnas.min' => 'Mínimo 5 columnas.',
            'cantidadColumnas.max' => 'Máximo 13 columnas.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.salas')
                ->with('editError', $validator->errors()->first())
                ->with('openModal', 'edit-' . $id)
                ->withInput();
        }

        $sala = Sala::findOrFail($id);
        $sala->idSala = $request->idSala;
        $sala->cantidadFilas = $request->cantidadFilas;
        $sala->cantidadColumnas = $request->cantidadColumnas;
        $sala->numButacasTotales = $request->cantidadFilas * $request->cantidadColumnas;
        $sala->save();

        return redirect()->route('admin.salas')->with('success', 'Sala actualizada correctamente.');
    }

    // Eliminar una sala
    public function destroy($id)
    {
        $sala = Sala::findOrFail($id);
        $sala->delete(); 
        return redirect()->route('admin.salas')->with('success', 'Sala eliminada correctamente.');
    }
}
