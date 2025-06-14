<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Recuperar la URL anterior del campo oculto (o redirigir a '/')
        $previousUrl = $request->input('previous_url', '/');

        if(str_contains($previousUrl, 'registro'))
            return redirect()->to('/');
        else
            return redirect()->to($previousUrl);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        // Solo eliminar la sesión del usuario, no invalidar toda la sesión (para no cerrar admin)
        $request->session()->forget(['_login_web_'.Auth::id(), 'user']);
        $request->session()->regenerateToken();
        return redirect()->to(url()->previous());
    }
}
