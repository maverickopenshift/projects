<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SupplierActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('supplier_activity', function (Blueprint $table) {
        $table->increments('id');
        $table->bigInteger('users_id')->unsigned();
        $table->bigInteger('supplier_id')->unsigned();
        $table->longText('activity')->nullable();
        $table->longText('komentar')->nullable();
        $table->timestamp('date')->nullable();

        $table->foreign('users_id')
              ->references('id')->on('users');
        $table->foreign('supplier_id')
              ->references('id')->on('supplier');
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
