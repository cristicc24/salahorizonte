<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistroExitosoMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Rules\PasswordStrong;
use Mail;

class RegisteredUserController extends Controller
{
    public function show()
    {
        return view('registro');
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //dd('PdfController / store()', $request->all());
        $request->merge([
            'email' => strtolower($request->input('email')),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phonenumber' => ['nullable', 'string', 'max:9'],
            'birthdate' => ['nullable', 'date'],
            'email_registro' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class . ',email'],
            'password_registro' => ['required', 'confirmed', 'min:8', new PasswordStrong],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phonenumber' => $request->phonenumber ?? null,
            'birthdate' => $request->birthdate ?? null,
            'email' => $request->email_registro,
            'password' => Hash::make($request->password_registro),
        ]);


        event(new Registered($user));

        Auth::login($user);
        Mail::to($user->email)->send(new RegistroExitosoMail($user));

        return redirect('/')->with('status', 'Registro completado. ¡Bienvenido!');
    }
}
