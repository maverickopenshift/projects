<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users_pegawai', function (Blueprint $table) {
        $table->string('nik',50)->change()->nullable();
      });
      Schema::table('users_atasan', function (Blueprint $table) {
        $table->string('nik',50)->change()->nullable();
      });
      Schema::table('users_approver', function (Blueprint $table) {
        $table->string('nik',50)->change()->nullable();
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
