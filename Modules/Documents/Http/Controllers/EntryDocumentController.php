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
use Modules\Documents\Entities\DocPo;
use Modules\Documents\Entities\DocActivity;
use Modules\Config\Entities\Config;
use Modules\Documents\Entities\DocComment as Comments;
use Modules\Documents\Http\Controllers\SuratPengikatanCreateController as SuratPengikatanCreate;
use Modules\Documents\Http\Controllers\SideLetterCreateController as SideLetterCreate;
use Modules\Documents\Http\Controllers\MouCreateController as MouCreate;
use Modules\Documents\Http\Controllers\SpCreateController as SpCreate;
use Modules\Documents\Http\Controllers\AmandemenSpCreateController as AmandemenSpCreate;
use Modules\Documents\Http\Controllers\AmandemenKontrakCreateController as AmandemenKontrakCreate;
use Modules\Documents\Http\Controllers\AmandemenKontrakKhsCreateController as AmandemenKontrakKhsCreate;
use Modules\Documents\Http\Controllers\AmandemenKontrakTurnkeyCreateController as AmandemenKontrakTurnkeyCreate;

use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;
use Excel;

class EntryDocumentController extends Controller
{
    protected $fields=[];
    protected $SuratPengikatanCreate;
    protected $spCreate;
    protected $MouCreate;
    protected $AmandemenSpCreate;
    protected $AmandemenKontrakCreate;
    protected $AmandemenKontrakKhsCreate;
    protected $AmandemenKontrakTurnkeyCreate;
    protected $AdendumCreate;
    protected $SideLetterCreate;

