<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Response;

use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\Documents;
use Modules\Documents\Entities\DocBoq;
use Modules\Documents\Entities\DocMeta;
use Modules\Documents\Entities\DocMetaSideLetter;
use Modules\Documents\Entities\DocPic;
use Modules\Documents\Entities\DocTemplate;
use Modules\Documents\Entities\DocTop;
use Modules\Config\Entities\Config;
use Modules\Documents\Entities\DocComment as Comments;
use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class AmandemenKontrakTurnkeyEditController extends Controller
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

    $m_hs_harga=[];
    $m_hs_harga_jasa=[];
    $m_hs_qty=[];

    if(!Documents::check_permission_doc($id ,$type)){
      abort(404);
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

    if(isset($request['hs_harga_jasa']) && count($request['hs_harga_jasa'])>0){
      foreach($request['hs_harga_jasa'] as $key => $val){
        $hs_harga_jasa[] = $val;
        $m_hs_harga_jasa[$key] = Helpers::input_rupiah($val);
      }
    }

    if(count($m_hs_harga_jasa)>0){
      $request->merge(['hs_harga_jasa'=>$m_hs_harga_jasa]);
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
      $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak2_nama']  =  $required.'|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
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
        }else if(empty($v)){
          $rules['doc_lampiran.'.$k] = $required.'|mimes:pdf';
          if(!isset($request->doc_lampiran[$k])){
            $new_lamp[] = $v;
            $new_lamp_up[] = $v;
          }else{
            $new_lamp[] = '';
            $new_lamp_up[] = $request->doc_lampiran[$k];
          }
        }else{
          $new_lamp[] = $v;
          $new_lamp_up[] = $v;
        }
      }
      $request->merge(['doc_lampiran' => $new_lamp]);
    }
    else{
      $rules['komentar']         = $required.'|max:250|min:2';
    }
    $rules['doc_pr']         =  'sometimes|nullable|pr_exists';

    $rule_scope_pasal = (count($request['f_scope_pasal'])>1)?$required:'sometimes|nullable';
    $rule_scope_judul = (count($request['f_scope_judul'])>1)?$required:'sometimes|nullable';
    $rule_scope_isi = (count($request['scope_isi'])>1)?$required:'sometimes|nullable';
    $rules['f_scope_pasal.*']  =  $rule_scope_pasal.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['f_scope_judul.*']  =  $rule_scope_judul.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['f_scope_isi.*']  =  $rule_scope_isi.'|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

    if(in_array($type,['turnkey'])){
      $rules['top_deskripsi.*']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-]+$/i';
      $rules['top_tanggal_mulai.*']     =  'sometimes|nullable|'.$date_format;
      $rules['top_tanggal_selesai.*']   =  'sometimes|nullable|'.$date_format.'|after:top_tanggal_mulai.*';
      $rules['top_harga.*']             =  'sometimes|nullable|regex:/^[a-z0-9 .\-]+$/i';
      $rules['top_tanggal_bapp.*']      =  'sometimes|nullable|'.$date_format;
    }

    foreach($request->f_scope_file_old as $k => $v){
      if(isset($request->f_scope_file[$k]) && is_object($request->f_scope_file[$k]) && !empty($v)){//jika ada file baru
        $new_scope_file[] = '';
        $new_scope_file_up[] = $request->f_scope_file[$k];
        $rules['f_scope_file.'.$k]  =  'sometimes|nullable|mimes:pdf';
      }
      else if(empty($v)){
        $rules['f_scope_file.'.$k]  =  'sometimes|nullable|mimes:pdf';
        if(!isset($request->f_scope_file[$k])){
          $new_scope_file[] = $v;
          $new_scope_file_up[] = $v;
        }
        else{
          $new_scope_file[] = '';
          $new_scope_file_up[] = $request->f_scope_file[$k];
        }
      }
      //$request->merge(['f_scope_file' => $new_scope_file]);
    }

    $request->merge(['f_scope_file' => $new_scope_file]);


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
          $validator->errors()->has('doc_sow') || 
          $validator->errors()->has('hs_kode_item.*') ||
          $validator->errors()->has('hs_item.*') ||
          $validator->errors()->has('hs_satuan.*') ||
          $validator->errors()->has('hs_mtu.*') ||
          $validator->errors()->has('hs_harga.*') ||
          $validator->errors()->has('hs_harga_jasa.*') ||
          $validator->errors()->has('hs_keterangan.*')
        ){
          array_push($tabs_error,'tab_harga_satuan');
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
          $validator->errors()->has('f_scope_pasal.*') || 
          $validator->errors()->has('f_scope_judul.*') || 
          $validator->errors()->has('f_scope_isi.*') || 
          $validator->errors()->has('f_scope_awal.*') ||
          $validator->errors()->has('f_scope_akhir.*') ||
          $validator->errors()->has('f_scope_file.*')
        ){
          array_push($tabs_error,'tab_scope_perubahan');
        }
        if(
          $validator->errors()->has('top_deskripsi.*') || 
          $validator->errors()->has('top_tanggal_mulai.*') ||
          $validator->errors()->has('top_tanggal_selesai.*') ||
          $validator->errors()->has('top_harga.*') ||
          $validator->errors()->has('top_tanggal_bapp.*')
        ){
          array_push($tabs_error,'tab_term_of_payment');
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
          $doc->divisi = $request->divisi;
          $doc->unit_bisnis = $request->unit_bisnis;
          $doc->unit_kerja = $request->unit_kerja;
          if((\Laratrust::hasRole('admin'))){
            $doc->user_id  = $request->user_id;
          }
          $doc->doc_signing = ($statusButton=='2')?'2':'0';
          $doc->doc_parent_id = $request->parent_kontrak;
          $doc->supplier_id = Documents::where('id',$doc->doc_parent_id)->first()->supplier_id;

          $doc->penomoran_otomatis =  Config::get_penomoran_otomatis($request->penomoran_otomatis);
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
    $doc->doc_sow = $request->doc_sow;
    $doc->save();

    //turn of payment
    if(count($request->top_deskripsi)>0){
      DocTop::where([
      ['documents_id','=',$doc->id],
      ])->delete();
      foreach($request['top_deskripsi'] as $key => $val){
        if(!empty($val)
        ){
          $top = new DocTop();
          $top->documents_id = $doc->id;
          $top->top_deskripsi = $request['top_deskripsi'][$key];
          $top->top_tanggal_mulai = Helpers::date_set_db($request['top_tanggal_mulai'][$key]);
          $top->top_tanggal_selesai = Helpers::date_set_db($request['top_tanggal_selesai'][$key]);
          $top->top_harga = Helpers::input_rupiah($request['top_harga'][$key]);
          $top->top_tanggal_bapp = Helpers::date_set_db($request['top_tanggal_bapp'][$key]);
          $top->save();
        }
      }
    }

    if(count($request->doc_pr)>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','eproposal_pr'],
        ])->delete();
      $doc_meta2 = new DocMeta();
      $doc_meta2->documents_id = $doc->id;
      $doc_meta2->meta_type = 'eproposal_pr';
      $doc_meta2->meta_name = $request->doc_pr;
      $doc_meta2->save();
    }

    // latar belakang wajib
    if(isset($request->lt_judul_ketetapan_pemenang)){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','latar_belakang_ketetapan_pemenang']
        ])->delete();
      $doc_meta = new DocMeta();
      $doc_meta->documents_id = $doc->id;
      $doc_meta->meta_type = "latar_belakang_ketetapan_pemenang";
      $doc_meta->meta_name = "Latar Belakang Ketetapan Pemenang";
      $doc_meta->meta_desc = Helpers::date_set_db($request->lt_tanggal_ketetapan_pemenang);

      if(is_object($request->lt_file_ketetapan_pemenang)){
        $fileName   = Helpers::set_filename('doc_',strtolower($request->lt_judul_ketetapan_pemenang));
        $file       = $request->lt_file_ketetapan_pemenang;
        $file->storeAs('document/'.$type.'_latar_belakang_ketetapan_pemenang', $fileName);
        $doc_meta->meta_file = $fileName;
      }else{
        $doc_meta->meta_file = $request->lt_file_ketetapan_pemenang_old;
      }

      $doc_meta->save();
    }

    if(isset($request->lt_judul_kesanggupan_mitra)){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','latar_belakang_kesanggupan_mitra']
        ])->delete();
      $doc_meta = new DocMeta();
      $doc_meta->documents_id = $doc->id;
      $doc_meta->meta_type = "latar_belakang_kesanggupan_mitra";
      $doc_meta->meta_name = "Latar Belakang Kesanggupan Mitra";
      $doc_meta->meta_desc = Helpers::date_set_db($request->lt_tanggal_kesanggupan_mitra);

      if(is_object($request->lt_file_kesanggupan_mitra)){
        $fileName   = Helpers::set_filename('doc_',strtolower($request->lt_judul_kesanggupan_mitra));
        $file       = $request->lt_file_kesanggupan_mitra;
        $file->storeAs('document/'.$type.'_latar_belakang_kesanggupan_mitra', $fileName);
        $doc_meta->meta_file = $fileName;
      }else{
        $doc_meta->meta_file = $request->lt_file_kesanggupan_mitra_old;
      }

      $doc_meta->save();
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
          $doc_meta->meta_title = Helpers::date_set_db($request['f_latar_belakang_tanggal'][$key]);
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

    //sow boq
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
          $doc_boq->harga = Helpers::input_rupiah($request['hs_harga'][$key]);
          $doc_boq->harga_jasa = Helpers::input_rupiah($request['hs_harga_jasa'][$key]);
          $hs_type = 'harga_satuan';
          if(in_array($type,['turnkey','amandemen_kontrak_turnkey','sp'])){
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

    if(count($request->f_scope_pasal)>0){
      DocMetaSideLetter::where('documents_id','=',$doc->id)->delete();
      foreach($request->f_scope_pasal as $key => $val){
        if(!empty($val)
            && !empty($request['f_scope_judul'][$key])
            && !empty($request['f_scope_isi'][$key])
        ){
          $doc_meta = new DocMetaSideLetter();
          $doc_meta->documents_id = $doc->id;
          $doc_meta->meta_pasal  = $request['f_scope_pasal'][$key];
          $doc_meta->meta_judul  = $request['f_scope_judul'][$key];
          $doc_meta->meta_isi    = $request['f_scope_isi'][$key];
          $doc_meta->meta_awal = $request['f_scope_awal'][$key];
          $doc_meta->meta_akhir = $request['f_scope_akhir'][$key];

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
