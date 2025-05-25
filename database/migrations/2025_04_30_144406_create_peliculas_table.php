<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peliculas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->decimal('precio', 8, 2);
            $table->string('genero');
            $table->string('directores');
            $table->string('edad_recomendada');
            $table->string('duracion');
            $table->date('fecha_estreno');
            $table->date('fecha_emision');
            $table->text('sinopsis');
            $table->string('foto_miniatura')->nullable();
            $table->string('actores');
            $table->string('enlace_trailer')->nullable();
            $table->string('foto_grande')->nullable();
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('peliculas');
    }
};
