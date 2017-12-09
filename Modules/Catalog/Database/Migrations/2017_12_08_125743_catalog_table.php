<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_category', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code',100);
          $table->string('display_name',100);
          $table->string('name',100);
          $table->bigInteger('parent_id')->nullable()->default(0);
          $table->bigInteger('child_position')->nullable()->default(0);
          $table->string('desc',100);
          $table->timestamps();
          $table->softDeletes();
        });

        Schema::create('catalog_product', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('catalog_category_id')->unsigned();
          $table->string('code',100);
          $table->string('name',100);
          $table->string('unit',100);
          $table->string('currency',100);
          $table->string('price',100);
          $table->string('desc',500);
          $table->string('keyword',500);
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
