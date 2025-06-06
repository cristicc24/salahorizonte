<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sala extends Model
{
    use HasFactory;

    protected $table = 'salas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'numButacasTotales',
        'cantidadColumnas',
        'cantidadFilas',
    ];

    // Relación: una sala tiene muchas sesiones
    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'idSala', 'id');
    }

}
