<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('documents', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('user_id')->unsigned();
          $table->bigInteger('supplier_id')->unsigned();
          $table->bigInteger('doc_template_id')->unsigned();
          $table->string('doc_title',500);
          $table->string('doc_no')->unique()->index()->nullable();
          $table->string('doc_mitra')->nullable();
          $table->longText('doc_desc')->nullable();
          $table->date('doc_date')->nullable();
          $table->string('doc_pihak1',500)->nullable();
          $table->string('doc_pihak1_nama')->nullable();
          $table->enum('doc_proc_process', array('P', 'PL', 'TL'))->nullable();
          $table->double('doc_value')->nullable();
          $table->string('doc_po_no')->nullable();
          $table->string('doc_po_tgl')->nullable();
          $table->string('doc_po_name')->nullable();
          $table->longText('doc_sow')->nullable();
          $table->string('doc_mtu')->nullable();
          $table->enum('doc_jaminan', array('PL', 'PM'))->nullable();
          $table->string('doc_asuransi')->nullable();
          $table->double('doc_jaminan_nilai')->nullable();
          $table->date('doc_jaminan_datestart')->nullable();
          $table->date('doc_jaminan_dateend')->nullable();
          $table->longText('doc_jaminan_desc')->nullable();
          $table->integer('doc_parent')->nullable()->default(1);
          $table->bigInteger('doc_parent_id')->nullable();
          $table->string('doc_lampiran',500);
          $table->integer('doc_status')->nullable()->default(0);
          $table->integer('doc_signing')->nullable()->default(0);
          $table->date('doc_signing_date')->nullable();
          $table->longText('doc_signing_reason')->nullable();
          $table->longText('doc_data')->nullable();
          $table->timestamps();
          $table->softDeletes();


          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('supplier_id')->references('id')->on('supplier');
          $table->foreign('doc_template_id')->references('id')->on('doc_template');
      });
      Schema::create('doc_boq', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('documents_id')->unsigned();
        $table->string('kode_item')->nullable();
        $table->string('item',500)->nullable();
        $table->string('qty')->nullable();
        $table->string('satuan')->nullable();
        $table->string('mtu')->nullable();
        $table->string('harga')->nullable();
        $table->string('harga_total')->nullable();
        $table->longText('desc')->nullable();
        $table->longText('data')->nullable();
        
        $table->foreign('documents_id')->references('id')->on('documents');
      });
      
      Schema::create('doc_meta', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('documents_id')->unsigned();
        $table->string('meta_type')->nullable();
        $table->string('meta_name',500)->nullable();
        $table->string('meta_title',500)->nullable();
        $table->longText('meta_desc')->nullable();
        $table->string('meta_file',500)->nullable();
        
        $table->foreign('documents_id')->references('id')->on('documents');
      });
      Schema::create('pegawai', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id')->unsigned();
        $table->string('nik',500)->nullable();
        $table->string('name',500)->nullable();
        $table->string('loker',500)->nullable();
        $table->string('posisi',500)->nullable();
        
        $table->foreign('user_id')->references('id')->on('users');
      });
      Schema::create('doc_pic', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('documents_id')->unsigned();
        $table->bigInteger('pegawai_id')->unsigned();
        
        $table->foreign('documents_id')->references('id')->on('documents');
        $table->foreign('pegawai_id')->references('id')->on('pegawai');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('documents', function (Blueprint $table) {
        $table->dropForeign(['id_roles','id_doc_cat','id_doc_type','id_supplier']);
      });
      Schema::dropIfExists('documents');
      
      Schema::table('doc_wbs', function (Blueprint $table) {
        $table->dropForeign(['id_doc']);
      });
      Schema::dropIfExists('doc_wbs');
      
      Schema::table('doc_wbs_lokasi', function (Blueprint $table) {
        $table->dropForeign(['id_doc_wbs']);
        // $table->dropIfExists('doc_wbs_lokasi');
      });
      Schema::dropIfExists('doc_wbs_lokasi');
      
      Schema::table('doc_wbs_nilai', function (Blueprint $table) {
        $table->dropForeign(['id_doc_wbs']);
        // $table->dropIfExists('doc_wbs_nilai');
      });
      Schema::dropIfExists('doc_wbs_nilai');
    }
}
