<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id(); 
            $table->decimal('totalPedido', 8, 2);
            $table->string('metodoPago')->nullable();
            $table->date('fechaPago');

            // Clave foránea a users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('email_enviado')->default(false);
            $table->string('hash_confirmacion', 64)->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};