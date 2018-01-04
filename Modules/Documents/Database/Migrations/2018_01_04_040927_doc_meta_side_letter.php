<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocMetaSideLetter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('doc_meta_side_letter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('documents_id')->unsigned();
            $table->string('meta_pasal',500);
            $table->string('meta_judul',500);
            $table->longText('meta_isi');
            $table->string('meta_awal',500);
            $table->string('meta_akhir',500);
            $table->string('meta_file',500);

            $table->foreign('documents_id')->references('id')->on('documents');
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
