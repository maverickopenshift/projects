<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocPo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('doc_po', function (Blueprint $table) {
        $table->increments('id');
        $table->bigInteger('documents_id')->unsigned();
        $table->foreign('documents_id')
              ->references('id')->on('documents');
        $table->string('po_no')->nullable();
        $table->date('po_date')->nullable();
        $table->string('po_vendor')->nullable();
        $table->string('po_pembuat')->nullable();
        $table->string('po_nik')->nullable();
        $table->string('po_approval')->nullable();
        $table->string('po_penandatangan')->nullable();

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
