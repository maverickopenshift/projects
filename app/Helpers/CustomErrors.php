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
            'klasifikasi_usaha.*.required' => 'Klasifikasi usaha harus diisi',
            'klasifikasi_usaha.*.regex' => 'Klasifikasi usaha harus huruf dan angka',
          ];
  }
}