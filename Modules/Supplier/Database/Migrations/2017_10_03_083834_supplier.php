<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Supplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('supplier', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('id_user')->unsigned();
          $table->foreign('id_user')->references('id')->on('users');
          $table->string('kd_vendor');
          $table->unique(['kd_vendor'],'kd_vendor');
          $table->string('bdn_usaha')->nullable();
          $table->string('nm_vendor')->nullable();
          $table->string('nm_vendor_uq')->nullable();
          $table->string('alamat',500)->nullable();
          $table->string('negara')->nullable();
          $table->string('kota')->nullable();
          $table->char('kd_pos',10)->nullable();
          $table->string('telepon')->nullable();
          $table->string('fax')->nullable();
          $table->string('email');
          $table->unique(['email'],'email');
          $table->string('web_site')->nullable();
          $table->string('induk_perus')->nullable();
          $table->integer('induk_perus_kd')->nullable();
          $table->string('akte_awal_no')->nullable();
          $table->date('akte_awal_tg')->nullable();
          $table->string('akte_awal_notaris')->nullable();
          $table->string('akte_akhir_no')->nullable();
          $table->date('akte_akhir_tg')->nullable();
          $table->string('akte_akhir_notaris')->nullable();
          $table->string('siup_no')->nullable();
          $table->date('siup_tg_terbit')->nullable();
          $table->date('siup_tg_expired')->nullable();
          $table->integer('siup_kualifikasi')->nullable()->default(1);
          $table->integer('pkp')->nullable()->default(1);
          $table->string('npwp_no')->nullable();
          $table->date('npwp_tg')->nullable();
          $table->string('tdp_no')->nullable();
          $table->date('tdp_tg_terbit')->nullable();
          $table->date('tdp_tg_expired')->nullable();
          $table->string('idp_no')->nullable();
          $table->date('idp_tg_terbit')->nullable();
          $table->date('idp_tg_expired')->nullable();
          $table->string('iujk_no')->nullable();
          $table->date('iujk_tg_terbit')->nullable();
          $table->date('iujk_tg_expired')->nullable();
          $table->decimal('modal_dasar',30,3)->nullable()->default(0);
          $table->decimal('asset',30,3)->nullable()->default(0);
          $table->string('bank_nama')->nullable();
          $table->string('bank_cabang')->nullable();
          $table->string('bank_norek')->nullable();
          $table->integer('jml_peg_domestik')->nullable()->default(0);
          $table->integer('jml_peg_asing')->nullable()->default(0);
          $table->char('st_aktif',1)->nullable()->default(1);
          $table->integer('app_jml')->nullable()->default(2);
          $table->integer('app_posisi')->nullable()->default(0);
          $table->integer('app_proses')->nullable()->default(2);
          $table->integer('no_agen')->nullable();
          $table->string('kode_loker')->nullable();
          $table->string('no_rekanan_telkom')->nullable();
          $table->string('kd_file')->nullable();
          $table->string('kd_vendor_old')->nullable();
          $table->string('proses_ke')->nullable()->default(1);
          $table->date('tg_toc')->nullable();
          $table->string('grup')->nullable()->default('01');
          $table->string('ciqs_no')->nullable();
          $table->date('ciqs_tg_terbit')->nullable();
          $table->date('ciqs_tg_expired')->nullable();
          $table->char('prinsipal_st',1)->nullable()->default(2);
          $table->string('prinsipal_no')->nullable();
          $table->date('prinsipal_tg_terbit')->nullable();
          $table->date('prinsipal_tg_expired')->nullable();
          $table->string('cp1_nama')->nullable();
          $table->string('cp1_telp')->nullable();
          $table->string('cp1_email')->nullable();
          $table->string('cp2_nama')->nullable();
          $table->string('cp2_telp')->nullable();
          $table->string('cp2_email')->nullable();
          $table->date('tg_rekanan_expired')->nullable();
          $table->string('kementrian_sk')->nullable();
          $table->date('kementrian_tg')->nullable();
          $table->integer('vendor_status')->nullable()->default(0);
          $table->dateTime('approval_at')->nullable();
          $table->string('created_by')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
      Schema::table('documents', function($table)
      {
        $table->bigInteger('id_supplier')->nullable()->unsigned()->after('id');
        $table->foreign('id_supplier')->references('id')->on('supplier');
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
