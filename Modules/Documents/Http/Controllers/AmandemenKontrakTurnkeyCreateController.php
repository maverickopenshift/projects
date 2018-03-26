<?php

namespace Modules\Documents\Http\Controllers;

use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\Documents;
use Modules\Documents\Entities\DocBoq;
use Modules\Documents\Entities\DocMeta;
use Modules\Documents\Entities\DocMetaSideLetter;
use Modules\Documents\Entities\DocPic;
use Modules\Documents\Entities\DocTemplate;
use Modules\Documents\Entities\DocActivity;
use Modules\Config\Entities\Config;
use Modules\Documents\Entities\DocComment as Comments;
use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;
use Response;

class AmandemenKontrakTurnkeyCreateController
{
  public function __construct()
  {
      //oke
  }
  public function store_ajax($request)
  {
    $type = $request->type;
    $rules = [];

    $m_hs_harga=[];
    $m_hs_harga_jasa=[];
    $m_hs_qty=[];
    
    $statusButton = $request->statusButton;
    $required = 'required';
    $date_format = 'date_format:"d-m-Y"';
    if($statusButton=='2'){
      $required = 'sometimes|nullable';
    }
    $user_type = Helpers::usertype();
    $auto_numb =Config::get_config('auto-numb');
    if(isset($request['hs_harga']) && count($request['hs_harga'])>0){
      foreach($request['hs_harga'] as $key => $val){
        $hs_harga[] = $val;
        $m_hs_harga[$key] = Helpers::input_rupiah($val);
      }
    }

    if(count($m_hs_harga)>0){
      $request->merge(['hs_harga'=>$m_hs_harga]);
    }

    if(isset($request['hs_harga_jasa']) && count($request['hs_harga_jasa'])>0){
      foreach($request['hs_harga_jasa'] as $key => $val){
        $hs_harga_jasa[] = $val;
        $m_hs_harga_jasa[$key] = Helpers::input_rupiah($val);
      }
    }

    if(count($m_hs_harga_jasa)>0){
      $request->merge(['hs_harga_jasa'=>$m_hs_harga_jasa]);
    }

    if(isset($request['hs_qty']) && count($request['hs_qty'])>0){
      foreach($request['hs_qty'] as $key => $val){
        $hs_qty[$key] = $val;
        $m_hs_qty[$key] = Helpers::input_rupiah($val);
      }
    }

    if(count($m_hs_qty)>0){
      $request->merge(['hs_qty'=>$m_hs_qty]);
    }
      $rules['parent_kontrak']   =  'required|kontrak_exists';
      $rules['komentar']         = $required.'|max:250|min:2';
      if($user_type!='subsidiary'){
        $rules['divisi']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['unit_bisnis']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      }
      $rules['doc_title']        =  'required|min:2';
      $rules['doc_startdate']    =  $required.'|'.$date_format;
      $rules['doc_enddate']      =  $required.'|'.$date_format.'|after:doc_startdate';
      $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak2_nama']  =  $required.'|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pr']         =  'sometimes|nullable|pr_exists';
      if(\Laratrust::hasRole('admin')){
        $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      }

      if($user_type=='subsidiary'){
        $rules['doc_no']  =  'required|min:5|max:500|unique:documents,doc_no';
      }
      else{
        if($auto_numb=='off'){
          $rules['doc_no']  =  'required|digits_between:1,5';
        }
      }

      $rules['doc_lampiran_nama.*']  =  $required.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $check_new_lampiran = false;
        foreach($request->doc_lampiran_old as $k => $v){
          if(isset($request->doc_lampiran[$k]) && is_object($request->doc_lampiran[$k]) && !empty($v)){//jika ada file baru
            $new_lamp[] = '';
            $new_lamp_up[] = $request->doc_lampiran[$k];
            $rules['doc_lampiran.'.$k] = $required.'|mimes:pdf';
          }
          else if(empty($v)){
            $rules['doc_lampiran.'.$k] = $required.'|mimes:pdf';
            if(!isset($request->doc_lampiran[$k])){
              $new_lamp[] = $v;
              $new_lamp_up[] = $v;
            }
            else{
              $new_lamp[] = '';
              $new_lamp_up[] = $request->doc_lampiran[$k];
            }
          }
          else{
            $new_lamp[] = $v;
            $new_lamp_up[] = $v;
          }
        }
        $request->merge(['doc_lampiran' => $new_lamp]);

      $rule_scope_pasal = (count($request['f_scope_pasal'])>1)?$required:'sometimes|nullable';
      $rule_scope_judul = (count($request['f_scope_judul'])>1)?$required:'sometimes|nullable';
      $rule_scope_isi = (count($request['f_scope_isi'])>1)?$required:'sometimes|nullable';
      $rules['f_scope_file.*']  =  'sometimes|nullable|mimes:pdf';
      $rules['f_scope_pasal.*']  =  $rule_scope_pasal.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['f_scope_judul.*']  =  $rule_scope_judul.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['f_scope_isi.*']  =  $rule_scope_isi.'|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
      $validator->after(function ($validator) use ($request,$auto_numb,$user_type) {
        if($user_type!='subsidiary' && $auto_numb=='off' && !$validator->errors()->has('doc_no')){
          $d = Documents::check_no_kontrak($request['doc_no'],date('Y',strtotime($request['doc_startdate'])));
          if($d){
            $validator->errors()->add('doc_no', 'No Kontrak yang Anda masukan sudah ada!');
          }
        }
      });
      if ($validator->fails ()){
        return Response::json (array(
          'errors' => $validator->getMessageBag()->toArray()
        ));
      }
      DB::beginTransaction();
      try {
    $doc = new Documents();
    $doc->doc_title = $request->doc_title;
    $doc->doc_date = Helpers::date_set_db($request->doc_startdate);
    $start_date = $request->doc_startdate;
    $doc->doc_startdate = Helpers::date_set_db($start_date);
    $doc->doc_enddate = Helpers::date_set_db($request->doc_enddate);
    $doc->doc_desc = $request->doc_desc;
    $template_id = DocTemplate::get_by_type($type)->id;
    $doc->doc_template_id = $template_id;
    $doc->doc_pihak1 = $request->doc_pihak1;
    $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
    $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
    $doc->user_id = (\Laratrust::hasRole('admin'))?$request->user_id:Auth::id();
    $doc->doc_type = $request->type;
    $doc->doc_sow = $request->doc_sow;
    $doc->doc_parent = 0;
    $doc->doc_parent_id = $request->parent_kontrak;
    $doc->supplier_id = Documents::where('id',$doc->doc_parent_id)->first()->supplier_id;
    $doc->doc_signing = $request->statusButton;

    $doc->penomoran_otomatis =  Config::get_penomoran_otomatis($request->penomoran_otomatis);
    if($user_type=='subsidiary'){
      $doc->doc_no = $request->doc_no;
    }
    if($user_type!='subsidiary' && $auto_numb=='off'){
      $doc->doc_no = Documents::create_manual_no_kontrak($request->doc_no,$request->doc_pihak1_nama,$template_id,$start_date,$request->type);
    }
    if($user_type=='subsidiary'){
      $doc->doc_user_type = 'subsidiary';
      $doc->penomoran_otomatis = 'no';
    }
    $doc->save();

    //pemilik Kontrak
    if(count($request->divisi)>0 && $user_type!='subsidiary'){
      $doc_meta2 = new DocMeta();
      $doc_meta2->documents_id = $doc->id;
      $doc_meta2->meta_type = 'pemilik_kontrak';
      $doc_meta2->meta_name = $request->divisi;
      $doc_meta2->meta_title =$request->unit_bisnis;
      $doc_meta2->save();
    }
    
    //eproposal PR
    if(count($request->doc_pr)>0){
      $doc_meta2 = new DocMeta();
      $doc_meta2->documents_id = $doc->id;
      $doc_meta2->meta_type = 'eproposal_pr';
      $doc_meta2->meta_name = $request->doc_pr;
      $doc_meta2->save();
    }
    
    if(count($request->doc_lampiran)>0){
      foreach($request->doc_lampiran as $key => $val){
        if(!empty($val)
        ){
          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'lampiran_ttd';
          $doc_meta->meta_name = $request['doc_lampiran_nama'][$key];
          if(isset($request['doc_lampiran'][$key])){
            $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($val));
            $file = $request['doc_lampiran'][$key];
            $file->storeAs('document/'.$request->type.'_lampiran_ttd', $fileName);
            $doc_meta->meta_file = $fileName;
          }
          $doc_meta->save();
        }
      }
    }

    // latar belakang optional
    if(count($request->f_latar_belakang_judul)>0){
      foreach($request->f_latar_belakang_judul as $key => $val){
        if(!empty($val) && !empty($request['f_latar_belakang_judul'][$key])){

          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = "latar_belakang_optional";
          $doc_meta->meta_name = $request['f_latar_belakang_judul'][$key];
          $doc_meta->meta_title = Helpers::date_set_db($request['f_latar_belakang_tanggal'][$key]);
          $doc_meta->meta_desc = $request['f_latar_belakang_isi'][$key];
          if(isset($request['f_latar_belakang_file'][$key])){
            $fileName   = Helpers::set_filename('doc_',strtolower($val));
            $file = $request['f_latar_belakang_file'][$key];
            $file->storeAs('document/'.$request->type.'_latar_belakang_optional', $fileName);
            $doc_meta->meta_file = $fileName;
          }
          $doc_meta->save();
        }
      }
    }

    // sow boq
    if(count($request->hs_harga)>0){
      foreach($request->hs_harga as $key => $val){
        if(!empty($val)
            && !empty($request['hs_kode_item'][$key])
            && !empty($request['hs_item'][$key])
            && !empty($request['hs_satuan'][$key])
            && !empty($request['hs_mtu'][$key])
        ){
          $doc_boq = new DocBoq();
          $doc_boq->documents_id = $doc->id;
          $doc_boq->kode_item = $request['hs_kode_item'][$key];
          $doc_boq->item = $request['hs_item'][$key];
          $doc_boq->satuan = $request['hs_satuan'][$key];
          $doc_boq->mtu = $request['hs_mtu'][$key];
          $doc_boq->harga = Helpers::input_rupiah($request['hs_harga'][$key]);
          $doc_boq->harga_jasa = Helpers::input_rupiah($request['hs_harga_jasa'][$key]);
          $hs_type = 'harga_satuan';

          if(in_array($type,['turnkey','amandemen_kontrak_turnkey','sp'])){
            $q_qty = Helpers::input_rupiah($request['hs_qty'][$key]);
            $q_harga = Helpers::input_rupiah($request['hs_harga'][$key]);
            $q_harga_jasa = Helpers::input_rupiah($request['hs_harga_jasa'][$key]);

            $q_total = $q_qty*($q_harga+$q_harga_jasa);
            $doc_boq->qty = $q_qty;
            $doc_boq->harga_total = $q_total;
            $hs_type = 'boq';
          }

          $doc_boq->desc = $request['hs_keterangan'][$key];
          $doc_boq->data = json_encode(array('type'=>$hs_type));
          $doc_boq->save();
        }
      }
    }

    // scope perubahan
    if(count($request->f_scope_pasal)>0){
      foreach($request->f_scope_pasal as $key => $val){
        if(!empty($val)
            && !empty($request['f_scope_judul'][$key])
            && !empty($request['f_scope_isi'][$key])
        ){
          $scope_judul = $request['f_scope_judul'][$key];
          $scope_isi = $request['f_scope_isi'][$key];

          $doc_meta = new DocMetaSideLetter();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_pasal  = $request['f_scope_pasal'][$key];
          $doc_meta->meta_judul  = $request['f_scope_judul'][$key];
          $doc_meta->meta_isi    = $request['f_scope_isi'][$key];
          $doc_meta->meta_awal = $request['f_scope_awal'][$key];
          $doc_meta->meta_akhir = $request['f_scope_akhir'][$key];

          if(isset($request['f_scope_file'][$key])){
            $fileName   = Helpers::set_filename('doc_scope_perubahan_',strtolower($val));
            $file = $request['f_scope_file'][$key];
            $file->storeAs('document/'.$request->type.'_scope_perubahan', $fileName);
            $doc_meta->meta_file = $fileName;
          }
          $doc_meta->save();
        }
      }
    }

    if($request->statusButton == '0'){
      $comment = new Comments();
      $comment->content = $request->komentar;
      $comment->documents_id = $doc->id;
      $comment->users_id = \Auth::id();
      $comment->status = 1;
      $comment->data = "Submitted";
      $comment->save();
    }

    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    DB::commit();
    if($request->statusButton == '0'){
      return Response::json (array(
        'status' => 'tracking'
      ));
    }else{
      return Response::json (array(
        'status' => 'draft'
      ));
    }
  } catch (\Exception $e) {
        DB::rollBack();
        return Response::json (array(
          'status' => 'error',
          'msg' => $e->getMessage()
        ));
    }
  }
}
