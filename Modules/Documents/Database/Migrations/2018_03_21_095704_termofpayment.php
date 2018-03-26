<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Termofpayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('doc_top_totalharga')->nullable();
            $table->string('doc_top_matauang')->nullable();
        });

        Schema::create('doc_top', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('documents_id')->unsigned();
            $table->foreign('documents_id')
                  ->references('id')->on('documents');

            $table->string('top_deskripsi')->nullable();
            $table->date('top_tanggal_mulai')->nullable();
            $table->date('top_tanggal_selesai')->nullable();
            $table->string('top_matauang')->nullable();
            $table->string('top_harga')->nullable();
            $table->date('top_tanggal_bapp')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
