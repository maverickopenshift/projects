<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Helpers\Helpers;
use App\Helpers\CustomErrors;
use App\User;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Entities\SupplierMetadata;
use Modules\Supplier\Entities\SupplierActivity;
use Validator;
use Response;
use Auth;

class SupplierEditController extends Controller
{
  public function index(Request $request)
  {

      $id = $request->id;
      $supplier = Supplier::where('id',$id)->first();
      
      if(!$supplier){
        abort(500);
      }
      $supplier->asset = $supplier->asset+0;
      
      $supplier->akte_awal_tg     = Helpers::date_set($supplier->akte_awal_tg);
      $supplier->akte_akhir_tg    = Helpers::date_set($supplier->akte_akhir_tg);
      $supplier->siup_tg_terbit   = Helpers::date_set($supplier->siup_tg_terbit);
      $supplier->siup_tg_expired  = Helpers::date_set($supplier->siup_tg_expired);
      $supplier->npwp_tg          = Helpers::date_set($supplier->npwp_tg);
      $supplier->tdp_tg_terbit    = Helpers::date_set($supplier->tdp_tg_terbit);
      $supplier->tdp_tg_expired   = Helpers::date_set($supplier->tdp_tg_expired);
      $supplier->idp_tg_terbit   = Helpers::date_set($supplier->idp_tg_terbit);
      $supplier->idp_tg_expired   = Helpers::date_set($supplier->idp_tg_expired);

      $dt_sertifikat_dokumen = SupplierMetadata::get_sertifikat_dokumen($id);
      foreach($dt_sertifikat_dokumen as $k=>$dt_sertifikat_dokumen){
        $d = json_decode($dt_sertifikat_dokumen->object_value);
        $iujk_no[]          = $d->iujk_no;
        $iujk_tg_terbit[]   = Helpers::date_set($d->iujk_tg_terbit);
        $iujk_tg_expired[]  = Helpers::date_set($d->iujk_tg_expired);
        $name[]             = $d->name;
        $file[]             = $d->file;
      }

      $supplier->iujk_no                      = $iujk_no;
      $supplier->iujk_tg_terbit               = $iujk_tg_terbit;
      $supplier->iujk_tg_expired              = $iujk_tg_expired;
      $supplier->nama_sertifikat_dokumen      = $name;
      $supplier->file_sertifikat_dokumen_old  = $file;

      $dt_klasifikasi = SupplierMetadata::select('object_value')->where([
        ['id_object','=',$id],
        ['object_key','=','klasifikasi_usaha']
      ])->get();
      $klasifikasi_kode=array();
      $klasifikasi_text=array();
      
      foreach($dt_klasifikasi as $dt_klasifikasi){
        if($dt_klasifikasi->object_value!=""){
          $d = json_decode($dt_klasifikasi->object_value);
          $klasifikasi_kode[] = $d->kode;
          $klasifikasi_text[] = $d->text;
        }
      }
      $supplier->klasifikasi_text = $klasifikasi_text;
      $supplier->klasifikasi_kode = $klasifikasi_kode;


      $dt_anak_perus = SupplierMetadata::select('object_value')->where([
        ['id_object','=',$id],
        ['object_key','=','anak_perusahaan']
      ])->get();
      foreach($dt_anak_perus as $dt_anak_perus){
        $anak_perus[] = $dt_anak_perus->object_value;
      }
      $supplier->anak_perusahaan = $anak_perus;

      $dt_meta = SupplierMetadata::select('object_value','object_key')->where([
        ['id_object','=',$id],
        // ['object_key','IN','"bank_kota","pengalaman_kerja","nm_direktur_utama","nm_komisaris_utama"']
      ])
      ->whereIn('object_key',["bank_kota","pengalaman_kerja","nm_direktur_utama","nm_komisaris_utama"])
      ->get();
      
      foreach($dt_meta as $dt){
        if($dt->object_key=='bank_kota'){
          $supplier->bank_kota = $dt->object_value;
        }
        if($dt->object_key=='pengalaman_kerja'){
          $supplier->pengalaman_kerja = $dt->object_value;
        }
        if($dt->object_key=='nm_direktur_utama'){
          $supplier->nm_direktur_utama = $dt->object_value;
        }
        if($dt->object_key=='nm_komisaris_utama'){
          $supplier->nm_komisaris_utama = $dt->object_value;
        }
      }

      $dt_legal_dokumen = SupplierMetadata::get_legal_dokumen($id);
      foreach($dt_legal_dokumen as $k=>$dt_legal_dokumen){
        $d = json_decode($dt_legal_dokumen->object_value);
        $legal_dokumen_nama[$k] = $d->name;
        $legal_dokumen[$k] = $d->file;
      }
      $supplier->legal_dokumen_nama = $legal_dokumen_nama;
      $supplier->legal_dokumen = $legal_dokumen;

      foreach($legal_dokumen as $k=>$v){
        $file_old_ld[] = $v;
      }
      $supplier->file_old_ld = $file_old_ld;

      $page_title = ucfirst($request->status).' Supplier';
      $action_type = $request->status;

      return view('supplier::form')->with(compact('supplier','page_title','action_type','id'));
  }

