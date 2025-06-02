<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;

class AdministradorController extends Controller
{
    public function show()
    {
        $administrador = Administrador::first();

        if (!$administrador) {
            return redirect('/')->with('error', 'No se encontró el administrador.');
        }

        return view('admin.dashboard', [
            'administrador' => $administrador
        ]);
    }

}
