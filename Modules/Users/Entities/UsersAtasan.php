<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class UsersAtasan extends Model
{
    protected $fillable = [];
    protected $table = 'users_atasan';
    
    public static function get_by_userid($id){
      $data = self::selectRaw('users_atasan.id as id,pegawai.n_nik as nik,pegawai.v_nama_karyawan as name,CONCAT(pegawai.n_nik, \'@\', \'telkom.co.id\') as email, pegawai.v_short_posisi as jabatan')
                ->join('users_pegawai', 'users_pegawai.id', '=', 'users_atasan.users_pegawai_id')
                ->join('pegawai', 'pegawai.n_nik', '=', 'users_atasan.nik')
                ->where('users_pegawai.users_id',$id);
      return $data->get();
    }
}
