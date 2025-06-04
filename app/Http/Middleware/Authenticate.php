<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redirige al login adecuado si no está autenticado.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Si es una ruta del área de administración
            if ($request->is('adminSH*')) {
                return route('admin.login');
            }

            // Por defecto (usuarios normales)
            return route('inicio');
        }
    }
}
