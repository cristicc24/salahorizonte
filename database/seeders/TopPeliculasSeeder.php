<?php

namespace Database\Seeders;

use App\Models\Pelicula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TopPelicula;

class TopPeliculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peliculas = Pelicula::activas()
                ->select('id')
                ->limit(7)
                ->get();

        foreach ($peliculas as $pelicula) {
            TopPelicula::create([
                'idPelicula' => $pelicula->id
            ]);
        }
    }
}
