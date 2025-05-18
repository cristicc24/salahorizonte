<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'administradores';
    protected $primaryKey = 'idAdministrador';

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo'
    ];

    protected $hidden = [
        'contrasena'
    ];

}