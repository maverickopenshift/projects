<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserChange2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users_approver', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('users_pegawai_id')->unsigned();
        $table->foreign('users_pegawai_id')
              ->references('id')->on('users_pegawai');
        $table->bigInteger('nik')->nullable();
        $table->timestamps();
      });
      Schema::create('users_pgs', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('users_id')->unsigned();
        $table->foreign('users_id')
              ->references('id')->on('users');
        $table->bigInteger('objiddivisi')->nullable();
        $table->string('c_kode_divisi')->nullable();
        $table->string('v_short_divisi')->nullable();
        $table->bigInteger('objidunit')->nullable();
        $table->string('c_kode_unit')->nullable();
        $table->string('v_short_unit')->nullable();
        $table->bigInteger('objidposisi')->nullable();
        $table->string('c_kode_posisi')->nullable();
        $table->string('v_short_posisi')->nullable();
        $table->string('v_band_posisi')->nullable();
        $table->integer('role_id')->nullable();
        $table->integer('role_id_first')->nullable();
        $table->timestamps();
      });
      Schema::table('users', function (Blueprint $table) {
        $table->string('user_type')->nullable();
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
