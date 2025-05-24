<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class CarteleraController extends Controller
{
    public function show(){
        $cartelera = Pelicula::getCartelera();

        return view('cartelera', [
            'cartelera' => $cartelera
        ]);
    }
}
