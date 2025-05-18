<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeliculaController extends Controller
{
    public function show(string $id) {

        $pelicula = DB::table('peliculas')->where('id', $id)->first();

        if($pelicula == false) {
            return redirect('/');
        }

        Carbon::setLocale('es');
        $fecha = Carbon::parse($pelicula->fecha_estreno)->isoFormat('DD MMMM YYYY');
        return view('peliculaEspecifica', [
            'id' => $id,
            'nombrePelicula' => $pelicula->titulo,
            'genero' => $pelicula->genero,
            'foto_grande' => $pelicula->foto_grande,
            'foto_miniatura' => $pelicula->foto_miniatura,
            'precio' => $pelicula->precio,
            'directores' => $pelicula->directores,
            'fecha_estreno' => $fecha,
            'duracion' => $pelicula->duracion,
            'actores' => $pelicula->actores,
            'sinopsis' => $pelicula->sinopsis,
            'edad_recomendada' => $pelicula->edad_recomendada,
            'trailer' => $pelicula->enlace_trailer
        ]);
    }

}
