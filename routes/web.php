<?php

use App\Models\Sesion;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CarteleraController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PeliculaController;
use App\Models\TopPelicula;
use App\Models\Slider;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AdminAuth\AuthenticatedSessionController as AdminLogin;
use App\Http\Controllers\Admin\AdminPeliculaController;
use App\Http\Controllers\ProcesoCompraController;

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


// Admin
Route::prefix('adminSH')->name('admin.')->middleware('admin.session')->group(function () {
    Route::get('login', [AdminLogin::class, 'create'])->name('login');
    Route::post('login', [AdminLogin::class, 'store']);

    
    // Rutas privadas (requieren autenticación como admin)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [AdministradorController::class, 'show'])->name('home');
        Route::get('/peliculas', [AdministradorController::class, 'showPeliculas'])->name('peliculas');
        Route::get('/sesiones', [AdministradorController::class, 'showSesiones'])->name('sesiones');
        Route::get('/salas', [AdministradorController::class, 'showSalas'])->name('salas');
        Route::post('logout', [AdminLogin::class, 'destroy'])->name('logout');

        Route::resource('api/peliculas', AdminPeliculaController::class);
        Route::post('/peliculas', [AdminPeliculaController::class, 'store'])->name('peliculas.store');
        Route::put('/peliculas/{id}', [AdminPeliculaController::class, 'update'])->name('peliculas.update');
        Route::delete('/peliculas/{id}', [AdminPeliculaController::class, 'destroy'])->name('peliculas.destroy');
    });
});

// routes/web.php
Route::get('/sesion/{id}/getMapa', function($id) {
    $mapa = Sesion::getMapa($id);
    return response()->json($mapa);
});

//proceso de compra
Route::get('/compra/asientos', [ProcesoCompraController::class, 'asientos'])->name('procesoCompra.paso1');

Route::get('/compra/resumen', [ProcesoCompraController::class, 'resumen'])->name('procesoCompra.paso2');

Route::get('/compra/pago', [ProcesoCompraController::class, 'pago'])->name('procesoCompra.paso3');

Route::get('/compra/tpv', [ProcesoCompraController::class, 'tpv'])->name('procesoCompra.tpv');

Route::get('/compra/confirmacion', [ProcesoCompraController::class, 'confirmacion'])->name('procesoCompra.paso4');

Route::get('/check-php', function () {
    return response()->json([
        'php_version' => phpversion(),
        'gd_enabled' => extension_loaded('gd'),
        'imagecreatetruecolor' => function_exists('imagecreatetruecolor'),
        'php_ini_loaded' => php_ini_loaded_file(),
    ]);
});
