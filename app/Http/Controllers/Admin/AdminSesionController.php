<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Sesion;
use App\Models\Pelicula;
use App\Models\Sala;
use Illuminate\Support\Facades\Validator;

class AdminSesionController extends Controller
{
    public function index($idSala = null)
    {
        $query = Sesion::with(['pelicula', 'sala']);

        if ($idSala) {
            $query->where('idSala', $idSala);
        }

        $query->orderBy('fechaHora', 'desc');

        $sesiones = $query->get();
        $peliculas = Pelicula::all();
        $salas = Sala::all();

        return view('admin.sesiones', [
            'sesiones' => $sesiones,
            'peliculas' => $peliculas,
            'salas' => $salas,
            'title' => 'Sesiones | Sala Horizonte',
            'administrador' => auth()->guard('admin')->user(),
            'salaSeleccionada' => $idSala,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idPelicula' => 'required|integer|exists:peliculas,id',
            'idSala' => 'required|integer|exists:salas,id',
            'fechaHora' => 'required|date_format:Y-m-d\TH:i|after_or_equal:now',
        ], [
            'idPelicula.required' => 'Debe seleccionar una película.',
            'idPelicula.integer' => 'La película seleccionada no es válida.',
            'idPelicula.exists' => 'La película seleccionada no existe.',

            'idSala.required' => 'Debe seleccionar una sala.',
            'idSala.integer' => 'La sala seleccionada no es válida.',
            'idSala.exists' => 'La sala seleccionada no existe.',

            'fechaHora.required' => 'Debe ingresar una fecha y hora.',
            'fechaHora.date_format' => 'El formato de la fecha y hora no es válido.',
            'fechaHora.after_or_equal' => 'La fecha y hora deben ser iguales o posteriores a la actual.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.sesiones')
                ->with('createError', $validator->errors()->first())
                ->with('openModal', 'create')
                ->withInput();
        }

        $nuevaFechaHora = Carbon::parse($request->fechaHora);
        $pelicula = Pelicula::findOrFail($request->idPelicula);
        $duracionEnMinutos = Sesion::parseDuracionEnMinutos($pelicula->duracion);

        $inicioPropuesta = $nuevaFechaHora->copy()->subMinutes(15);
        $finPropuesta = $nuevaFechaHora->copy()->addMinutes($duracionEnMinutos + 15);

        $conflictos = Sesion::where('idSala', $request->idSala)
            ->with('pelicula')
            ->get()
            ->filter(function ($sesion) use ($inicioPropuesta, $finPropuesta) {
                $inicioSesion = Carbon::parse($sesion->fechaHora);
                $duracionSesion = Sesion::parseDuracionEnMinutos($sesion->pelicula->duracion);
                $finSesion = $inicioSesion->copy()->addMinutes($duracionSesion);

                return $finSesion->gt($inicioPropuesta) && $inicioSesion->lt($finPropuesta);
            });

        if ($conflictos->isNotEmpty()) {
            return redirect()->route('admin.sesiones')
                ->with('createError', 'Ya existe una sesión en esa sala demasiado próxima en el tiempo.')
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
        $sesion = Sesion::findOrFail($id);

        if ($sesion->estado !== 'Activa') {
            return redirect()->route('admin.sesiones')
                ->with('editError', 'No se puede editar esta sesión porque ya ha comenzado o finalizado.')
                ->with('openModal', 'edit-' . $id);
        }

        $validator = Validator::make($request->all(), [
            'idPelicula' => 'required|integer|exists:peliculas,id',
            'idSala' => 'required|integer|exists:salas,id',
            'fechaHora' => 'required|date_format:Y-m-d\TH:i|after_or_equal:now',
        ], [
            'idPelicula.required' => 'Debe seleccionar una película.',
            'idPelicula.integer' => 'La película seleccionada no es válida.',
            'idPelicula.exists' => 'La película seleccionada no existe.',

            'idSala.required' => 'Debe seleccionar una sala.',
            'idSala.integer' => 'La sala seleccionada no es válida.',
            'idSala.exists' => 'La sala seleccionada no existe.',

            'fechaHora.required' => 'Debe ingresar una fecha y hora.',
            'fechaHora.date_format' => 'El formato de la fecha y hora no es válido.',
            'fechaHora.after_or_equal' => 'La fecha y hora deben ser iguales o posteriores a la actual.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.sesiones')
                ->with('editError', $validator->errors()->first())
                ->with('openModal', 'edit-' . $id)
                ->withInput();
        }

        $nuevaFechaHora = Carbon::parse($request->fechaHora);
        $pelicula = Pelicula::findOrFail($request->idPelicula);
        $duracionEnMinutos = Sesion::parseDuracionEnMinutos($pelicula->duracion);

        $inicioPropuesta = $nuevaFechaHora->copy()->subMinutes(15);
        $finPropuesta = $nuevaFechaHora->copy()->addMinutes($duracionEnMinutos + 15);

        $conflictos = Sesion::where('idSala', $request->idSala)
            ->where('id', '!=', $id)
            ->with('pelicula')
            ->get()
            ->filter(function ($otraSesion) use ($inicioPropuesta, $finPropuesta) {
                $inicio = Carbon::parse($otraSesion->fechaHora);
                $duracion = Sesion::parseDuracionEnMinutos($otraSesion->pelicula->duracion);
                $fin = $inicio->copy()->addMinutes($duracion);

                return $fin->gt($inicioPropuesta) && $inicio->lt($finPropuesta);
            });

        if ($conflictos->isNotEmpty()) {
            return redirect()->route('admin.sesiones')
                ->with('editError', 'Existe una sesión en esa sala demasiado próxima en el tiempo.')
                ->with('openModal', 'edit-' . $id)
                ->withInput();
        }

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
