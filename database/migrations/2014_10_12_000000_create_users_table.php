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
            $table->string('ip')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('premium')->default(0);
            $table->integer('premium_expire_date')->nullable();
            $table->integer('crystals')->default(0);
            $table->integer('status')->default(0);
            $table->integer('level')->default(1);
            $table->integer('radius')->default(150);
            $table->float('lon', 10, 7)->nullable();
            $table->float('lat', 10, 7)->nullable();
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
