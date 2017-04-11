<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('premium')->default(0);
            $table->integer('crystals')->default(0);
            $table->integer('coordinates_id')->nullable()->unsigned();
            $table->foreign('coordinates_id')->references('id')->on('coordinates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('premium', 'crystals');
            $table->dropForeign(['coordinates_id']);
            $table->dropColumn('coordinates_id');
        });
    }
}
