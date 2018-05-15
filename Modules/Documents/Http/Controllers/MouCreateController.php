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
use Modules\Documents\Entities\DocPo;
use Modules\Documents\Entities\DocActivity;
use Modules\Config\Entities\Config;
use Modules\Documents\Entities\DocComment as Comments;

use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class MouCreateController extends Controller
{
    public function __construct()
    {
        //oke
    }
    public function store_ajax(Request $request)
    {
      $type = $request->type;
      $doc_value = $request->doc_value;
      $request->merge(['doc_value' => Helpers::input_rupiah($request->doc_value)]);
      $m_hs_harga=[];
      $m_hs_qty=[];

      $user_type = Helpers::usertype();
      $auto_numb =Config::get_config('auto-numb');
      $statusButton = $request->statusButton;
      $required = 'required';
      $date_format = 'date_format:"d-m-Y"';
      
      if($statusButton=='2'){
        $required = 'sometimes|nullable';
      }

      if(isset($request['hs_harga']) && count($request['hs_harga'])>0){
        foreach($request['hs_harga'] as $key => $val){
          $hs_harga[] = $val;
          $m_hs_harga[$key] = Helpers::input_rupiah($val);
        }
      }

      if(count($m_hs_harga)>0){
        $request->merge(['hs_harga'=>$m_hs_harga]);
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


      $rules = [];
      $rules['komentar']         = $required.'|max:250|min:2';
      if(Helpers::usertype()!='subsidiary'){
        $rules['divisi']      =  'required|min:1|exists:__mtz_pegawai,divisi';
        $rules['unit_bisnis'] =  'required|min:1|exists:__mtz_pegawai,unit_bisnis';
        $rules['unit_kerja']  =  'required|min:1|exists:__mtz_pegawai,unit_kerja';
      }
      $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_startdate']    =  $required.'|'.$date_format;
      $rules['doc_enddate']      =  $required.'|'.$date_format.'|after:doc_startdate';
      $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_pihak2_nama']  =  $required.'|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

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

      $rule_ps_judul = (count($request['ps_judul'])>1)?$required:'sometimes|nullable';
      $rule_ps_isi = (count($request['ps_isi'])>1)?$required:'sometimes|nullable';
      $rules['ps_judul.*']      =  $rule_ps_judul.'|in:Jangka Waktu Penerbitan Surat Pesanan,Jangka Waktu Penyerahan Pekerjaan,Tata Cara Pembayaran,Tanggal Efektif dan Masa Laku Perjanjian,Jaminan Pelaksanaan,Jaminan Uang Muka,Jaminan Pemeliharaan,Masa Laku Jaminan,Harga Kontrak,Lainnya';
      $rules['ps_isi.*']        =  $rule_ps_isi.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

      if(is_array($request->ps_judul)) {
        foreach($request->ps_judul as $k => $v){
          if(isset($request->ps_judul[$k]) && $request->ps_judul[$k]=="Lainnya" && !empty($v)){//jika ada file baru
            $new_pasal[] = $request->ps_judul_new[$k];
            $rules['ps_judul_new.'.$k] = $required.'|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
          }
          else{
            $new_pasal[] = $v;
          }
        }

        $request->merge(['ps_judul_new' => $new_pasal]);
      }

      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
      $validator->after(function ($validator) use ($request,$auto_numb,$user_type) {
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
            $validator->errors()->has('doc_sow') 
          ){
            array_push($tabs_error,'tab_ruang_lingkup');
          }
          if(
            $validator->errors()->has('ps_judul.*') || 
            $validator->errors()->has('ps_isi.*')
          ){
            array_push($tabs_error,'tab_pasal_khusus');
          }
          if(count($tabs_error)>0){
            foreach ($tabs_error as $key=>$val){
              $validator->errors()->add('tabs_error.'.$key, $val);
            }
          }
      });
      $request->merge(['doc_value' => $doc_value]);
      if(isset($hs_harga) && count($hs_harga)>0){
        $request->merge(['hs_harga'=>$hs_harga]);
      }
      if(isset($hs_qty) && count($hs_qty)>0){
        $request->merge(['hs_qty'=>$hs_qty]);
      }


      if ($validator->fails ()){
        //return redirect()->back()->withInput($request->input())->withErrors($validator);
        return Response::json (array(
          'errors' => $validator->getMessageBag()->toArray()
        ));
      }
      DB::beginTransaction();
      try {
      $doc = new Documents();
      $doc->doc_title = $request->doc_title;
      $doc->doc_desc = $request->doc_desc;
      $template_id = DocTemplate::get_by_type($type)->id;
      $doc->doc_template_id = $template_id;
      $doc->doc_date = Helpers::date_set_db($request->doc_startdate);
      $start_date = $request->doc_startdate;
      $doc->doc_startdate = Helpers::date_set_db($start_date);
      $doc->doc_enddate = Helpers::date_set_db($request->doc_enddate);
      $doc->doc_pihak1 = $request->doc_pihak1;
      $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
      $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
      $doc->user_id = (\Laratrust::hasRole('admin'))?$request->user_id:Auth::id();
      $doc->supplier_id = $request->supplier_id;

      if(in_array($type,['turnkey','sp','surat_pengikatan'])){
        $doc->doc_po_no = $request->doc_po;
      }

      $doc->doc_proc_process = $request->doc_proc_process;
      $doc->doc_mtu = $request->doc_mtu;
      $doc->doc_value = Helpers::input_rupiah($request->doc_value);
      $doc->doc_sow = $request->doc_sow;
      $doc->doc_type = $request->type;
      $doc->doc_signing = $request->statusButton;

      $doc->penomoran_otomatis = Config::get_penomoran_otomatis($request->penomoran_otomatis);
      if($user_type=='subsidiary'){
        $doc->doc_no = $request->doc_no;
      }
      if($user_type!='subsidiary' && $auto_numb=='off'){
        $doc->doc_no = Documents::create_manual_no_kontrak($request->doc_no,$request->doc_pihak1_nama,$template_id,$doc->doc_startdate,$request->type);
      }
      if(Helpers::usertype()=='subsidiary'){
        $doc->doc_user_type = 'subsidiary';
        $doc->penomoran_otomatis = 'no';
      }
      $doc->divisi = $request->divisi;
      $doc->unit_bisnis = $request->unit_bisnis;
      $doc->unit_kerja = $request->unit_kerja;
      $doc->save();

      if(count($request->ps_judul)>0){
        foreach($request->ps_judul as $key => $val){
          if(!empty($val)
          ){
            $doc_meta2 = new DocMeta();
            $doc_meta2->documents_id = $doc->id;
            $doc_meta2->meta_type = 'pasal_pasal';
            $doc_meta2->meta_name = $request['ps_judul'][$key];
            $doc_meta2->meta_title =$request['ps_judul_new'][$key];
            $doc_meta2->meta_desc = $request['ps_isi'][$key];
            $doc_meta2->save();
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

      if(count($request->lt_name)>0){
        foreach($request->lt_name as $key => $val){
          if(!empty($val)){
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

      if($request->statusButton == '0'){
        $comment = new Comments();
        $comment->content = $request->komentar;
        $comment->documents_id = $doc->id;
        $comment->users_id = \Auth::id();
        $comment->status = 1;
        $comment->data = "Submitted";
        $comment->save();
      }
      /*
      $request->session()->flash('alert-success', 'Data berhasil disimpan');
      if($request->statusButton == '0'){
        return redirect()->route('doc',['status'=>'tracking']);
      }else{
        return redirect()->route('doc',['status'=>'draft']);
      }
      */

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

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('documents::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('documents::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    protected function rules(){

    }
}