    public function __construct(Request $req,MouCreate $MouCreate,SuratPengikatanCreate $SuratPengikatanCreate,SpCreate $spCreate,AmandemenSpCreate $AmandemenSpCreate,AmandemenKontrakCreate $AmandemenKontrakCreate,SideLetterCreate $SideLetterCreate, AmandemenKontrakKhsCreate $AmandemenKontrakKhsCreate, AmandemenKontrakTurnkeyCreate $AmandemenKontrakTurnkeyCreate){
      $this->SuratPengikatanCreate  = $SuratPengikatanCreate;
      $this->MouCreate              = $MouCreate;
      $this->spCreate               = $spCreate;
      $this->AmandemenSpCreate      = $AmandemenSpCreate;
      $this->AmandemenKontrakCreate = $AmandemenKontrakCreate;
      $this->AmandemenKontrakKhsCreate = $AmandemenKontrakKhsCreate;
      $this->AmandemenKontrakTurnkeyCreate = $AmandemenKontrakTurnkeyCreate;
      $this->SideLetterCreate = $SideLetterCreate;
      $doc_id = $req->doc_id;
      $field = Documents::get_fields();
      if(!empty($doc_id)){
        $doc = Documents::where('id','=',$doc_id)->first();
        if(!$doc){
          abort(404);
        }
        $this->fields = $doc;
      }
      else{
        $this->fields = $field;
      }
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $req)
    {
      $doc_type = DocType::where('name','=',$req->type)->first();
      if(!$doc_type){
        abort(404);
      }
      $field = Documents::get_fields();
      $data['page_title'] = 'Entry - '.$doc_type['title'];
      $data['doc_type'] = $doc_type;
      $data['doc'] = [];
      $data['doc']['doc_pihak1'] = 'PT. TELEKOMUNIKASI INDONESIA Tbk';
      // dd($doc_type);
      $field = Documents::get_fields();
      $data['data'] = $this->fields;
      $data['pegawai'] = \App\User::get_user_pegawai();
      $ppn = Config::where('object_key','=','ppn-sp')->first();

      if($ppn){
        $ppn->ppn = $ppn->object_value;
      }else{
        $ppn = "0";
      }

      // dd($ppn->ppn);
      $data['ppn'] = $ppn;
      $data['auto_numb']=Config::get_config('auto-numb');

      // dd($data);
      return view('documents::form')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('documents::create');
    }
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    /*
    public function store(Request $request)
    {
      $type = $request->type;
      if($type=='surat_pengikatan'){
        return $this->SuratPengikatanCreate->store($request);
      }
      if($type=='mou'){
        return $this->MouCreate->store($request);
      }
      if($type=='sp'){
        return $this->spCreate->store($request);
      }
      if($type=='amandemen_sp'){
        return $this->AmandemenSpCreate->store($request);
      }
      if($type=='side_letter'){
        return $this->SideLetterCreate->store($request);
      }
      if(in_array($type,['amandemen_kontrak','adendum'])){
        return $this->AmandemenKontrakCreate->store($request);
      }
      if(in_array($type,['amandemen_kontrak_khs'])){
        return $this->AmandemenKontrakKhsCreate->store($request);
      }

      if(in_array($type,['amandemen_kontrak_turnkey'])){
        return $this->AmandemenKontrakTurnkeyCreate->store($request);
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
      if($request->statusButton == '0'){
        $rules['komentar']         = 'required|max:250|min:2';
        $rules['divisi']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['unit_bisnis']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_desc']         =  'sometimes|nullable|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_template_id']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_startdate']    =  'required';
        $rules['doc_enddate']      =  'required';
        $rules['doc_pihak1']       =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_pihak2_nama']  =  'required|min:1|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_proc_process'] =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_mtu']          =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';

        if(Config::get_config('auto-numb')=='off'){
          $rules['doc_no']  =  'required|min:5|max:500|unique:documents,doc_no';
        }

        if($type!='khs'){
          $rules['doc_value']        =  'required|max:500|min:3|regex:/^[0-9 .]+$/i';
        }

        if(\Laratrust::hasRole('admin')){
          $rules['user_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
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

        $rules['hs_kode_item.*']   =  'sometimes|nullable|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_item.*']        =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_satuan.*']      =  'sometimes|nullable|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_mtu.*']         =  'sometimes|nullable|max:5|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_harga.*']       =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_harga_jasa.*']  =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_qty.*']         =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_keterangan.*']  =  'sometimes|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i';

        if(in_array($type,['turnkey','sp'])){
            $rule_doc_jaminan = (count($request['doc_jaminan'])>1)?'required':'sometimes|nullable';
            $rule_doc_asuransi = (count($request['doc_asuransi'])>1)?'required':'sometimes|nullable';
            $rule_doc_jaminan_nilai = (count($request['doc_jaminan_nilai'])>1)?'required':'sometimes|nullable';
            $rule_doc_jaminan_startdate = (count($request['doc_jaminan_startdate'])>1)?'required':'sometimes|nullable';
            $rule_doc_jaminan_enddate = (count($request['doc_jaminan_enddate'])>1)?'required':'sometimes|nullable';
            $rule_doc_jaminan_desc = (count($request['doc_jaminan_desc'])>1)?'required':'sometimes|nullable';
            $rules['doc_jaminan.*']           = $rule_doc_jaminan.'|in:PL,PM';
            $rules['doc_asuransi.*']          = $rule_doc_asuransi.'|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
            $rules['doc_jaminan_nilai.*']     = $rule_doc_jaminan_nilai.'|max:500|min:3|regex:/^[0-9 .]+$/i';
            $rules['doc_jaminan_startdate.*'] = $rule_doc_jaminan_startdate; //|date_format:"Y-m-d"
            $rules['doc_jaminan_enddate.*']   = $rule_doc_jaminan_enddate; //
            $rules['doc_jaminan_desc.*']      = $rule_doc_jaminan_desc.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
            $rules['doc_jaminan_file.*']      = 'sometimes|nullable|mimes:pdf';
            $rules['doc_po']                  = 'sometimes|nullable|po_exists|regex:/^[a-z0-9 .\-]+$/i';
        }

        $rules['lt_judul_ketetapan_pemenang']     = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_ketetapan_pemenang']   = 'required';
        $rules['lt_file_ketetapan_pemenang']      = 'required|mimes:pdf';

        $rules['lt_judul_kesanggupan_mitra']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_kesanggupan_mitra']  = 'required';
        $rules['lt_file_kesanggupan_mitra']     = 'required|mimes:pdf';

        $rule_ps_judul = (count($request['ps_judul'])>1)?'required':'sometimes|nullable';
        $rule_ps_isi   = (count($request['ps_isi'])>1)?'required':'sometimes|nullable';
        $rules['ps_judul.*'] =  $rule_ps_judul.'|in:Jangka Waktu Penerbitan Surat Pesanan,Jangka Waktu Penyerahan Pekerjaan,Tata Cara Pembayaran,Tanggal Efektif dan Masa Laku Perjanjian,Jaminan Pelaksanaan,Jaminan Uang Muka,Jaminan Pemeliharaan,Masa Laku Jaminan,Harga Kontrak,Lainnya';
        $rules['ps_isi.*']   =  $rule_ps_isi.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

        foreach($request->ps_judul as $k => $v){
          if(isset($request->ps_judul[$k]) && $request->ps_judul[$k]=="Lainnya" && !empty($v)){//jika ada file baru
            $new_pasal[] = $request->ps_judul_new[$k];
            $rules['ps_judul_new.'.$k] = 'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
          }else{
            $new_pasal[] = $v;
          }
        }

        $request->merge(['ps_judul_new' => $new_pasal]);

        $rules['pic_posisi.*']    =  'required|max:500|min:2|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
        $validator->after(function ($validator) use ($request) {
            if (!isset($request['pic_nama'][0])) {
                $validator->errors()->add('pic_nama_err', 'Unit Penanggung jawab harus dipilih!');
            }

            if($request->doc_enddate < $request->doc_startdate){
              $validator->errors()->add('doc_enddate', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Mulai!');
            }
            if(Config::get_config('auto-numb')=='off'){
              $validator->errors()->add('doc_no', 'Test');
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
          return redirect()->back()
                      ->withInput($request->input())
                      ->withErrors($validator);
        }
      }else{
        $rules['doc_template_id']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['pic_posisi.*']     =  'required|max:500|min:2|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        if(\Laratrust::hasRole('admin')){
          $rules['user_id']        =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        }
        $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());


        if ($validator->fails ()){
          return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
      }

      $doc = new Documents();
      $doc->doc_title = $request->doc_title;
      $doc->doc_desc = $request->doc_desc;
      $doc->doc_template_id = $request->doc_template_id;
      $doc->doc_date = $request->doc_startdate;
      $doc->doc_startdate = $request->doc_startdate;
      $doc->doc_enddate = $request->doc_enddate;
      $doc->doc_pihak1 = $request->doc_pihak1;
      $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
      $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
      $doc->user_id = (\Laratrust::hasRole('admin'))?$request->user_id:Auth::id();
      $doc->supplier_id = $request->supplier_id;

      if(in_array($type,['turnkey','sp'])){
        $doc->doc_po_no = $request->doc_po;
      }

      $doc->doc_proc_process = $request->doc_proc_process;
      $doc->doc_mtu = $request->doc_mtu;
      $doc->doc_value = Helpers::input_rupiah($request->doc_value);
      $doc->doc_sow = $request->doc_sow;
      $doc->doc_type = $request->type;
      $doc->doc_signing = $request->statusButton;


      $doc->penomoran_otomatis =  Config::get_penomoran_otomatis($request->penomoran_otomatis);
      if(Config::get_config('auto-numb')=='off'){
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
      /// pasal khusus
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

      // PO
      if(in_array($type,['turnkey','sp'])){
        if(count($request->doc_po_no)>0){
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

      // asuransi
      if(in_array($type,['turnkey','sp'])){
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
      }

      // pic
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

      // sow boq
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
    */

