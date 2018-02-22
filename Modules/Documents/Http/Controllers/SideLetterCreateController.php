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

class SideLetterCreateController
{
  public function __construct()
  {
      //oke
  }
  
  // function store sudah tidak di pakai

  public function store($request)
  {
    $type = $request->type;
    $rules = [];

    if($request->statusButton == '0'){
      $rules['parent_kontrak']   =  'required|kontrak_exists';
      $rules['komentar']         = 'required|max:250|min:2';
      $rules['divisi']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['unit_bisnis']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
      $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
      $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak2_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

      $rules['doc_lampiran_nama.*']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      if( Config::get_config('auto-numb')=='off'){
        $rules['doc_no']  =  'required|min:5|max:500|unique:documents,doc_no';
      }
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

      if(\Laratrust::hasRole('admin')){
        $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      }

      $rules['lt_judul_ketetapan_pemenang']     = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['lt_tanggal_ketetapan_pemenang']   = 'required|date_format:"Y-m-d"';
      $rules['lt_file_ketetapan_pemenang']      = 'required|mimes:pdf';

      $rules['lt_judul_kesanggupan_mitra']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['lt_tanggal_kesanggupan_mitra']  = 'required|date_format:"Y-m-d"';
      $rules['lt_file_kesanggupan_mitra']     = 'required|mimes:pdf';

      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
      $validator->after(function ($validator) use ($request) {
        if($request->doc_enddate < $request->doc_startdate){
          $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
        }
      });
      if ($validator->fails ()){
        return redirect()->back()->withInput($request->input())->withErrors($validator);
      }
    }else{
      $rules['parent_kontrak']   =  'required|kontrak_exists';
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
    $doc->penomoran_otomatis = Config::get_penomoran_otomatis($request->penomoran_otomatis);
    if( Config::get_config('auto-numb')=='off'){
      $doc->doc_no = $request->doc_no;
    }
    $doc->save();

    //pemilik Kontrak
    if(count($request->divisi)>0){
      $doc_meta2 = new DocMeta();
      $doc_meta2->documents_id = $doc->id;
      $doc_meta2->meta_type = 'pemilik_kontrak';
      $doc_meta2->meta_name = $request->divisi;
      $doc_meta2->meta_title =$request->unit_bisnis;
      $doc_meta2->save();
    }

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

    // latar belakang wajib
    if(isset($request->lt_judul_ketetapan_pemenang)){
      $doc_meta = new DocMeta();
      $doc_meta->documents_id = $doc->id;
      $doc_meta->meta_type = "latar_belakang_ketetapan_pemenang";
      $doc_meta->meta_name = "Latar Belakang Ketetapan Pemenang";
      $doc_meta->meta_desc = $request->lt_tanggal_ketetapan_pemenang;

      if(isset($request->lt_file_ketetapan_pemenang)){
        $fileName   = Helpers::set_filename('doc_',strtolower($request->lt_judul_ketetapan_pemenang));
        $file = $request->lt_file_ketetapan_pemenang;
        $file->storeAs('document/'.$type.'_latar_belakang_ketetapan_pemenang', $fileName);
        $doc_meta->meta_file = $fileName;
      }

      $doc_meta->save();
    }

    if(isset($request->lt_judul_kesanggupan_mitra)){
      $doc_meta = new DocMeta();
      $doc_meta->documents_id = $doc->id;
      $doc_meta->meta_type = "latar_belakang_kesanggupan_mitra";
      $doc_meta->meta_name = "Latar Belakang Kesanggupan Mitra";
      $doc_meta->meta_desc = $request->lt_tanggal_kesanggupan_mitra;

      if(isset($request->lt_file_kesanggupan_mitra)){
        $fileName   = Helpers::set_filename('doc_',strtolower($request->lt_judul_kesanggupan_mitra));
        $file = $request->lt_file_kesanggupan_mitra;
        $file->storeAs('document/'.$type.'_latar_belakang_kesanggupan_mitra', $fileName);
        $doc_meta->meta_file = $fileName;
      }

      $doc_meta->save();
    }

    // latar belakang optional
    if(count($request->f_latar_belakang_judul)>0){
      foreach($request->f_latar_belakang_judul as $key => $val){
        if(!empty($val) && !empty($request['f_latar_belakang_judul'][$key])){

          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_type = "latar_belakang_optional";
          $doc_meta->meta_name = $request['f_latar_belakang_judul'][$key];
          $doc_meta->meta_title = $request['f_latar_belakang_tanggal'][$key];
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

  public function store_ajax($request)
  {
    $type = $request->type;
    $rules = [];

    if($request->statusButton == '0'){
      $rules['parent_kontrak']   =  'required|kontrak_exists';
      $rules['komentar']         = 'required|max:250|min:2';
      $rules['divisi']           =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['unit_bisnis']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
      $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
      $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak2_nama']  =  'required|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

      $rules['doc_lampiran_nama.*']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      if( Config::get_config('auto-numb')=='off'){
        $rules['doc_no']  =  'required|min:5|max:500|unique:documents,doc_no';
      }
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

      $rule_scope_pasal = (count($request['f_scope_pasal'])>1)?'required':'sometimes|nullable';
      $rule_scope_judul = (count($request['f_scope_judul'])>1)?'required':'sometimes|nullable';
      $rule_scope_isi = (count($request['f_scope_isi'])>1)?'required':'sometimes|nullable';
      $rules['f_scope_file.*']  =  'sometimes|nullable|mimes:pdf';
      $rules['f_scope_pasal.*']  =  $rule_scope_pasal.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['f_scope_judul.*']  =  $rule_scope_judul.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['f_scope_isi.*']  =  $rule_scope_isi.'|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

      if(\Laratrust::hasRole('admin')){
        $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      }

      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
      $validator->after(function ($validator) use ($request, $type) {
        if($request->doc_enddate < $request->doc_startdate){
          $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
        }
      });
      if ($validator->fails ()){
        return Response::json (array(
          'errors' => $validator->getMessageBag()->toArray()
        ));
      }
    }else{
      $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['parent_kontrak']   =  'required|kontrak_exists';
      if(\Laratrust::hasRole('admin')){
        $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      }
      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

      if ($validator->fails ()){
        return Response::json (array(
          'errors' => $validator->getMessageBag()->toArray()
        ));
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
    $doc->penomoran_otomatis = Config::get_penomoran_otomatis($request->penomoran_otomatis);
    
    if( Config::get_config('auto-numb')=='off'){
      $doc->doc_no = $request->doc_no;
    }

    $doc->save();

    //pemilik Kontrak
    if(count($request->divisi)>0){
      $doc_meta2 = new DocMeta();
      $doc_meta2->documents_id = $doc->id;
      $doc_meta2->meta_type = 'pemilik_kontrak';
      $doc_meta2->meta_name = $request->divisi;
      $doc_meta2->meta_title =$request->unit_bisnis;
      $doc_meta2->save();
    }

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
          $doc_meta->meta_title = $request['f_latar_belakang_tanggal'][$key];
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
    if($request->statusButton == '0'){
      return Response::json (array(
        'status' => 'tracking'
      ));
    }else{
      return Response::json (array(
        'status' => 'draft'
      ));
    }
  }
}
