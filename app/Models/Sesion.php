<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sesion extends Model
{
    use HasFactory;

    protected $table = 'sesiones';

    protected $fillable = [
        'fechaHora',
        'butacasReservadas',
        'numButacasReservadas',
        'idSala',
        'idPelicula',
    ];

    // Relación: una sesión pertenece a una sala
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'idSala', 'id');
    }

    // Relación: una sesión pertenece a una película
    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'idPelicula', 'id');
    }

    // Relación: una sesión puede tener muchas líneas de pedido
    public function lineasPedido()
    {
        return $this->hasMany(LineaPedido::class, 'sesion_id', 'id');
    }
    public static function getSesionesPeliculaEspecifica(string $id){
        return DB::table('sesiones')
                    ->where('idPelicula', $id)
                    ->select('id','idSala', 'fechaHora', 'numButacasReservadas', 'idPelicula')
                    ->get();
    }

    public static function getMapa(string $sesionId) {
        return DB::table('sesiones')
            ->where('id', $sesionId)
            ->select('butacasReservadas')
            ->get()[0]->butacasReservadas;
    }
   
}
