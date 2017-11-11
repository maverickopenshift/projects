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
use Modules\Documents\Http\Controllers\SpCreateController as SpCreate;
use Modules\Documents\Http\Controllers\AmandemenSpCreateController as AmandemenSpCreate;
use Modules\Documents\Http\Controllers\AmandemenKontrakCreateController as AmandemenKontrakCreate;
use Modules\Documents\Http\Controllers\AdendumCreateController as AdendumCreate;
use Modules\Documents\Http\Controllers\SideLetterCreateController as SideLetterCreate;

use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class EntryDocumentController extends Controller
{
    protected $fields=[];
    protected $spCreate;
    protected $AmandemenSpCreate;
    protected $AmandemenKontrakCreate;
    protected $AdendumCreate;
    protected $SideLetterCreate;
    public function __construct(Request $req,SpCreate $spCreate,AmandemenSpCreate $AmandemenSpCreate,AmandemenKontrakCreate $AmandemenKontrakCreate,AdendumCreate $AdendumCreate,SideLetterCreate $SideLetterCreate){
      $this->spCreate               = $spCreate;
      $this->AmandemenSpCreate      = $AmandemenSpCreate;
      $this->AmandemenKontrakCreate = $AmandemenKontrakCreate;
      $this->AdendumCreate          = $AdendumCreate;
      $this->SideLetterCreate       = $SideLetterCreate;
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
        $data['data'] = $this->fields;
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
    public function store(Request $request)
    {
      $type = $request->type;
      if($type=='sp'){
        return $this->spCreate->store($request);
      }
      if($type=='amandemen_sp'){
        return $this->AmandemenSpCreate->store($request);
      }
      if(in_array($type,['amandemen_kontrak','adendum','side_letter'])){
        return $this->AmandemenKontrakCreate->store($request);
      }
      // if($type=='adendum'){
      //   return $this->AdendumCreate->store($request);
      // }
      // if($type=='side_letter'){
      //   return $this->SideLetterCreate->store($request);
      // }
      $doc_value = $request->doc_value;
      $request->merge(['doc_value' => Helpers::input_rupiah($request->doc_value)]);
      //$request->merge(['doc_value' => 'asdfsadfsdafsd']);
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
      $rules['doc_title']        =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_desc']         =  'sometimes|nullable|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_template_id']  =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_date']         =  'required|date_format:"Y-m-d"';
      $rules['doc_pihak1']       =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_pihak1_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['supplier_id']      =  'required|min:1|max:20|regex:/^[0-9]+$/i';
      $rules['doc_pihak2_nama']  =  'required|min:5|max:500|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['doc_lampiran.*']     =  'required|mimes:pdf';
      $rules['doc_proc_process'] =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_mtu']          =  'required|min:1|max:20|regex:/^[a-z0-9 .\-]+$/i';
      $rules['doc_value']        =  'required|max:500|min:3|regex:/^[0-9 .]+$/i';
      $rules['doc_sow']          =  'sometimes|nullable|min:30|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';

      $rules['hs_kode_item.*']   =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_item.*']        =  'sometimes|nullable|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_satuan.*']      =  'sometimes|nullable|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_mtu.*']         =  'sometimes|nullable|max:5|min:1|regex:/^[a-z0-9 .\-]+$/i';
      $rules['hs_harga.*']       =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
      $rules['hs_qty.*']         =  'sometimes|nullable|max:500|min:1|regex:/^[0-9 .]+$/i';
      $rules['hs_keterangan.*']  =  'sometimes|nullable|max:500|regex:/^[a-z0-9 .\-]+$/i';

      if(in_array($type,['turnkey','sp'])){
          $doc_jaminan_nilai = $request->doc_jaminan_nilai;
          $request->merge(['doc_jaminan_nilai.*' => Helpers::input_rupiah($request->doc_jaminan_nilai)]);
          $rules['doc_jaminan.*']           = 'required|in:PL,PM';
          $rules['doc_asuransi.*']          = 'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
          $rules['doc_jaminan_nilai.*']     = 'required|max:500|min:3|regex:/^[0-9 .]+$/i';
          $rules['doc_jaminan_startdate.*'] = 'required|date_format:"Y-m-d"';
          $rules['doc_jaminan_enddate.*']   = 'required|date_format:"Y-m-d"';
          $rules['doc_jaminan_desc.*']      = 'sometimes|nullable|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
          $rules['doc_po']                = 'sometimes|nullable|po_exists|regex:/^[a-z0-9 .\-]+$/i';
     }

      $rule_lt_name = (count($request['lt_name'])>1)?'required':'sometimes|nullable';
      $rule_lt_desc = (count($request['lt_desc'])>1)?'required':'sometimes|nullable';
      $rules['lt_file.*']  =  'sometimes|nullable|mimes:pdf';
      $rules['lt_desc.*']  =  $rule_lt_desc.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
      $rules['lt_name.*']  =  $rule_lt_name.'|max:500|regex:/^[a-z0-9 .\-]+$/i';

      $rule_ps_pasal = (count($request['ps_pasal'])>1)?'required':'sometimes|nullable';
      $rule_ps_judul = (count($request['ps_judul'])>1)?'required':'sometimes|nullable';
      $rule_ps_isi = (count($request['ps_isi'])>1)?'required':'sometimes|nullable';
      $rules['ps_pasal.*']  =  $rule_ps_pasal.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['ps_judul.*']  =  $rule_ps_isi.'|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['ps_isi.*']    =  $rule_ps_judul.'|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';


      $rules['pic_posisi.*']    =  'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';

      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
      $validator->after(function ($validator) use ($request) {
          if (!isset($request['pic_nama'][0])) {
              $validator->errors()->add('pic_nama_err', 'Unit Penanggung jawab harus dipilih!');
          }
      });
      if(isset($doc_jaminan_nilai)){
        $request->merge(['doc_jaminan_nilai' => $doc_jaminan_nilai]);
      }
      $request->merge(['doc_value' => $doc_value]);
      if(isset($hs_harga) && count($hs_harga)>0){
        $request->merge(['hs_harga'=>$hs_harga]);
      }
      if(isset($hs_qty) && count($hs_qty)>0){
        $request->merge(['hs_qty'=>$hs_qty]);
      }
      //dd($request->input());
      if ($validator->fails ()){
        return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
      }
      // dd($request->input());
      //dd('berhasil');
      $doc = new Documents();
      $doc->doc_title = $request->doc_title;
      $doc->doc_desc = $request->doc_desc;
      $doc->doc_template_id = $request->doc_template_id;
      $doc->doc_date = $request->doc_date;
      $doc->doc_pihak1 = $request->doc_pihak1;
      $doc->doc_pihak1_nama = $request->doc_pihak1_nama;
      $doc->doc_pihak2_nama = $request->doc_pihak2_nama;
      $doc->user_id = Auth::id();
      $doc->supplier_id = $request->supplier_id;

      if(in_array($type,['turnkey','sp'])){
        $doc->doc_po_no = $request->doc_po;
        // $doc->doc_jaminan = $request->doc_jaminan;
        // $doc->doc_asuransi = $request->doc_asuransi;
        // $doc->doc_jaminan_startdate = $request->doc_jaminan_startdate;
        // $doc->doc_jaminan_enddate = $request->doc_jaminan_enddate;
        // $doc->doc_jaminan_desc = $request->doc_jaminan_desc;
        // $doc->doc_jaminan_nilai = Helpers::input_rupiah($request->doc_jaminan_nilai);
      }
      $doc->doc_proc_process = $request->doc_proc_process;
      $doc->doc_mtu = $request->doc_mtu;
      $doc->doc_value = Helpers::input_rupiah($request->doc_value);
      $doc->doc_sow = $request->doc_sow;
      $doc->doc_type = $request->type;
      $doc->save();

      if(count($request->name_lampiran)>0){
        foreach($request->name_lampiran as $key => $val){
          dd($val);
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

      if(in_array($type,['turnkey','sp'])){
        foreach($request['doc_asuransi'] as $key => $val){
          $asr = new DocAsuransi();
          $asr->documents_id = $doc->id;
          $asr->doc_jaminan = $request['doc_jaminan'][$key];
          $asr->doc_jaminan_name = $request['doc_asuransi'][$key];
          $asr->doc_jaminan_nilai = Helpers::input_rupiah($request['doc_jaminan_startdate'][$key]);
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
      if(count($request->ps_pasal)>0){
        foreach($request->ps_pasal as $key => $val){
          if(!empty($val)
              && !empty($request['ps_judul'][$key])
              && !empty($request['ps_isi'][$key])
          ){
            $doc_meta2 = new DocMeta();
            $doc_meta2->documents_id = $doc->id;
            $doc_meta2->meta_type = 'pasal_pasal';
            $doc_meta2->meta_name = $val;
            $doc_meta2->meta_title =$request['ps_judul'][$key];
            $doc_meta2->meta_desc = $request['ps_isi'][$key];
            $doc_meta2->save();
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
      return redirect()->route('doc',['status'=>'proses']);
                  // ->withErrors($validator);
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
