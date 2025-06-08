<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('salas', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('idSala')->unique();
            $table->integer('numButacasTotales');
            $table->integer('cantidadColumnas');
            $table->integer('cantidadFilas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salas');
  
    }
};
