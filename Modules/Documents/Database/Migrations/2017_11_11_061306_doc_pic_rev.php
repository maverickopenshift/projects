<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocPicRev extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::table('doc_pic')->delete();
      Schema::enableForeignKeyConstraints();
      Schema::table('doc_pic', function (Blueprint $table) {
        $table->dropForeign('doc_pic_pegawai_id_foreign');
        $table->dropColumn('pegawai_id');
      });
      Schema::disableForeignKeyConstraints();
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