  public function update_ajax(Request $request)
  {
    $id = $request->id;
    $asset = $request->asset;
    
    $rules = array (
        'komentar'          => 'required|max:250|min:2',
        'bdn_usaha'         => 'required|max:250|min:2',
        'nm_vendor'         => 'required|max:500|min:3',
        'nm_vendor_uq'      => 'max:500|min:3',
        'prinsipal_st'      => 'required|boolean',
        // 'klasifikasi_usaha.*' => 'required',
        'pengalaman_kerja'  => 'required|min:10|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i',
        'alamat'            => 'required|max:1000|min:10|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i',
        'kota'              => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'kd_pos'            => 'required|max:5',
        'telepon'           => 'required|digits_between:7,12',
        'fax'               => 'required|digits_between:7,12',
        // 'email'             => 'required|max:50|min:4|email',
        // 'password'          => 'required|max:50|min:6|confirmed',
        'web_site'          => 'sometimes|nullable|url',
        'induk_perus'       => 'sometimes|nullable|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'anak_perusahaan.*' => 'sometimes|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'asset'             => 'required|max:500|min:3|regex:/^[0-9 .]+$/i',
        'bank_nama'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'bank_cabang'       => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'bank_norek'        => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'bank_kota'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_awal_no'      => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_awal_tg'      => 'required|date_format:"d-m-Y"',
        'akte_awal_notaris' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_akhir_no'     => 'sometimes|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_akhir_tg'     => 'sometimes|nullable|date_format:"d-m-Y"',
        'akte_akhir_notaris'=> 'sometimes|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'siup_no'           => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'siup_tg_terbit'    => 'required|date_format:"d-m-Y"',
        'siup_tg_expired'   => 'required|date_format:"d-m-Y"|after:siup_tg_terbit',
        'siup_kualifikasi'  => 'required|in:"1","2","3"',
        'pkp'               => 'required|boolean',
        'npwp_no'           => 'required_if:pkp,"1"|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'npwp_tg'           => 'required_if:pkp,"1"|nullable|date_format:"d-m-Y"',
        'tdp_no'            => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'tdp_tg_terbit'     => 'required|date_format:"d-m-Y"',
        'tdp_tg_expired'    => 'required|date_format:"d-m-Y"|after:tdp_tg_terbit',
        'idp_no'            => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'idp_tg_terbit'     => 'required|date_format:"d-m-Y"',
        'idp_tg_expired'    => 'required|date_format:"d-m-Y"|after:idp_tg_terbit',
        'nm_direktur_utama' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'nm_komisaris_utama'=> 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'cp1_nama'          => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'cp1_telp'          => 'required|digits_between:7,20',
        'cp1_email'         => 'required|max:50|min:4|email',
        'jml_peg_domestik'  => 'required|integer',
        'jml_peg_asing'     => 'required|integer',
        'legal_dokumen_name.*' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        // 'sertifikat_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
    );

    $rule_iujk_no = (count($request['iujk_no'])>1)?'required':'sometimes|nullable';
    $rule_iujk_tg_terbit = (count($request['iujk_tg_terbit'])>1)?'required':'sometimes|nullable';
    $rule_iujk_tg_expired = (count($request['iujk_tg_expired'])>1)?'required':'sometimes|nullable';
    $rule_nama_sertifikat_dokumen = (count($request['nama_sertifikat_dokumen'])>1)?'required':'sometimes|nullable';

    $rules['iujk_no.*']                    = $rule_iujk_no.'|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i';
    $rules['iujk_tg_terbit.*']             = $rule_iujk_tg_terbit.'|date_format:"d-m-Y"';
    $rules['iujk_tg_expired.*']            = $rule_iujk_tg_expired.'|date_format:"d-m-Y"|after:iujk_tg_terbit.*';
    $rules['nama_sertifikat_dokumen.*']    = $rule_nama_sertifikat_dokumen.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
    
    if(isset($request->file_sertifikat_dokumen_old)){
      foreach($request->file_sertifikat_dokumen_old as $k => $v){
        if(isset($request->file_sertifikat_dokumen[$k]) && is_object($request->file_sertifikat_dokumen[$k]) && !empty($v)){//jika ada file baru
          $new_sertifikat[] = '';
          $new_sertifikat_up[] = $request->file_sertifikat_dokumen[$k];
          $rules['file_sertifikat_dokumen.'.$k] = 'sometimes|nullable|mimes:pdf';
        }
        else if(empty($v)){
          $rules['file_sertifikat_dokumen.'.$k] = 'sometimes|nullable|mimes:pdf';
          if(!isset($request->file_sertifikat_dokumen[$k])){
            $new_sertifikat[] = $v;
            $new_sertifikat_up[] = $v;
          }
          else{
            $new_sertifikat[] = '';
            $new_sertifikat_up[] = $request->file_sertifikat_dokumen[$k];
          }
        }
        else{
          $new_sertifikat[] = $v;
          $new_sertifikat_up[] = $v;
        }
      }
      $request->merge(['file_sertifikat_dokumen' => $new_sertifikat]);
    }
    $request->merge(['asset' => $asset]);

    //$check_new_legal_dokumen = false;
    if(isset($request->legal_dokumen_old)){
      foreach($request->legal_dokumen_old as $k => $v){
        if(isset($request->legal_dokumen[$k]) && is_object($request->legal_dokumen[$k]) && !empty($v)){//jika ada file baru
          $new_dokumen[] = '';
          $new_dokumen_up[] = $request->legal_dokumen[$k];
          $rules['legal_dokumen.'.$k] = 'required|mimes:pdf';
        }
        else if(empty($v)){
          $rules['legal_dokumen.'.$k] = 'required|mimes:pdf';
          if(!isset($request->legal_dokumen[$k])){
            $new_dokumen[] = $v;
            $new_dokumen_up[] = $v;
          }
          else{
            $new_dokumen[] = '';
            $new_dokumen_up[] = $request->legal_dokumen[$k];
          }
        }
        else{
          $new_dokumen[] = $v;
          $new_dokumen_up[] = $v;
        }
      }
      $request->merge(['legal_dokumen' => $new_dokumen]);
    }

    $validator = Validator::make($request->all(), $rules,CustomErrors::supplier());
    $validator->after(function ($validator) use ($request) {
        if (!isset($request['klasifikasi_kode'][0])) {
            $validator->errors()->add('klasifikasi_err', 'Klasifikasi Usaha harus dipilih!');
        }
    });
    
    if ($validator->fails ()){
      /*
      return redirect()->back()->withInput($request->input())->withErrors($validator);
      */

      return Response::json (array(
        'errors' => $validator->getMessageBag()->toArray()
      ));
    }
    else {
      $id = $request->id;

      $data = Supplier::where('id',$id)->first();
      if(!$data){
        abort(500);
      }

      $user = User::where('username',$data->kd_vendor)->first();
      $user->name   = $request->nm_vendor;
      $user->phone  = $request->telepon;
        $bdn_usaha  = $request->bdn_usaha;
        $inisial    = $request->nm_vendor_uq;
        $gabung     = $bdn_usaha." - ".$inisial;
      $user->data   = $gabung;
      $user->save();

      $data->bdn_usaha            = $request->bdn_usaha;
      $data->nm_vendor            = $request->nm_vendor;
      $data->nm_vendor_uq         = $request->nm_vendor_uq;
      $data->prinsipal_st         = $request->prinsipal_st;
      $data->alamat               = $request->alamat;
      $data->kota                 = $request->kota;
      $data->kd_pos               = $request->kd_pos;
      $data->telepon              = $request->telepon;
      $data->fax                  = $request->fax;
      $data->web_site             = $request->web_site;
      $data->induk_perus          = $request->induk_perus;
      $data->asset                = Helpers::input_rupiah($request->asset);
      $data->bank_nama            = $request->bank_nama;
      $data->bank_cabang          = $request->bank_cabang;
      $data->bank_norek           = $request->bank_norek;
      $data->akte_awal_no         = $request->akte_awal_no;
      $data->akte_awal_tg         = Helpers::date_set_db($request->akte_awal_tg);
      $data->akte_awal_notaris    = $request->akte_awal_notaris;
      $data->akte_akhir_no        = $request->akte_akhir_no;
      $data->akte_akhir_tg        = Helpers::date_set_db($request->akte_akhir_tg);
      $data->akte_akhir_notaris   = $request->akte_akhir_notaris;
      $data->siup_no              = $request->siup_no;
      $data->siup_tg_terbit       = Helpers::date_set_db($request->siup_tg_terbit);
      $data->siup_tg_expired      = Helpers::date_set_db($request->siup_tg_expired);
      $data->siup_kualifikasi     = $request->siup_kualifikasi;
      $data->pkp                  = $request->pkp;
      $data->npwp_no              = $request->npwp_no;
      $data->npwp_tg              = Helpers::date_set_db($request->npwp_tg);
      $data->tdp_no               = $request->tdp_no;
      $data->tdp_tg_terbit        = Helpers::date_set_db($request->tdp_tg_terbit);
      $data->tdp_tg_expired       = Helpers::date_set_db($request->tdp_tg_expired);
      $data->idp_no               = $request->idp_no;
      $data->idp_tg_terbit        = Helpers::date_set_db($request->idp_tg_terbit);
      $data->idp_tg_expired       = Helpers::date_set_db($request->idp_tg_expired);
      // $data->iujk_no = $request->iujk_no;
      // $data->iujk_tg_terbit = $request->iujk_tg_terbit;
      // $data->iujk_tg_expired = $request->iujk_tg_expired;
      $data->cp1_nama             = $request->cp1_nama;
      $data->cp1_telp             = $request->cp1_telp;
      $data->cp1_email            = $request->cp1_email;
      $data->jml_peg_domestik     = $request->jml_peg_domestik;
      $data->jml_peg_asing        = $request->jml_peg_asing;
      $data->vendor_status        = 0;
      // $data->Komen = $request->reason;
      $data->save();

      SupplierMetadata::where([
        ['id_object','=',$data->id],
        ['object_type','=','vendor'],
        ['object_key','=','sertifikat_dokumen']
        ])->delete();
        foreach($request->iujk_no as $l => $val){
          $mt_data = new SupplierMetadata();
          $mt_data->id_object    = $data->id;
          $mt_data->object_type  = 'vendor';
          $mt_data->object_key   = 'sertifikat_dokumen';

          if(is_object($new_sertifikat_up[$l])){
            $nama = $request['nama_sertifikat_dokumen'][$l];
            $fileName   = $data->kd_vendor.'_'.str_slug($nama).'_'.time().'.pdf';
            $new_sertifikat_up[$l]->storeAs('supplier/sertifikat_dokumen', $fileName);
          }
          else{
            $fileName = $new_sertifikat_up[$l];
          }
          $mt_data->object_value = json_encode([
            'iujk_no'         => $request['iujk_no'][$l], 
            'iujk_tg_terbit'  => Helpers::date_set_db($request['iujk_tg_terbit'][$l]),
            'iujk_tg_expired' => Helpers::date_set_db($request['iujk_tg_expired'][$l]), 
            'name'            => $request['nama_sertifikat_dokumen'][$l],
            'file'            => $fileName]);
          $mt_data->save();
        };

      $mt_data = SupplierMetadata::where([
        ['id_object','=',$data->id],
        ['object_type','=','vendor'],
        ['object_key','=','pengalaman_kerja']
        ])->first();
      $mt_data->object_value = $request->pengalaman_kerja;
      $mt_data->save();
      $data->pengalaman_kerja = $request->pengalaman_kerja;

      $mt_data = SupplierMetadata::where([
        ['id_object','=',$data->id],
        ['object_type','=','vendor'],
        ['object_key','=','bank_kota']
        ])->first();
      $mt_data->object_value = $request->bank_kota;
      $mt_data->save();
      $data->bank_kota = $request->bank_kota;

      $mt_data = SupplierMetadata::where([
        ['id_object','=',$data->id],
        ['object_type','=','vendor'],
        ['object_key','=','nm_direktur_utama']
        ])->first();
      $mt_data->object_value = $request->nm_direktur_utama;
      $mt_data->save();
      $data->nm_direktur_utama = $request->nm_direktur_utama;

      $mt_data = SupplierMetadata::where([
        ['id_object','=',$data->id],
        ['object_type','=','vendor'],
        ['object_key','=','nm_komisaris_utama']
        ])->first();
      $mt_data->object_value = $request->nm_komisaris_utama;
      $mt_data->save();
      $data->nm_komisaris_utama = $request->nm_komisaris_utama;

      SupplierMetadata::where([
        ['id_object','=',$data->id],
        ['object_type','=','vendor'],
        ['object_key','=','klasifikasi_usaha']
        ])->delete();
      foreach($request->klasifikasi_kode as $key=>$v){
        $mt_data = new SupplierMetadata();
        $mt_data->id_object    = $data->id;
        $mt_data->object_type  = 'vendor';
        $mt_data->object_key   = 'klasifikasi_usaha';
        $mt_data->object_value = json_encode(['kode'=>$request['klasifikasi_kode'][$key], 'text'=>$request['klasifikasi_text'][$key]]);
        $mt_data->save();
      }

      SupplierMetadata::where([
        ['id_object','=',$data->id],
        ['object_type','=','vendor'],
        ['object_key','=','anak_perusahaan']
        ])->delete();
      foreach($request->anak_perusahaan as $k){
        $mt_data = new SupplierMetadata();
        $mt_data->id_object    = $data->id;
        $mt_data->object_type  = 'vendor';
        $mt_data->object_key   = 'anak_perusahaan';
        $mt_data->object_value = $k;
        $mt_data->save();
      };
      $data->anak_perusahaan = $request->anak_perusahaan;

      SupplierMetadata::where([
        ['id_object','=',$data->id],
        ['object_type','=','vendor'],
        ['object_key','=','legal_dokumen']
        ])->delete();
      if(count($new_dokumen_up)>0){
        foreach($new_dokumen_up as $key => $val){
          if(!empty($val)
          ){
            $mt_data = new SupplierMetadata();
            $mt_data->id_object    = $data->id;
            $mt_data->object_type  = 'vendor';
            $mt_data->object_key   = 'legal_dokumen';
            $fileName   = Helpers::set_filename($data->kd_vendor,strtolower($val));
            $mt_data->object_value = json_encode(['name'=>$request->legal_dokumen_nama[$key],'file'=>$fileName]);
            
            if(is_object($val)){
              $file = $request['legal_dokumen'][$key];  
              $file->storeAs('supplier/legal_dokumen', $fileName);              
            }
            $mt_data->save();
          }
        }
      }

      $log_activity = new SupplierActivity();
      $log_activity->users_id = Auth::id();
      $log_activity->supplier_id = $request->id;
      $log_activity->activity = "Edited";
      $log_activity->date = new \DateTime();
      $log_activity->komentar = $request->komentar;
      $log_activity->save();

      return Response::json (array(
        'status' => 'all'
      ));
    }
  }

