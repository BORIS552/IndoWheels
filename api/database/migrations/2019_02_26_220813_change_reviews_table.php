<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Reviews', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->string('video')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Reviews', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
            $table->dropColumn('video');
        });
    }
}
