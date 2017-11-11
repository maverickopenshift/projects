<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocPicRev2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('doc_pic', function (Blueprint $table) {
        $table->bigInteger('pegawai_id')->nullable();
        $table->string('nama')->nullable();
        $table->string('jabatan')->nullable();
        $table->string('email')->nullable();
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
