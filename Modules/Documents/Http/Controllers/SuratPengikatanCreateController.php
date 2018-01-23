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
use Modules\Documents\Entities\DocComment as Comments;

use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class SuratPengikatanCreateController extends Controller
{
    public function __construct()
    {
        //oke
    }

    public function store(Request $request)
    {
      $type = $request->type;
      $doc_value = $request->doc_value;
      $request->merge(['doc_value' => Helpers::input_rupiah($request->doc_value)]);
      $m_hs_harga=[];
      $m_hs_qty=[];

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
      if($request->statusButton == '0'){
        $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_desc']         =  'sometimes|nullable|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
        $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
        $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_pihak2_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

        if(\Laratrust::hasRole('admin')){
          $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
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

        $rules['lt_desc.0']  =  'required|date_format:"Y-m-d"';
        $rules['lt_desc.3']  =  'required|date_format:"Y-m-d"';
        $rules['lt_desc.4']  =  'required|date_format:"Y-m-d"';
        $rules['lt_name.0']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_name.3']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_name.4']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';

        $check_new_file = false;
        foreach($request->lt_file_old as $k => $v){
          if(isset($request->lt_file[$k]) && is_object($request->lt_file[$k]) && !empty($v)){//jika ada file baru
            $new_file[] = '';
            $new_file_up[] = $request->lt_file[$k];
            if(!in_array($k,['1','2'])){
              $rules['lt_file.'.$k] = 'required|mimes:pdf';
            }
          }
          else if(empty($v)){
            if(!in_array($k,['1','2'])){
              $rules['lt_file.'.$k] = 'required|mimes:pdf';
            }

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

        $rule_ps_judul = (count($request['ps_judul'])>1)?'required':'sometimes|nullable';
        $rule_ps_isi = (count($request['ps_isi'])>1)?'required':'sometimes|nullable';
        $rules['ps_judul.*']      =  $rule_ps_judul.'|in:Jangka Waktu Penerbitan Surat Pesanan,Jangka Waktu Penyerahan Pekerjaan,Tata Cara Pembayaran,Tanggal Efektif dan Masa Laku Perjanjian,Jaminan Pelaksanaan,Jaminan Uang Muka,Jaminan Pemeliharaan,Masa Laku Jaminan,Harga Kontrak,Lainnya';
        $rules['ps_isi.*']        =  $rule_ps_isi.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

        if(is_array($request->ps_judul)) {
          foreach($request->ps_judul as $k => $v){
            if(isset($request->ps_judul[$k]) && $request->ps_judul[$k]=="Lainnya" && !empty($v)){//jika ada file baru
              $new_pasal[] = $request->ps_judul_new[$k];
              $rules['ps_judul_new.'.$k] = 'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
            }
            else{
              $new_pasal[] = $v;
            }
          }

          $request->merge(['ps_judul_new' => $new_pasal]);
        }

        $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

        $request->merge(['doc_value' => $doc_value]);
        if(isset($hs_harga) && count($hs_harga)>0){
          $request->merge(['hs_harga'=>$hs_harga]);
        }
        if(isset($hs_qty) && count($hs_qty)>0){
          $request->merge(['hs_qty'=>$hs_qty]);
        }

        if ($validator->fails ()){
          return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
      }else{
          $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
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
// dd($request->input());
      $doc = new Documents();
      $doc->doc_title = $request->doc_title;
      $doc->doc_desc = $request->doc_desc;
      $doc->doc_template_id = DocTemplate::get_by_type($type)->id;
      $doc->doc_startdate = $request->doc_startdate;
      $doc->doc_enddate = $request->doc_enddate;
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
