<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocWbs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('doc_wbs', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('id_doc')->unsigned();
          $table->foreign('id_doc')->references('id')->on('documents');
          $table->string('kd_kontrak')->references('doc_number')->on('documents');
          $table->integer('no_amdke');
          $table->integer('kd_wbs');
          $table->unique(['kd_kontrak','no_amdke','kd_wbs'],'doc_wbs_key');
          $table->integer('kd_parent')->nullable();
          $table->integer('kd_wp')->nullable();
          $table->string('nm_wbs')->nullable();
          $table->integer('kd_act')->nullable();
          $table->string('pk_owner')->nullable();
          $table->string('kd_sgrup')->nullable();
          $table->char('kd_lokasi1',8)->nullable();
          $table->string('nm_lokasi1')->nullable();
          $table->char('kd_lokasi2',8)->nullable();
          $table->string('nm_lokasi2')->nullable();
          $table->string('kt_lokasi',500)->nullable();
          $table->string('kd_rka')->nullable();
          $table->string('merk')->nullable();
          $table->string('negara')->nullable();
          $table->string('accountcode')->nullable();
          $table->char('st_lock_sche',1)->nullable();
          $table->char('st_lock_nilai',1)->nullable();
          $table->date('comm_budget')->nullable();
          $table->decimal('bobot',17,14)->nullable();
          $table->decimal('pro_plan',17,14)->nullable();
          $table->decimal('pro_actual',17,14)->nullable();
          $table->decimal('pro_bast')->nullable();
          $table->date('tg_plan_start')->nullable();
          $table->date('tg_plan_finish')->nullable();
          $table->date('tg_actual_start')->nullable();
          $table->date('tg_actual_finish')->nullable();
          $table->date('tg_forecast_start')->nullable();
          $table->date('tg_forecast_finish')->nullable();
          $table->char('st_proses',1)->nullable();
          $table->char('st_toc',1)->nullable();
          $table->date('tg_plan_finish1')->nullable();
          $table->date('tg_actual_finish1')->nullable();
          $table->date('tg_forecast_finish1')->nullable();
          $table->decimal('pro_plan1',17,14)->nullable();
          $table->decimal('pro_actual1',17,14)->nullable();
          $table->string('kor_lat')->nullable();
          $table->string('kor_long')->nullable();
          $table->string('provinsi')->nullable();
          $table->string('kota')->nullable();
          $table->string('region')->nullable();
          $table->string('site_name1')->nullable();
          $table->string('site_name2')->nullable();
          $table->string('site_name_ket')->nullable();
          $table->string('project_site_id')->nullable();
          $table->string('wo_no')->nullable();
          $table->date('wo_tg')->nullable();
          $table->string('batch')->nullable();
          $table->string('site_id')->nullable();
          $table->decimal('tinggi_tower',5,2)->nullable();
          $table->integer('wo_no_amdke')->nullable();
          $table->char('st_lokasi',1)->nullable();
          $table->string('power_type')->nullable();
          $table->string('status_lahan')->nullable();
          $table->string('site_alamat')->nullable();
          $table->string('site_kdpos')->nullable();
          $table->date('tg_mulai')->nullable();
          $table->date('tg_target_user')->nullable();
          $table->string('kor_lat_actual')->nullable();
          $table->string('kor_long_actual')->nullable();
          $table->char('st_add_act',1)->nullable();
          $table->char('st_objective',1)->nullable();
          $table->char('st_alpro',1)->nullable();
          $table->char('st_isiska',1)->nullable();
          $table->char('st_tenos',1)->nullable();
          $table->char('st_asbult',1)->nullable();
          $table->char('kd_asbd',14)->nullable();
          $table->string('cmdf')->nullable();
          $table->date('tg_optimis_start')->nullable();
          $table->date('tg_optimis_finish_ut')->nullable();
          $table->date('tg_optimis_finish_st')->nullable();
          $table->date('tg_finish_prep')->nullable();
          $table->date('tg_finish_material')->nullable();
          $table->date('tg_finish_instalasi')->nullable();
          $table->date('tg_finish_baut')->nullable();
          $table->decimal('pro_plan2',17,14)->nullable();
          $table->decimal('pro_actual2',17,14)->nullable();
          $table->date('tg_toc_lk')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
      Schema::create('doc_wbs_lokasi', function (Blueprint $table) {
          $table->bigInteger('id_doc_wbs')->unsigned();
          $table->foreign('id_doc_wbs')->references('id')->on('doc_wbs');
          $table->string('kd_kontrak');
          $table->integer('no_amdke');
          $table->integer('kd_wbs');
          $table->unique(['kd_kontrak','no_amdke','kd_wbs'],'doc_wbs_key');
          $table->string('kd_harga')->nullable();
          $table->string('part_number')->nullable();
          $table->string('serial_number')->nullable();
          $table->decimal('qty',30,3)->nullable();
          $table->string('satuan')->nullable();
      });
      Schema::create('doc_wbs_nilai', function (Blueprint $table) {
          $table->bigInteger('id_doc_wbs')->unsigned();
          $table->foreign('id_doc_wbs')->references('id')->on('doc_wbs');
          $table->string('kd_kontrak');
          $table->integer('no_amdke');
          $table->integer('kd_wbs');
          $table->unique(['kd_kontrak','no_amdke','kd_wbs'],'doc_wbs_key');
          $table->string('pk_mtu')->nullable();
          $table->string('part_number')->nullable();
          $table->decimal('ni_barang',30,3)->nullable();
          $table->decimal('ni_jasa',30,3)->nullable();
          $table->decimal('ni_total',30,3)->nullable();
          $table->decimal('ni_barang01',30,3)->nullable();
          $table->decimal('ni_jasa01',30,3)->nullable();
          $table->decimal('ni_total01',30,3)->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('doc_wbs');
      Schema::drop('doc_wbs_lokasi');
      Schema::drop('doc_wbs_nilai');
    }
}
