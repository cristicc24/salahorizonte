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
            'idSala' => 'required|integer|min:1|unique:salas,idSala',
            'cantidadFilas' => 'required|integer|min:1|max:13',
            'cantidadColumnas' => 'required|integer|min:1|max:13',
        ], [
            'idSala.unique' => 'El ID de sala ya existe.',
            'idSala.min' => 'El ID de sala debe ser mayor que cero.',
            'cantidadFilas.max' => 'Máximo 13 filas.',
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
            'cantidadFilas' => 'required|integer|min:1|max:13',
            'cantidadColumnas' => 'required|integer|min:1|max:13',
        ], [
            'cantidadFilas.max' => 'Máximo 13 filas.',
            'cantidadColumnas.max' => 'Máximo 13 columnas.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.salas')
                ->with('editError', $validator->errors()->first())
                ->with('openModal', 'edit-' . $id)
                ->withInput();
        }

        $sala = Sala::findOrFail($id);
        $sala->cantidadFilas = $request->cantidadFilas;
        $sala->cantidadColumnas = $request->cantidadColumnas;
        $sala->numButacasTotales = $request->cantidadFilas * $request->cantidadColumnas;
        $sala->save();

        return redirect()->route('admin.salas')->with('success', 'Sala actualizada correctamente.');
    }

    // Eliminar una sala
    public function destroy($id)
    {
        $sala = Sala::findOrFail($id); // Ya no necesitas `withCount`

        $sala->delete(); // Esto eliminará también sus sesiones por cascada

        return redirect()->route('admin.salas')->with('success', 'Sala eliminada correctamente.');
    }

}