  public function editstatus(Request $request)
  {
    if ($request->ajax()) {
      $user = Supplier::where('id',$request->id)->first();
      if($user){
        $user->vendor_status = 1;
        $user->save();

        $log_activity = new SupplierActivity();
        $log_activity->users_id = Auth::id();
        $log_activity->supplier_id = $request->id;
        $log_activity->activity = "Approved";
        $log_activity->date = new \DateTime();
        $log_activity->komentar = $request->reason;
        $log_activity->save();

        return Response::json(['status'=>true,'csrf_token'=>csrf_token()]);
      }
      return Response::json(['status'=>false]);
    }
    abort(500);
  }

  public function return(Request $request)
  {
    if ($request->ajax()) {
      $user = Supplier::where('id',$request->id)->first();
      if($user){
          $user->vendor_status = 2;
          $user->save();

          $log_activity = new SupplierActivity();
          $log_activity->users_id = Auth::id();
          $log_activity->supplier_id = $request->id;
          $log_activity->activity = "Returned";
          $log_activity->date = new \DateTime();
          $log_activity->komentar = $request->reason;
          $log_activity->save();
        return Response::json(['status'=>true,'csrf_token'=>csrf_token()]);
      }
      return Response::json(['status'=>false]);
    }
    abort(500);
  }
}
