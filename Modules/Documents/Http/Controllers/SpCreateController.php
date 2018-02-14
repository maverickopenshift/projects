<?php
namespace Modules\Documents\Http\Controllers;

use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\Documents;
use Modules\Documents\Entities\DocBoq;
use Modules\Documents\Entities\DocMeta;
use Modules\Documents\Entities\DocPic;
use Modules\Documents\Entities\DocPo;
use Modules\Documents\Entities\DocTemplate;
use Modules\Documents\Entities\DocAsuransi;
use Modules\Documents\Entities\DocActivity;
use Modules\Config\Entities\Config;
use Modules\Documents\Entities\DocComment as Comments;
use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class SpCreateController
{
    public function __construct()
    {
        //oke
    }
    public function store($request)
    {

      $type = $request->type;
      $doc_nilai_material = $request->doc_nilai_material;
      $doc_nilai_jasa = $request->doc_nilai_jasa;
      $request->merge(['doc_nilai_material' => Helpers::input_rupiah($request->doc_nilai_material)]);
      $request->merge(['doc_nilai_jasa' => Helpers::input_rupiah($request->doc_nilai_jasa)]);

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
        $rules['parent_kontrak']   =  'required|kontrak_exists';
        $rules['doc_title']        =  'required|min:2';
        $rules['doc_desc']         =  'sometimes|nullable|min:10|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
        $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
        $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak2_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_lampiran_teknis']     =  'sometimes|nullable|mimes:pdf';
        $rules['doc_mtu']          =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';

        if(\Laratrust::hasRole('admin')){
          $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';

        }
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

        $rules['doc_nilai_material']   =  'required|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['doc_nilai_jasa']       =  'required|max:500|min:1|regex:/^[0-9 .]+$/i';

        $rules['hs_kode_item.*']   =  'sometimes|nullable|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_item.*']        =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_satuan.*']      =  'sometimes|nullable|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_mtu.*']         =  'sometimes|nullable|max:5|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_harga.*']       =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_harga_jasa.*']  =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_qty.*']         =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_keterangan.*']  =  'sometimes|nullable|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i';

        $rule_doc_jaminan = (count($request['doc_jaminan'])>1)?'required':'sometimes|nullable';
        $rule_doc_asuransi = (count($request['doc_asuransi'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_nilai = (count($request['doc_jaminan_nilai'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_startdate = (count($request['doc_jaminan_startdate'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_enddate = (count($request['doc_jaminan_enddate'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_desc = (count($request['doc_jaminan_desc'])>1)?'required':'sometimes|nullable';
        $rules['doc_jaminan.*']           = $rule_doc_jaminan.'|in:PL,PM';
        $rules['doc_asuransi.*']          = $rule_doc_asuransi.'|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_jaminan_nilai.*']     = $rule_doc_jaminan_nilai.'|max:500|min:3|regex:/^[0-9 .]+$/i';
        $rules['doc_jaminan_startdate.*'] = $rule_doc_jaminan_startdate.'|date_format:"Y-m-d"'; //|date_format:"Y-m-d"
        $rules['doc_jaminan_enddate.*']   = $rule_doc_jaminan_enddate.'|date_format:"Y-m-d"'; //
        $rules['doc_jaminan_desc.*']      = $rule_doc_jaminan_desc.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_jaminan_file.*']      = 'sometimes|nullable|mimes:pdf';
        $rules['doc_po']                  = 'sometimes|nullable|po_exists|regex:/^[a-z0-9 .\-]+$/i';

        $rules['lt_judul_ketetapan_pemenang']     = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_ketetapan_pemenang']   = 'required|date_format:"Y-m-d"';
        $rules['lt_file_ketetapan_pemenang']      = 'required|mimes:pdf';

        $rules['lt_judul_kesanggupan_mitra']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_kesanggupan_mitra']  = 'required|date_format:"Y-m-d"';
        $rules['lt_file_kesanggupan_mitra']     = 'required|mimes:pdf';

        $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
        $validator->after(function ($validator) use ($request) {
          if (!isset($request['pic_nama'][0])) {
              $validator->errors()->add('pic_nama_err', 'Unit Penanggung jawab harus dipilih!');
          }

          if($request->doc_enddate < $request->doc_startdate){
            $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
          }
        });

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
      $doc->doc_date = $request->doc_startdate;
      $doc->doc_startdate = $request->doc_startdate;
      $doc->doc_enddate = $request->doc_enddate;
      $doc->doc_pihak1 = $request->doc_pihak1;
      $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
      $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
      $doc->user_id = (\Laratrust::hasRole('admin'))?$request->user_id:Auth::id();


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

      $doc->doc_proc_process = $request->doc_proc_process;
      $doc->doc_mtu = $request->doc_mtu;
      $doc->doc_value = Helpers::input_rupiah($request->doc_value);
      $doc->doc_sow = $request->doc_sow;
      $doc->doc_type = $request->type;
      $doc->doc_parent = 0;
      $doc->doc_signing = $request->statusButton;
      $doc->doc_parent_id = Documents::get_id_parent_sp($request->parent_kontrak);
      $doc->supplier_id = Documents::where('id',$doc->doc_parent_id)->first()->supplier_id;
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


      if(isset($request->doc_po)){
        $doc_po = new DocPo();
        $doc_po->documents_id = $doc->id;
        $doc_po->po_no = $request->po_no;
        $doc_po->po_date = $request->po_date;
        $doc_po->po_vendor = $request->po_vendor;
        $doc_po->po_pembuat = $request->po_pembuat;
        $doc_po->po_nik = $request->po_nik;
        $doc_po->po_approval = $request->po_approval;
        $doc_po->po_penandatangan = $request->po_penandatangan;
        $doc_po->save();
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

      if(count($request->doc_asuransi)>0){
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
            // dd($asr);
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

      if(count($request->pic_nama)>0){
        foreach($request['pic_nama'] as $key => $val){
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

      if(count($request->hs_harga)>0){
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
