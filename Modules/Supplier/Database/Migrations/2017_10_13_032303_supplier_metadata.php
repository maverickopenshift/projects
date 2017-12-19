<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SupplierMetadata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Schema::create('supplier_metadata', function (Blueprint $table) {
      //     $table->bigIncrements('id');
      //     $table->bigInteger('id_object')->nullable();
      //     $table->string('object_type')->nullable();
      //     $table->string('object_key')->nullable();
      //     $table->longText('object_value')->nullable();
      //     $table->string('object_status')->nullable();
      //     $table->timestamps();
      // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_metadata');
    }
}
