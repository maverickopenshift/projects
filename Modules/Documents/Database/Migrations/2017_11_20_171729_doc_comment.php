<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('doc_comment', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('documents_id')->unsigned();
        $table->foreign('documents_id')
              ->references('id')->on('documents');
        $table->bigInteger('users_id')->unsigned();
        $table->foreign('users_id')
                    ->references('id')->on('users');
        $table->longText('content')->nullable();
        $table->integer('status')->nullable()->default(0);
        $table->longText('data')->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_comment');
    }
}
