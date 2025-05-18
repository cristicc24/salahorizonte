<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientePelicula extends Pivot
{
    protected $table = 'clientes_peliculas';

    protected $fillable = [
        'idCliente',
        'idPelicula',
        'estrellas',
        'comentario',
    ];

    public $timestamps = true;
}
