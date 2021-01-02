<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuegosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juegos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('imagen_portada')->nullable();
            $table->string('imagen_caratula')->nullable();
            $table->longText('contenido')->nullable();
            $table->boolean('ban')->default(false);
            $table->longText('motivo')->nullable();
            $table->date('fecha_lanzamiento')->nullable();
            $table->double('precio')->nullable();
            $table->timestamps();
            $table->bigInteger('desarrolladora_id')->unsigned();
            $table->bigInteger('genero_id')->unsigned();
            $table->foreign('desarrolladora_id')->references('id')->on('desarrolladoras');
            $table->foreign('genero_id')->references('id')->on('generos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('juegos');
    }
}
