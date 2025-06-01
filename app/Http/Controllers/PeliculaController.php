<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Pelicula;
use Carbon\Carbon;
use function PHPUnit\Framework\returnArgument;

class PeliculaController extends Controller
{
    public function show(string $id) {

        $pelicula = Pelicula::getPeliculaEspecifica($id);
        if($pelicula == false) {
            return redirect('/');
        }
        $peliculasRelacionadas = Pelicula::getPeliculasRelacionadas($pelicula->genero);
        $sesiones = Sesion::getSesionesPeliculaEspecifica($id);
        if($sesiones->isEmpty()) {
            $pelicula->fecha_emision = 'No hay sesiones disponibles';
        } else {
            $pelicula->fecha_emision = $sesiones[0]->fechaHora;
        }
        

        Carbon::setLocale('es');
        $fechaEstreno = Carbon::parse($pelicula->fecha_estreno)->isoFormat('DD MMMM YYYY');
        $fechaEmision = Carbon::parse($pelicula->fecha_emision)->isoFormat('DD MMMM YYYY');
        return view('peliculaEspecifica', [
            'id' => $id,
            'nombrePelicula' => $pelicula->titulo,
            'genero' => $pelicula->genero,
            'foto_grande' => $pelicula->foto_grande,
            'foto_miniatura' => $pelicula->foto_miniatura,
            'precio' => $pelicula->precio,
            'directores' => $pelicula->directores,
            'fecha_estreno' => $fechaEstreno,
            'fecha_emision' => $fechaEmision,
            'duracion' => $pelicula->duracion,
            'actores' => $pelicula->actores,
            'sinopsis' => $pelicula->sinopsis,
            'edad_recomendada' => $pelicula->edad_recomendada,
            'trailer' => $pelicula->enlace_trailer,
            'peliculasRelacionadas' => $peliculasRelacionadas,
            'sesiones' => $sesiones
        ]);
        

    }





}
