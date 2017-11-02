<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('documents', function (Blueprint $table) {
        $table->dropColumn('doc_jaminan_datestart');
        $table->dropColumn('doc_jaminan_dateend');
        $table->date('doc_jaminan_startdate')->nullable();
        $table->date('doc_jaminan_enddate')->nullable();
        $table->date('doc_startdate')->nullable();
        $table->date('doc_enddate')->nullable();
        $table->string('doc_lampiran_teknis',500)->nullable();
        $table->string('doc_nilai_material',500)->nullable();
        $table->string('doc_nilai_jasa',500)->nullable();
        $table->string('doc_nilai_total',500)->nullable();
        $table->string('doc_nilai_ppn',500)->nullable();
        $table->string('doc_nilai_total_ppn',500)->nullable();
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
