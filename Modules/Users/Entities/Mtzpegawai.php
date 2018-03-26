<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mtzpegawai extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = '__mtz_pegawai';
    
    public static function get_by_nik($nik){
      $data = self::where('n_nik',$nik)->first();
      return $data;
    }
    public static function get_rptom($select,$field,$value){
      $data = DB::table('rptom')->select($select)->where($field,$value)->first();
      return $data->{$select};
    }
}
