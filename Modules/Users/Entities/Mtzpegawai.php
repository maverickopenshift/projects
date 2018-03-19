<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class Mtzpegawai extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = '__mtz_pegawai';
    
    public static function get_by_nik($nik){
      $data = self::where('n_nik',$nik)->first();
      return $data;
    }
}
