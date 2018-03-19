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
use Modules\Documents\Entities\DocComment as Comments;
use Modules\Config\Entities\Config;
use Modules\Users\Entities\Mtzpegawai;
use Modules\Documents\Http\Controllers\SuratPengikatanEditController as SuratPengikatanEdit;
use Modules\Documents\Http\Controllers\SideLetterEditController as SideLetterEdit;
use Modules\Documents\Http\Controllers\MouEditController as MouEdit;
use Modules\Documents\Http\Controllers\AmandemenSpEditController as AmandemenSpEdit;
use Modules\Documents\Http\Controllers\SpEditController as SpEdit;
use Modules\Documents\Http\Controllers\AmandemenKontrakEditController as AmademenKontrakEdit;
use Modules\Documents\Http\Controllers\AmandemenKontrakKhsEditController as AmademenKontrakKhsEdit;
use Modules\Documents\Http\Controllers\AmandemenKontrakTurnkeyEditController as AmademenKontrakTurnkeyEdit;


use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class EditController extends Controller
{
  protected $documents;
  protected $SuratPengikatanEdit;
  protected $MouEdit;
  protected $amandemenSpEdit;
  protected $spEdit;
  protected $amademenKontrakEdit;
  protected $amademenKontrakKhsEdit;
  protected $amademenKontrakTurnkeyEdit;
  protected $SideLetterEdit;

  public function __construct(Documents $documents,SuratPengikatanEdit $SuratPengikatanEdit,MouEdit $MouEdit,AmandemenSpEdit $amandemenSpEdit,SpEdit $spEdit, AmademenKontrakEdit $amademenKontrakEdit, SideLetterEdit $SideLetterEdit, AmademenKontrakKhsEdit $amademenKontrakKhsEdit, AmademenKontrakTurnkeyEdit $amademenKontrakTurnkeyEdit)
  {
      $this->documents = $documents;
      $this->SuratPengikatanEdit = $SuratPengikatanEdit;
      $this->MouEdit = $MouEdit;
      $this->amandemenSpEdit = $amandemenSpEdit;
      $this->spEdit = $spEdit;
      $this->amademenKontrakEdit = $amademenKontrakEdit;
      $this->amademenKontrakKhsEdit = $amademenKontrakKhsEdit;
      $this->amademenKontrakTurnkeyEdit = $amademenKontrakTurnkeyEdit;
      $this->SideLetterEdit = $SideLetterEdit;
  }

  public function index(Request $request)
  {
    $id = $request->id;
    $type = $request->type;
    $doc = $this->documents->where('documents.id','=',$id);
    $dt = $doc->with('pemilik_kontrak','jenis','supplier','pic','boq','lampiran_ttd','latar_belakang','pasal','asuransi','sow_boq','scope_perubahan','users','latar_belakang_surat_pengikatan','latar_belakang_mou','scope_perubahan_side_letter','latar_belakang_optional','latar_belakang_ketetapan_pemenang','latar_belakang_kesanggupan_mitra','latar_belakang_rks')
              ->first();
    if(!$dt || !$this->documents->check_permission_doc($id,$type)){
      abort(404);
    }

    $pic = [];
    $boq = [];
    $lt  = [];
    $pasal = [];
    $lampiran = [];
    $user_type = \App\User::check_usertype(\Auth::user()->username);
    if($type=='amandemen_sp'){
      $qry = $this->documents->where('documents.id','=',$id)
                            ->join('documents as doc','doc.id','=', 'documents.doc_parent_id')
                            ->select('doc.doc_parent_id as ibu','documents.*')
                            ->first();
      $parent = ($qry->ibu!==null)?$qry->ibu:$dt->doc_parent_id;
      $dt->parent_kontrak = $parent;
      $dt->parent_kontrak_text = $this->documents->select('doc_no')->where('id','=',$parent)->first()->doc_no;
      $dt->parent_sp = $dt->doc_parent_id;
      $dt->parent_sp_text = $this->documents->select('doc_no')->where('id','=',$dt->doc_parent_id)->first()->doc_no;
    }

    if($type=='sp'){
      $qry = $this->documents->where('documents.id','=',$id)
                            ->join('documents as doc','doc.id','=', 'documents.doc_parent_id')
                            ->select('doc.doc_parent_id as ibu','documents.*')
                            ->first();
      $parent = ($qry->ibu!==null)?$qry->ibu:$dt->doc_parent_id;
      $dt->parent_kontrak_id = $dt->doc_parent_id;
      $dt->parent_kontrak = $parent;
      $dt->parent_kontrak_text = $this->documents->select('doc_no')->where('id','=',$parent)->first()->doc_no;
    }

    if(in_array($type,['amandemen_kontrak','amandemen_kontrak_khs','amandemen_kontrak_turnkey','adendum','side_letter'])){
      $dt->parent_kontrak = $dt->doc_parent_id;
      $dt->parent_kontrak_text = $this->documents->select('doc_no')->where('id','=',$dt->doc_parent_id)->first()->doc_no;
    }

    if(in_array($type,['khs', 'turnkey','surat_pengikatan','sp','amandemen_sp','adendum','side_letter'])){
      if(isset($dt->latar_belakang_kesanggupan_mitra[0])){
        $dt->lt_judul_kesanggupan_mitra     = $dt->latar_belakang_kesanggupan_mitra[0]['meta_name'];
        $dt->lt_tanggal_kesanggupan_mitra   = $dt->latar_belakang_kesanggupan_mitra[0]['meta_desc'];
        $dt->lt_file_kesanggupan_mitra      = $dt->latar_belakang_kesanggupan_mitra[0]['meta_file'];
        $dt->lt_file_kesanggupan_mitra_old  = $dt->latar_belakang_kesanggupan_mitra[0]['meta_file'];

        $dt->lt_judul_ketetapan_pemenang    = $dt->latar_belakang_ketetapan_pemenang[0]['meta_name'];
        $dt->lt_tanggal_ketetapan_pemenang  = $dt->latar_belakang_ketetapan_pemenang[0]['meta_desc'];
        $dt->lt_file_ketetapan_pemenang     = $dt->latar_belakang_ketetapan_pemenang[0]['meta_file'];
        $dt->lt_file_ketetapan_pemenang_old = $dt->latar_belakang_ketetapan_pemenang[0]['meta_file'];
      }
    }

    if(in_array($type,['surat_pengikatan'])){
      if(isset($dt->latar_belakang_rks[0])){
        $dt->lt_judul_rks    = $dt->latar_belakang_rks[0]['meta_name'];
        $dt->lt_tanggal_rks  = $dt->latar_belakang_rks[0]['meta_desc'];
        $dt->lt_file_rks     = $dt->latar_belakang_rks[0]['meta_file'];
        $dt->lt_file_rks_old = $dt->latar_belakang_rks[0]['meta_file'];
      }
    }

    if(count($dt->latar_belakang_optional)>0){
      foreach($dt->latar_belakang_optional as $key => $val){
        $lt_optional['f_latar_belakang_judul'][$key]    = $val->meta_name;
        $lt_optional['f_latar_belakang_tanggal'][$key]  = $val->meta_title;
        $lt_optional['f_latar_belakang_isi'][$key]      = $val->meta_desc;
        $lt_optional['f_latar_belakang_file'][$key]      = $val->meta_file;
      }

      $dt->f_latar_belakang_judul = $lt_optional['f_latar_belakang_judul'];
      $dt->f_latar_belakang_tanggal = $lt_optional['f_latar_belakang_tanggal'];
      $dt->f_latar_belakang_isi = $lt_optional['f_latar_belakang_isi'];
      $dt->f_latar_belakang_file = $lt_optional['f_latar_belakang_file'];
    }

    if(count($dt->scope_perubahan)>0){
      foreach($dt->scope_perubahan as $key => $val){
        $scop['name'][$key]  = $val->meta_name;
        $scop['awal'][$key]  = $val->meta_title;
        $scop['akhir'][$key] = $val->meta_desc;
        $scop['file'][$key]  = $val->meta_file;
      }
      if($type=='amandemen_sp'){
        $dt->scope_name     = $scop['name'];
        $dt->scope_awal     = $scop['awal'];
        $dt->scope_akhir    = $scop['akhir'];
      }
      else{
        $dt->scope_pasal     = $scop['name'];
        $dt->scope_judul     = $scop['awal'];
        $dt->scope_isi    = $scop['akhir'];
      }

      $dt->scope_file     = $scop['file'];
      $dt->scope_file_old = $scop['file'];
    }

    if(count($dt->scope_perubahan_side_letter)>0){
      foreach($dt->scope_perubahan_side_letter as $key => $val){
        $scop['pasal'][$key]  = $val->meta_pasal;
        $scop['judul'][$key]  = $val->meta_judul;
        $scop['isi'][$key]  = $val->meta_isi;
        $scop['awal'][$key]  = $val->meta_awal;
        $scop['akhir'][$key] = $val->meta_akhir;
        $scop['file'][$key]  = $val->meta_file;
      }

      $dt->scope_pasal    = $scop['pasal'];
      $dt->scope_judul    = $scop['judul'];
      $dt->scope_isi      = $scop['isi'];
      $dt->scope_awal     = $scop['awal'];
      $dt->scope_akhir    = $scop['akhir'];
      $dt->scope_file     = $scop['file'];
      $dt->scope_file_old = $scop['file'];
    }

    if(count($dt->pic)>0){
      foreach($dt->pic as $key => $val){
        $pic['pic_posisi'][$key]  = $val->posisi;
        $pic['pic_nama'][$key]    = $val->nama;
        $pic['pic_jabatan'][$key] = $val->jabatan;
        $pic['pic_email'][$key]   = $val->email;
        $pic['pic_telp'][$key]    = $val->telp;
        $pic['pic_id'][$key]      = $val->pegawai_id;
      }
      $dt->pic_posisi = $pic['pic_posisi'];
      $dt->pic_nama   = $pic['pic_nama'];
      $dt->pic_email  = $pic['pic_email'];
      $dt->pic_jabatan= $pic['pic_jabatan'];
      $dt->pic_telp   = $pic['pic_telp'];
      $dt->pic_id     = $pic['pic_id'];
    }

    if(count($dt->boq)>0){
      foreach($dt->boq as $key => $val){
        $boq['hs_kode_item'][$key]  = $val->kode_item;
        $boq['hs_item'][$key]       = $val->item;
        $boq['hs_satuan'][$key]     = $val->satuan;
        $boq['hs_mtu'][$key]        = $val->mtu;
        $boq['hs_harga'][$key]      = $val->harga;
        $boq['hs_harga_jasa'][$key] = $val->harga_jasa;
        $boq['hs_qty'][$key]        = $val->qty;
        $boq['hs_keterangan'][$key] = $val->desc;
      }
      $dt->hs_kode_item = $boq['hs_kode_item'];
      $dt->hs_item      = $boq['hs_item'];
      $dt->hs_satuan    = $boq['hs_satuan'];
      $dt->hs_mtu       = $boq['hs_mtu'];
      $dt->hs_harga     = $boq['hs_harga'];
      $dt->hs_harga_jasa   = $boq['hs_harga_jasa'];
      $dt->hs_qty       = $boq['hs_qty'];
      $dt->hs_keterangan= $boq['hs_keterangan'];
    }

    if(count($dt->asuransi)>0){
      foreach($dt->asuransi as $key => $val){
        $jas['doc_jaminan'][$key]           = $val->doc_jaminan;
        $jas['doc_asuransi'][$key]          = $val->doc_jaminan_name;
        $jas['doc_jaminan_nilai'][$key]     = $val->doc_jaminan_nilai;
        $jas['doc_jaminan_startdate'][$key] = $val->doc_jaminan_startdate;
        $jas['doc_jaminan_enddate'][$key]   = $val->doc_jaminan_enddate;
        $jas['doc_jaminan_desc'][$key]      = $val->doc_jaminan_desc;
        $jas['doc_jaminan_file'][$key]      = $val->doc_jaminan_file;
      }
      $dt->doc_jaminan           = $jas['doc_jaminan'];
      $dt->doc_asuransi          = $jas['doc_asuransi'];
      $dt->doc_jaminan_nilai     = $jas['doc_jaminan_nilai'];
      $dt->doc_jaminan_startdate = $jas['doc_jaminan_startdate'];
      $dt->doc_jaminan_enddate   = $jas['doc_jaminan_enddate'];
      $dt->doc_jaminan_desc      = $jas['doc_jaminan_desc'];
      $dt->doc_jaminan_file      = $jas['doc_jaminan_file'];
      $dt->doc_jaminan_file_old  = $jas['doc_jaminan_file'];
    }

    if(count($dt->pasal)>0){
      foreach($dt->pasal as $key => $val){
        $ps['name'][$key]  = $val->meta_name;
        $ps['desc'][$key]       = $val->meta_desc;
        $ps['title'][$key]     = $val->meta_title;
      }
      $dt->ps_judul      = $ps['name'];
      $dt->ps_isi        = $ps['desc'];
      $dt->ps_judul_new  = $ps['title'];
    }

    if(count($dt->lampiran_ttd)>0){
      foreach($dt->lampiran_ttd as $key => $val){
        $lampiran['file'][$key]  = $val->meta_file;
        $lampiran['name'][$key]  = $val->meta_name;
      }
      $dt->doc_lampiran_nama  = $lampiran['name'];
      $dt->doc_lampiran  = $lampiran['file'];
      $dt->doc_lampiran_old  = $lampiran['file'];
    }

    $dt->doc_po = $dt->doc_po_no;
    $dt->doc_no = $dt->doc_no;
    $dt->penomoran_otomatis = $dt->penomoran_otomatis;
    $dt->supplier_text = $dt->supplier->bdn_usaha.'.'.$dt->supplier->nm_vendor;
    $dt->konseptor_text = $dt->users->name.' - '.$dt->users->username;
    $data['page_title'] = 'Edit Dokumen';
    $data['doc_type'] = $dt->jenis->type;
    $data['doc'] = $dt;

    $konseptor = \App\User::get_user_pegawai($dt->user_id);
    $data['action_type'] = 'edit';
    $data['auto_numb']=Config::get_config('auto-numb');
    $data['action_url'] = route('doc.storeedit_ajax',['type'=>$dt->jenis->type->name,'id'=>$dt->id]);
    $data['data'] = [];
    $data['id'] = $dt->id;
    $data['pegawai_pihak1'] = Mtzpegawai::where('n_nik',$dt->doc_pihak1_nama)->first();
    $data['pegawai_konseptor'] = $konseptor;
    $data['doc_parent'] = \DB::table('documents')->where('id',$dt->doc_parent_id)->first();
    
    if($user_type!='subsidiary'){
      $objiddivisi=$dt->pemilik_kontrak->meta_name;
      $objidunit=$dt->pemilik_kontrak->meta_title;
      $data['divisi'] = \DB::table('rptom')->where('objiddivisi',$objiddivisi)->first();
      $data['unit_bisnis'] = \DB::table('rptom')->where('objidunit',$objidunit)->first();
    }
    else{
      $data['divisi'] = $konseptor;
      $data['unit_bisnis'] = $konseptor;
    }
    $data['user_type'] = $user_type;

    return view('documents::form-edit')->with($data);
  }
  public function store(Request $request)
  {
    $id = $request->id;
    $type = $request->type;
    $status = Documents::where('id',$id)->first()->doc_signing;

    if(!$this->documents->check_permission_doc($id ,$type)){
      abort(404);
    }
    if($type=='amandemen_sp'){
      return $this->amandemenSpEdit->store($request);
    }
    if($type=='sp'){
      return $this->spEdit->store($request);
    }
    if($type=='surat_pengikatan'){
      return $this->SuratPengikatanEdit->store($request);
    }
    if($type=='mou'){
      return $this->MouEdit->store($request);
    }
    if($type=='side_letter'){
      return $this->SideLetterEdit->store($request);
    }
    if(in_array($type,['amandemen_kontrak','adendum'])){
      return $this->amademenKontrakEdit->store($request);
    }

    if($type=='amandemen_kontrak_khs'){
      return $this->amademenKontrakKhsEdit->store($request);
    }

    if($type=='amandemen_kontrak_turnkey'){
      return $this->amademenKontrakTurnkeyEdit->store($request);
    }

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
    $new_lamp_up=[];
    if(in_array($status,['0','2'])){
      $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_desc']         =  'sometimes|nullable|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_template_id']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_startdate']    =  'required';
      $rules['doc_enddate']      =  'required';
      $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak2_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_proc_process'] =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_mtu']          =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';
      if($type!='khs'){
        $rules['doc_value']        =  'required|max:500|min:3|regex:/^[0-9 .]+$/i';
      }

      $rules['doc_lampiran_nama.*']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $check_new_lampiran = false;
      foreach($request->doc_lampiran_old as $k => $v){
        if(isset($request->doc_lampiran[$k]) && is_object($request->doc_lampiran[$k]) && !empty($v)){//jika ada file baru
          $new_lamp[] = '';
          $new_lamp_up[] = $request->doc_lampiran[$k];
          $rules['doc_lampiran.'.$k] = 'required|mimes:pdf';
        }else if(empty($v)){
          $rules['doc_lampiran.'.$k] = 'required|mimes:pdf';
          if(!isset($request->doc_lampiran[$k])){
            $new_lamp[] = $v;
            $new_lamp_up[] = $v;
          }
          else{
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

    $rules['doc_sow']          =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['hs_kode_item.*']   =  'sometimes|nullable|regex:/^[a-z0-9 .\-]+$/i';
    $rules['hs_item.*']        =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
    $rules['hs_satuan.*']      =  'sometimes|nullable|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
    $rules['hs_mtu.*']         =  'sometimes|nullable|max:5|min:1|regex:/^[a-z0-9 .\-]+$/i';
    $rules['hs_harga.*']       =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
    $rules['hs_harga_harga.*'] =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
    $rules['hs_qty.*']         =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
    $rules['hs_keterangan.*']  =  'sometimes|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i';
    if(\Laratrust::hasRole('admin')){
      $rules['user_id']        =  'required|min:1|max:20|regex:/^[0-9]+$/i';
    }

    if(in_array($type,['turnkey','sp'])){
        $rule_doc_jaminan = (count($request['doc_jaminan'])>1)?'required':'sometimes|nullable';
        $rule_doc_asuransi = (count($request['doc_asuransi'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_nilai = (count($request['doc_jaminan_nilai'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_startdate = (count($request['doc_jaminan_startdate'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_enddate = (count($request['doc_jaminan_enddate'])>1)?'required':'sometimes|nullable';
        $rules['doc_jaminan.*']           = $rule_doc_jaminan.'|in:PL,PM';
        $rules['doc_asuransi.*']          = $rule_doc_asuransi.'|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_jaminan_nilai.*']     = $rule_doc_jaminan_nilai.'|max:500|min:3|regex:/^[0-9 .]+$/i';
        $rules['doc_jaminan_startdate.*'] = $rule_doc_jaminan_startdate; //|date_format:"Y-m-d"
        $rules['doc_jaminan_enddate.*']   = $rule_doc_jaminan_enddate; //
        $rules['doc_jaminan_desc.*']      = 'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

        $rules['doc_po']                  = 'sometimes|nullable|po_exists|regex:/^[a-z0-9 .\-]+$/i';
        foreach($request->doc_jaminan_file_old as $k => $v){
          if(isset($request->doc_jaminan_file[$k]) && is_object($request->doc_jaminan_file[$k]) && !empty($v)){//jika ada file baru
            $new_jfile[] = '';
            $new_jfile_up[] = $request->doc_jaminan_file[$k];
            $rules['doc_jaminan_file.'.$k] = 'sometimes|nullable|mimes:pdf';
          }else if(empty($v)){
            $rules['doc_jaminan_file.'.$k] = 'sometimes|nullable|mimes:pdf';
            if(!isset($request->doc_jaminan_file[$k])){
              $new_jfile[] = $v;
              $new_jfile_up[] = $v;
            }else{
              $new_jfile[] = '';
              $new_jfile_up[] = $request->doc_jaminan_file[$k];
            }
          }else{
            $new_jfile[] = $v;
            $new_jfile_up[] = $v;
          }
        }
        $request->merge(['doc_jaminan_file' => $new_jfile]);
    }

    $rules['lt_judul_ketetapan_pemenang']     = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['lt_tanggal_ketetapan_pemenang']   = 'required';
    if($request->lt_file_ketetapan_pemenang_old==null){
      $rules['lt_file_ketetapan_pemenang']      = 'required|mimes:pdf';
    }

    $rules['lt_judul_kesanggupan_mitra']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['lt_tanggal_kesanggupan_mitra']  = 'required';
    if($request->lt_file_kesanggupan_mitra_old==null){
      $rules['lt_file_kesanggupan_mitra']     = 'required|mimes:pdf';
    }

    $rule_ps_judul = (count($request['ps_judul'])>1)?'required':'sometimes|nullable';
    $rule_ps_isi = (count($request['ps_isi'])>1)?'required':'sometimes|nullable';
    $rules['ps_judul.*']      =  $rule_ps_judul.'|in:Jangka Waktu Penerbitan Surat Pesanan,Jangka Waktu Penyerahan Pekerjaan,Tata Cara Pembayaran,Tanggal Efektif dan Masa Laku Perjanjian,Jaminan Pelaksanaan,Jaminan Uang Muka,Jaminan Pemeliharaan,Masa Laku Jaminan,Harga Kontrak,Lainnya';
    $rules['ps_isi.*']        =  $rule_ps_isi.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

    foreach($request->ps_judul as $k => $v){
      if(isset($request->ps_judul[$k]) && $request->ps_judul[$k]=="Lainnya" && !empty($v)){//jika ada file baru
        $new_pasal[] = $request->ps_judul_new[$k];
        $rules['ps_judul_new.'.$k] = 'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      }else{
        $new_pasal[] = $v;
      }
    }
    $request->merge(['ps_judul_new' => $new_pasal]);

    $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

    if(in_array($status,['0','2'])){
      $rules['pic_posisi.*']    =  'required|max:500|min:2|regex:/^[a-z0-9 .\-]+$/i';
      $validator->after(function ($validator) use ($request) {
          if (!isset($request['pic_nama'][0])) {
              $validator->errors()->add('pic_nama_err', 'Unit Penanggung jawab harus dipilih!');
          }

          if($request->doc_enddate < $request->doc_startdate){
            $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
          }
      });
    }

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

    if(in_array($status,['0','2'])){
      $doc = Documents::where('id',$id)->first();
      $doc->doc_title = $request->doc_title;
      $doc->doc_desc = $request->doc_desc;
      $doc->doc_template_id = $request->doc_template_id;
      $doc->doc_date = $request->doc_startdate;
      $doc->doc_startdate = $request->doc_startdate;
      $doc->doc_enddate = $request->doc_enddate;
      $doc->doc_pihak1 = $request->doc_pihak1;
      $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
      $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
      $doc->doc_signing = '0';
      if((\Laratrust::hasRole('admin'))){
        $doc->user_id = $request->user_id;
      }
      $doc->supplier_id = $request->supplier_id;
      if(in_array($type,['turnkey','sp'])){
        $doc->doc_po_no = $request->doc_po;
      }
      $doc->doc_proc_process = $request->doc_proc_process;
      $doc->doc_mtu = $request->doc_mtu;
      $doc->doc_value = Helpers::input_rupiah($request->doc_value);
      $doc->doc_sow = $request->doc_sow;
      $doc->doc_data = Helpers::json_input($doc->doc_data,['edited_by'=>\Auth::id()]);
      $doc->save();
    }else{
      //kalo dokumennya di return/ di approve dan di edit datanya (status = 3 & 1)
      $doc = Documents::where('id',$id)->first();
      $doc->doc_signing = '0';
      $doc->doc_sow = $request->doc_sow;
      $doc->save();
    }

    if(count($request->ps_judul)>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','pasal_pasal'],
        ])->delete();
      foreach($request->ps_judul as $key => $val){

        if(!empty($val)
        ){
          $doc_meta2 = new DocMeta();
          $doc_meta2->documents_id = $doc->id;
          $doc_meta2->meta_type = 'pasal_pasal';
          $doc_meta2->meta_name = $val;
          $doc_meta2->meta_title =$request['ps_judul_new'][$key];
          $doc_meta2->meta_desc = $request['ps_isi'][$key];
          $doc_meta2->save();
        }
      }
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
      $doc_meta->meta_desc = $request->lt_tanggal_ketetapan_pemenang;

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
      $doc_meta->meta_desc = $request->lt_tanggal_kesanggupan_mitra;

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
          $doc_meta->meta_title = $request['f_latar_belakang_tanggal'][$key];
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

    if(in_array($type,['turnkey','sp'])){
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
            $asr->doc_jaminan_startdate = $request['doc_jaminan_startdate'][$key];
            $asr->doc_jaminan_enddate = $request['doc_jaminan_enddate'][$key];
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
    }

    if(count($request->pic_nama)>0){
      DocPic::where([
        ['documents_id','=',$doc->id]
        ])->delete();
      foreach($request['pic_nama'] as $key => $val){
        if(!empty($request['pic_email'][$key])
            && !empty($request['pic_jabatan'][$key])
            && !empty($request['pic_posisi'][$key])
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

    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    if($request->statusButtons == '0'){
      return redirect()->route('doc',['status'=>'proses']);
    }else{
      $comment = new Comments();
      $comment->content = $request->komentar;
      $comment->documents_id = $doc->id;
      $comment->users_id = \Auth::id();
      $comment->status = 1;
      $comment->data = "Edited";
      $comment->save();
    }

    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    return redirect()->route('doc',['status'=>'tracking']);
  }

  public function store_ajax(Request $request)
  {
    $id = $request->id;
    $type = $request->type;
    $status = Documents::where('id',$id)->first()->doc_signing;

    if(!$this->documents->check_permission_doc($id ,$type)){
      abort(404);
    }
    if($type=='amandemen_sp'){
      return $this->amandemenSpEdit->store_ajax($request);
    }
    if($type=='sp'){
      return $this->spEdit->store_ajax($request);
    }
    if($type=='surat_pengikatan'){
      return $this->SuratPengikatanEdit->store_ajax($request);
    }
    if($type=='mou'){
      return $this->MouEdit->store_ajax($request);
    }
    if($type=='side_letter'){
      return $this->SideLetterEdit->store_ajax($request);
    }
    if(in_array($type,['amandemen_kontrak','adendum'])){
      return $this->amademenKontrakEdit->store_ajax($request);
    }

    if($type=='amandemen_kontrak_khs'){
      return $this->amademenKontrakKhsEdit->store_ajax($request);
    }

    if($type=='amandemen_kontrak_turnkey'){
      return $this->amademenKontrakTurnkeyEdit->store_ajax($request);
    }

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
    $new_lamp_up=[];
    if(in_array($status,['0','2'])){
      $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_template_id']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_startdate']    =  'required';
      $rules['doc_enddate']      =  'required|after:doc_startdate';
      $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak2_nama']  =  'required|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_proc_process'] =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_mtu']          =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';

      if($type!='khs'){
        $rules['doc_value']        =  'required|max:500|min:3|regex:/^[0-9 .]+$/i';
      }

      if( Config::get_config('auto-numb')=='off'){
        $rules['doc_no']  =  'required|min:5|max:500|unique:documents,doc_no,'.$id;
      }

      $rules['doc_lampiran_nama.*']  =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $check_new_lampiran = false;
      foreach($request->doc_lampiran_old as $k => $v){
        if(isset($request->doc_lampiran[$k]) && is_object($request->doc_lampiran[$k]) && !empty($v)){//jika ada file baru
          $new_lamp[] = '';
          $new_lamp_up[] = $request->doc_lampiran[$k];
          $rules['doc_lampiran.'.$k] = 'required|mimes:pdf';
        }else if(empty($v)){
          $rules['doc_lampiran.'.$k] = 'required|mimes:pdf';
          if(!isset($request->doc_lampiran[$k])){
            $new_lamp[] = $v;
            $new_lamp_up[] = $v;
          }
          else{
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

    $rules['doc_sow']          =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
    $rules['hs_kode_item.*']   =  'sometimes|nullable|regex:/^[a-z0-9 .\-]+$/i';
    $rules['hs_item.*']        =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
    $rules['hs_satuan.*']      =  'sometimes|nullable|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
    $rules['hs_mtu.*']         =  'sometimes|nullable|max:5|min:1|regex:/^[a-z0-9 .\-]+$/i';
    $rules['hs_harga.*']       =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
    $rules['hs_harga_harga.*'] =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
    $rules['hs_qty.*']         =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
    $rules['hs_keterangan.*']  =  'sometimes|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i';
    if(\Laratrust::hasRole('admin')){
      $rules['user_id']        =  'required|min:1|max:20|regex:/^[0-9]+$/i';
    }

    if(in_array($type,['turnkey','sp'])){
        $rule_doc_jaminan = (count($request['doc_jaminan'])>1)?'required':'sometimes|nullable';
        $rule_doc_asuransi = (count($request['doc_asuransi'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_nilai = (count($request['doc_jaminan_nilai'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_startdate = (count($request['doc_jaminan_startdate'])>1)?'required':'sometimes|nullable';
        $rule_doc_jaminan_enddate = (count($request['doc_jaminan_enddate'])>1)?'required':'sometimes|nullable';
        $rules['doc_jaminan.*']           = $rule_doc_jaminan.'|in:PL,PM';
        $rules['doc_asuransi.*']          = $rule_doc_asuransi.'|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_jaminan_nilai.*']     = $rule_doc_jaminan_nilai.'|max:500|min:3|regex:/^[0-9 .]+$/i';
        $rules['doc_jaminan_startdate.*'] = $rule_doc_jaminan_startdate; //|date_format:"Y-m-d"
        $rules['doc_jaminan_enddate.*']   = $rule_doc_jaminan_enddate.'|after:doc_jaminan_startdate.*'; //
        $rules['doc_jaminan_desc.*']      = 'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

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
    }

    $rules['lt_judul_ketetapan_pemenang']     = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['lt_tanggal_ketetapan_pemenang']   = 'required';
    if($request->lt_file_ketetapan_pemenang_old==null){
      $rules['lt_file_ketetapan_pemenang']      = 'required|mimes:pdf';
    }

    $rules['lt_judul_kesanggupan_mitra']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
    $rules['lt_tanggal_kesanggupan_mitra']  = 'required';
    if($request->lt_file_kesanggupan_mitra_old==null){
      $rules['lt_file_kesanggupan_mitra']     = 'required|mimes:pdf';
    }

    $rule_ps_judul = (count($request['ps_judul'])>1)?'required':'sometimes|nullable';
    $rule_ps_isi = (count($request['ps_isi'])>1)?'required':'sometimes|nullable';
    $rules['ps_judul.*']      =  $rule_ps_judul.'|in:Jangka Waktu Penerbitan Surat Pesanan,Jangka Waktu Penyerahan Pekerjaan,Tata Cara Pembayaran,Tanggal Efektif dan Masa Laku Perjanjian,Jaminan Pelaksanaan,Jaminan Uang Muka,Jaminan Pemeliharaan,Masa Laku Jaminan,Harga Kontrak,Lainnya';
    $rules['ps_isi.*']        =  $rule_ps_isi.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

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

    $rules['pic_posisi.*']    =  'required|max:500|min:2|regex:/^[a-z0-9 .\-]+$/i';
    $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());

    if(in_array($status,['0','2'])){
      $rules['pic_posisi.*']    =  'required|max:500|min:2|regex:/^[a-z0-9 .\-]+$/i';
      $validator->after(function ($validator) use ($request, $type) {
          if (!isset($request['pic_nama'][0])) {
            $validator->errors()->add('pic_nama_err', 'Unit Penanggung jawab harus dipilih!');
          }

          // if($request->doc_enddate < $request->doc_startdate){
          //   $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
          // }

          // if(in_array($type,['turnkey','sp'])){
          //   foreach($request->doc_jaminan_enddate as $k => $v){
          //     if($request->doc_jaminan_enddate[$k] < $request->doc_jaminan_startdate[$k]){
          //       $validator->errors()->add('doc_jaminan_enddate.'.$k, 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
          //     }
          //   }
          // }
      });
    }

    $request->merge(['doc_value' => $doc_value]);
    if(isset($hs_harga) && count($hs_harga)>0){
      $request->merge(['hs_harga'=>$hs_harga]);
    }

    if(isset($hs_qty) && count($hs_qty)>0){
      $request->merge(['hs_qty'=>$hs_qty]);
    }

    if($validator->fails ()){
      return Response::json (array(
        'errors' => $validator->getMessageBag()->toArray()
      ));
    }
    
    if(in_array($status,['0','2'])){
      $doc = Documents::where('id',$id)->first();
      $doc->doc_title = $request->doc_title;
      $doc->doc_desc = $request->doc_desc;
      $doc->doc_template_id = $request->doc_template_id;
      $doc->doc_date = date("Y-m-d", strtotime($request->doc_startdate));
      $doc->doc_startdate = date("Y-m-d", strtotime($request->doc_startdate));
      $doc->doc_enddate = date("Y-m-d", strtotime($request->doc_enddate));
      $doc->doc_pihak1 = $request->doc_pihak1;
      $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
      $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
      $doc->doc_signing = '0';
      $doc->supplier_id = $request->supplier_id;
      $doc->doc_proc_process = $request->doc_proc_process;
      $doc->doc_mtu = $request->doc_mtu;
      $doc->doc_value = Helpers::input_rupiah($request->doc_value);
      $doc->doc_sow = $request->doc_sow;
      $doc->doc_data = Helpers::json_input($doc->doc_data,['edited_by'=>\Auth::id()]);

      if((\Laratrust::hasRole('admin'))){
        $doc->user_id = $request->user_id;
      }

      if(in_array($type,['turnkey','sp'])){
        $doc->doc_po_no = $request->doc_po;
      }

      $doc->penomoran_otomatis =  Config::get_penomoran_otomatis($request->penomoran_otomatis);
      if(Config::get_config('auto-numb')=='off'){
        $doc->doc_no = $request->doc_no;
      }

      $doc->save();
    }else{
      //kalo dokumennya di return/ di approve dan di edit datanya (status = 3 & 1)
      $doc = Documents::where('id',$id)->first();
      $doc->doc_signing = '0';
      $doc->doc_sow = $request->doc_sow;
      $doc->save();
    }

    if(count($request->ps_judul)>0){
      DocMeta::where([
        ['documents_id','=',$doc->id],
        ['meta_type','=','pasal_pasal'],
        ])->delete();
      foreach($request->ps_judul as $key => $val){

        if(!empty($val)
        ){
          $doc_meta2 = new DocMeta();
          $doc_meta2->documents_id = $doc->id;
          $doc_meta2->meta_type = 'pasal_pasal';
          $doc_meta2->meta_name = $val;
          $doc_meta2->meta_title =$request['ps_judul_new'][$key];
          $doc_meta2->meta_desc = $request['ps_isi'][$key];
          $doc_meta2->save();
        }
      }
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
      $doc_meta->meta_desc = date("Y-m-d", strtotime($request->lt_tanggal_ketetapan_pemenang));

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
      $doc_meta->meta_desc = date("Y-m-d", strtotime($request->lt_tanggal_kesanggupan_mitra));

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

    if(in_array($type,['turnkey','sp'])){
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
    }

    if(count($request->pic_nama)>0){
      DocPic::where([
        ['documents_id','=',$doc->id]
        ])->delete();
      foreach($request['pic_nama'] as $key => $val){
        if(!empty($request['pic_email'][$key])
            && !empty($request['pic_jabatan'][$key])
            && !empty($request['pic_posisi'][$key])
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

    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    if($request->statusButtons == '0'){
      return redirect()->route('doc',['status'=>'proses']);
    }else{
      $comment = new Comments();
      $comment->content = $request->komentar;
      $comment->documents_id = $doc->id;
      $comment->users_id = \Auth::id();
      $comment->status = 1;
      $comment->data = "Edited";
      $comment->save();
    }
    /*
    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    return redirect()->route('doc',['status'=>'tracking']);
    */
    $request->session()->flash('alert-success', 'Data berhasil disimpan');
    return Response::json (array(
      'status' => 'tracking'
    ));
  }
}
