<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanias', function (Blueprint $table) {
            $table->id();
            $table->double('meta');
            $table->double('recaudado')->default(0);
            $table->date('fecha_fin');
            $table->longText('contenido')->nullable();
            $table->longText('faq')->nullable();
            $table->integer('reportes')->default(0);
            $table->boolean('ban')->default(false);
            $table->longText('motivo')->nullable();
            $table->timestamps();
            $table->bigInteger('juego_id')->unsigned();
            $table->foreign('juego_id')->references('id')->on('juegos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campanias');
    }
}
