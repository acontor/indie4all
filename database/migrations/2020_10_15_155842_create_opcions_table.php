<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcions', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->boolean('ganadora')->nullable();
            $table->timestamps();
            $table->bigInteger('encuesta_id')->unsigned();
            $table->foreign('encuesta_id')->references('id')->on('encuestas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opciones');
    }
}
