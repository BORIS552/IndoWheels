<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->nullable()->deafult(null);
            $table->integer('user_id')->unsigned()->nullable()->deafult(null);
            $table->integer('prize_id')->unsigned()->nullable()->deafult(null);
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('prize_id')->references('id')->on('prizes')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('winners');
    }
}
