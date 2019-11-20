<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->nullable()->deafult(null);
            $table->integer('lottery_id')->unsigned()->nullable()->deafult(null);
            $table->string('name')->nullable()->deafult(null);
            $table->text('info')->nullable()->deafult(null);
            // $table->integer('quantity')->unsigned()->nullable()->deafult(null);
            $table->string('email')->nullable()->deafult(null);
            $table->string('dob')->nullable()->deafult(null);
            $table->string('car_make')->nullable()->deafult(null);
            $table->string('car_reg_no')->nullable()->deafult(null);
            $table->string('review')->nullable()->deafult(null);
            $table->string('rating')->nullable()->deafult(null);
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('lottery_id')->references('id')->on('lotteries')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizes');
    }
}
