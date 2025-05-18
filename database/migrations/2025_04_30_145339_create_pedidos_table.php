<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id(); // clave primaria estándar
            $table->decimal('totalPedido', 8, 2);
            $table->string('metodoPago');
            $table->date('fechaPago');

            // Clave foránea a clientes
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};