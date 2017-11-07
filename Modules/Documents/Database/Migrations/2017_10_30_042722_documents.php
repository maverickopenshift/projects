<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Documents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {      
      Schema::create('doc_template', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('id_doc_type')->unsigned();
          $table->bigInteger('id_doc_category')->unsigned();
          $table->string('name');
          $table->string('kode');
          $table->string('title');
          $table->longText('desc')->nullable();
          $table->timestamps();
          $table->softDeletes();
          
          $table->foreign('id_doc_type')->references('id')->on('doc_type');
          $table->foreign('id_doc_category')->references('id')->on('doc_category');
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
