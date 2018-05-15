<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupCoverage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('catalog_group_coverage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_group_coverage',100);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('catalog_coverage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_group_coverage')->unsigned();
            $table->string('nama_coverage',100);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_group_coverage')->references('id')->on('catalog_group_coverage');
        });

        Schema::table('catalog_product_logistic', function (Blueprint $table) {
            $table->dropColumn('lokasi_logistic');

            $table->bigInteger('id_coverage')->unsigned();
            $table->foreign('id_coverage')->references('id')->on('catalog_coverage');
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
