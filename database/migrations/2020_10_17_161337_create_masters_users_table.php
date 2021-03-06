<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMastersUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_user', function (Blueprint $table) {
            $table->id();
            $table->boolean('notificacion');
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('master_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('master_user');
    }
}
