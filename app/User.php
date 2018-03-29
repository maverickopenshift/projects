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
      $data = \DB::table('__mtz_pegawai')
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
    public static function get_atasan(){
      $data = \DB::table('users_pegawai')
                ->join('users_atasan','users_atasan.users_pegawai_id','=','users_pegawai.id');
      if(self::is_subsidiary(\Auth::user()->username)){
        $data->select('pegawai_subsidiary.*')->join('pegawai_subsidiary','pegawai_subsidiary.n_nik','=','users_atasan.nik');
      }
      else{
        $data->select('pegawai.*')->join('pegawai','pegawai.n_nik','=','users_atasan.nik');
      }
      $data->where('users_id',\Auth::id());
      return $data->get();
    }
    public static function get_divisi_by_user_id($id=null){
      if(is_null($id)){
        $id = \Auth::id();
      }
      $data = \DB::table('v_users_pegawai')->select('*');
      $data->where('user_id',$id);
      $data = $data->first();
      return $data->objiddivisi;
    }
    public static function get_pegawai_by_id($id){
      $data = \DB::table('v_users_pegawai')->select('*');
      $data->where('user_id',$id);
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
    public static function get_all_real_disivi($key=false){
      $data = \DB::table('__mtz_pegawai')->selectRaw('divisi as id,divisi as title,count(divisi) as total_divisi');
      $data->orderBy('divisi','ASC');
      $data->whereNotNull('divisi');
      $data->where('divisi','!=',"");
      $data->groupBy(['divisi']);
      if(!empty($key)){
        $data->where('divisi', 'like', '%'.$key.'%');
      }
      return $data;
    }
    public static function get_all_real_unit_bisnis($key=false,$divisi='dsfafas'){
      $data = \DB::table('__mtz_pegawai')->selectRaw('unit_bisnis as id,unit_bisnis as title,count(unit_bisnis) as total_unit_bisnis');
      $data->orderBy('unit_bisnis','ASC');
      $data->whereNotNull('unit_bisnis');
      $data->where('unit_bisnis','!=',"");
      $data->groupBy(['unit_bisnis']);
      if(empty($divisi) || is_null($divisi)){
        $divisi = 'asdfsfaasdf';
      }
      $data->where('divisi',$divisi);
      if(!empty($key)){
        $data->where('unit_bisnis', 'like', '%'.$key.'%');
      }
      return $data;
    }
    public static function get_all_real_unit_kerja($key=false,$unit_bisnis='dsfafas'){
      $data = \DB::table('__mtz_pegawai')->selectRaw('unit_kerja as id,unit_kerja as title,count(unit_kerja) as total_unit_kerja');
      $data->orderBy('unit_kerja','ASC');
      $data->whereNotNull('unit_kerja');
      $data->where('unit_kerja','!=',"");
      $data->groupBy(['unit_kerja']);
      if(empty($unit_bisnis) || is_null($unit_bisnis)){
        $unit_bisnis = 'asdfsfaasdf';
      }
      $data->where('unit_bisnis',$unit_bisnis);
      if(!empty($key)){
        $data->where('unit_kerja', 'like', '%'.$key.'%');
      }
      return $data;
    }
    public static function get_all_real_posisi($key=false,$unit_kerja='dsfafas'){
      $data = \DB::table('__mtz_pegawai')->selectRaw('objidposisi as id,v_short_posisi as title,count(objidposisi) as total_posisi');
      $data->orderBy('v_short_posisi','ASC');
      $data->whereNotNull('v_short_posisi');
      $data->where('v_short_posisi','!=',"");
      $data->groupBy(['v_short_posisi']);
      if(empty($unit_kerja) || is_null($unit_kerja)){
        $unit_bisnis = 'asdfsfaasdf';
      }
      $data->where('unit_kerja',$unit_kerja);
      if(!empty($key)){
        $data->where('v_short_posisi', 'like', '%'.$key.'%');
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
      $divisi_long = \DB::table('rptom')->select('v_short_divisi')->where('objiddivisi',$divisi)->first()->v_short_divisi;
      // dd($divisi_long);
      $data = \DB::table('rptom')->selectRaw('objidunit as id,v_short_unit as title,count(objidposisi) as total_posisi');
      $data->orderBy('v_short_unit','ASC');
      $data->where('objiddivisi',$divisi)
           // ->where('v_long_unit','like','%'.$divisi_long.'%')
           ->groupBy(['objidunit']);
      return $data;
    }
    public static function get_real_unit_by_disivi($divisi){
      $divisi_long = \DB::table('rptom')->select('v_short_divisi')->where('objiddivisi',$divisi)->first()->v_short_divisi;
      $data = \DB::table('rptom')->selectRaw('objidunit as id,v_short_unit as title,v_long_unit,count(objidposisi) as total_posisi');
      $data->orderBy('v_short_unit','ASC');
      $data
           ->where('objiddivisi',$divisi)
           // ->where('v_long_unit','like','%'.$divisi_long.'%')
           ->groupBy(['objidunit']);
      $data = $data->get();
      $data->map(function ($item, $key) {
          $ubis = $item->v_long_unit;
          $exp  = @explode('/',$ubis);
          $exp_1 = '';
          $exp_2 = '';
          if(isset($exp[2])){
            $exp_1 = $exp[2];
          }
          if(isset($exp[3])){
            $exp_2 = '/'.$exp[3];
          }
          $item->title = $exp_1.$exp_2;
          // if(isset($exp[1])){
          //   $item->title = $exp[1].'/'.$item->title;
          // }
          // if(isset($exp[3])){
          //   $item->title = $exp[3];
          // }
          return $item;
      });
      return $data;
    }
    public static function get_user_telkom_by_nik($nik){
      $data = \DB::table('__mtz_pegawai')->select('*')->where('n_nik','=',$nik);
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
    public static function get_user_pegawai($id=null){
      if(is_null($id)){
        $id = \Auth::id();
      }
      $data = \DB::table('v_users_pegawai');
      $data =  $data->where('v_users_pegawai.user_id',$id)->first();
      // dd($data);
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
      else if(self::is_subsidiary($username)){
        return 'subsidiary';
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
    public static function get_subsidiary_user(){
      $data = \DB::table('v_pegawai_subsidiary')
                ->where('user_id',\Auth::id());
      return $data->first();
    }
    public static function get_subsidiary_user_by_id($id){
      $data = \DB::table('v_pegawai_subsidiary')
                ->where('user_id',$id);
      return $data->first();
    }
}
