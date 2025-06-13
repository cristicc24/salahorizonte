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
            $query->where('genero', 'like', '%' . $request->genero . '%');
        }

        if ($request->filled('edad')) {
            $query->where('edad_recomendada', $request->edad);
        }

        $cartelera = $query->paginate(8)->withQueryString();
        $generos = Pelicula::getGenerosDisponibles();
        $edades = Pelicula::getEdadesDisponibles();

        return view('cartelera', compact('cartelera', 'generos', 'edades'));
    }


    
}
