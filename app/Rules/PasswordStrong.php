<?php

namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class PasswordStrong implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/[a-z]/', $value) &&
               preg_match('/[A-Z]/', $value) &&
               preg_match('/[0-9]/', $value) &&
               preg_match('/[@$!%*#?&]/', $value);
    }

    public function message()
    {
        return 'La contraseña debe tener al menos una mayúscula, una minúscula, un número y un carácter especial.';
    }
}

