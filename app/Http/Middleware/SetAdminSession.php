<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class SetAdminSession
{
    public function handle($request, Closure $next)
    {
        // Usar la configuración completa de admin_session
        foreach (config('admin_session') as $key => $value) {
            \Config::set('session.' . $key, $value);
        }
        return $next($request);
    }
}
