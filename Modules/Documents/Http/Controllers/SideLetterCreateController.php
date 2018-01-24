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
use Modules\Documents\Entities\DocComment as Comments;
use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class SideLetterCreateController
{
  public function __construct()
  {
      //oke
  }

  public function store($request)
  {
    $type = $request->type;
    $rules = [];
    if($request->statusButton == '0'){
    $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
    $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
    $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak2_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';


    $check_new_lampiran = false;
    foreach($request->doc_lampiran_old as $k => $v){
      if(isset($request->doc_lampiran[$k]) && is_object($request->doc_lampiran[$k]) && !empty($v)){//jika ada file baru
        $new_lamp[] = '';
        $new_lamp_up[] = $request->doc_lampiran[$k];
        $rules['doc_lampiran.'.$k] = 'required|mimes:pdf';
      }
      else if(empty($v)){
        $rules['doc_lampiran.'.$k] = 'required|mimes:pdf';
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

    $rule_scope_pasal = (count($request['scope_pasal'])>1)?'required':'sometimes|nullable';
    $rule_scope_judul = (count($request['scope_judul'])>1)?'required':'sometimes|nullable';
    $rule_scope_isi = (count($request['scope_isi'])>1)?'required':'sometimes|nullable';
    $rules['scope_file.*']  =  'sometimes|nullable|mimes:pdf';
    $rules['scope_pasal.*']  =  $rule_scope_pasal.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['scope_judul.*']  =  $rule_scope_judul.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['scope_isi.*']  =  $rule_scope_isi.'|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

    $rules['lt_desc.*']  =  'required|date_format:"Y-m-d"';
    $rules['lt_name.*']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
    if(\Laratrust::hasRole('admin')){
      $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
    }
    $check_new_file = false;
    foreach($request->lt_file_old as $k => $v){
      if(isset($request->lt_file[$k]) && is_object($request->lt_file[$k]) && !empty($v)){//jika ada file baru
        $new_file[] = '';
        $new_file_up[] = $request->lt_file[$k];
        $rules['lt_file.'.$k] = 'required|mimes:pdf';
      }
      else if(empty($v)){
        $rules['lt_file.'.$k] = 'required|mimes:pdf';
        if(!isset($request->lt_file[$k])){
          $new_file[] = $v;
          $new_file_up[] = $v;
        }
        else{
          $new_file[] = '';
          $new_file_up[] = $request->lt_file[$k];
        }
      }
      else{
        $new_file[] = $v;
        $new_file_up[] = $v;
      }
    }

    $request->merge(['lt_file' => $new_file]);

    $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

    if ($validator->fails ()){
      return redirect()->back()->withInput($request->input())->withErrors($validator);
    }
  }else{
    $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      if(\Laratrust::hasRole('admin')){
        $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      }
      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

      if ($validator->fails ()){
        return redirect()->back()->withInput($request->input())->withErrors($validator);
      }
  }

    $doc = new Documents();
    $doc->doc_title = $request->doc_title;
    $doc->doc_date = $request->doc_startdate;
    $doc->doc_startdate = $request->doc_startdate;
    $doc->doc_enddate = $request->doc_enddate;
    $doc->doc_desc = $request->doc_desc;
    $doc->doc_template_id = DocTemplate::get_by_type($type)->id;
    $doc->doc_pihak1 = $request->doc_pihak1;
    $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
    $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
    $doc->user_id = (\Laratrust::hasRole('admin'))?$request->user_id:Auth::id();
    $doc->doc_type = $request->type;
    $doc->doc_parent = 0;
    $doc->doc_parent_id = $request->parent_kontrak;
    $doc->supplier_id = Documents::where('id',$doc->doc_parent_id)->first()->supplier_id;
    $doc->doc_signing = $request->statusButton;
    $doc->save();

    if(count($request->f_judul)>0){
      foreach($request->f_judul as $key => $val){
        if(!empty($val)){

          if($val=="Harga"){
            $f_name="harga";
            $desc=$request->f_harga[$key];
          }elseif($val=="Jangka Waktu"){
            $f_name="jangka_waktu";
            $desc=$request->f_tanggal1[$key] ."|". $request->f_tanggal2[$key];
          }elseif($val=="Lainnya"){
            $f_name="lainnya";
            $desc=$request->f_isi[$key];
          }

          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'sow_boq';
          $doc_meta->meta_name = $f_name;
          $doc_meta->meta_title = $val;
          $doc_meta->meta_desc = $desc;

          $doc_meta->save();
        }
      }
    }

    if(count($request->doc_lampiran)>0){
      foreach($request->doc_lampiran as $key => $val){
        if(!empty($val)
        ){
          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'lampiran_ttd';
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

    if(count($request->lt_name)>0){
      foreach($request->lt_name as $key => $val){
        if(!empty($val)
            && !empty($request['lt_desc'][$key])
        ){
          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'latar_belakang';
          $doc_meta->meta_name = $val;
          $doc_meta->meta_desc = $request['lt_desc'][$key];
          if(isset($request['lt_file'][$key])){
            $fileName   = Helpers::set_filename('doc_',strtolower($val));
            $file = $request['lt_file'][$key];
            $file->storeAs('document/'.$request->type.'_latar_belakang', $fileName);
            $doc_meta->meta_file = $fileName;
          }
          $doc_meta->save();
        }
      }
    }

    if(count($request->scope_pasal)>0){
      foreach($request->scope_pasal as $key => $val){
        if(!empty($val)
            && !empty($request['scope_judul'][$key])
            && !empty($request['scope_isi'][$key])
        ){
          $scope_judul = $request['scope_judul'][$key];
          $scope_isi = $request['scope_isi'][$key];

          $doc_meta = new DocMetaSideLetter();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_pasal  = $request['scope_pasal'][$key];
          $doc_meta->meta_judul  = $request['scope_judul'][$key];
          $doc_meta->meta_isi    = $request['scope_isi'][$key];
          $doc_meta->meta_awal = $request['scope_awal'][$key];
          $doc_meta->meta_akhir = $request['scope_akhir'][$key];

          if(isset($request['scope_file'][$key])){
            $fileName   = Helpers::set_filename('doc_scope_perubahan_',strtolower($val));
            $file = $request['scope_file'][$key];
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

    // $log_activity = new DocActivity();
    // $log_activity->users_id = Auth::id();
    // $log_activity->documents_id = $doc->id;
    // $log_activity->activity = "Submitted";
    // $log_activity->date = new \DateTime();
    // $log_activity->save();

    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    if($request->statusButton == '0'){
      return redirect()->route('doc',['status'=>'tracking']);
    }else{
      return redirect()->route('doc',['status'=>'draft']);
    }
  }
}
