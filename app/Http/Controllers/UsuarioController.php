<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = Auth::user();
        $pedidos = Pedido::with('lineas')->where('user_id', $usuario->id)->get();

        return view('usuario.perfil', compact('usuario', 'pedidos'));
    }
}
