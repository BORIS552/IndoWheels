<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWinnersTableAdd4Columns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('winners', function (Blueprint $table) {
            $table->string('email')->nullable()->default(null);
            $table->string('car_make')->nullable()->default(null);
            $table->string('car_reg_no')->nullable()->default(null);
            $table->string('invoice_no')->nullable()->default(null);
            $table->string('invoice_photo')->nullable()->default(null);
            $table->text('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('pin_no')->nullable()->default(null);
            $table->string('review')->nullable()->default(null);
            $table->tinyInteger('rating')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('winners', function (Blueprint $table) {
            $table->dropColumn('invoice_no');
            $table->dropColumn('invoice_photo');
            $table->dropColumn('address');
            $table->dropColumn('pin_no');
        });
    }
}
