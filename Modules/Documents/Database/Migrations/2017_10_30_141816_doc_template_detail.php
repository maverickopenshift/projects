<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocTemplateDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::table('doc_template')->delete();
      Schema::table('doc_template', function (Blueprint $table) {
        $table->dropColumn(['name','title','desc']);
      });
      
      Schema::create('doc_template_detail', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('id_doc_template')->unsigned();
          $table->string('name');
          $table->string('title');
          $table->longText('desc')->nullable();
          $table->string('created_by')->nullable();
          $table->string('updated_by')->nullable();
          $table->timestamps();
          $table->softDeletes();
          
          $table->foreign('id_doc_template')->references('id')->on('doc_template');
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
