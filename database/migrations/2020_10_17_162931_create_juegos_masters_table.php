<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuegosMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juego_master', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('juego_id');
            $table->bigInteger('master_id');
            $table->string('titulo');
            $table->longText('contenido');
            $table->double('calificacion');
            $table->date('fecha_publicacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('juego_master');
    }
}
