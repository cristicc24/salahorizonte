<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Sesion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Pagination\LengthAwarePaginator;

class CarteleraController extends Controller
{
    public function show(Request $request)
    {
        $hoy = now();
        $fin = now()->addDays(4);

        // 1. Cargamos todas las películas con sus sesiones en el rango dado
        $peliculas = Pelicula::with(['sesiones' => function ($q) use ($hoy, $fin) {
            $q->whereBetween('fechaHora', [$hoy, $fin])
            ->orderBy('fechaHora');
        }]);

        // 2. Filtros
        if ($request->filled('buscar')) {
            $peliculas->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('genero')) {
            $peliculas->where('genero', 'like', '%' . $request->genero . '%');
        }

        if ($request->filled('edad')) {
            $peliculas->where('edad_recomendada', $request->edad);
        }

        $peliculas = $peliculas->get();

        // 3. Filtrar solo películas con sesiones activas (según duración real)
        $filtradas = $peliculas->filter(function ($pelicula) {
            return $pelicula->sesiones->contains(function ($sesion) {
                return $sesion->estado === 'Activa';
            });
        });

        // 4. Filtro por día (opcional)
        if ($request->filled('dia')) {
            $fecha = Carbon::parse($request->dia)->toDateString();

            $filtradas = $filtradas->filter(function ($pelicula) use ($fecha) {
                return $pelicula->sesiones->contains(function ($sesion) use ($fecha) {
                    return $sesion->estado === 'Activa' &&
                        Carbon::parse($sesion->fechaHora)->toDateString() === $fecha;
                });
            });
        }

        // 5. Paginar manualmente (ya que es colección)
        $porPagina = 8;
        $pagina = request('page', 1);
        $items = $filtradas->forPage($pagina, $porPagina)->values();
        $cartelera = new LengthAwarePaginator(
            $items,
            $filtradas->count(),
            $porPagina,
            $pagina,
            ['path' => request()->url(), 'query' => request()->query()]
        );        
        $generos = Pelicula::getGenerosDisponibles();
        $edades = Pelicula::getEdadesDisponibles();

        return view('cartelera', compact('cartelera', 'generos', 'edades'));
    }
}
