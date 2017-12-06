<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('doc_activity', function (Blueprint $table) {
        $table->increments('id');
        $table->bigInteger('users_id')->unsigned();
        $table->bigInteger('documents_id')->unsigned();
        $table->longText('activity')->nullable();
        $table->timestamp('date')->nullable();

        $table->foreign('users_id')
              ->references('id')->on('users');
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
