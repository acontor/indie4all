<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesarrolladorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desarrolladoras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('email')->unique();
            $table->string('direccion');
            $table->string('telefono');
            $table->string('url');
            $table->string('imagen_logo')->nullable();
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
        Schema::dropIfExists('desarrolladoras');
    }
}
