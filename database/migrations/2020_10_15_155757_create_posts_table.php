<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->longText('contenido');
            $table->string('tipo')->nullable();
            $table->double('calificacion')->nullable();
            $table->boolean('destacado')->default(false);
            $table->boolean('ban')->default(false);
            $table->longText('motivo')->nullable();
            $table->boolean('comentarios')->default(true);
            $table->timestamps();
            $table->bigInteger('desarrolladora_id')->unsigned()->nullable();
            $table->bigInteger('juego_id')->unsigned()->nullable();
            $table->bigInteger('master_id')->unsigned()->nullable();
            $table->bigInteger('campania_id')->unsigned()->nullable();
            $table->foreign('desarrolladora_id')->references('id')->on('desarrolladoras');
            $table->foreign('campania_id')->references('id')->on('campanias');
            $table->foreign('juego_id')->references('id')->on('juegos');
            $table->foreign('master_id')->references('id')->on('masters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
