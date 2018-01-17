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

      $dt_sertifikat_dokumen = SupplierMetadata::get_sertifikat_dokumen($id);
      foreach($dt_sertifikat_dokumen as $k=>$dt_sertifikat_dokumen){
        $d = json_decode($dt_sertifikat_dokumen->object_value);
        $iujk_no[] = $d->iujk_no;
        $iujk_tg_terbit[] = $d->iujk_tg_terbit;
        $iujk_tg_expired[] = $d->iujk_tg_expired;
        $name[] = $d->name;
        $file[] = $d->file;
      }
      $supplier->iujk_no = $iujk_no;
      $supplier->iujk_tg_terbit = $iujk_tg_terbit;
      $supplier->iujk_tg_expired = $iujk_tg_expired;
      $supplier->nama_sertifikat_dokumen = $name;
      $supplier->file_sertifikat_dokumen_old = $file;
      //dd($supplier);

      $dt_klasifikasi = SupplierMetadata::select('object_value')->where([
        ['id_object','=',$id],
        ['object_key','=','klasifikasi_usaha']
      ])->get();
      foreach($dt_klasifikasi as $dt_klasifikasi){
        $klasifikasi[] = $dt_klasifikasi->object_value;
      }
      $supplier->klasifikasi_usaha = $klasifikasi;


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
      //dd($dt_meta);
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
        $legal_dokumen[$k]['name'] = $d->name;
        $legal_dokumen[$k]['file'] = $d->file;
      }
      $supplier->legal_dokumen = $legal_dokumen;

      foreach($legal_dokumen as $k=>$v){
        $file_old_ld[] = $v['file'];
      }
      $supplier->file_old_ld = $file_old_ld;

      //$data = $sup;
      $page_title = ucfirst($request->status).' Supplier';
      $action_type = $request->status;
      return view('supplier::form')->with(compact('supplier','page_title','action_type','id'));
  }

  public function update(Request $request)
  {
    $id = $request->id;
    $asset = $request->asset;
    // dd($request->input());
    $rules = array (
        'komentar'          => 'required|max:250|min:2',
        'bdn_usaha'         => 'required|max:250|min:2',
        'nm_vendor'         => 'required|max:500|min:3',
        'nm_vendor_uq'      => 'max:500|min:3',
        'prinsipal_st'      => 'required|boolean',
        'klasifikasi_usaha.*' => 'required',
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
        'akte_awal_tg'      => 'required|date_format:"Y-m-d"',
        'akte_awal_notaris' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_akhir_no'     => 'sometimes|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'akte_akhir_tg'     => 'sometimes|nullable|date_format:"Y-m-d"',
        'akte_akhir_notaris'=> 'sometimes|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
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
        'nm_direktur_utama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'nm_komisaris_utama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'cp1_nama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'cp1_telp'     => 'required|digits_between:7,20',
        'cp1_email'     => 'required|max:50|min:4|email',
        'jml_peg_domestik'     => 'required|integer',
        'jml_peg_asing'     => 'required|integer',
        'legal_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        // 'sertifikat_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',

        'iujk_no.*'                    => 'sometimes|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
        'iujk_tg_terbit.*'             => 'sometimes|nullable|date_format:"Y-m-d"',
        'iujk_tg_expired.*'            => 'sometimes|nullable|date_format:"Y-m-d"',
        'nama_sertifikat_dokumen.*'    => 'sometimes|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i',
    );

    $check_new_legal_dok = false;
    foreach($request->legal_dokumen as $l => $v){
      $legal_dokumen[$l]['name'] = $v['name'];
      if(isset($v['file'])){
        $filenya = $v['file'];
        $legal_dokumen[$l]['file'] = $filenya;
      }
      else{
          if(count($request->legal_dokumen)==count($request->file_old_ld)){
            $filenya = $request->file_old_ld[$l];
            $legal_dokumen[$l]['file'] = $filenya;
          }
          else{
            $filenya = isset($request->file_old_ld[$l])?$request->file_old_ld[$l]:"";
            $legal_dokumen[$l]['file'] = $filenya;
          }
      }
      if(is_object($filenya) || empty($filenya) || (empty($filenya) && is_object($filenya))){
        $check_new_legal_dok = true;
      }
      if($check_new_legal_dok) {
          $rules['legal_dokumen.'.$l.'.file'] = 'required|mimes:pdf';
      }
    }
    $request->merge(['legal_dokumen' => $legal_dokumen]);
    //dd($request->input());
    // exit;
    // foreach($file_old_ld as $k=>$v){
    //   $file_old_ld[] = $v;
    // }
    // $request->merge(['file_old_ld' => $file_old_ld]);
    //dd($request->input());

    //dd($request['file_old_ld']);

    // $check_new_sertifikat_dok = false;
    // foreach($request->sertifikat_dokumen as $l => $v){
    //   $sertifikat_dokumen[$l]['name'] = $v['name'];
    //   if(isset($v['file'])){
    //     $filenya = $v['file'];
    //     $sertifikat_dokumen[$l]['file'] = $filenya;
    //   }
    //   else{
    //     if(count($request->sertifikat_dokumen)==count($request->file_old_sd)){
    //       $filenya = $request->file_old_sd[$l];
    //       $sertifikat_dokumen[$l]['file'] = $filenya;
    //     }
    //     else{
    //       $filenya = isset($request->file_old_sd[$l])?$request->file_old_sd[$l]:"";
    //       $sertifikat_dokumen[$l]['file'] = $filenya;
    //     }
    //
    //   }
    //   if(is_object($filenya) || empty($filenya) || (empty($filenya) && is_object($filenya))){
    //     $check_new_sertifikat_dok = true;
    //   }
    //   if($check_new_sertifikat_dok) {
    //       $rules['sertifikat_dokumen.'.$l.'.file'] = 'required|mimes:pdf';
    //   }
    // }
    // $request->merge(['sertifikat_dokumen' => $sertifikat_dokumen]);

    $check_new_lampiran = false;
    foreach($request->file_sertifikat_dokumen_old as $k => $v){
      if(isset($request->file_sertifikat_dokumen[$k]) && is_object($request->file_sertifikat_dokumen[$k]) && !empty($v)){//jika ada file baru
        $new_lamp[] = '';
        $new_lamp_up[] = $request->file_sertifikat_dokumen[$k];
        $rules['file_sertifikat_dokumen.'.$k] = 'sometimes|nullable|mimes:pdf';
      }
      else if(empty($v)){
        $rules['file_sertifikat_dokumen.'.$k] = 'sometimes|nullable|mimes:pdf';
        if(!isset($request->file_sertifikat_dokumen[$k])){
          $new_lamp[] = $v;
          $new_lamp_up[] = $v;
        }
        else{
          $new_lamp[] = '';
          $new_lamp_up[] = $request->file_sertifikat_dokumen[$k];
        }
      }
      else{
        $new_lamp[] = $v;
        $new_lamp_up[] = $v;
      }
    }
    $request->merge(['file_sertifikat_dokumen' => $new_lamp]);
    $request->merge(['asset' => $asset]);

    $validator = Validator::make($request->all(), $rules,CustomErrors::supplier());
    //dd($request->input());
    if ($validator->fails ()){
      return redirect()->back()
                  ->withInput($request->input())
                  ->withErrors($validator);
    }
    else {
// dd("hai");
// dd($request->input());
      $id = $request->id;

      $data = Supplier::where('id',$id)->first();
      if(!$data){
        abort(500);
      }

      $user = User::where('username',$data->kd_vendor)->first();
      $user->name = $request->nm_vendor;
      $user->phone = $request->telepon;
        $bdn_usaha = $request->bdn_usaha;
        $inisial = $request->nm_vendor_uq;
        $gabung = $bdn_usaha." - ".$inisial;
      $user->data = $gabung;
      $user->save();

      $data->bdn_usaha = $request->bdn_usaha;
      $data->nm_vendor = $request->nm_vendor;
      $data->nm_vendor_uq = $request->nm_vendor_uq;
      $data->prinsipal_st = $request->prinsipal_st;
      $data->alamat = $request->alamat;
      $data->kota = $request->kota;
      $data->kd_pos = $request->kd_pos;
      $data->telepon = $request->telepon;
      $data->fax = $request->fax;
      $data->web_site = $request->web_site;
      $data->induk_perus = $request->induk_perus;
      $data->asset = Helpers::input_rupiah($request->asset);
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
      // $data->iujk_no = $request->iujk_no;
      // $data->iujk_tg_terbit = $request->iujk_tg_terbit;
      // $data->iujk_tg_expired = $request->iujk_tg_expired;
      $data->cp1_nama = $request->cp1_nama;
      $data->cp1_telp = $request->cp1_telp;
      $data->cp1_email = $request->cp1_email;
      $data->jml_peg_domestik = $request->jml_peg_domestik;
      $data->jml_peg_asing = $request->jml_peg_asing;
      $data->vendor_status = 0;
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

          if(is_object($new_lamp_up[$l])){
            $nama = $request['nama_sertifikat_dokumen'][$l];
            $fileName   = $data->kd_vendor.'_'.str_slug($nama).'_'.time().'.pdf';
            $new_lamp_up[$l]->storeAs('supplier/sertifikat_dokumen', $fileName);
          }
          else{
            $fileName = $new_lamp_up[$l];
          }
          $mt_data->object_value = json_encode(['iujk_no'=>$request['iujk_no'][$l], 'iujk_tg_terbit'=>$request['iujk_tg_terbit'][$l],
                                  'iujk_tg_expired'=>$request['iujk_tg_expired'][$l], 'name'=>$request['nama_sertifikat_dokumen'][$l],
                                  'file'=>$fileName]);
          $mt_data->save();
        };
// dd("yo");
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

      foreach($request->klasifikasi_usaha as $k){
        $mt_data = new SupplierMetadata();
        $mt_data->id_object    = $data->id;
        $mt_data->object_type  = 'vendor';
        $mt_data->object_key   = 'klasifikasi_usaha';
        $mt_data->object_value = $k;
        $mt_data->save();
      };
      $data->klasifikasi_usaha = $request->klasifikasi_usaha;

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
      foreach($request->legal_dokumen as $l => $val){
        if(is_object($val['file'])){
          $fileName   = Helpers::set_filename($data->kd_vendor,$val['name']);
          $val['file']->storeAs('supplier/legal_dokumen', $fileName);
        }
        else{
          $fileName = $val['file'];
        }

        $mt_data = new SupplierMetadata();
        $mt_data->id_object    = $data->id;
        $mt_data->object_type  = 'vendor';
        $mt_data->object_key   = 'legal_dokumen';
        $mt_data->object_value = json_encode(['name'=>$val['name'],'file'=>$fileName]);
        $mt_data->save();
      };

      $log_activity = new SupplierActivity();
      $log_activity->users_id = Auth::id();
      $log_activity->supplier_id = $request->id;
      $log_activity->activity = "Edited";
      $log_activity->date = new \DateTime();
      $log_activity->komentar = $request->komentar;
      $log_activity->save();

      // return redirect()->route('supplier.lihat', ['id' => $request->id, 'status' => 'lihat'])->withData($data)->with('message', 'Data berhasil disimpan!');

      return redirect()->route('supplier', ['status' => 'proses'])->withData($data)->with('message', 'Data berhasil disimpan!');

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

      //$request->session()->flash('alert-success', 'Data berhasil disetujui!');
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
      //$request->session()->flash('alert-success', 'Data berhasil disetujui!');
      return Response::json(['status'=>true,'csrf_token'=>csrf_token()]);
    }
    return Response::json(['status'=>false]);
  }
  abort(500);

  }
}
