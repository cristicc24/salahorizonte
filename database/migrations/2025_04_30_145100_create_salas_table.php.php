<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('salas', function (Blueprint $table) {
            $table->id(); // clave primaria estándar 'id'
            $table->integer('numButacasTotales');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salas');
  
    }
};
