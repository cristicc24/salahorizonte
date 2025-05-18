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
        return DB::table('toppeliculas', 'tp')
                ->leftJoin('peliculas', 'tp.idPelicula', '=', 'peliculas.id')
                ->select('peliculas.id','peliculas.titulo', 'peliculas.foto_miniatura', 'peliculas.enlace_trailer')
                ->get();
    }
}