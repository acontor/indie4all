<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('encuesta_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('opcion_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('encuesta_id')->references('id')->on('encuestas');
            $table->foreign('opcion_id')->references('id')->on('opcions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sorteo_user');
    }
}
