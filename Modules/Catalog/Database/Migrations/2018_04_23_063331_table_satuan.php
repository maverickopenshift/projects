<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSatuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('catalog_satuan', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('nama_satuan',100);
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::table('catalog_product_master', function (Blueprint $table) {
            $table->dropColumn('satuan_product');
            $table->bigInteger('satuan_id')->unsigned();
            $table->foreign('satuan_id')->references('id')->on('catalog_satuan');
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
