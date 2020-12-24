<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSorteosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorteos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('descripcion');
            $table->date('fecha_fin');
            $table->timestamps();
            $table->bigInteger('desarrolladora_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('desarrolladora_id')->references('id')->on('desarrolladoras');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sorteos');
    }
}
