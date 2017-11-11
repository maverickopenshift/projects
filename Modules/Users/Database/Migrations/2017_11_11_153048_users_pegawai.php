<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users_pegawai', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('users_id')->unsigned();
        $table->foreign('users_id')
              ->references('id')->on('users');
        $table->bigInteger('nik')->nullable();
        $table->timestamps();
      });
      Schema::create('users_atasan', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('users_pegawai_id')->unsigned();
        $table->foreign('users_pegawai_id')
              ->references('id')->on('users_pegawai');
        $table->bigInteger('nik')->nullable();
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
        //
    }
}
