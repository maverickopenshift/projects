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
use Modules\Documents\Entities\DocAsuransi;
use Modules\Config\Entities\Config;
use Modules\Documents\Entities\DocComment as Comments;

use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class SpEditController extends Controller
{
    public function __construct()
    {
        //oke
    }
    public function store_ajax($request)
    {
      // dd("haoi");
      $type = $request->type;
      $id = $request->id;
      $status = Documents::where('id',$id)->first()->doc_signing;

      $doc_nilai_material = $request->doc_nilai_material;
      $doc_nilai_jasa = $request->doc_nilai_jasa;
      $request->merge(['doc_nilai_material' => Helpers::input_rupiah($request->doc_nilai_material)]);
      $request->merge(['doc_nilai_jasa' => Helpers::input_rupiah($request->doc_nilai_jasa)]);

      $user_type = Helpers::usertype();
      $auto_numb =Config::get_config('auto-numb');
      $statusButton = $request->statusButton;
      $required = 'required';
      $date_format = 'date_format:"d-m-Y"';
      if($statusButton=='2'){
        $required = 'sometimes|nullable';
      }

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
      if(in_array($status,['2'])){
        $rules['parent_kontrak']   =  'required|kontrak_exists';
        if($user_type!='subsidiary'){
          $rules['divisi']      =  'required|min:1|exists:__mtz_pegawai,divisi';
          $rules['unit_bisnis'] =  'required|min:1|exists:__mtz_pegawai,unit_bisnis';
          $rules['unit_kerja']  =  'required|min:1|exists:__mtz_pegawai,unit_kerja';
        }
        $rules['doc_title']        =  'required|min:2';
        $rules['doc_desc']         =  'sometimes|nullable|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_startdate']    =  $required.'|'.$date_format;
        $rules['doc_enddate']      =  $required.'|'.$date_format.'|after:doc_startdate';
        $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak2_nama']  =  $required.'|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_lampiran_teknis']     =  'sometimes|nullable|mimes:pdf';
        $rules['doc_mtu']          =  $required.'|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';
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

        $rules['doc_nilai_material']   =  $required.'|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['doc_nilai_jasa']       =  $required.'|max:500|min:1|regex:/^[0-9 .]+$/i';
      }

      $rules['hs_kode_item.*']   =  'sometimes|nullable|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_item.*']        =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_satuan.*']      =  'sometimes|nullable|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_mtu.*']         =  'sometimes|nullable|max:5|min:1|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_harga.*']       =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
      $rules['hs_harga_jasa.*']  =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
      $rules['hs_qty.*']         =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
      $rules['hs_keterangan.*']  =  'sometimes|nullable|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i';

      $rule_doc_jaminan = (count($request['doc_jaminan'])>1)?$required:'sometimes|nullable';
      $rule_doc_asuransi = (count($request['doc_asuransi'])>1)?$required:'sometimes|nullable';
      $rule_doc_jaminan_nilai = (count($request['doc_jaminan_nilai'])>1)?$required:'sometimes|nullable';
      $rule_doc_jaminan_startdate = (count($request['doc_jaminan_startdate'])>1)?$required:'sometimes|nullable';
      $rule_doc_jaminan_enddate = (count($request['doc_jaminan_enddate'])>1)?$required:'sometimes|nullable';
      $rule_doc_jaminan_desc = (count($request['doc_jaminan_desc'])>1)?$required:'sometimes|nullable';
      $rules['doc_jaminan.*']           = $rule_doc_jaminan.'|in:PL,PM';
      $rules['doc_asuransi.*']          = $rule_doc_asuransi.'|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_jaminan_nilai.*']     = $rule_doc_jaminan_nilai.'|max:500|min:3|regex:/^[0-9 .]+$/i';
      $rules['doc_jaminan_startdate.*'] = $rule_doc_jaminan_startdate.'|'.$date_format; //|date_format:"Y-m-d"
      $rules['doc_jaminan_enddate.*']   = $rule_doc_jaminan_enddate.'|'.$date_format.'|after:doc_jaminan_startdate.*'; //
      $rules['doc_jaminan_desc.*']      = $rule_doc_jaminan_desc.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

      $rules['doc_po']                  = 'sometimes|nullable|po_exists|regex:/^[a-z0-9 .\-]+$/i';

      foreach($request->doc_jaminan_file_old as $k => $v){
        if(isset($request->doc_jaminan_file[$k]) && is_object($request->doc_jaminan_file[$k]) && !empty($v)){//jika ada file baru
          $new_jfile[] = '';
          $new_jfile_up[] = $request->doc_jaminan_file[$k];
          $rules['doc_jaminan_file.'.$k] = 'sometimes|nullable|mimes:pdf';
        }
        else if(empty($v)){
          $rules['doc_jaminan_file.'.$k] = 'sometimes|nullable|mimes:pdf';
          if(!isset($request->doc_jaminan_file[$k])){
            $new_jfile[] = $v;
            $new_jfile_up[] = $v;
          }
          else{
            $new_jfile[] = '';
            $new_jfile_up[] = $request->doc_jaminan_file[$k];
          }
        }
        else{
          $new_jfile[] = $v;
          $new_jfile_up[] = $v;
        }
      }
      $request->merge(['doc_jaminan_file' => $new_jfile]);

      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

      $validator->after(function ($validator) use ($request, $status, $type,$auto_numb,$user_type,$statusButton) {
        if (!isset($request['pic_nama'][0]) && in_array($status,['2']) && $statusButton!='2') {
            $validator->errors()->add('pic_nama_err', 'Unit Penanggung jawab harus dipilih!');
        }

        // if($request->doc_enddate < $request->doc_startdate){
        //   $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
        // }
        //
        // if(in_array($type,['turnkey','sp'])){
        //   foreach($request->doc_jaminan_enddate as $k => $v){
        //     if($request->doc_jaminan_enddate[$k] < $request->doc_jaminan_startdate[$k]){
        //       $validator->errors()->add('doc_jaminan_enddate.'.$k, 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
        //     }
        //   }
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
            $validator->errors()->has('doc_lampiran_teknis') || 
            $validator->errors()->has('hs_kode_item.*') || 
            $validator->errors()->has('hs_item.*') || 
            $validator->errors()->has('hs_qty.*') || 
            $validator->errors()->has('hs_satuan.*') || 
            $validator->errors()->has('hs_mtu.*') || 
            $validator->errors()->has('hs_harga.*') || 
            $validator->errors()->has('hs_harga_jasa.*') || 
            $validator->errors()->has('hs_keterangan.*')
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
          if(
            $validator->errors()->has('doc_jaminan.*') || 
            $validator->errors()->has('doc_asuransi.*') ||
            $validator->errors()->has('doc_jaminan_nilai.*') ||
            $validator->errors()->has('doc_jaminan_startdate.*') ||
            $validator->errors()->has('doc_jaminan_enddate.*') ||
            $validator->errors()->has('doc_jaminan_desc.*') ||
            $validator->errors()->has('doc_jaminan_file.*')
          ){
            array_push($tabs_error,'tab_jaminan_asuransi');
          }
          if(count($tabs_error)>0){
            foreach ($tabs_error as $key=>$val){
              $validator->errors()->add('tabs_error.'.$key, $val);
            }
          }
      });
      if(isset($hs_harga) && count($hs_harga)>0){
        $request->merge(['hs_harga'=>$hs_harga]);
      }
      if(isset($hs_qty) && count($hs_qty)>0){
        $request->merge(['hs_qty'=>$hs_qty]);
      }

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
          $doc->doc_desc = $request->doc_desc;
          $doc->doc_template_id = DocTemplate::get_by_type($type)->id;
          $doc->doc_date = Helpers::date_set_db($request->doc_startdate);
          $start_date = $request->doc_startdate;
          $doc->doc_startdate = Helpers::date_set_db($start_date);
          $doc->doc_enddate = Helpers::date_set_db($request->doc_enddate);
          $doc->doc_pihak1 = $request->doc_pihak1;
          $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
          $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
          $doc->doc_signing = ($statusButton=='2')?'2':'0';
          $doc->penomoran_otomatis = Config::get_penomoran_otomatis($request->penomoran_otomatis);
          if($user_type=='subsidiary'){
            $doc->doc_no = $request->doc_no;
          }

          if($user_type!='subsidiary' && $auto_numb=='off'){
            $doc->doc_no = Documents::create_manual_no_kontrak($request->doc_no,$request->doc_pihak1_nama,$request->doc_template_id,$start_date,$request->type);
          }

          if($user_type=='subsidiary'){
            $doc->doc_user_type = 'subsidiary';
            $doc->penomoran_otomatis = 'no';
          }
          if((\Laratrust::hasRole('admin'))){
            $doc->user_id  = $request->user_id;
          }
          if(isset($request->doc_lampiran_teknis)){
            $fileName   = Helpers::set_filename('doc_lampiran_teknis_',strtolower($request->doc_title));
            $request->doc_lampiran_teknis->storeAs('document/'.$request->type, $fileName);
            $doc->doc_lampiran_teknis = $fileName;
          }

          $nilai_jasa               = Helpers::input_rupiah($request->doc_nilai_jasa);
          $nilai_material           = Helpers::input_rupiah($request->doc_nilai_material);
          $nilai_ppn                = $request->ppn;
          $nilai_total              = $nilai_jasa+$nilai_material;

          $doc->doc_nilai_material  = $nilai_material;
          $doc->doc_nilai_jasa      = $nilai_jasa;
          $doc->doc_nilai_ppn       = $nilai_ppn;
          $doc->doc_nilai_total     = $nilai_total;
          $doc->doc_nilai_total_ppn = (($nilai_ppn/100)*$nilai_total)+$nilai_total;

          $doc->doc_po_no = $request->doc_po;
          
          $doc->divisi = $request->divisi;
          $doc->unit_bisnis = $request->unit_bisnis;
          $doc->unit_kerja = $request->unit_kerja;
          
          $doc->doc_proc_process = $request->doc_proc_process;
          $doc->doc_mtu = $request->doc_mtu;
          $doc->doc_value = Helpers::input_rupiah($request->doc_value);
          $doc->doc_type = $request->type;
          $doc->doc_parent = 0;
          $doc->doc_parent_id = $request->parent_kontrak_id;
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
        $doc->doc_signing = ($statusButton=='2')?'2':'0';
      }
      
      $doc->doc_data = Helpers::json_input($doc->doc_data,['edited_by'=>\Auth::id()]);
      $doc->doc_sow = $request->doc_sow;
      $doc->save();
      
      if(count($request->doc_po_no)>0){
        $doc_po = DocPo::where('id',$id)->first();
        // $doc_po->documents_id = $doc->id;
        $doc_po->po_no = $request->po_no;
        $doc_po->po_date = $request->po_date;
        $doc_po->po_vendor = $request->po_vendor;
        $doc_po->po_pembuat = $request->po_pembuat;
        $doc_po->po_nik = $request->po_nik;
        $doc_po->po_approval = $request->po_approval;
        $doc_po->po_penandatangan = $request->po_penandatangan;
        $doc_po->save();
      }

      /*
      if(count($request->doc_asuransi)>0){
        DocAsuransi::where([
          ['documents_id','=',$doc->id]
          ])->delete();
        foreach($request['doc_asuransi'] as $key => $val){
          if(!empty($val)
          ){
            $asr = new DocAsuransi();
            $asr->documents_id = $doc->id;
            $asr->doc_jaminan = $request['doc_jaminan'][$key];
            $asr->doc_jaminan_name = $request['doc_asuransi'][$key];
            $asr->doc_jaminan_nilai = Helpers::input_rupiah($request['doc_jaminan_nilai'][$key]);
            $asr->doc_jaminan_startdate = $request['doc_jaminan_startdate'][$key];
            $asr->doc_jaminan_enddate = $request['doc_jaminan_enddate'][$key];
            $asr->doc_jaminan_desc = $request['doc_jaminan_desc'][$key];

            if(isset($request['doc_jaminan_file'][$key])){
              $fileName   = Helpers::set_filename('doc_',strtolower($val));
              $file = $request['doc_jaminan_file'][$key];
              $file->storeAs('document/'.$request->type.'_asuransi', $fileName);
              $asr->doc_jaminan_file = $fileName;
            }
            $asr->save();
          }
        }
      }
      */

      if(count($request['doc_jaminan'])>0){
        DocAsuransi::where([
          ['documents_id','=',$doc->id]
          ])->delete();
        foreach($request['doc_jaminan'] as $key => $val){
          if(!empty($request['doc_jaminan'][$key])
              && !empty($request['doc_asuransi'][$key])
              && !empty($request['doc_jaminan_nilai'][$key])
              && !empty($request['doc_jaminan_startdate'][$key])
              && !empty($request['doc_jaminan_enddate'][$key])
          ){
            $asr = new DocAsuransi();
            $asr->documents_id = $doc->id;
            $asr->doc_jaminan = $request['doc_jaminan'][$key];
            $asr->doc_jaminan_name = $request['doc_asuransi'][$key];
            $asr->doc_jaminan_nilai = Helpers::input_rupiah($request['doc_jaminan_nilai'][$key]);
            $asr->doc_jaminan_startdate = date("Y-m-d", strtotime($request['doc_jaminan_startdate'][$key]));
            $asr->doc_jaminan_enddate = date("Y-m-d", strtotime($request['doc_jaminan_enddate'][$key]));
            $asr->doc_jaminan_desc = $request['doc_jaminan_desc'][$key];

            if(is_object($new_jfile_up[$key])){
              $fileName   = Helpers::set_filename('doc_',strtolower($val));
              $file = $new_jfile_up[$key];
              $file->storeAs('document/'.$request->type.'_asuransi', $fileName);
              $asr->doc_jaminan_file = $fileName;
            }
            else{
              $asr->doc_jaminan_file = $new_jfile_up[$key];
            }
            $asr->save();
          }
        }
      }

      if(count($request->pic_nama)>0){
          DocPic::where([
            ['documents_id','=',$doc->id]
            ])->delete();
        foreach($request['pic_nama'] as $key => $val){
          if(!empty($val)
          ){
            $pic = new DocPic();
            $pic->documents_id = $doc->id;
            $pic->pegawai_id = $request['pic_id'][$key];
            $pic->nama = $val;
            $pic->email = $request['pic_email'][$key];
            $pic->jabatan = $request['pic_jabatan'][$key];
            $pic->telp = $request['pic_telp'][$key];
            $pic->posisi = $request['pic_posisi'][$key];
            $pic->save();
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

      if(count($request->hs_harga)>0){
        DocBoq::where([
          ['documents_id','=',$doc->id]
          ])->delete();
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
            //$q_harga = Helpers::input_rupiah($val);
            $doc_boq->harga = Helpers::input_rupiah($request['hs_harga'][$key]);
            $doc_boq->harga_jasa = Helpers::input_rupiah($request['hs_harga_jasa'][$key]);
            $hs_type = 'harga_satuan';
            if(in_array($type,['turnkey','sp'])){
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
