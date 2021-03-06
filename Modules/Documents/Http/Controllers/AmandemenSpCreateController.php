<?php

namespace Modules\Documents\Http\Controllers;

use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\Documents;
use Modules\Documents\Entities\DocBoq;
use Modules\Documents\Entities\DocMeta;
use Modules\Documents\Entities\DocPic;
use Modules\Documents\Entities\DocTemplate;
use Modules\Documents\Entities\DocActivity;
use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class AmandemenSpCreateController
{
  public function __construct()
  {
      //oke
  }
  public function store($request)
  {
    // dd("hai");
    $type = $request->type;
    $rules = [];
    if($request->statusButton == '0'){
    $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
    $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
    $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak2_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    // $rules['doc_lampiran.*']     =  'required|mimes:pdf';
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

    $rule_scope_name = (count($request['scope_name'])>1)?'required':'sometimes|nullable';
    $rule_scope_awal = (count($request['scope_awal'])>1)?'required':'sometimes|nullable';
    $rule_scope_akhir = (count($request['scope_akhir'])>1)?'required':'sometimes|nullable';
    $rules['scope_file.*']  =  'sometimes|nullable|mimes:pdf';
    $rules['scope_name.*']  =  $rule_scope_name.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['scope_awal.*']  =  $rule_scope_awal.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['scope_akhir.*']  =  $rule_scope_akhir.'|max:500|regex:/^[a-z0-9 .\-]+$/i';

    // $rule_lt_name = (count($request['lt_name'])>1)?'required':'sometimes|nullable';
    // $rule_lt_desc = (count($request['lt_desc'])>1)?'required':'sometimes|nullable';
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

    //dd($validator->errors());
    if ($validator->fails ()){
      return redirect()->back()
                  ->withInput($request->input())
                  ->withErrors($validator);
    }
  }else{
      if(\Laratrust::hasRole('admin')){
        $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      }
      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

      if ($validator->fails ()){
        return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
      }

  }
    // dd($request->input());
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
    $doc->doc_parent_id = $request->parent_sp;
    $doc->supplier_id = Documents::where('id',$doc->doc_parent_id)->first()->supplier_id;
    $doc->doc_signing = $request->statusButton;
    $doc->save();

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

    if(count($request->scope_name)>0){
      foreach($request->scope_name as $key => $val){
        if(!empty($val)
            && !empty($request['scope_awal'][$key])
            && !empty($request['scope_akhir'][$key])
        ){

          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'scope_perubahan';
          $doc_meta->meta_name = $request['scope_name'][$key];
          $doc_meta->meta_title = $request['scope_awal'][$key];
          $doc_meta->meta_desc = $request['scope_akhir'][$key];

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

    $log_activity = new DocActivity();
    $log_activity->users_id = Auth::id();
    $log_activity->documents_id = $doc->id;
    $log_activity->activity = "Submitted";
    $log_activity->date = new \DateTime();
    $log_activity->save();


    //dd($request->input());
    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    if($request->statusButton == '0'){
      return redirect()->route('doc',['status'=>'tracking']);
    }else{
      return redirect()->route('doc',['status'=>'draft']);
    }
  }
}
