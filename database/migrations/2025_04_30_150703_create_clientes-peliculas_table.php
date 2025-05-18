<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientes_peliculas', function (Blueprint $table) {
            // Claves foráneas
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('pelicula_id');

            // Datos adicionales
            $table->integer('estrellas'); // valoración numérica (1-5, por ejemplo)
            $table->text('comentario')->nullable();

            // Definir relaciones
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');

            // Clave primaria compuesta
            $table->primary(['cliente_id', 'pelicula_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes_peliculas');
    }
};
