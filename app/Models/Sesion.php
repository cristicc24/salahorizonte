<?php

namespace App\Models;

use Carbon\CarbonTimeZone;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
    public static function getSesionesPeliculaEspecifica(string $id)
    {
        return DB::table('sesiones')
            ->join('salas', 'sesiones.idSala', '=', 'salas.id')
            ->join('peliculas', 'sesiones.idPelicula', '=', 'peliculas.id')
            ->where('sesiones.idPelicula', $id)
            ->select(
                'sesiones.id',
                'salas.idSala',
                'sesiones.fechaHora',
                'sesiones.numButacasReservadas',
                'sesiones.idPelicula',
                'salas.numButacasTotales',
                'peliculas.duracion',
                DB::raw("CASE
                WHEN NOW() < sesiones.fechaHora THEN 'Activa'
                WHEN NOW() BETWEEN sesiones.fechaHora AND (sesiones.fechaHora + (peliculas.duracion || ' minutes')::interval) THEN 'En curso'
                ELSE 'Finalizada'
                END as estado")
            )
            ->get();
    }


    public static function getMapa(string $sesionId) {
        return DB::table('sesiones')
            ->where('id', $sesionId)
            ->select('butacasReservadas')
            ->first()->butacasReservadas;
    }

    public static function getInfoSesion(string $sesionId) {
        return DB::table('sesiones')
            ->leftJoin('Peliculas', 'sesiones.idPelicula', '=', 'Peliculas.id')
            ->leftJoin('Salas', 'sesiones.idSala', '=', 'Salas.id')
            ->where('sesiones.id', $sesionId)
            ->select('*')    
            ->first();
    }
   
    // Crea un campo calculado en el Model Sesión (como si estuviera en BD, pero no se guarda)
    public function getEstadoAttribute()
    {
        $ahora = Carbon::now(new CarbonTimeZone(env('APP_TIMEZONE')));
        $inicio = Carbon::parse($this->fechaHora, env('APP_TIMEZONE'));
        $duracionTexto = $this->pelicula?->duracion;

        $duracion = $this->parseDuracionEnMinutos($duracionTexto);

        $fin = $inicio->copy()->addMinutes($duracion);

        if ($ahora->lt($inicio)) return 'Activa';
        if ($ahora->between($inicio, $fin)) return 'En curso';

        return 'Finalizada';
    }

    private function parseDuracionEnMinutos($duracion)
    {
        $minutos = 0;

        if (preg_match('/(\d+)h/', $duracion, $horas)) {
            $minutos += intval($horas[1]) * 60;
        }

        if (preg_match('/(\d+)m/', $duracion, $mins)) {
            $minutos += intval($mins[1]);
        }

        return $minutos;
    }
}
