<?php

namespace Modules\Supplier\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Supplier extends Model
{
    protected $fillable = [];
    protected $table = 'supplier';

    public function user()
    {
        return $this->hasOne('App\User','id','id_user');
    }

    public function supplierSap()
    {
        return $this->hasMany('Modules\Supplier\Entities\SupplierSap','supplier_id','id');
    }

    public static function gen_userid(){
      $thn=date("y");
      $bln=date("m");
      $tgl=date("d");
      $today = date('Y-m-d');
      $pattern = "V";
      $cekid=$pattern.$tgl.$bln.$thn."0001";
      $count = DB::table('users')->where('username',$cekid)->count();
        if($count==0){
          $nextplgnya=$cekid;
        }
        else{
          //jika 001 sudah ada
          $dt = DB::table('users')
                  ->select('username')
                  ->where([
                      ['username', 'like', 'v'.$tgl.$bln.$thn.'%'],
                      [DB::raw('DATE(created_at)'), '=', $today]
                   ])
                   ->orderBy('created_at','DESC')
                   ->first();

          $last = $dt->username;
          $lastplg = substr($last, -4,4);
          $nextplg = $lastplg + 1;
          $idnya = sprintf('%04s', $nextplg);
          $nextplgnya=$pattern.$tgl.$bln.$thn.$idnya;
        }

        return $nextplgnya;
    }

    public static function gen_dmtnomer(){
  // dd("yo");
  $thn=date("Y");
  $loker = "COP-E0042000";
  $kode = "LG.530";
  $pattern = "TEL.";
  $nomer = "0001";
  $cekid=$pattern.$nomer.'/'.$kode.'/'.$loker.'/'.$thn;
  $count = DB::table('supplier')->where('no_rekanan_telkom',$cekid)->count();
    if($count==0){
      $nextplgnya=$cekid;
    }
    else{
      //jika 001 sudah ada
     $dt = \DB::table('supplier')
             ->select('no_rekanan_telkom')
             ->orderBy('updated_at','DESC')
             ->first();

      $last = $dt->no_rekanan_telkom;
      $lastplg = substr($last, 4,4);
      $nextplg = intval($lastplg) + 1;
      $idnya = sprintf('%04s', $nextplg);
      $nextplgnya=$pattern.$idnya.'/'.$kode.'/'.$loker.'/'.$thn;
    }

    return $nextplgnya;
}

}
