<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class CarteleraController extends Controller
{
    public function show(Request $request)
    {
        $query = Pelicula::query();

        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        if ($request->filled('edad')) {
            $query->where('edad_recomendada', $request->edad);
        }

        if ($request->filled('duracion_min')) {
            $query->where('duracion', '>=', $request->duracion_min);
        }

        if ($request->filled('duracion_max')) {
            $query->where('duracion', '<=', $request->duracion_max);
        }

        $cartelera = $query->paginate(8)->withQueryString();
        $generos = Pelicula::getGenerosDisponibles();
        $edades = Pelicula::getEdadesDisponibles();

        return view('cartelera', compact('cartelera', 'generos', 'edades'));
    }


    
}
