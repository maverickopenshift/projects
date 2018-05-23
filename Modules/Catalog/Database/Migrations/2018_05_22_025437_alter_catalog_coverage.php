<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCatalogCoverage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('catalog_coverage', function (Blueprint $table) {
            $table->dropForeign(['id_group_coverage']);
            $table->dropColumn('id_group_coverage');

            $table->bigInteger('group_coverage_id')->unsigned();
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
