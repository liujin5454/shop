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
            $table->unsignedInteger('store_id');
            //$table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->string('nickname');
            $table->string('portrait')->nullable()->comment('头像');
            $table->string('phone')->unique()->nullable()->comment('手机号码');
            $table->string('password');
            $table->integer('gender')->comment('性别');
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
