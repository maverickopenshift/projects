<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocAsuransi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_asuransi', function (Blueprint $table) {
          $table->increments('id');
          $table->bigInteger('documents_id')->unsigned();
          $table->string('doc_jaminan')->nullable();
          $table->string('doc_jaminan_name')->nullable();
          $table->double('doc_jaminan_nilai')->nullable();
          $table->date('doc_jaminan_startdate')->nullable();
          $table->date('doc_jaminan_startdate')->nullable();
          $table->longText('doc_jaminan_desc')->nullable();
          $table->string('doc_jaminan_file')->nullable();

          $table->foreign('documents_id')
                ->references('id')->on('documents');
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
