<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('precio');
            $table->date('fecha_compra');
            $table->string('key')->nullable();
            $table->bigInteger('campania_id')->unsigned()->nullable();
            $table->bigInteger('juego_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('juego_id')->references('id')->on('juegos');
            $table->foreign('campania_id')->references('id')->on('campanias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
