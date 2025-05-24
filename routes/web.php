<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CarteleraController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PeliculaController;
use App\Models\TopPelicula;
use App\Models\Slider;

require __DIR__.'/auth.php';

Route::get('/', function () {
    $sliders = Slider::get();
    $topPeliculas = TopPelicula::get();
    return view('inicio', ['sliders'=>$sliders, 'toppeliculas'=>$topPeliculas]);
})->name('inicio');

Route::get('/registro', function () {
    return view('registro');
})->name('registro');

Route::get('/pelicula/{id}', [PeliculaController::class, 'show']);

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::get('/footer', function () {
    return view('footer');
})->name('footer');

Route::post('/contacto', [ContactoController::class, 'enviar'])->name('contacto.enviar');

Route::get('/cartelera', [CarteleraController::class, 'show'])->name('cartelera');

