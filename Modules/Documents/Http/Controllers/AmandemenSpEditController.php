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
use Modules\Documents\Entities\DocAsuransi;
use Modules\Documents\Entities\DocTemplate;
use Modules\Config\Entities\Config;
use Modules\Documents\Entities\DocComment as Comments;

use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class AmandemenSpEditController extends Controller
{
  public function __construct()
  {
      //oke
  }
  public function store_ajax($request)
  {
    $type = $request->type;
    $id = $request->id;
    $status = Documents::where('id',$id)->first()->doc_signing;
    $rules = [];
    
    $user_type = Helpers::usertype();
    $auto_numb =Config::get_config('auto-numb');
    $statusButton = $request->statusButton;
    $required = 'required';
    $date_format = 'date_format:"d-m-Y"';
    if($statusButton=='2'){
      $required = 'sometimes|nullable';
    }
    if(!Documents::check_permission_doc($id ,$type)){
      abort(404);
    }
    if(in_array($status,['2'])){
      $rules['parent_kontrak']   =  'required|kontrak_exists';
      if($user_type!='subsidiary'){
        $rules['divisi']      =  'required|min:1|exists:__mtz_pegawai,divisi';
        $rules['unit_bisnis'] =  'required|min:1|exists:__mtz_pegawai,unit_bisnis';
        $rules['unit_kerja']  =  'required|min:1|exists:__mtz_pegawai,unit_kerja';
      }
      $rules['doc_title']        =  'required|min:2';
      $rules['doc_startdate']    =  $required.'|'.$date_format;
      $rules['doc_enddate']      =  $required.'|'.$date_format.'|after:doc_startdate';
      $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak2_nama']  =  $required.'|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['komentar']         = $required.'|max:250|min:2';
      if(\Laratrust::hasRole('admin')){
        $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      }

      if($user_type=='subsidiary'){
        $rules['doc_no']  =  'required|min:5|max:500|unique:documents,doc_no,'.$id;
      }
      else{
        if($auto_numb=='off'){
          $rules['doc_no']  =  'required|digits_between:1,5';
        }
      }
      $rules['doc_lampiran_nama.*']  =  $required.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
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
    }

    $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
    $validator->after(function ($validator) use ($request,$auto_numb,$user_type) {
      // if($request->doc_enddate < $request->doc_startdate){
      //   $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
      // }
      if($user_type!='subsidiary' && $auto_numb=='off' && !$validator->errors()->has('doc_no')){
        $d = Documents::check_no_kontrak($request['doc_no'],date('Y',strtotime($request['doc_startdate'])));
        if($d){
          $validator->errors()->add('doc_no', 'No Kontrak yang Anda masukan sudah ada!');
        }
      }
    });
    $validator->after(function ($validator) use ($request) {
      $tabs_error = [];
      if(
          $validator->errors()->has('doc_no') || 
          $validator->errors()->has('doc_title') ||
          $validator->errors()->has('doc_desc') ||
          $validator->errors()->has('parent_kontrak') ||
          $validator->errors()->has('parent_sp') ||
          $validator->errors()->has('doc_startdate') ||
          $validator->errors()->has('doc_enddate') || 
          $validator->errors()->has('divisi') || 
          $validator->errors()->has('unit_bisnis') || 
          $validator->errors()->has('unit_kerja') || 
          $validator->errors()->has('doc_pihak1') || 
          $validator->errors()->has('doc_pihak1_nama') || 
          $validator->errors()->has('supplier_id') || 
          $validator->errors()->has('doc_pihak2_nama') || 
          $validator->errors()->has('doc_proc_process') || 
          $validator->errors()->has('doc_mtu') || 
          $validator->errors()->has('doc_value') || 
          $validator->errors()->has('doc_po') || 
          $validator->errors()->has('doc_nilai_material') || 
          $validator->errors()->has('doc_nilai_jasa') || 
          $validator->errors()->has('doc_lampiran_nama.*') || 
          $validator->errors()->has('doc_lampiran.*') ||
          $validator->errors()->has('pic_nama.*') ||
          $validator->errors()->has('pic_jabatan.*') ||
          $validator->errors()->has('pic_email.*') ||
          $validator->errors()->has('pic_telp.*') ||
          $validator->errors()->has('pic_posisi.*')
        ){
          array_push($tabs_error,'tab_general_info');
        }
        if(
          $validator->errors()->has('f_judul.*') || 
          $validator->errors()->has('f_harga.*') || 
          $validator->errors()->has('f_tanggal1.*') || 
          $validator->errors()->has('f_tanggal2.*') || 
          $validator->errors()->has('f_isi.*')
        ){
          array_push($tabs_error,'tab_sow_boq');
        }
        if(
          $validator->errors()->has('f_latar_belakang_judul.*') || 
          $validator->errors()->has('f_latar_belakang_tanggal.*') || 
          $validator->errors()->has('f_latar_belakang_isi.*') || 
          $validator->errors()->has('f_latar_belakang_file.*')
        ){
          array_push($tabs_error,'tab_latar_belakang');
        }
        if(count($tabs_error)>0){
          foreach ($tabs_error as $key=>$val){
            $validator->errors()->add('tabs_error.'.$key, $val);
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
    $doc = Documents::where('id',$id)->first();
    
    if(in_array($status,['0','2'])){
      if($status=='2'){
        $doc->doc_title = $request->doc_title;
        $doc->doc_date = Helpers::date_set_db($request->doc_startdate);
        $start_date = $request->doc_startdate;
        $doc->doc_startdate = Helpers::date_set_db($start_date);
        $doc->doc_enddate = Helpers::date_set_db($request->doc_enddate);
        $doc->doc_desc = $request->doc_desc;
        $doc->doc_pihak1 = $request->doc_pihak1;
        $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
        $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
        if((\Laratrust::hasRole('admin'))){
          $doc->user_id  = $request->user_id;
        }
        
        $doc->divisi = $request->divisi;
        $doc->unit_bisnis = $request->unit_bisnis;
        $doc->unit_kerja = $request->unit_kerja;
        $doc->penomoran_otomatis = Config::get_penomoran_otomatis($request->penomoran_otomatis);
        if($user_type=='subsidiary'){
          $doc->doc_no = $request->doc_no;
        }

        if($user_type!='subsidiary' && $auto_numb=='off'){
          $doc->doc_no = Documents::create_manual_no_kontrak($request->doc_no,$request->doc_pihak1_nama,$request->doc_template_id,$start_date,$request->type);
        }

        $doc->doc_signing = ($statusButton=='2')?'2':'0';
        $doc->doc_parent = 0;
        $doc->doc_parent_id = $request->parent_sp;
        $doc->supplier_id = Documents::where('id',$doc->doc_parent_id)->first()->supplier_id;
        
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
              $doc_meta->meta_name = $request['doc_lampiran_nama'][$key];
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
        
      }
    }else{
      //kalo dokumennya di return/ di approve dan di edit datanya (status = 3 & 1)
      $doc->doc_signing = ($statusButton=='2')?'2':'0';
    }
    $doc->doc_data = Helpers::json_input($doc->doc_data,['edited_by'=>\Auth::id()]);
    $doc->save();

    if(count($request->f_judul)>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','sow_boq']
        ])->delete();
      foreach($request->f_judul as $key => $val){
        if(!empty($val)){

          if($val=="Harga"){
            $f_name="harga";
            $desc=$request->f_harga[$key];
          }elseif($val=="Jangka Waktu"){
            $f_name="jangka_waktu";
            $desc=date("Y-m-d", strtotime($request->f_tanggal1[$key])) ."|". date("Y-m-d", strtotime($request->f_tanggal2[$key]));
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

    // latar belakang optional
    if(count($request->f_latar_belakang_judul)>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','latar_belakang_optional']
        ])->delete();
      foreach($request->f_latar_belakang_judul as $key => $val){
        if(!empty($val) && !empty($request['f_latar_belakang_judul'][$key])){

          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = "latar_belakang_optional";
          $doc_meta->meta_name = $request['f_latar_belakang_judul'][$key];
          $doc_meta->meta_title = date("Y-m-d", strtotime($request['f_latar_belakang_tanggal'][$key]));
          $doc_meta->meta_desc = $request['f_latar_belakang_isi'][$key];

          if(is_object($request['f_latar_belakang_file'][$key])){
            $fileName   = Helpers::set_filename('doc_',strtolower($val));
            $file       = $request['f_latar_belakang_file'][$key];
            $file->storeAs('document/'.$request->type.'_latar_belakang_optional', $fileName);
            $doc_meta->meta_file = $fileName;
          }else{
            $doc_meta->meta_file = $request['f_latar_belakang_file_old'][$key];
          }
          $doc_meta->save();
        }
      }
    }

    if(count($request['scope_name'])>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','scope_perubahan']
        ])->delete();
      foreach($request['scope_name'] as $key => $val){
        if(!empty($request['scope_name'][$key])
            && !empty($request['scope_awal'][$key])
            && !empty($request['scope_akhir'][$key])
        ){

          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = 'scope_perubahan';
          $doc_meta->meta_name = $request['scope_name'][$key];
          $doc_meta->meta_title = $request['scope_awal'][$key];
          $doc_meta->meta_desc = $request['scope_akhir'][$key];

          if(is_object($new_scope_file_up[$key])){
            $fileName   = Helpers::set_filename('doc_scope_perubahan_',strtolower($val));
            $file = $new_scope_file_up[$key];
            $file->storeAs('document/'.$request->type.'_scope_perubahan', $fileName);
            $doc_meta->meta_file = $fileName;
          }
          else{
            $doc_meta->meta_file = $new_scope_file_up[$key];
          }
          $doc_meta->save();
        }
      }
    }

    if(!empty($request->komentar)){
      $comment = new Comments();
      $comment->content = $request->komentar;
      $comment->documents_id = $doc->id;
      $comment->users_id = \Auth::id();
      $comment->status = 1;
      $comment->data = "Submitted";
      $comment->save();
    }
    DB::commit();
    $r_status=($statusButton=='2')?'draft':'tracking';
    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    //return redirect()->route('doc',['status'=>'tracking']);
    return Response::json (array(
      'status' => $r_status
    ));
    } catch (\Exception $e) {
          DB::rollBack();
          return Response::json (array(
            'status' => 'error',
            'msg' => $e->getMessage()
          ));
      }
  }
}