    public function upload(Request $request)
    {
      if ($request->ajax()) {

          $data = Excel::load($request->file('daftar_harga')->getRealPath(), function ($reader) {

          })->get();
          $type = $request->type;
          // dd($type);
          if($type != "khs" && $type != "amandemen_kontrak_khs"){
              $header = ['kode_item','item','qty','satuan','mtu','harga','harga_jasa','keterangan'];
              $jml_header = '8';
          }else {
            $header = ['kode_item','item','satuan','mtu','harga','harga_jasa','keterangan'];
            $jml_header = '7';
          }
          $colomn = $data->first()->keys()->toArray();

          if(!empty($data) && count($colomn) == $jml_header && $colomn == $header){
          return Response::json(['status'=>true,'csrf_token'=>csrf_token(),'data'=>$data]);
        }
        else{
          return Response::json(['status'=>false]);
        }
      }
      else{
        return Response::json(['status'=>false]);
      }
  }

    public function store_ajax(Request $request)
    {
      $type = $request->type;

      if($type=='surat_pengikatan'){
        return $this->SuratPengikatanCreate->store_ajax($request);
      }
      if($type=='mou'){
        return $this->MouCreate->store_ajax($request);
      }
      if($type=='sp'){
        return $this->spCreate->store_ajax($request);
      }
      if($type=='amandemen_sp'){
        return $this->AmandemenSpCreate->store_ajax($request);
      }
      if($type=='side_letter'){
        return $this->SideLetterCreate->store_ajax($request);
      }
      if(in_array($type,['amandemen_kontrak','adendum'])){
        return $this->AmandemenKontrakCreate->store_ajax($request);
      }
      if(in_array($type,['amandemen_kontrak_khs'])){
        return $this->AmandemenKontrakKhsCreate->store_ajax($request);
      }

      if(in_array($type,['amandemen_kontrak_turnkey'])){
        return $this->AmandemenKontrakTurnkeyCreate->store_ajax($request);
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
      if($request->statusButton == '0'){
        $rules['komentar']         = 'required|max:250|min:2';
        $rules['divisi']           =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['unit_bisnis']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_desc']         =  'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_template_id']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_startdate']    =  'required';
        $rules['doc_enddate']      =  'required|after:doc_startdate';
        $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_pihak2_nama']  =  'required|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_proc_process'] =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';
        $rules['doc_mtu']          =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';

        if(Config::get_config('auto-numb')=='off'){
          $rules['doc_no']  =  'required|min:1|max:500|unique:documents,doc_no';
        }

        if($type!='khs'){
          $rules['doc_value']     =  'required|max:500|min:3|regex:/^[0-9 .]+$/i';
        }

        if(\Laratrust::hasRole('admin')){
          $rules['user_id']       =  'required|min:1|max:20|regex:/^[0-9]+$/i';
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

        $rules['hs_kode_item.*']   =  'sometimes|nullable|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_item.*']        =  'sometimes|nullable|max:500|min:2|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_satuan.*']      =  'sometimes|nullable|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_mtu.*']         =  'sometimes|nullable|max:5|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['hs_harga.*']       =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_harga_jasa.*']  =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_qty.*']         =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
        $rules['hs_keterangan.*']  =  'sometimes|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i';

        if(in_array($type,['turnkey','sp'])){
          $rule_doc_jaminan = (count($request['doc_jaminan'])>1)?'required':'sometimes|nullable';
          $rule_doc_asuransi = (count($request['doc_asuransi'])>1)?'required':'sometimes|nullable';
          $rule_doc_jaminan_nilai = (count($request['doc_jaminan_nilai'])>1)?'required':'sometimes|nullable';
          $rule_doc_jaminan_startdate = (count($request['doc_jaminan_startdate'])>1)?'required':'sometimes|nullable';
          $rule_doc_jaminan_enddate = (count($request['doc_jaminan_enddate'])>1)?'required':'sometimes|nullable';
          $rule_doc_jaminan_desc = (count($request['doc_jaminan_desc'])>1)?'required':'sometimes|nullable';
          $rules['doc_jaminan.*']           = $rule_doc_jaminan.'|in:PL,PM';
          $rules['doc_asuransi.*']          = $rule_doc_asuransi.'|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
          $rules['doc_jaminan_nilai.*']     = $rule_doc_jaminan_nilai.'|max:500|min:3|regex:/^[0-9 .]+$/i';
          $rules['doc_jaminan_startdate.*'] = $rule_doc_jaminan_startdate;
          $rules['doc_jaminan_enddate.*']   = $rule_doc_jaminan_enddate.'|after:doc_jaminan_startdate.*';
          $rules['doc_jaminan_desc.*']      = $rule_doc_jaminan_desc.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
          $rules['doc_jaminan_file.*']      = 'sometimes|nullable|mimes:pdf';
          $rules['doc_po']                  = 'sometimes|nullable|po_exists|regex:/^[a-z0-9 .\-]+$/i';
        }

        $rules['lt_judul_ketetapan_pemenang']     = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_ketetapan_pemenang']   = 'required';
        $rules['lt_file_ketetapan_pemenang']      = 'required|mimes:pdf';

        $rules['lt_judul_kesanggupan_mitra']    = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['lt_tanggal_kesanggupan_mitra']  = 'required';
        $rules['lt_file_kesanggupan_mitra']     = 'required|mimes:pdf';

        $rule_ps_judul = (count($request['ps_judul'])>1)?'required':'sometimes|nullable';
        $rule_ps_isi   = (count($request['ps_isi'])>1)?'required':'sometimes|nullable';
        $rules['ps_judul.*'] =  $rule_ps_judul.'|in:Jangka Waktu Penerbitan Surat Pesanan,Jangka Waktu Penyerahan Pekerjaan,Tata Cara Pembayaran,Tanggal Efektif dan Masa Laku Perjanjian,Jaminan Pelaksanaan,Jaminan Uang Muka,Jaminan Pemeliharaan,Masa Laku Jaminan,Harga Kontrak,Lainnya';
        $rules['ps_isi.*']   =  $rule_ps_isi.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

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

        $request->merge(['doc_value' => $doc_value]);
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
      }else{
        $rules['doc_template_id']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
        $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
        if(\Laratrust::hasRole('admin')){
          $rules['user_id']        =  'required|min:1|max:20|regex:/^[0-9]+$/i';
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
      $doc->doc_desc = $request->doc_desc;
      $doc->doc_template_id = $request->doc_template_id;
      $doc->doc_date = date("Y-m-d", strtotime($request->doc_startdate));
      $doc->doc_startdate = date("Y-m-d", strtotime($request->doc_startdate));
      $doc->doc_enddate = date("Y-m-d", strtotime($request->doc_enddate));
      $doc->doc_pihak1 = $request->doc_pihak1;
      $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
      $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
      $doc->user_id = (\Laratrust::hasRole('admin'))?$request->user_id:Auth::id();
      $doc->supplier_id = $request->supplier_id;

      if(in_array($type,['turnkey','sp'])){
        $doc->doc_po_no = $request->doc_po;
      }

      $doc->doc_proc_process = $request->doc_proc_process;
      $doc->doc_mtu = $request->doc_mtu;
      $doc->doc_value = Helpers::input_rupiah($request->doc_value);
      $doc->doc_sow = $request->doc_sow;
      $doc->doc_type = $request->type;
      $doc->doc_signing = $request->statusButton;


      $doc->penomoran_otomatis =  Config::get_penomoran_otomatis($request->penomoran_otomatis);
      if(Config::get_config('auto-numb')=='off'){
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

      /// pasal khusus
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

      // PO
      if(in_array($type,['turnkey','sp'])){
        if(count($request->doc_po_no)>0){
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

      // asuransi
      if(in_array($type,['turnkey','sp'])){
        if(count($request->doc_asuransi)>0){
          foreach($request['doc_asuransi'] as $key => $val){
            if(!empty($val)
            ){
              $asr = new DocAsuransi();
              $asr->documents_id = $doc->id;
              $asr->doc_jaminan = $request['doc_jaminan'][$key];
              $asr->doc_jaminan_name = $request['doc_asuransi'][$key];
              $asr->doc_jaminan_nilai = Helpers::input_rupiah($request['doc_jaminan_nilai'][$key]);
              $asr->doc_jaminan_startdate = date("Y-m-d", strtotime($request['doc_jaminan_startdate'][$key]));
              $asr->doc_jaminan_enddate = date("Y-m-d", strtotime($request['doc_jaminan_enddate'][$key]));
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
      }

      // pic
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
        $doc_meta->meta_desc = date("Y-m-d", strtotime($request->lt_tanggal_ketetapan_pemenang));

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
        $doc_meta->meta_desc = date("Y-m-d", strtotime($request->lt_tanggal_kesanggupan_mitra));

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
            $doc_meta->meta_title = date("Y-m-d", strtotime($request['f_latar_belakang_tanggal'][$key]));
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

      // sow boq
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
