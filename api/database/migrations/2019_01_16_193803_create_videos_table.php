<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->nullable()->deafult(null);
            $table->string('name', 256)->nullable()->deafult(null);
            $table->string('path')->nullable()->deafult(null);
            $table->integer('video_for_id')->unsigned()->nullable()->deafult(null);
            $table->string('video_for_type')->nullable()->deafult(null);
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
        Schema::dropIfExists('videos');
    }
}
