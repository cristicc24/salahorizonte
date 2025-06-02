<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CarteleraController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PeliculaController;
use App\Models\TopPelicula;
use App\Models\Slider;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AdminAuth\AuthenticatedSessionController as AdminLogin;


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
    Route::get('/', function () {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    })->name('home'); // Puedes nombrar esta ruta si quieres

    Route::get('login', [AdminLogin::class, 'create'])->name('login');
    Route::post('login', [AdminLogin::class, 'store']);
    Route::post('logout', [AdminLogin::class, 'destroy'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });
});

Route::get('/admin/dashboard', [AdministradorController::class, 'show'])->name('admin.dashboard');

// routes/web.php
Route::get('/sesion/{id}/ocupados', function($id) {
    $ocupados = \DB::table('lineas_pedido')
        ->where('sesion_id', $id)
        ->pluck('numButaca');
    return response()->json($ocupados);
});
