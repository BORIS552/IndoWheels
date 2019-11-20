<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable()->default(null);
            $table->string('username')->nullable()->default(null);
            $table->string('mobile')->unique()->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('email')->unique()->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->string('api_token')->nullable()->default(null);
            $table->text('address')->nullable();
            $table->string('pin')->nullable()->default(null);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
