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
    public static function get_by_userid($id){
      $data = self::selectRaw('users_pegawai.id as ids,pegawai.*')
                ->join('pegawai', 'pegawai.n_nik', '=', 'users_pegawai.nik')
                ->where('users_pegawai.users_id',$id)->first();
      return $data;
    }
}
