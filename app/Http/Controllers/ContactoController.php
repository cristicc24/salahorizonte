<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
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

        // Enviar el correo
        Mail::send('emails.contenidoCorreo', $data, function ($message) use ($data) {
            $message->to('cristinacabreracarrillo@gmail.com') 
                    ->cc('ariolop154@gmail.com')
                    ->subject('Nuevo mensaje de contacto');
        });
        return back()->with('success', 'Mensaje enviado correctamente.');
    }
}
