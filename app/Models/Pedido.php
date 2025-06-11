<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'totalPedido',
        'metodoPago',
        'fechaPago',
        'user_id',
    ];

    // Relación: un pedido pertenece a un user
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    // Relación: un pedido tiene muchas líneas
    public function lineas()
    {
        return $this->hasMany(LineaPedido::class, 'pedido_id', 'id');
    }
}
