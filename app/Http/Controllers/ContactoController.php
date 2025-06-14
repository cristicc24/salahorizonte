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
            'nombre' => 'required|string|regex:/^[\pL\s\-]+$/u|max:100',
            'apellidos' => 'required|string|regex:/^[\pL\s\-]+$/u|max:150',
            'telefono' => 'nullable|regex:/^\d{9}$/',
            'email' => 'required|email|max:255',
            'comentario' => 'required|string|min:10|max:1000',
        ]);

        // Enviar correo al usuario
        Mail::to($data['email'])->send(new ConfirmacionUsuarioMail($data));

        // Enviar correo al administrador
        Mail::to('contacto.salahorizonte@gmail.com')->send(new NotificacionAdminMail($data));

        return back()->with('success', 'Tu mensaje ha sido enviado correctamente.');
    }
}
