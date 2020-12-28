<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->longText('motivo');
            $table->unsignedBigInteger('campania_id')->nullable();
            $table->unsignedBigInteger('desarrolladora_id')->nullable();
            $table->unsignedBigInteger('juego_id')->nullable();
            $table->unsignedBigInteger('master_id')->nullable();
            $table->unsignedBigInteger('mensaje_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('campania_id')->references('id')->on('campanias');
            $table->foreign('desarrolladora_id')->references('id')->on('desarrolladoras');
            $table->foreign('juego_id')->references('id')->on('juegos');
            $table->foreign('master_id')->references('id')->on('masters');
            $table->foreign('mensaje_id')->references('id')->on('mensajes');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
