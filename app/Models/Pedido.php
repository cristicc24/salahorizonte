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
        'cliente_id',
    ];

    // Relación: un pedido pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    // Relación: un pedido tiene muchas líneas
    public function lineas()
    {
        return $this->hasMany(LineaPedido::class, 'pedido_id', 'id');
    }
}
