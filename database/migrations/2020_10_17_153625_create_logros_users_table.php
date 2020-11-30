<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogrosUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logro_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('logro_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('logro_id')->references('id')->on('logros');
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
        Schema::dropIfExists('logro_user');
    }
}
