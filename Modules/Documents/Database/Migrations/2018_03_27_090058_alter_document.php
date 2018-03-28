<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('documents', function (Blueprint $table) {
          $table->string('divisi')->nullable()->after('doc_no');
          $table->string('unit_bisnis')->nullable()->after('divisi');
          $table->string('unit_kerja')->nullable()->after('unit_bisnis');
          $table->string('position')->nullable()->after('unit_kerja');
          $table->dropColumn('doc_top_totalharga');
          $table->dropColumn('doc_top_matauang');
      });
      
      Schema::table('doc_top', function (Blueprint $table) {
          $table->dropColumn('top_matauang');
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
