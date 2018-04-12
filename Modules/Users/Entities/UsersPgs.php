<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class UsersPgs extends Model
{
    protected $fillable = [];
    protected $table = 'users_pgs';
    
    public function role(){
      return $this->hasOne('App\Role','id','role_id');
    }
    public static function is_pgs($id=null){
      if(is_null($id)){
        $id = \Auth::id();
      }
      $data = self::where('users_id',$id)->first();
      if($data){
        return true;
      }
      return false;
    }
    public static function get_one($id=null){
      if(is_null($id)){
        $id = \Auth::id();
      }
      $data = self::where('users_id',$id)->where('pgs_status','active')->first();
      return $data;
    }
    public static function user_pgs($user,$id=null){
      if(is_null($id)){
        $id = \Auth::id();
      }
      if($user->pegawai_type=='organik'){
        $data = self::get_one($id);
        $user->objiddivisi    = $data->objiddivisi;
        $user->c_kode_divisi  = $data->c_kode_divisi;
        $user->v_short_divisi = $data->v_short_divisi;
        $user->objidunit      = $data->objidunit;
        $user->c_kode_unit    = $data->c_kode_unit;
        $user->v_short_unit   = $data->v_short_unit;
        $user->objidposisi    = $data->objidposisi;
        $user->c_kode_posisi  = $data->c_kode_posisi;
        $user->v_short_posisi = $data->v_short_posisi;
        $user->v_band_posisi  = $data->v_band_posisi;
        $user->divisi         = $data->divisi;
        $user->unit_bisnis    = $data->unit_bisnis;
        $user->unit_kerja     = $data->unit_kerja;
        $user->position       = $data->position;
      }
      return $user;
    }
}
