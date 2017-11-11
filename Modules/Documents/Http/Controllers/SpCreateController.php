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
      //dd($request->input());
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
      $rules['parent_kontrak']   =  'required|kontrak_exists';
      $rules['doc_desc']         =  'sometimes|nullable|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_startdate']    =  'required|date_format:"Y-m-d"';
      $rules['doc_enddate']      =  'required|date_format:"Y-m-d"';
      $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_pihak2_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_lampiran.*']     =  'required|mimes:pdf';
      $rules['doc_lampiran_teknis']     =  'required|mimes:pdf';
      $rules['doc_mtu']          =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';

      $rules['doc_nilai_material']   =  'required|max:500|min:1|regex:/^[0-9 .]+$/i';
      $rules['doc_nilai_jasa']       =  'required|max:500|min:1|regex:/^[0-9 .]+$/i';

      $rules['hs_kode_item.*']   =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_item.*']        =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_satuan.*']      =  'sometimes|nullable|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_mtu.*']         =  'sometimes|nullable|max:5|min:1|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_harga.*']       =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
      $rules['hs_qty.*']         =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
      $rules['hs_keterangan.*']  =  'sometimes|nullable|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i';


      $doc_jaminan_nilai = $request->doc_jaminan_nilai;
      $request->merge(['doc_jaminan_nilai' => Helpers::input_rupiah($request->doc_jaminan_nilai)]);
      $rules['doc_jaminan']           = 'required|in:PL,PM';
      $rules['doc_asuransi']          = 'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_jaminan_nilai']     = 'required|max:500|min:3|regex:/^[0-9 .]+$/i';
      $rules['doc_jaminan_startdate'] = 'required|date_format:"Y-m-d"';
      $rules['doc_jaminan_enddate']   = 'required|date_format:"Y-m-d"';
      $rules['doc_jaminan_desc']      = 'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_po']                = 'required|po_exists|regex:/^[a-z0-9 .\-]+$/i';



      $rule_lt_name = (count($request['lt_name'])>1)?'required':'sometimes|nullable';
      $rule_lt_desc = (count($request['lt_desc'])>1)?'required':'sometimes|nullable';
      $rules['lt_file.*']  =  'sometimes|nullable|mimes:pdf';
      $rules['lt_desc.*']  =  $rule_lt_desc.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['lt_name.*']  =  $rule_lt_name.'|max:500|regex:/^[a-z0-9 .\-]+$/i';

      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
      $validator->after(function ($validator) use ($request) {
          if (!isset($request['pic_data'][0])) {
              $validator->errors()->add('pic_data', 'Unit Penanggung jawab harus dipilih!');
          }
      });
      if(isset($doc_jaminan_nilai)){
        $request->merge(['doc_jaminan_nilai' => $doc_jaminan_nilai]);
      }

      if(isset($hs_harga) && count($hs_harga)>0){
        $request->merge(['hs_harga'=>$hs_harga]);
      }
      if(isset($hs_qty) && count($hs_qty)>0){
        $request->merge(['hs_qty'=>$hs_qty]);
      }
      //dd($validator->errors());
      if ($validator->fails ()){
        return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
      }
      //dd('berhasil');
      $doc = new Documents();
      $doc->doc_title = $request->doc_title;
      $doc->doc_desc = $request->doc_desc;
      $doc->doc_template_id = DocTemplate::get_by_type($type)->id;
      $doc->doc_startdate = $request->doc_startdate;
      $doc->doc_enddate = $request->doc_enddate;
      $doc->doc_pihak1 = $request->doc_pihak1;
      $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
      $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
      $doc->user_id = Auth::id();
      $doc->supplier_id = $request->supplier_id;

      // if(isset($request->doc_lampiran)){
      //   $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($request->doc_title));
      //   $request->doc_lampiran->storeAs('document/'.$request->type, $fileName);
      //   $doc->doc_lampiran = $fileName;
      // }

      if(isset($request->doc_lampiran_teknis)){
        $fileName   = Helpers::set_filename('doc_lampiran_teknis_',strtolower($request->doc_title));
        $request->doc_lampiran_teknis->storeAs('document/'.$request->type, $fileName);
        $doc->doc_lampiran_teknis = $fileName;
      }

      $nilai_jasa               = Helpers::input_rupiah($request->doc_nilai_jasa);
      $nilai_material           = Helpers::input_rupiah($request->doc_nilai_material);
      $nilai_ppn                = config('app.ppn_set');
      $nilai_total              = $nilai_jasa+$nilai_material;

      $doc->doc_nilai_material  = $nilai_material;
      $doc->doc_nilai_jasa      = $nilai_jasa;
      $doc->doc_nilai_ppn       = $nilai_ppn;
      $doc->doc_nilai_total_ppn = (($nilai_ppn/100)*$nilai_total)+$nilai_total;

      $doc->doc_po_no = $request->doc_po;
      $doc->doc_jaminan = $request->doc_jaminan;
      $doc->doc_asuransi = $request->doc_asuransi;
      $doc->doc_jaminan_startdate = $request->doc_jaminan_startdate;
      $doc->doc_jaminan_enddate = $request->doc_jaminan_enddate;
      $doc->doc_jaminan_desc = $request->doc_jaminan_desc;
      $doc->doc_jaminan_nilai = Helpers::input_rupiah($request->doc_jaminan_nilai);

      $doc->doc_proc_process = $request->doc_proc_process;
      $doc->doc_mtu = $request->doc_mtu;
      $doc->doc_value = Helpers::input_rupiah($request->doc_value);
      $doc->doc_sow = $request->doc_sow;
      $doc->doc_type = $request->type;
      $doc->doc_parent = 0;
      $doc->doc_parent_id = $request->parent_kontrak;

      $doc->save();

      if(count($request->doc_lampiran)>0){
        foreach($request->doc_lampiran as $key => $val){
          if(!empty($val)
          ){
            $doc_meta = new DocMeta();
            $doc_meta->documents_id = $doc->id;
            $doc_meta->meta_type = 'lampiran_ttd';
            if(isset($request['doc_lampiran'][$key])){
              $fileName   = Helpers::set_filename('doc_',strtolower($val));
              $file = $request['doc_lampiran'][$key];
              $file->storeAs('document/'.$request->type.'_lampiran_ttd', $fileName);
              $doc_meta->meta_file = $fileName;
            }
            $doc_meta->save();
          }
        }
      }

      foreach($request['pic_data'] as $key => $val){
        $data = json_decode(urldecode($val),true);
        $pic = new DocPic();
        $pic->documents_id = $doc->id;
        $pic->pegawai_id = $data['id'];
        $pic->posisi = $request['pic_posisi'][$key];
        $pic->save();
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
            $q_harga = Helpers::input_rupiah($val);
            $doc_boq->harga = Helpers::input_rupiah($q_harga);
            $hs_type = 'harga_satuan';
            if(in_array($type,['turnkey','sp'])){
              $q_qty = Helpers::input_rupiah($request['hs_qty'][$key]);
              $q_total = $q_qty*$q_harga;
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

      //dd($request->input());
      $request->session()->flash('alert-success', 'Data berhasil disimpan');
      return redirect()->route('doc');
    }

}
