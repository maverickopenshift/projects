<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserPgs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users_pgs', function (Blueprint $table) {
        $table->string('divisi')->nullable()->after('v_band_posisi');
        $table->string('unit_bisnis')->nullable()->after('divisi');
        $table->string('unit_kerja')->nullable()->after('unit_bisnis');
        $table->string('position')->nullable()->after('unit_kerja');
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
