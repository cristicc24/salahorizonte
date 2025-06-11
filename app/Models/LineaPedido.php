<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineaPedido extends Model
{
    use HasFactory;

    protected $table = 'lineas_pedido';

    protected $fillable = [
        'numButaca',
        'pedido_id',
        'sesion_id',
    ];

    // Una línea de pedido pertenece a un pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id', 'pedido_id');
    }

    // Una línea de pedido pertenece a una sesión
    public function sesion()
    {
        return $this->belongsTo(Sesion::class, 'id', 'sesion_id');
    }
}
