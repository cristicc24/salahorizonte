<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\TopPelicula;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {

        $sliders = Slider::with('pelicula')
        ->whereHas('pelicula', function ($query) {
            $query->where('activo', true);
        })
        ->get();

        $topPeliculas = TopPelicula::get();

        return view('inicio', [
            'sliders' => $sliders,
            'toppeliculas' => $topPeliculas
        ]);
    }
}
