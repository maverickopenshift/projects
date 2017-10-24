<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Helpers\Helpers;
use App\Helpers\CustomErrors;
use App\User;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Entities\SupplierMetadata;
use Validator;
use DB;


class SupplierAddController extends Controller
{
  public function index()
  {
      //dd(Supplier::gen_userid());
      $supplier = [];
      $page_title = 'Add Supplier';
      $action_type = 'add';
      return view('supplier::form')->with(compact('supplier','page_title','action_type'));
  }
  
  public function store(Request $request)
  {
    //dd($request->all());
    $rules = array (
        'bdn_usaha'         => 'required|max:250|min:2|regex:/^[a-z0-9 .\-]+$/i',
        'nm_vendor'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'nm_vendor_uq'      => 'max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'prinsipal_st'      => 'required|boolean',
        'klasifikasi_usaha.*' => 'required|regex:/^[a-z0-9 .\-]+$/i',
        'pengalaman_kerja'  => 'required|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i',
        'alamat'            => 'required|max:1000|min:10|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i',
        'kota'              => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'kd_pos'            => 'required|digits_between:3,20',
        'telepon'           => 'required|digits_between:7,20',
        'fax'               => 'required|digits_between:7,20',
        'email'             => 'required|max:50|min:4|email',
        'password'          => 'required|max:50|min:6|confirmed',
        'web_site'          => 'sometimes|nullable|url',
        'induk_perus'       => 'sometimes|nullable|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'anak_perusahaan.*' => 'sometimes|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'asset'             => 'required|max:500|min:3|digits_between:3,50',
        'bank_nama'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'bank_cabang'       => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'bank_norek'        => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'bank_kota'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_awal_no'      => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_awal_tg'      => 'required|date_format:"Y-m-d"',
        'akte_awal_notaris' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_akhir_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_akhir_tg'     => 'required|date_format:"Y-m-d"',
        'akte_akhir_notaris'=> 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'siup_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'siup_tg_terbit'     => 'required|date_format:"Y-m-d"',
        'siup_tg_expired'     => 'required|date_format:"Y-m-d"',
        'siup_kualifikasi'     => 'required|in:"1","2","3"',
        'pkp'      => 'required|boolean',
        'npwp_no'     => 'required_if:pkp,"1"|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'npwp_tg'     => 'required_if:pkp,"1"|nullable|date_format:"Y-m-d"',
        'tdp_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'tdp_tg_terbit'     => 'required|date_format:"Y-m-d"',
        'tdp_tg_expired'     => 'required|date_format:"Y-m-d"',
        'idp_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'idp_tg_terbit'     => 'required|date_format:"Y-m-d"',
        'idp_tg_expired'     => 'required|date_format:"Y-m-d"',
        'iujk_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'iujk_tg_terbit'     => 'required|date_format:"Y-m-d"',
        'iujk_tg_expired'     => 'required|date_format:"Y-m-d"',
        'nm_direktur_utama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'nm_komisaris_utama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'cp1_nama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'cp1_telp'     => 'required|digits_between:7,20',
        'cp1_email'     => 'required|max:50|min:4|email',
        'jml_peg_domestik'     => 'required|integer',
        'jml_peg_asing'     => 'required|integer',
        'legal_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i', 
        'legal_dokumen.*.file' => 'required|mimes:pdf', 
        'sertifikat_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i', 
        'sertifikat_dokumen.*.file' => 'required|mimes:pdf', 
    );
    $validator = Validator::make($request->all(), $rules,CustomErrors::supplier());
    if ($validator->fails ()){
      return redirect()->back()
                  ->withInput($request->input())
                  ->withErrors($validator);
    }
    else {
      $kd_vendor = $this->generate_id();
      $user = new User();
      $user->name = $request->nm_vendor;
      $user->username = $kd_vendor;
      $user->phone = $request->telepon;
      $user->email = $request->email;
      $user->confirmed = 1;
      $user->actived = 1;
      $user->password = bcrypt($request->password);
      $user->save();
      $user->attachRole('vendor');
      
      $data = new Supplier();
      $data->bdn_usaha = $request->bdn_usaha;
      $data->id_user = $user->id;
      $data->nm_vendor = $request->nm_vendor;
      $data->nm_vendor_uq = $request->nm_vendor_uq;
      $data->prinsipal_st = $request->prinsipal_st;
      $data->alamat = $request->alamat;
      $data->kota = $request->kota;
      $data->kd_pos = $request->kd_pos;
      $data->telepon = $request->telepon;
      $data->fax = $request->fax;
      $data->email = $request->email;
      $data->web_site = $request->web_site;
      $data->induk_perus = $request->induk_perus;
      $data->asset = $request->asset;
      $data->bank_nama = $request->bank_nama;
      $data->bank_cabang = $request->bank_cabang;
      $data->bank_norek = $request->bank_norek;
      $data->akte_awal_no = $request->akte_awal_no;
      $data->akte_awal_tg = $request->akte_awal_tg;
      $data->akte_awal_notaris = $request->akte_awal_notaris;
      $data->akte_akhir_no = $request->akte_akhir_no;
      $data->akte_akhir_tg = $request->akte_akhir_tg;
      $data->akte_akhir_notaris = $request->akte_akhir_notaris;
      $data->siup_no = $request->siup_no;
      $data->siup_tg_terbit = $request->siup_tg_terbit;
      $data->siup_tg_expired = $request->siup_tg_expired;
      $data->siup_kualifikasi = $request->siup_kualifikasi;
      $data->pkp = $request->pkp;
      $data->npwp_no = $request->npwp_no;
      $data->npwp_tg = $request->npwp_tg;
      $data->tdp_no = $request->tdp_no;
      $data->tdp_tg_terbit = $request->tdp_tg_terbit;
      $data->tdp_tg_expired = $request->tdp_tg_expired;
      $data->idp_no = $request->idp_no;
      $data->idp_tg_terbit = $request->idp_tg_terbit;
      $data->idp_tg_expired = $request->idp_tg_expired;
      $data->iujk_no = $request->iujk_no;
      $data->iujk_tg_terbit = $request->iujk_tg_terbit;
      $data->iujk_tg_expired = $request->iujk_tg_expired;
      $data->cp1_nama = $request->cp1_nama;
      $data->cp1_telp = $request->cp1_telp;
      $data->cp1_email = $request->cp1_email;
      $data->jml_peg_domestik = $request->jml_peg_domestik;
      $data->jml_peg_asing = $request->jml_peg_asing;
      $data->approval_at = DB::raw('now()');
      $data->vendor_status = 1;
      $data->created_by = \Auth::user()->username;
      $data->kd_vendor = $kd_vendor;
      $data->save();
      
      $mt_data = new SupplierMetadata();
      $mt_data->id_object    = $data->id;
      $mt_data->object_type  = 'vendor';
      $mt_data->object_key   = 'pengalaman_kerja';
      $mt_data->object_value = $request->pengalaman_kerja;
      $mt_data->save();
      
      $mt_data = new SupplierMetadata();
      $mt_data->id_object    = $data->id;
      $mt_data->object_type  = 'vendor';
      $mt_data->object_key   = 'bank_kota';
      $mt_data->object_value = $request->bank_kota;
      $mt_data->save();
      
      $mt_data = new SupplierMetadata();
      $mt_data->id_object    = $data->id;
      $mt_data->object_type  = 'vendor';
      $mt_data->object_key   = 'nm_direktur_utama';
      $mt_data->object_value = $request->nm_direktur_utama;
      $mt_data->save();
      
      $mt_data = new SupplierMetadata();
      $mt_data->id_object    = $data->id;
      $mt_data->object_type  = 'vendor';
      $mt_data->object_key   = 'nm_komisaris_utama';
      $mt_data->object_value = $request->nm_komisaris_utama;
      $mt_data->save();
      
      foreach($request->klasifikasi_usaha as $k){
        $mt_data = new SupplierMetadata();
        $mt_data->id_object    = $data->id;
        $mt_data->object_type  = 'vendor';
        $mt_data->object_key   = 'klasifikasi_usaha';
        $mt_data->object_value = $k;
        $mt_data->save();
      };
      foreach($request->anak_perusahaan as $a){
        $mt_data = new SupplierMetadata();
        $mt_data->id_object    = $data->id;
        $mt_data->object_type  = 'vendor';
        $mt_data->object_key   = 'anak_perusahaan';
        $mt_data->object_value = $a;
        $mt_data->save();
      };
      foreach($request->legal_dokumen as $l => $val){
        $fileName   = Helpers::set_filename($kd_vendor,$val['name']);
        $val['file']->storeAs('supplier/legal_dokumen', $fileName);
        
        $mt_data = new SupplierMetadata();
        $mt_data->id_object    = $data->id;
        $mt_data->object_type  = 'vendor';
        $mt_data->object_key   = 'legal_dokumen';
        $mt_data->object_value = json_encode(['name'=>$val['name'],'file'=>$fileName]);
        $mt_data->save();
      };
      foreach($request->sertifikat_dokumen as $l => $val){
        $fileName   = Helpers::set_filename($kd_vendor,$val['name']);
        $val['file']->storeAs('supplier/sertifikat_dokumen', $fileName);
        
        $mt_data = new SupplierMetadata();
        $mt_data->id_object    = $data->id;
        $mt_data->object_type  = 'vendor';
        $mt_data->object_key   = 'sertifikat_dokumen';
        $mt_data->object_value = json_encode(['name'=>$val['name'],'file'=>$fileName]);
        $mt_data->save();
      };
      return redirect()->route('supplier')->with('message', 'Data supplier berhasil ditambahkan!');
    }
  }
  
  private function generate_id(){
    $sup = new Supplier();
    $id = $sup->gen_userid();
    $count=User::where('username',$id)->count();
    if($count>0){
      return $this->generate_id();
    }
    else{
      return $id;
    }
  }
}
