<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevSupplierMetadata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('supplier_meta', function (Blueprint $table) {
          $table->increments('id');
          $table->bigInteger('supplier_id')->unsigned();
          $table->foreign('supplier_id')
                ->references('id')->on('supplier');
          $table->string('meta_type')->nullable();
          $table->string('meta_name')->nullable();
          $table->string('meta_title')->nullable();
          $table->longText('meta_desc')->nullable();
          $table->date('meta_start_date')->nullable();
          $table->date('meta_end_date')->nullable();
          $table->string('meta_file_name')->nullable();
          $table->string('meta_file')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      // Schema::dropIfExists('supplier_metadata');
    }
}
