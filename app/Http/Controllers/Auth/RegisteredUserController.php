<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phonenumber' => $request->phonenumber ?? null,
            'birthdate' => $request->birthdate ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
