<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->nullable()->deafult(null);
            $table->string('name')->nullable()->deafult(null);
            $table->boolean('is_active')->nullable()->deafult(null);
            $table->date('date')->nullable()->deafult(null);
            $table->date('start_date')->nullable()->deafult(null);
            $table->date('end_date')->nullable()->deafult(null);
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lotteries');
    }
}
