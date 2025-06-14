<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TopPelicula extends Model
{
    use HasFactory;
    protected $table = 'toppeliculas';
    protected $primaryKey = 'id';
   
    protected $fillable = [
        'idPelicula',
    ];

    public static function get(){
        return Pelicula::activas()
            ->whereIn('id', function ($query) {
                $query->select('idPelicula')->from('toppeliculas');
            })
            ->select('id', 'titulo', 'foto_miniatura', 'enlace_trailer')
            ->get();
    }
}