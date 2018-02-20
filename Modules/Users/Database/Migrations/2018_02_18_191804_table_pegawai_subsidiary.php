<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePegawaiSubsidiary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pegawai_subsidiary', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('subsidiary_id')->unsigned();
        $table->foreign('subsidiary_id')
              ->references('id')->on('subsidiary_telkom');
        $table->integer('n_tahun')->nullable();
        $table->integer('n_bulan')->nullable();
        $table->integer('n_triwulan')->nullable();
        $table->string('v_triwulan')->nullable();
        $table->string('n_nik')->nullable();
        $table->string('v_nama_karyawan')->nullable();
        $table->string('c_employee_group',11)->nullable();
        $table->string('v_employee_group')->nullable();
        $table->integer('c_employee_subgroup')->nullable();
        $table->string('v_employee_subgroup')->nullable();
        $table->date('d_tgl_employeesubgroup')->nullable();
        $table->string('c_personnel_area')->nullable();
        $table->string('v_personnel_area')->nullable();
        $table->string('c_personnel_subarea')->nullable();
        $table->string('v_personnel_subarea')->nullable();
        $table->string('objiddivisi',20)->nullable();
        $table->string('c_kode_divisi')->nullable();
        $table->string('v_short_divisi')->nullable();
        $table->date('d_tgl_divisi')->nullable();
        $table->string('objidunit',20)->nullable();
        $table->string('c_kode_unit')->nullable();
        $table->string('v_short_unit')->nullable();
        $table->longText('v_long_unit')->nullable();
        $table->date('d_tgl_unit')->nullable();
        $table->string('objidposisi',20)->nullable();
        $table->string('c_kode_posisi')->nullable();
        $table->string('v_short_posisi')->nullable();
        $table->longText('v_long_posisi')->nullable();
        $table->date('d_tgl_posisi')->nullable();
        $table->string('v_band_posisi',5)->nullable();
        $table->date('d_tgl_bandposisi')->nullable();
        $table->string('c_kelas_posisi',50)->nullable();
        $table->date('d_tgl_kelasposisi')->nullable();
        $table->string('c_kode_kk',50)->nullable();
        $table->string('c_pasutri_yakes',50)->nullable();
        $table->string('c_group_host',50)->nullable();
        $table->string('c_host')->nullable();
        $table->string('v_kota_gedung',50)->nullable();
        $table->string('flag_chief',50)->nullable();
        $table->timestamps();
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
