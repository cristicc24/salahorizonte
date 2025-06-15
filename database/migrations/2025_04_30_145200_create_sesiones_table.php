<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id(); 
            $table->dateTime('fechaHora');
            $table->text('butacasReservadas'); 
            $table->integer('numButacasReservadas')->default(0);

            $table->unsignedBigInteger('idSala');
            $table->unsignedBigInteger('idPelicula');

            $table->foreign('idSala')->references('id')->on('salas')->onDelete('cascade');
            $table->foreign('idPelicula')->references('id')->on('peliculas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
