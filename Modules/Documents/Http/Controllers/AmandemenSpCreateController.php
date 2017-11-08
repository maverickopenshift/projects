<?php

namespace Modules\Documents\Http\Controllers;

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

class AmandemenSpCreateController
{
  public function __construct()
  {
      //oke
  }
  public function store($request)
  {
    $type = $request->type;
    $rules = [];
    $rules['doc_date']         =  'required|date_format:"Y-m-d"';
    $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
    $rules['doc_pihak2_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['doc_lampiran']     =  'required|mimes:pdf';

    $rule_scope_name = (count($request['scope_name'])>1)?'required':'sometimes|nullable';
    $rule_scope_awal = (count($request['scope_awal'])>1)?'required':'sometimes|nullable';
    $rule_scope_akhir = (count($request['scope_akhir'])>1)?'required':'sometimes|nullable';
    $rules['scope_file.*']  =  'sometimes|nullable|mimes:pdf';
    $rules['scope_name.*']  =  $rule_scope_name.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['scope_awal.*']  =  $rule_scope_awal.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['scope_akhir.*']  =  $rule_scope_akhir.'|max:500|regex:/^[a-z0-9 .\-]+$/i';


    $rule_lt_name = (count($request['lt_name'])>1)?'required':'sometimes|nullable';
    $rule_lt_desc = (count($request['lt_desc'])>1)?'required':'sometimes|nullable';
    $rules['lt_file.*']  =  'sometimes|nullable|mimes:pdf';
    $rules['lt_desc.*']  =  $rule_lt_desc.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['lt_name.*']  =  $rule_lt_name.'|max:500|regex:/^[a-z0-9 .\-]+$/i';

    $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

    //dd($validator->errors());
    if ($validator->fails ()){
      return redirect()->back()
                  ->withInput($request->input())
                  ->withErrors($validator);
    }
    // dd($request->input());
    $doc = new Documents();
    $doc->doc_title = $request->doc_title;
    $doc->doc_date = $request->doc_date;
    $doc->doc_desc = $request->doc_desc;
    $doc->doc_template_id = DocTemplate::get_by_type($type)->id;
    $doc->doc_pihak1 = $request->doc_pihak1;
    $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
    $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
    $doc->user_id = Auth::id();
    $doc->supplier_id = $request->supplier_id;

    if(isset($request->doc_lampiran)){
      $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($request->doc_title));
      $request->doc_lampiran->storeAs('document/'.$request->type, $fileName);
      $doc->doc_lampiran = $fileName;
    }

    $doc->doc_type = $request->type;
    $doc->doc_parent = 0;
    $doc->doc_parent_id = $request->parent_sp;
    $doc->save();

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


    //dd($request->input());
    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    return redirect()->route('doc');
  }
}
