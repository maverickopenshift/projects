<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('catalog_product_master', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('catalog_category_id')->unsigned();
          $table->string('kode_product',100);
          $table->string('keterangan_product',100);
          $table->string('satuan_product',100);
          $table->timestamps();
          $table->softDeletes();

          $table->foreign('catalog_category_id')->references('id')->on('catalog_category');
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
