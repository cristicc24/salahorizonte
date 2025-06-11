<?php

namespace Database\Seeders;

use App\Models\Administrador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class AdministradoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrador::create([
                'nombre' => 'Cristina',
                'apellidos' => 'Cabrera',
                'email' => 'admin@salahorizonte.com',
                'password' => Hash::make('12345678'), // cámbialo luego en producción
                // añade aquí cualquier campo adicional como 'role' si lo tienes
            ]);
    }
}
