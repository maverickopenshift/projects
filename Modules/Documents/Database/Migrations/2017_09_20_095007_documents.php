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
      Schema::create('doc_category', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name')->unique();
          $table->string('title')->unique();
          $table->longText('desc')->nullable();
          $table->string('created_by')->nullable();
          $table->string('updated_by')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
      Schema::create('doc_type', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name')->unique();
          $table->string('title')->unique();
          $table->longText('desc')->nullable();
          $table->string('created_by')->nullable();
          $table->string('updated_by')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_roles')->unsigned();
            $table->bigInteger('id_doc_cat')->unsigned();
            $table->bigInteger('id_doc_type')->unsigned();
            $table->string('doc_title');
            $table->string('doc_number')->unique()->index();
            $table->string('doc_mitra')->nullable();
            $table->longText('doc_desc')->nullable();
            $table->date('doc_startdate')->nullable();
            $table->date('doc_enddate')->nullable();
            $table->longText('doc_keywords')->nullable();
            $table->string('doc_file')->nullable();
            $table->longText('doc_file_desc')->nullable();
            $table->longText('doc_related')->nullable();
            $table->integer('doc_signing')->nullable();
            $table->date('doc_signing_date')->nullable();
            $table->longText('doc_signing_reason')->nullable();
            $table->enum('doc_change', array('addendum', 'amandemen', 'side letter'))->nullable();
            $table->string('doc_status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('id_roles')->references('id')->on('roles');
            $table->foreign('id_doc_cat')->references('id')->on('doc_category');
            $table->foreign('id_doc_type')->references('id')->on('doc_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropForeign(['id_roles','id_doc_cat','id_doc_type']);
      Schema::dropIfExists('doc_category');
      Schema::dropIfExists('doc_type');
      Schema::dropIfExists('documents');
    }
}
