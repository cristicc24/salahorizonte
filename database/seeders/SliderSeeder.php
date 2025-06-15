<?php

namespace Database\Seeders;

use App\Models\Pelicula;
use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ids = [24, 43, 34, 32, 28]; 

        $peliculas = Pelicula::activas()
            ->select('id', 'titulo')
            ->whereIn('id', $ids)
            ->get();

        foreach ($peliculas as $pelicula) {
            Slider::create([
                'idPelicula' => $pelicula->id,
                'titulo' => $pelicula->titulo,
            ]);
        }
    }
}
