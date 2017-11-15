<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Response;

use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\Documents;
use Modules\Documents\Entities\DocBoq;
use Modules\Documents\Entities\DocMeta;
use Modules\Documents\Entities\DocPic;
use Modules\Documents\Entities\DocTemplate;
use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class AmandemenKontrakEditController extends Controller
{
  public function __construct()
  {
      //oke
  }
  public function store($request)
  {
    // dd("hai");
    $type = $request->type;
    $id = $request->id;
    $rules = [];
    $rules['doc_date']         =  'required|date_format:"Y-m-d"';
    $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
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

    $rule_scope_pasal = (count($request['scope_pasal'])>1)?'required':'sometimes|nullable';
    $rule_scope_judul = (count($request['scope_judul'])>1)?'required':'sometimes|nullable';
    $rule_scope_isi = (count($request['scope_isi'])>1)?'required':'sometimes|nullable';
    $rules['scope_file.*']  =  'sometimes|nullable|mimes:pdf';
    $rules['scope_pasal.*']  =  $rule_scope_pasal.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['scope_judul.*']  =  $rule_scope_judul.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['scope_isi.*']  =  $rule_scope_isi.'|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';


    $rule_lt_name = (count($request['lt_name'])>1)?'required':'sometimes|nullable';
    $rule_lt_desc = (count($request['lt_desc'])>1)?'required':'sometimes|nullable';
    // $rules['lt_file.*']  =  'sometimes|nullable|mimes:pdf';
    $rules['lt_desc.*']  =  $rule_lt_desc.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['lt_name.*']  =  $rule_lt_name.'|max:500|regex:/^[a-z0-9 .\-]+$/i';

    foreach($request->lt_file_old as $k => $v){
      if(isset($request->lt_file[$k]) && is_object($request->lt_file[$k]) && !empty($v)){//jika ada file baru
        $new_lt_file[] = '';
        $new_lt_file_up[] = $request->lt_file[$k];
        $rules['lt_file.'.$k]  =  'sometimes|nullable|mimes:pdf';
      }
      else if(empty($v)){
        $rules['lt_file.'.$k]  =  'sometimes|nullable|mimes:pdf';
        if(!isset($request->lt_file[$k])){
          $new_lt_file[] = $v;
          $new_lt_file_up[] = $v;
        }
        else{
          $new_lt_file[] = '';
          $new_lt_file_up[] = $request->lt_file[$k];
        }
      }
      else{
        $new_lt_file[] = $v;
        $new_lt_file_up[] = $v;
      }
    }
    $request->merge(['lt_file' => $new_lt_file]);

    $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

    //dd($validator->errors());
    if ($validator->fails ()){
      return redirect()->back()
                  ->withInput($request->input())
                  ->withErrors($validator);
    }

    // dd($request->input());
    $doc = Documents::where('id',$id)->first();
    $doc->doc_title = $request->doc_title;
    $doc->doc_date = $request->doc_date;
    $doc->doc_desc = $request->doc_desc;
    $doc->doc_template_id = DocTemplate::get_by_type($type)->id;
    $doc->doc_pihak1 = $request->doc_pihak1;
    $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
    $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
    // $doc->user_id = Auth::id();
    $doc->supplier_id = $request->supplier_id;

    // if(isset($request->doc_lampiran)){
    //   $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($request->doc_title));
    //   $request->doc_lampiran->storeAs('document/'.$request->type, $fileName);
    //   $doc->doc_lampiran = $fileName;
    // }

    $doc->doc_parent = 0;
    $doc->doc_parent_id = $request->parent_kontrak;
    // $doc->doc_signing = $request->statusButton;
    $doc->doc_data = Helpers::json_input($doc->doc_data,['edited_by'=>\Auth::id()]);
    $doc->save();

    if(count($new_lamp_up)>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','lampiran_ttd']
        ])->delete();
      foreach($new_lamp_up as $key => $val){
        if(!empty($val)){
          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'lampiran_ttd';
          if(is_object($val)){
            $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($val));
            $file = $request['doc_lampiran'][$key];
            $file->storeAs('document/'.$request->type.'_lampiran_ttd', $fileName);
            $doc_meta->meta_file = $fileName;
          }
          else{
            $doc_meta->meta_file = $val;
          }
          $doc_meta->save();
        }
      }
    }

    if(count($request['lt_name'])>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','latar_belakang']
        ])->delete();
      foreach($request['lt_name'] as $key => $val){
        if(!empty($request['lt_name'][$key])
            && !empty($request['lt_desc'][$key])
        ){
          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'latar_belakang';
          $doc_meta->meta_name = $request['lt_name'][$key];
          $doc_meta->meta_desc = $request['lt_desc'][$key];
          if(is_object($new_lt_file_up[$key])){
            $fileName   = Helpers::set_filename('doc_',strtolower($request['lt_name'][$key]));
            $file = $new_lt_file_up[$key];
            $file->storeAs('document/'.$request->type.'_latar_belakang', $fileName);
            $doc_meta->meta_file = $fileName;
          }
          else{
            $doc_meta->meta_file = $new_lt_file_up[$key];
          }
          $doc_meta->save();
        }
      }
    }

    if(count($request->scope_pasal)>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','scope_perubahan']
        ])->delete();
      foreach($request->scope_pasal as $key => $val){
        if(!empty($val)
            && !empty($request['scope_judul'][$key])
            && !empty($request['scope_isi'][$key])
        ){
          $scope_judul = $request['scope_judul'][$key];
          $scope_isi = $request['scope_isi'][$key];
          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'scope_perubahan';
          $doc_meta->meta_name = $request['scope_pasal'][$key];
          $doc_meta->meta_title = $request['scope_judul'][$key];
          $doc_meta->meta_desc = $request['scope_isi'][$key];


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


    //dd($request->input());
    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    return redirect()->back();
  }
}
