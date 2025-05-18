<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'contrasena',
        'correo',
    ];

    protected $hidden = [
        'contrasena'
    ];

    // Relación: un cliente puede hacer muchos pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cliente_id', 'id');
    }

    // Relación: un cliente puede valorar muchas películas
    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class, 'clientes_peliculas', 'cliente_id', 'pelicula_id')
                    ->withPivot('estrellas', 'comentario')
                    ->withTimestamps();
    }
}
