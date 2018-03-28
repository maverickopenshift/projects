<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductLogistic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('catalog_product_logistic', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('product_master_id')->unsigned();
          $table->string('lokasi_logistic',100);
          $table->string('harga_barang_logistic',100);
          $table->string('harga_jasa_logistic',100);
          $table->string('jenis_referensi',100);
          $table->string('referensi_logistic',100);
          $table->timestamps();
          $table->softDeletes();

          $table->foreign('product_master_id')->references('id')->on('catalog_product_master');
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
