<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Administrador extends Authenticatable
{
    use HasFactory;

    protected $table = 'administradores';
    protected $primaryKey = 'idAdministrador';

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password' // Asegúrate de tener este campo en tu tabla
    ];

    protected $hidden = [
        'password', // Laravel espera este campo por defecto
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAdministrador()
    {
        return DB::table('administradores')
            ->select('*')
            ->get();
    }
}
