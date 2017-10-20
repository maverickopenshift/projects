<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
  protected $table = 'supplier';
  protected $filltable=
  ['bdn_usaha','nm_vendor','prinsipal_st','alamat','kota','kd_pos','negara','telepon',
    'fax','email','web_site','induk_perus','asset','bank_cabang','bank_norek','akte_awal_no',
  'akte_awal_tg','akte_awal_notaris','akte_akhir_no','akte_akhir_tg','akte_akhir_notaris','siup_no','siup_tg_terbit','siup_tg_expired',
'siup_kualifikasi','pkp','npwp_no','npwp_tg','tdp_no','tdp_tg_terbit','tdp_tg_expired','idp_no',
'idp_tg_terbit','idp_tg_expired','cp1_nama','cp1_telp','cp1_email','jml_peg_domestik','jml_peg_asing'];


}
