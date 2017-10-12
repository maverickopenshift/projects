<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SupplierDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('supplier_detail', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('supplier_id')->unsigned();
        $table->bigInteger('badan_usaha_id')->unsigned();
        $table->bigInteger('klasifikasi_usaha_id')->unsigned();
        $table->longText('text');
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('supplier_id')->references('id')->on('supplier');
        $table->foreign('badan_usaha_id')->references('id')->on('badan_usaha');
        $table->foreign('klasifikasi_usaha_id')->references('id')->on('klasifikasi_usaha');
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
