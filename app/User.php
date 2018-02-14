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
    public static function get_divisi_by_user_id($id=null){
      if(is_null($id)){
        $id = \Auth::id();
      }
      $data = \DB::table('users_pegawai')->select('*');  
      $data->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');  
      $data->where('users_pegawai.users_id',$id)->orderBy('users_pegawai.users_id','desc');
      $data = $data->first();
      return $data->objiddivisi;
    }
    public static function get_pegawai_by_id($id){
      $data = \DB::table('users_pegawai')->select('*');  
      $data->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');  
      $data->where('users_pegawai.users_id',$id)->orderBy('users_pegawai.users_id','desc');
      $data = $data->first();
      return $data;
    }
    public static function get_unit_by_disivi(){
      $data = \DB::table('rptom')->selectRaw('objidunit as id,v_short_unit as title,count(objidposisi) as total_posisi');
      $data->where('objiddivisi',self::get_divisi_by_user_id())->groupBy(['objidunit','v_short_unit']);
      return $data;
    }
    public static function get_all_disivi($key=false){
      $data = \DB::table('rptom')->selectRaw('objiddivisi as id,v_short_divisi as title,count(objidposisi) as total_divisi');
      $data->orderBy('v_short_divisi','ASC');
      $data->whereNotNull('v_short_divisi');
      $data->groupBy(['objiddivisi','v_short_divisi']);
      if(!empty($key)){
        $data->where('v_short_divisi', 'like', '%'.$key.'%');
      }
      return $data;
    }
    public static function get_unit($key=false,$divisi=false){
      $data = \DB::table('rptom')->selectRaw('objidunit as id,v_short_unit as title,count(objidunit) as total_unit');
      $data->orderBy('v_short_unit','ASC');
      $data->whereNotNull('v_short_unit');
      $data->groupBy(['objidunit','v_short_unit']);
      if(!empty($divisi)){
        $data->where('objiddivisi',$divisi);
      }
      if(!empty($key)){
        $data->where('v_short_unit', 'like', '%'.$key.'%');
      }
      return $data;
    } 
    public static function get_posisi($key=false,$unit=false){
      $data = \DB::table('rptom')->selectRaw('objidposisi as id,v_short_posisi as title,count(objidposisi) as total_posisi');
      $data->orderBy('v_short_posisi','ASC');
      $data->whereNotNull('v_short_posisi');
      $data->groupBy(['objidposisi','v_short_posisi']);
      if(!empty($unit)){
        $data->where('objidunit',$unit);
      }
      if(!empty($key)){
        $data->where('v_short_posisi', 'like', '%'.$key.'%');
      }
      return $data;
    } 
    public static function get_posisi_by_unit($unit){
      $data = \DB::table('rptom')->selectRaw('objidposisi as id,v_short_posisi as title');
      $data->where('objidunit',$unit);
      return $data;
    }
    public static function get_unit_by_disivi2($divisi){
      $data = \DB::table('rptom')->selectRaw('objidunit as id,v_short_unit as title,count(objidposisi) as total_posisi');
      $data->orderBy('v_short_unit','ASC');
      $data->where('objiddivisi',$divisi)->groupBy(['objidunit','v_short_unit']);
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
                ->where('users_pegawai.users_id',\Auth::id())->first();
      if(!$data){
        $data = \DB::table('users_pegawai')
                  ->join('pegawai_nonorganik', 'pegawai_nonorganik.n_nik', '=', 'users_pegawai.nik')
                  ->where('users_pegawai.users_id',\Auth::id())->first();
      }
      return $data;
    }
    public static function get_user_by_role($role){
      $data = \DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->selectRaw('users.id as id,pegawai.v_nama_karyawan as name,pegawai.n_nik as nik,pegawai.objiddivisi as divisi,pegawai.v_short_divisi as divisi_name,pegawai.objidunit as unit,pegawai.v_short_unit as unit_name,pegawai.objidposisi as posisi,pegawai.v_short_posisi as posisi_name')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->join('users_pegawai', 'users_pegawai.users_id', '=', 'users.id')
                ->join('pegawai', 'pegawai.n_nik', '=', 'users_pegawai.nik')
                ->where('roles.name',$role);
      return $data;
    }
    public static function check_usertype($username){
      if($username=='admin'){
        return 'admin';
      }
      else if(self::is_vendor($username)){
        return 'vendor';
      }
      else if(self::is_organik($username)){
        return 'organik';
      }
      else if(self::is_nonorganik($username)){
        return 'nonorganik';
      }
      else{
        return 'anonimouse';
      }
    }
    public static function is_vendor($username){
      $count = \DB::table('supplier')->select('kd_vendor')
                ->where('kd_vendor',$username)->count();
      if($count>0){
        return true;
      }
      return false;
    }
    public static function is_organik($username){
      $count = \DB::table('pegawai')->select('n_nik')
                ->where('n_nik',$username)->count();
      if($count>0){
        return true;
      }
      return false;
    }
    public static function is_nonorganik($username){
      $count = \DB::table('pegawai_nonorganik')->select('n_nik')
                ->where('n_nik',$username)->count();
      if($count>0){
        return true;
      }
      return false;
    }
    public static function is_subsidiary($username){
      $count = \DB::table('users')->select('username')
                ->where('username',$username)
                ->where('user_type','subsidiary')
                ->count();
      if($count>0){
        return true;
      }
      return false;
    }
    
}
