<?php

use Illuminate\Support\Facades\Route;
use App\Models\Sesion;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\CarteleraController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ProcesoCompraController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AdminAuth\AuthenticatedSessionController as AdminLogin;
use App\Http\Controllers\Admin\AdminPeliculaController;
use App\Http\Controllers\Admin\AdminSesionController;
use App\Http\Controllers\Admin\AdminSalaController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Admin\AdminSmtpController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\InicioController;


require __DIR__.'/auth.php';
     
// ==============================
// RUTAS PÚBLICAS
// ==============================

Route::get('/', [InicioController::class, 'index'])->name('inicio');

Route::get('/registro', [RegistroController::class, 'show'])->name('registro');

Route::get('/pelicula/{id}', [PeliculaController::class, 'show'])->name('pelicula');

Route::get('/contacto', [ContactoController::class, 'show'])->name('contacto');
Route::post('/contacto', [ContactoController::class, 'enviar'])->name('contacto.enviar');

Route::get('/cartelera', [CarteleraController::class, 'show'])->name('cartelera');


// ==============================
// RUTAS DE PROCESO DE COMPRA
// ==============================

Route::get('/compra/asientos', [ProcesoCompraController::class, 'asientos'])->name('procesoCompra.paso1');
Route::get('/compra/resumen', [ProcesoCompraController::class, 'resumen'])->name('procesoCompra.paso2');
Route::get('/compra/pago', [ProcesoCompraController::class, 'pago'])->name('procesoCompra.paso3');
Route::get('/compra/tpv', [ProcesoCompraController::class, 'tpv'])->name('procesoCompra.tpv');
Route::get('/compra/confirmacion', [ProcesoCompraController::class, 'confirmacion'])->name('procesoCompra.paso4');


// ==============================
// RUTA PARA MAPA DE BUTACAS (AJAX)
// ==============================

Route::get('/sesion/{id}/getMapa', function($id) {
    $mapa = Sesion::getMapa($id);
    return response()->json($mapa);
});


// ==============================
// RUTAS ADMINISTRATIVAS
// ==============================

Route::prefix('adminSH')->name('admin.')->middleware('admin.session')->group(function () {

    // LOGIN
    Route::get('login', [AdminLogin::class, 'create'])->name('login');
    Route::post('login', [AdminLogin::class, 'store']);

    // ÁREA PROTEGIDA (ADMIN LOGUEADO)
    Route::middleware('auth:admin')->group(function () {
        
        // DASHBOARD
        Route::get('/', [AdministradorController::class, 'show'])->name('dashboard');

        // LOGOUT
        Route::post('logout', [AdminLogin::class, 'destroy'])->name('logout');

        // VISTAS DEL MENÚ
        Route::get('/peliculas', [AdminPeliculaController::class, 'index'])->name('peliculas');
        Route::get('/sesiones/{idSala?}', [AdminSesionController::class, 'index'])->name('sesiones');
        Route::get('/salas', [AdminSalaController::class, 'index'])->name('salas');
        Route::get('/sliders', [AdminSliderController::class, 'index'])->name('sliders');

        // CRUD PELÍCULAS
        Route::post('/peliculas', [AdminPeliculaController::class, 'store'])->name('peliculas.store');
        Route::put('/peliculas/{id}', [AdminPeliculaController::class, 'update'])->name('peliculas.update');
        Route::delete('/peliculas/{id}', [AdminPeliculaController::class, 'destroy'])->name('peliculas.destroy');
        Route::patch('/peliculas/{id}', [AdminPeliculaController::class, 'toggleActivo'])->name('peliculas.toggleActivo');

        // CRUD SESIONES
        Route::post('/sesiones', [AdminSesionController::class, 'store'])->name('sesiones.store');
        Route::put('/sesiones/{id}', [AdminSesionController::class, 'update'])->name('sesiones.update');
        Route::delete('/sesiones/{id}', [AdminSesionController::class, 'destroy'])->name('sesiones.destroy');

        // CRUD SALAS
        Route::post('/salas', [AdminSalaController::class, 'store'])->name('salas.store');
        Route::put('/salas/{id}', [AdminSalaController::class, 'update'])->name('salas.update');
        Route::delete('/salas/{id}', [AdminSalaController::class, 'destroy'])->name('salas.destroy');

        // CRUD SLIDERS (Carrusel)
        Route::post('/sliders', [AdminSliderController::class, 'store'])->name('sliders.store');
        Route::put('/sliders/{id}', [AdminSliderController::class, 'update'])->name('sliders.update');
        Route::delete('/sliders/{id}', [AdminSliderController::class, 'destroy'])->name('sliders.destroy');
        
        // RU SMTP (Read & Update)
        Route::get('/smtp', [AdminSmtpController::class, 'show'])->name('smtp.show');
        Route::put('/smtp', [AdminSmtpController::class, 'update'])->name('smtp.update');
    });
});

// ==============================
// RUTAS PERFIL USUARIO
// ==============================

Route::middleware(['auth'])->group(function () {
    Route::get('/usuario/perfil', [UsuarioController::class, 'index'])->name('usuario.perfil');
});
