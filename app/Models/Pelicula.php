<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'sinopsis',
        'foto_grande',
        'actores',
        'enlace_trailer',
        'foto_miniatura'
    ];

    // Relación: una película puede tener muchas sesiones
    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'idPelicula', 'id');
    }

    // Relación: una película puede ser valorada por muchos clientes
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_peliculas', 'pelicula_id', 'cliente_id')
                    ->withPivot('estrellas', 'comentario')
                    ->withTimestamps();
    }
}
