<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;
use App\Models\Pelicula;

class AdministradorController extends Controller
{
   public function show()
    {
        return view('admin.dashboard', [
            'title' => 'Inicio | Sala Horizonte',
            'administrador' => auth()->guard('admin')->user(),
        ]);
    }

    public function showPeliculas()
    {
        $peliculas = Pelicula::all();
        return view('admin.peliculas', [
            'peliculas' => $peliculas,
            'title' => 'Películas | Sala Horizonte',
            'administrador' => auth()->guard('admin')->user(),
        ]);
    }

    public function showSalas()
    {
        $salas = \App\Models\Sala::all();

        return view('admin.salas', ['salas' => $salas]);
    }

   
}
