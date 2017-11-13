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
    public static function get_user_telkom($key=null,$type=null,$posisi=null){
      $data = \DB::table('pegawai')
                ->select('*');    
      if(!empty($key)){
        $data->where(function($q) use ($key) {
            $q->orWhere('n_nik', 'like', '%'.$key.'%');
            $q->orWhere('v_nama_karyawan', 'like', '%'.$key.'%');
        });
      }
      if(!empty($type) && !empty($posisi)){
        $data->where('objiddivisi',$type);
        $data->where('v_band_posisi','<',$posisi);
      }
      return $data->orderBy('v_short_posisi','desc');
    }
    public static function get_atasan_by_divisi($type,$posisi){
      $data = \DB::table('pegawai')
                ->select('*');    
      $data->where('objiddivisi',$type);
      $data->where('v_band_posisi','<',$posisi);
      return $data->orderBy('v_band_posisi','asc')->get();
    }
    public static function get_divisi_by_user_id(){
      $data = \DB::table('users_pegawai')->select('*');  
      $data->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');  
      $data->where('users_pegawai.users_id',\Auth::id())->orderBy('users_pegawai.users_id','desc');
      $data = $data->first();
      return $data->objiddivisi;
    }
    public static function get_unit_by_disivi(){
      $data = \DB::table('rptom')->selectRaw('objidunit as id,v_short_unit as title,count(objidposisi) as total_posisi');
      $data->where('objiddivisi',self::get_divisi_by_user_id())->groupBy(['objidunit','v_short_unit']);
      return $data;
    } 
    public static function get_posisi_by_unit($unit){
      $data = \DB::table('rptom')->selectRaw('objidposisi as id,v_short_posisi as title');
      $data->where('objidunit',$unit);
      return $data;
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
    public static function get_user_pegawai(){
      $data = \DB::table('users_pegawai')
                ->join('pegawai', 'pegawai.n_nik', '=', 'users_pegawai.nik')
                ->where('users_pegawai.users_id',\Auth::id());
      return $data->first();
    }
}
