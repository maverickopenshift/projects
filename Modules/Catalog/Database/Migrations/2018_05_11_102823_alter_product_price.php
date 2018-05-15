<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('catalog_product_logistic', function (Blueprint $table) {
            $table->dropForeign(['id_coverage']);
            $table->dropColumn('id_coverage');

            $table->bigInteger('coverage_id')->unsigned();
            $table->bigInteger('group_coverage_id')->unsigned();
            $table->foreign('coverage_id')->references('id')->on('catalog_coverage');
            $table->foreign('group_coverage_id')->references('id')->on('catalog_group_coverage');
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
