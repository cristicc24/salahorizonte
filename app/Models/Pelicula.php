<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pelicula extends Model
{
    use HasFactory;

    protected $table = 'peliculas';

    protected $fillable = [
        'precio',
        'titulo',
        'genero',
        'directores',
        'edad_recomendada',
        'duracion',
        'fecha_estreno',
        'fecha_emision',
        'sinopsis',
        'foto_grande',
        'actores',
        'enlace_trailer',
        'foto_miniatura',
        'activo'
    ];

    // Relación: una película puede tener muchas sesiones
    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'idPelicula', 'id');
    }


    public static function getPeliculaEspecifica(string $id){
        return DB::table('peliculas')
                    ->where('id', $id)->first();
    }

    public static function getPeliculasRelacionadas(string $generos){
        
        $generosArray = explode(',', $generos);
        $generosArrSinEspacios = array_map('trim', $generosArray);

        $consulta = DB::table('peliculas')
                    ->select(['id', 'titulo', 'foto_miniatura', 'enlace_trailer']);
                
        foreach($generosArrSinEspacios as $index => $genero){
            if($index === 0){
                $consulta->where('genero', 'like', "%$genero%");
            } else{
                $consulta->orWhere('genero', 'like', "%$genero%");
            }
        }

        return $consulta->inRandomOrder() // orden aleatorio
        ->limit(8)        // máximo 8 resultados
        ->get();
    }

    public static function getCartelera(){
        return DB::table('peliculas')
                ->select('*')
                ->get();
    }

    public function getDuracionFormatoAttribute()
    {
        $minutos = (int) $this->duracion;
        $horas = floor($minutos / 60);
        $min = $minutos % 60;
        return "{$horas}h {$min}m";
    }

    public static function getGenerosDisponibles()
    {
        return self::pluck('genero')
            ->flatMap(function ($generos) {
                return array_map('trim', explode(',', $generos));
            })
            ->unique()
            ->sort()
            ->values();
    }


    public static function getEdadesDisponibles()
    {
        return self::select('edad_recomendada')
            ->distinct()
            ->orderBy('edad_recomendada')
            ->pluck('edad_recomendada')
            ->filter()
            ->values();
    }
}
