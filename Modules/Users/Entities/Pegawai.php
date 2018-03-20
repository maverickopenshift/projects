<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = 'pegawai';
    
    public static function get_by_nik($nik){
      $data = self::where('n_nik',$nik)->first();
      return $data;
    }
    public static function callProc($val,$type)
    {
       //return true;
        return \DB::statement('CALL PROC_MTZ_PEGAWAI("'.$val.'", "'.$type.'")');
    }
}
