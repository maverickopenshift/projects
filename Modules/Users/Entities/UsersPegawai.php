<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class UsersPegawai extends Model
{
    protected $fillable = [];
    protected $table = 'users_pegawai';
    
    public static function is_pegawai($id){
      $data = self::selectRaw('users_pegawai.id')
                ->join('pegawai', 'pegawai.n_nik', '=', 'users_pegawai.nik')
                ->where('users_pegawai.users_id',$id)->count();
      if($data>0){
        return true;
      }
      return false;
    }
    public static function get_by_userid($id,$type='organik'){
      $data = self::selectRaw('users_pegawai.id as ids,pegawai.*');
      if($type=='nonorganik'){
        $data->join('pegawai_nonorganik as pegawai', 'pegawai.n_nik', '=', 'users_pegawai.nik');
      }
      else if($type=='subsidiary'){
        $data->join('pegawai_subsidiary as pegawai', 'pegawai.n_nik', '=', 'users_pegawai.nik');
      }
      else{
        $data->join('pegawai as pegawai', 'pegawai.n_nik', '=', 'users_pegawai.nik');
      }
                
      $data = $data->where('users_pegawai.users_id',$id)->first();
      
      return $data;
    }
}
