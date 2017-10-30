<?php
namespace App\Helpers;

class CustomErrors
{
  public static function supplier(){
    return [
            'nm_vendor.max' => 'Nama Perusahaan maksimal 500 karakter',
            'nm_vendor.min' => 'Nama Perusahaan minimal 3 karakter',
            'nm_vendor.required' => 'Nama Perusahaan harus diisi',
            'nm_vendor.regex' => 'Nama Perusahaan harus huruf dan angka',

            'nm_vendor_uq.max' => 'Nama Inisial Perusahaan maksimal 500 karakter',
            'nm_vendor_uq.min' => 'Nama Inisial Perusahaan minimal 3 karakter',
            'nm_vendor_uq.regex' => 'Nama Inisial Perusahaan harus huruf dan angka',

            'klasifikasi_usaha.*.required' => 'Klasifikasi usaha harus diisi',
            'klasifikasi_usaha.*.regex' => 'Klasifikasi usaha harus huruf dan angka',

            'pengalaman_kerja.required' => 'Pengalaman Kerja harus diisi',
            'pengalaman_kerja.min' => 'Pengalaman Kerja minimal 30 karakter',

            'alamat.required' => 'Alamat harus diisi',
            'alamat.max' => 'Alamat maksimal 1000 karakter',
            'alamat.min' => 'Alamat minimal 10 karakter',

            'kota.required' => 'Kota harus diisi',
            'kota.max' => 'Kota maksimal 500 karakter',
            'kota.min' => 'Kota minimal 3 karakter',

            'kd_pos.required' => 'Kode Pos harus diisi',
            'kd_pos.digits_between' => 'Kode Pos harus diantara 3 sampai 20 digit',

            'telepon.required' => 'Telepon harus diisi',
            'telepon.digits_between' => 'Telepon harus diantara 7 sampai 20 digit',

            'fax.required' => 'Fax harus diisi',
            'fax.digits_between' => 'Fax harus harus diantara 7 sampai 20 digit',

            'email.required' => 'Email harus diisi',
            'email.max' => 'Email maksimal 50 karakter',
            'email.min' => 'Email minimal 4 karakter',
            'email.email' => 'Email harus format email',

            'password.required' => 'Password harus diisi',
            'password.max' => 'Email maksimal 50 karakter',
            'password.min' => 'Email minimal 6 karakter',

            'web_site.url' => 'Format Website salah',

            'induk_perus.min' => 'Perusahaan Induk minimal 3 karakter',

            'anak_perusahaan.*.max' => 'Anak Perusahaan maksimal 500 karakter',
            'anak_perusahaan.*.min' => 'Anak Perusahaan minimal 3 karakter',

            'asset.required' => 'Asset Perusahaan harus diisi',
            'asset.max' => 'Asset Perusahaan maksimal 500 karakter',
            'asset.min' => 'Asset Perusahaan maksimal 3 karakter',
            'asset.digits_between' => 'Asset Perusahaan harus harus diantara 3 sampai 50 digit',

            'bank_nama.required' => 'Nama Bank harus diisi',
            'bank_nama.max' => 'Nama Bank maksimal 500 karakter',
            'bank_nama.min' => 'Nama Bank minimal 3 karakter',
            'bank_nama.regex' => 'Nama Bank harus huruf dan angka',

            'bank_cabang.required' => 'Nama Cabang Bank harus diisi',
            'bank_cabang.max' => 'Nama Cabang Bank maksimal 500 karakter',
            'bank_cabang.min' => 'Nama Cabang Bank minimal 3 karakter',
            'bank_cabang.regex' => 'Nama Cabang Bank harus huruf dan angka',

            'bank_norek.required' => 'Nomer Rekening Bank harus diisi',
            'bank_norek.max' => 'Nomer Rekening Bank maksimal 500 karakter',
            'bank_norek.min' => 'Nomer Rekening Bank minimal 3 karakter',
            'bank_norek.regex' => 'Nomer Rekening Bank harus angka',

            'bank_kota.required' => 'Nama Kota Bank harus diisi',
            'bank_kota.max' => 'Nama Kota Bank maksimal 500 karakter',
            'bank_kota.min' => 'Nama Kota Bank minimal 3 karakter',
            'bank_kota.regex' => 'Nama Kota Bank harus huruf dan angka',

            'akte_awal_no.required' => 'Nomer Akte Awal harus diisi',
            'akte_awal_no.max' => 'Nomer Akte Awal maksimal 500 karakter',
            'akte_awal_no.min' => 'Nomer Akte Awal minimal 3 karakter',
            'akte_awal_no.regex' => 'Nomer Akte Awal harus huruf dan angka',

            'akte_awal_tg.required' => 'Tanggal Terbit Akte Awal harus diisi',

            'akte_awal_notaris.required' => 'Notaris Akte Akhir harus diisi',
            'akte_awal_notaris.max' => 'Notaris Akte Akhir maksimal 500 karakter',
            'akte_awal_notaris.min' => 'Notaris Akte Akhir minimal 3 karakter',
            'akte_awal_notaris.regex' => 'Notaris Akte Akhir harus huruf dan angka',

            'akte_akhir_no.required' => 'Nomer Akte Akhir harus diisi',
            'akte_akhir_no.max' => 'Nomer Akte Akhir maksimal 500 karakter',
            'akte_akhir_no.min' => 'Nomer Akte Akhir minimal 3 karakter',
            'akte_akhir_no.regex' => 'Nomer Akte Akhir harus huruf dan angka',

            'akte_akhir_tg.required' => 'Tanggal Terbit Akte Akhir harus diisi',

            'akte_akhir_notaris.required' => 'Notaris Akte Akhir harus diisi',
            'akte_akhir_notaris.max' => 'Notaris Akte Akhir maksimal 500 karakter',
            'akte_akhir_notaris.min' => 'Notaris Akte Akhir minimal 3 karakter',
            'akte_akhir_notaris.regex' => 'Notaris Akte Akhir harus huruf dan angka',

            'siup_no.required' => 'Nomer SIUP harus diisi',
            'siup_no.max' => 'Nomer SIUP maksimal 500 karakter',
            'siup_no.min' => 'Nomer SIUP minimal 3 karakter',
            'siup_no.regex' => 'Nomer SIUP harus huruf dan angka',

            'siup_tg_terbit.required' => 'Tanggal Terbit SIUP harus diisi',

            'siup_tg_expired.required' => 'Tanggal Masa Berlaku SIUP harus diisi',

            'npwp_no.required_if' => 'Nomer NPWP harus diisi jika perusahaan kena pajak',
            'npwp_no.max' => 'Nomer NPWP maksimal 500 karakter',
            'npwp_no.min' => 'Nomer NPWP minimal 3 karakter',
            'npwp_no.regex' => 'Nomer NPWP  harus huruf dan angka',

            'npwp_tg.required_if' => 'Tanggal Terbit NPWP harus diisi jika perusahaan kena pajak',

            'tdp_no.required' => 'Nomer TDP harus diisi',
            'tdp_no.max' => 'Nomer TDP maksimal 500 karakter',
            'tdp_no.min' => 'Nomer TDP minimal 3 karakter',
            'tdp_no.regex' => 'Nomer TDP  harus huruf dan angka',

            'tdp_tg_terbit.required' => 'Tanggal Terbit TDP harus diisi',

            'tdp_tg_expired.required' => 'Tanggal Masa Berlaku TDP harus diisi',

            'idp_no.required' => 'Nomer IDP harus diisi',
            'idp_no.max' => 'Nomer IDP maksimal 500 karakter',
            'idp_no.min' => 'Nomer IDP minimal 3 karakter',
            'idp_no.regex' => 'Nomer IDP  harus huruf dan angka',

            'idp_tg_terbit.required' => 'Tanggal Terbit IDP harus diisi',

            'idp_tg_expired.required' => 'Tanggal Masa Berlaku IDP harus diisi',

            'iujk_no.required' => 'Nomer Sertifikat harus diisi',
            'iujk_no.max' => 'Nomer Sertifikat maksimal 500 karakter',
            'iujk_no.min' => 'Nomer Sertifikat minimal 3 karakter',
            'iujk_no.regex' => 'Nomer Sertifikat  harus huruf dan angka',

            'iujk_tg_terbit.required' => 'Tanggal Terbit Sertifikat Keahliah harus diisi',

            'iujk_tg_expired.required' => 'Tanggal Masa Berlaku Sertifikat Keahliah harus diisi',

            'nm_direktur_utama.required' => 'Nama Direktur Utama harus diisi',
            'nm_direktur_utama.max' => 'Nama Direktur Utama maksimal 500 karakter',
            'nm_direktur_utama.min' => 'Nama Direktur Utama minimal 3 karakter',
            'nm_direktur_utama.regex' => 'Nama Direktur Utama  harus huruf dan angka',

            'nm_komisaris_utama.required' => 'Nama Komisaris Utama harus diisi',
            'nm_komisaris_utama.max' => 'Nama Komisaris Utama maksimal 500 karakter',
            'nm_komisaris_utama.min' => 'Nama Komisaris Utama minimal 3 karakter',
            'nm_komisaris_utama.regex' => 'Nama Komisaris Utama  harus huruf dan angka',

            'cp1_nama.required' => 'Nama harus diisi',
            'cp1_nama.max' => 'Nama maksimal 500 karakter',
            'cp1_nama.min' => 'Nama minimal 3 karakter',
            'cp1_nama.regex' => 'Nama harus huruf',

            'cp1_telp.required' => 'No Telepon harus diisi',
            'cp1_telp.digits_between' => 'No Telepon harus diantara 7 sampai 20 digit',

            'cp1_email.required' => 'Email harus diisi',
            'cp1_email.email' => 'Email harus format email',
            'cp1_email.max' => 'Nama maksimal 50 karakter',
            'cp1_email.min' => 'Nama minimal 4 karakter',

            'jml_peg_domestik.required' => 'Jumlah Pegawai Domestik harus diisi',
            'jml_peg_domestik.integer' => 'Jumlah Pegawai Domestik harus angka',

            'jml_peg_asing.required' => 'Jumlah Pegawai Asing harus diisi',
            'jml_peg_asing.integer' => 'Jumlah Pegawai Asing harus angka',

            'legal_dokumen.*.name.required' => 'Nama Dokumen harus diisi',
            'legal_dokumen.*.name.max' => 'Nama Dokumen maksimal 500 karakter',
            'legal_dokumen.*.name.min' => 'Nama Dokumen minimal 3 karakter',
            'legal_dokumen.*.name.regex' => 'Nama Dokumen  harus huruf dan angka',

            'legal_dokumen.*.file.required' => 'File Dokumen harus diisi',
            'legal_dokumen.*.file.mimes' => 'File Dokumen harus format PDF',

            'sertifikat_dokumen.*.name.required' => 'Nama Sertifikat harus diisi',
            'sertifikat_dokumen.*.name.max' => 'Nama Sertifikat maksimal 500 karakter',
            'sertifikat_dokumen.*.name.min' => 'Nama Sertifikat minimal 3 karakter',
            'sertifikat_dokumen.*.name.regex' => 'Nama Sertifikat  harus huruf dan angka',

            'sertifikat_dokumen.*.file.required' => 'File Sertifikat harus diisi',
            'sertifikat_dokumen.*.file.mimes' => 'File Sertifikat harus format PDF',

          ];
  }
}
