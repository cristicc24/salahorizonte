<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function run()
    {
        $peliculas = DB::table('peliculas')
                        ->select('id', 'titulo', 'foto_miniatura', 'enlace_trailer')
                        ->limit(7)
                        ->get(); 
    
        return view('toppeliculas', [
            'peliculas' => $peliculas
        ]);
    }
}
