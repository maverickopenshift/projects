<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','username', 'email', 'password','phone','data',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function supplier()
    {
        return $this->hasOne('Modules\Supplier\Entities\Supplier','id_user');
    }
    public static function get_user_telkom($key=null){
      $data = \DB::table('pegawai')
                ->select('*');    
      if(!empty($key)){
        $data->where(function($q) use ($key) {
            $q->orWhere('n_nik', 'like', '%'.$key.'%');
            $q->orWhere('v_nama_karyawan', 'like', '%'.$key.'%');
        });
      }
      return $data->orderBy('v_short_posisi','desc');
    }
    public static function get_user_telkom_by_nik($nik){
      $data = \DB::table('pegawai')->select('*')->where('n_nik','=',$nik);
      return $data;
    }
    public static function get_user_vendor($key=null){
      $data = \DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->join('supplier', 'supplier.id_user', '=', 'users.id')
                ->select('users.id','users.name','users.username','supplier.bdn_usaha')
                ->whereIn('roles.name',['vendor']);
      if(!empty($key)){
        $data->where(function($q) use ($key) {
            $q->orWhere('users.username', 'like', '%'.$key.'%');
            $q->orWhere('users.name', 'like', '%'.$key.'%');
        });
      }
      return $data;
    }
}
