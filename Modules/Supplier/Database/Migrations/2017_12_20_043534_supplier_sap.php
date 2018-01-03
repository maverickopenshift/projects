<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SupplierSap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('supplier_sap', function (Blueprint $table) {
        $table->increments('id');
        $table->bigInteger('users_id')->unsigned();
        $table->string('supplier_id')->nullable();
        $table->string('ci')->nullable();
        $table->string('vendor')->nullable();
        $table->string('cty')->nullable();
        $table->string('name_1')->nullable();
        $table->string('city')->nullable();
        $table->string('postalcode')->nullable();
        $table->string('rg')->nullable();
        $table->string('searchterm')->nullable();
        $table->longText('street')->nullable();
        $table->string('title')->nullable();
        $table->date('date')->nullable();
        $table->string('created_by')->nullable();
        $table->string('group')->nullable();
        $table->string('language')->nullable();
        $table->string('vat_registration_no')->nullable();
        $table->timestamp('upload_date')->nullable();
        $table->string('upload_by')->nullable();

        $table->foreign('users_id')
              ->references('id')->on('users');
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
