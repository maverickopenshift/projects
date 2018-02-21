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
        $rules['komentar']         = 'required|max:250|min:2';
        $rules['divisi']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['unit_bisnis']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_desc']         =  'sometimes|nullable|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
        $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
        $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_pihak2_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

        if(\Laratrust::hasRole('admin')){
          $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        }
        if(Config::get_config('auto-numb')=='off'){
          $rules['doc_no']  =  'required|min:5|max:500|unique:documents,doc_no';
        }
        $rules['doc_lampiran_nama.*']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
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

        $rules['lt_judul_ketetapan_pemenang']     = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_ketetapan_pemenang']   = 'required|date_format:"Y-m-d"';
        $rules['lt_file_ketetapan_pemenang']      = 'required|mimes:pdf';

        $rules['lt_judul_kesanggupan_mitra']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_kesanggupan_mitra']  = 'required|date_format:"Y-m-d"';
        $rules['lt_file_kesanggupan_mitra']     = 'required|mimes:pdf';

        $rules['lt_judul_rks']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_rks']  = 'required|date_format:"Y-m-d"';
        $rules['lt_file_rks']     = 'required|mimes:pdf';

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
        $validator->after(function ($validator) use ($request) {
          if($request->doc_enddate < $request->doc_startdate){
            $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
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
      $doc->penomoran_otomatis = Config::get_penomoran_otomatis($request->penomoran_otomatis);
      if(Config::get_config('auto-numb')=='off'){
        $doc->doc_no = $request->doc_no;
      }
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

      //pemilik Kontrak
      if(count($request->divisi)>0){
        $doc_meta2 = new DocMeta();
        $doc_meta2->documents_id = $doc->id;
        $doc_meta2->meta_type = 'pemilik_kontrak';
        $doc_meta2->meta_name = $request->divisi;
        $doc_meta2->meta_title =$request->unit_bisnis;
        $doc_meta2->save();
      }

      // pasal khusus
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

      // lampiran tanda tangan
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
      if(isset($request->lt_judul_rks)){
        $doc_meta = new DocMeta();
        $doc_meta->documents_id = $doc->id;
        $doc_meta->meta_type = "latar_belakang_rks";
        $doc_meta->meta_name = "Latar Belakang rks";
        $doc_meta->meta_desc = $request->lt_tanggal_rks;

        if(isset($request->lt_file_rks)){
          $fileName   = Helpers::set_filename('doc_',strtolower($request->lt_judul_rks));
          $file = $request->lt_file_rks;
          $file->storeAs('document/'.$type.'_latar_belakang_rks', $fileName);
          $doc_meta->meta_file = $fileName;
        }

        $doc_meta->save();
      }

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

      // latar belakang
      /*
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
      */

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

    public function store_ajax(Request $request)
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
        $rules['komentar']         = 'required|max:250|min:2';
        $rules['divisi']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['unit_bisnis']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
        $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
        $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_pihak2_nama']  =  'required|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

        if(\Laratrust::hasRole('admin')){
          $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        }
        if(Config::get_config('auto-numb')=='off'){
          $rules['doc_no']  =  'required|min:5|max:500|unique:documents,doc_no';
        }
        $rules['doc_lampiran_nama.*']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
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

        $rules['lt_judul_ketetapan_pemenang']     = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_ketetapan_pemenang']   = 'required|date_format:"Y-m-d"';
        $rules['lt_file_ketetapan_pemenang']      = 'required|mimes:pdf';

        $rules['lt_judul_kesanggupan_mitra']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_kesanggupan_mitra']  = 'required|date_format:"Y-m-d"';
        $rules['lt_file_kesanggupan_mitra']     = 'required|mimes:pdf';

        $rules['lt_judul_rks']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_rks']  = 'required|date_format:"Y-m-d"';
        $rules['lt_file_rks']     = 'required|mimes:pdf';

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
        $validator->after(function ($validator) use ($request) {
          if($request->doc_enddate < $request->doc_startdate){
            $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
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
      }else{
        $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        if(\Laratrust::hasRole('admin')){
          $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        }
        $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
        if ($validator->fails ()){
          //return redirect()->back()->withInput($request->input())->withErrors($validator);

          return Response::json (array(
            'errors' => $validator->getMessageBag()->toArray()
          ));
        }
      }

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
      $doc->penomoran_otomatis = Config::get_penomoran_otomatis($request->penomoran_otomatis);
      if(Config::get_config('auto-numb')=='off'){
        $doc->doc_no = $request->doc_no;
      }
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

      //pemilik Kontrak
      if(count($request->divisi)>0){
        $doc_meta2 = new DocMeta();
        $doc_meta2->documents_id = $doc->id;
        $doc_meta2->meta_type = 'pemilik_kontrak';
        $doc_meta2->meta_name = $request->divisi;
        $doc_meta2->meta_title =$request->unit_bisnis;
        $doc_meta2->save();
      }

      // pasal khusus
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

      // lampiran tanda tangan
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
      if(isset($request->lt_judul_rks)){
        $doc_meta = new DocMeta();
        $doc_meta->documents_id = $doc->id;
        $doc_meta->meta_type = "latar_belakang_rks";
        $doc_meta->meta_name = "Latar Belakang rks";
        $doc_meta->meta_desc = $request->lt_tanggal_rks;

        if(isset($request->lt_file_rks)){
          $fileName   = Helpers::set_filename('doc_',strtolower($request->lt_judul_rks));
          $file = $request->lt_file_rks;
          $file->storeAs('document/'.$type.'_latar_belakang_rks', $fileName);
          $doc_meta->meta_file = $fileName;
        }

        $doc_meta->save();
      }

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
      /*

      $request->session()->flash('alert-success', 'Data berhasil disimpan');
      if($request->statusButton == '0'){
        return redirect()->route('doc',['status'=>'tracking']);
      }else{
        return redirect()->route('doc',['status'=>'draft']);
      }
      */

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
