<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMetaSideletter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('doc_meta_side_letter', function (Blueprint $table) {
          $table->string('meta_pasal',500)->nullable()->change();
          $table->string('meta_judul',500)->nullable()->change();
          $table->longText('meta_isi')->nullable()->change();
          $table->string('meta_awal',500)->nullable()->change();
          $table->string('meta_akhir',500)->nullable()->change();
          $table->string('meta_file',500)->nullable()->change();
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
