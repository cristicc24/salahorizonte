<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peliculas = DB::table('peliculas')
                        ->select('id', 'titulo')
                        ->limit(5)
                        ->get(); 

        foreach ($peliculas as $pelicula) {
            Slider::create([
                'idPelicula' => $pelicula->id,
                'titulo' => $pelicula->titulo,
            ]);
        }
    }
}
