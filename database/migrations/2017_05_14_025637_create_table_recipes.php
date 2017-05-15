<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRecipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('bonus');
            $table->float('chance');
            $table->integer('lead');
            $table->integer('tin');
            $table->integer('silver');
            $table->integer('gold');
            $table->integer('mercury');
            $table->integer('iron');
            $table->integer('sulfur');
            $table->integer('manuscript');
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
        Schema::dropIfExists('recipes');
    }
}
