<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class SubsidiaryTelkom extends Model
{
    protected $fillable = [];
    protected $table = 'subsidiary_telkom';
    public static function get_data($key=null){
      $data = \DB::table('subsidiary_telkom')
                ->select('*');    
      if(!empty($key)){
        $data->where(function($q) use ($key) {
            $q->orWhere('name', 'like', '%'.$key.'%');
        });
      }
      return $data->orderBy('name','asc');
    }
    public static function get_user($key=null,$subsidiary_id='iiiii'){
      $data = \DB::table('pegawai_subsidiary')
                ->select('*');    
      if(!empty($key)){
        $data->where(function($q) use ($key) {
            $q->orWhere('n_nik', 'like', '%'.$key.'%');
            $q->orWhere('v_nama_karyawan', 'like', '%'.$key.'%');
        });
      }
      if(empty($subsidiary_id) || $subsidiary_id==""){$subsidiary_id='12jkasjdkasjdlk';};
      $data->where('subsidiary_id',$subsidiary_id);
      return $data->orderBy('v_nama_karyawan','asc');
    }
}
