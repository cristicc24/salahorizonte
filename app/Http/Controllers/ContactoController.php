<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionUsuarioMail;
use App\Mail\NotificacionAdminMail;

class ContactoController extends Controller
{

    public function show()
    {
        return view('contacto');
    }

    public function enviar(Request $request)
    {
        // Validar el formulario
        $data = $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'telefono' => 'required|string',
            'email' => 'required|email',
            'comentario' => 'required|string',
        ]);

        // Enviar correo al usuario
        Mail::to($data['email'])->send(new ConfirmacionUsuarioMail($data));

        // Enviar correo al administrador
        Mail::to('contacto@salahorizonte.com')->send(new NotificacionAdminMail($data));

        return back()->with('success', 'Tu mensaje ha sido enviado correctamente.');
    }
}
