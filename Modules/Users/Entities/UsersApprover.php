<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class UsersApprover extends Model
{
    protected $fillable = [];
    protected $table = 'users_approver';
    
    public static function get_by_userid($id){
      $data = self::selectRaw('users_approver.id as id,pegawai.n_nik as nik,pegawai.v_nama_karyawan as name,CONCAT(pegawai.n_nik, \'@\', \'telkom.co.id\') as email, pegawai.v_short_posisi as jabatan')
                ->join('users_pegawai', 'users_pegawai.id', '=', 'users_approver.users_pegawai_id')
                ->join('pegawai', 'pegawai.n_nik', '=', 'users_approver.nik')
                ->where('users_pegawai.users_id',$id);
      return $data->get();
    }
}
