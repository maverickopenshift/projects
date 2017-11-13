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
use App\Helpers\Helpers;
use Validator;

class DocumentsController extends Controller
{
    protected $documents;

    public function __construct(Documents $documents)
    {
        $this->documents = $documents;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
      $status = $request->status;
      $status_arr = ['proses','selesai','draft','reject'];
      if(!in_array($status,$status_arr)){
        abort(404);
      }
      foreach ($status_arr as $key => $st){
        if($status==$st){
          $status_no = $key;
        }
      }
      if ($request->ajax()) {
          $limit = 25;
          $search = $request->q;
          $unit = $request->unit;
          $posisi = $request->posisi;
          if(!empty($request->limit)){
            $limit = $request->limit;
          }

          if(in_array($request->child,[1,2,3])){
            $documents = $this->documents
                ->oldest('documents.created_at')
            ;
              $documents->leftJoin('documents as child','child.doc_parent_id','=','documents.id');
              $documents->leftJoin('documents as child2','child2.doc_parent_id','=','child.id');
              $documents->where('documents.doc_parent',0);
              $documents->where('documents.doc_parent_id',$request->parent_id);
              $documents->whereRaw('(child.`doc_signing`='.$status_no.' OR child2.`doc_signing`='.$status_no.' OR documents.`doc_signing`='.$status_no.')');
              $documents->selectRaw('DISTINCT (documents.id) , documents.*');
          }
          else{
            $documents = $this->documents
                ->latest('documents.updated_at')
            ;
            $documents->leftJoin('documents as child','child.doc_parent_id','=','documents.id');
            $documents->leftJoin('documents as child2','child2.doc_parent_id','=','child.id');
            $documents->leftJoin('documents as child3','child3.doc_parent_id','=','child2.id');
//            $documents->select('documents.*');
              $documents->selectRaw('DISTINCT (documents.id) , documents.*');
            $documents->where('documents.doc_parent',1);
//            $documents->where('documents.doc_signing',$status_no);
            $documents->whereRaw('(child.`doc_signing`='.$status_no.' OR child2.`doc_signing`='.$status_no.' OR child3.`doc_signing`='.$status_no.' OR documents.`doc_signing`='.$status_no.')');
            if(!empty($request->q)){
              $documents->where(function($q) use ($search) {
                  $q->orWhere('documents.doc_no', 'like', '%'.$search.'%');
                  $q->orWhere('documents.doc_title', 'like', '%'.$search.'%');
                  // $q->whereHas(
                  //       'child', function ($q) use ($search) {
                  //                 $q->orWhere('doc_no', 'like', '%'.$search.'%');
                  //                 $q->orWhere('doc_title', 'like', '%'.$search.'%');
                  //       }
                  //   );
              });
            }
            
          }
          if(!empty($unit)){
            $documents->join('users_pegawai as up','up.users_id','=','documents.user_id');
            $documents->join('pegawai as g','g.n_nik','=','up.nik');
            if(!empty($posisi)){
              $documents->where('g.objidposisi',$posisi);
            }
            $documents->where('g.objidunit',$unit); 
          }
//          echo $search;
//          echo $status_no;
//          echo($documents->toSql());exit;
          if(!\Auth::user()->hasRole('admin')){
            $documents->join('users_pegawai','users_pegawai.users_id','=','documents.user_id');
            $documents->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');
            $documents->where('pegawai.objiddivisi',\App\User::get_divisi_by_user_id());
          }
          $documents = $documents->with(['jenis','supplier','pic']);
          $documents = $documents->paginate($limit);
          $documents->getCollection()->transform(function ($value)use ($status_no) {
            // $sp = $this->documents->get_child('sp',$value['id']);
            // $aman_sp = $this->documents->get_child('amandemen_sp',$value['id']);
            // $aman_kon = $this->documents->get_child('amandemen_kontrak',$value['id']);
            // $adendum = $this->documents->get_child('adendum',$value['id']);
            // $side_letter = $this->documents->get_child('side_letter',$value['id']);
            // if($sp>0 || $aman_sp>0 || $aman_kon>0 || $adendum>0 || $side_letter>0){
            //   $value['doc_no'] = $value['doc_no'].'<br/>'
            //   .Helpers::create_button('SP',$sp)
            //   .Helpers::create_button('Amandemen SP',$aman_sp,'info')
            //   .Helpers::create_button('Amandemen Kontrak',$aman_kon,'danger')
            //   .Helpers::create_button('Adendum',$adendum,'warning')
            //   .Helpers::create_button('Side Letter',$side_letter,'info');
            // }
            $value['total_child']=$this->documents->total_child($value['id'],$status_no);
            if($value['doc_signing']==0 && \Laratrust::can('approve-kontrak')){
              $value['link'] = '<a class="btn btn-xs btn-success" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'">Setujui</a>';
            }
            else{
              $value['link'] = '<a class="btn btn-xs btn-primary" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'">Lihat</a>';
            }
            $value['status'] = Helpers::label_status($value['doc_signing'],$value['doc_status'],$value['doc_signing_reason']);
            $value['sup_name']= $value->supplier->bdn_usaha.'.'.$value->supplier->nm_vendor;
            // $value['supplier']['nm_vendor'] = $value->supplier->bdn_usaha.'.'.$value->supplier->nm_vendor;
            // $value->doc_title = $value->doc_title.' <i>'.$value->supplier_id.'</i>';
            return $value;
          });

          return Response::json($documents);
     }
      $data['page_title'] = 'Data Dokumen '.ucfirst($status);
      $data['doc_status'] = $status;
      return view('documents::index')->with($data);
    }
    public function view(Request $request)
    {
      $id = $request->id;
      $doc_type = DocType::where('name','=',$request->type)->first();
      $dt = $this->documents->where('id','=',$id)->with('jenis','supplier','pic')->first();

      $boq = $this->documents->where('documents.id','=',$id)
            ->join('doc_boq', 'documents.id', '=', 'doc_boq.documents_id')
            ->select('doc_boq.*')
            ->get();

      $pgw = $this->documents->where('documents.id','=',$id)
            ->join('pegawai', 'documents.doc_pihak1_nama', '=', 'pegawai.n_nik')
            ->select('pegawai.v_nama_karyawan as nama_pegawai')
            ->first();

      $meta_lt = $this->documents
            ->where('documents.id','=',$id)
            ->where('meta_type','latar_belakang')
            ->join('doc_meta', 'documents.id', '=', 'doc_meta.documents_id')
            ->select('doc_meta.*')
            ->get();

      $meta_sc = $this->documents
            ->where('documents.id','=',$id)
            ->where('meta_type','scope_perubahan')
            ->join('doc_meta', 'documents.id', '=', 'doc_meta.documents_id')
            ->select('doc_meta.*')
            ->get();

      $meta_ps = $this->documents
            ->where('documents.id','=',$id)
            ->where('meta_type','pasal_pasal')
            ->join('doc_meta', 'documents.id', '=', 'doc_meta.documents_id')
            ->select('doc_meta.*')
            ->get();

      // dd($meta);
      $no_kontrak=$this->documents->create_no_kontrak($dt->doc_template_id,$id);
      $loker=$this->documents->get_loker($id);
      // dd($loker);
      if(!$doc_type || !$dt){
        abort(404);
      }
      $data['doc_type'] = $doc_type;
      $data['boq'] = $boq;
      $data['meta_lt'] = $meta_lt;
      $data['meta_sc'] = $meta_sc;
      $data['meta_ps'] = $meta_ps;
      $data['pgw']  = $pgw;
      $data['no_kontrak']  = $no_kontrak;
      $data['no_loker']  = $loker;
      $data['page_title'] = 'View Kontrak - '.$doc_type['title'];
      $data['doc'] = $dt;
      $data['id'] = $id;

      return view('documents::view')->with($data);
    }
    public function getPo(Request $request){
      $search = trim($request->po);

      if (empty($search)) {
        return Response::json(['status'=>false]);
      }
      $sql = \DB::table('dummy_po')->where('no_po','=',$search)->get();
      return Response::json(['status'=>true,'data'=>$sql,'length'=>count($sql)]);
    }

    public function getPic(Request $request){
      $search = trim($request->id_user);
      if (empty($search)) {
          abort(500);
      }
      $sql = \DB::table('dummy_pic')->where('id_user','=',$search)->get();
      return Datatables::of($sql)
          ->addIndexColumn()
          ->make(true);
    }
    public function approve(Request $request)
    {
      if ($request->ajax()) {
        $doc = $this->documents->where('id',$request->id)->whereNull('doc_no')->first();
        if($doc){
          $doc->doc_no = $this->documents->create_no_kontrak($doc->doc_template_id,$doc->id);
          $doc->doc_signing = 1;
          $doc->doc_status = 0;
          $doc->doc_signing_date = \DB::raw('NOW()');
          $doc->doc_data =  json_encode(['signing_by_userid'=>\Auth::id()]);
          $doc->save();
          //$request->session()->flash('alert-success', 'Data berhasil disetujui!');
          return Response::json(['status'=>true,'doc_no'=>$doc->doc_no,'csrf_token'=>csrf_token()]);
        }
        return Response::json(['status'=>false]);
      }
      abort(500);
    }
    public function reject(Request $request)
    {
      if ($request->ajax()) {
        $doc = $this->documents->where('id',$request->id)->whereNull('doc_no')->first();
        if($doc){
          $rules['reason'] = 'required|min:5|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
          $validator = Validator::make($request->all(), $rules,['reason.required'=>'Alasan harus diisi!','reason.regex'=>'Format penulisan tidak valid!','reason.min'=>'Inputan minimal 5 karakter']);
          if ($validator->fails ()){
            return Response::json(['status'=>false,'msg'=>$validator->errors()->first()]);
          }
          else{
            $doc->doc_status = 1;
            $doc->doc_signing_date   = \DB::raw('NOW()');
            $doc->doc_signing_reason = $request->reason;
            $doc->doc_data =  json_encode(['rejected_by_userid'=>\Auth::id()]);
            $doc->save();
            //$request->session()->flash('alert-success', 'Data berhasil disetujui!');
            return Response::json(['status'=>true,'doc_no'=>$doc->doc_no,'csrf_token'=>csrf_token()]);
          }
        }
        return Response::json(['status'=>false,'msg'=>'Dokumen tidak ditemukan']);
      }
      abort(500);
    }
    public function getSelectKontrak(Request $request){
        $search = trim($request->q);
        $type = trim($request->type);//sp,amandemen,adendum dll

        if (empty($type)) {
            return \Response::json([]);
        }
        $data = $this->documents->select('documents.id','documents.doc_no','documents.doc_date','documents.doc_title','documents.doc_template_id','documents.supplier_id')
        ->with('jenis','supplier','pic')->whereNotNull('documents.doc_no')->where('documents.doc_parent',1);
        if($type=='sp'){
          $data->where('documents.doc_type','khs');
        }
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('documents.doc_no', 'like', '%'.$search.'%');
              $q->orWhere('documents.doc_title', 'like', '%'.$search.'%');
          });
        }
        if(!\Auth::user()->hasRole('admin')){
          $data->join('users_pegawai','users_pegawai.users_id','=','documents.user_id');
          $data->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');
          $data->where('pegawai.objiddivisi',\App\User::get_divisi_by_user_id());
        }
        $data = $data->paginate(30);
        //dd($data);
        $data->getCollection()->transform(function ($value) use ($type){
          $types=DocType::select('id')->where('name',$type)->first();
          $temp = DocTemplate::select('id')->where('id_doc_type', $types->id)->first();
          if($type=='sp'){
            $doc = Documents::where('doc_parent', 0)->where('doc_type','sp')->where('doc_template_id', $temp->id)->get();
          }
          else{
           $doc = Documents::where('doc_parent', 0)->where('doc_parent_id', $value['id'])->where('doc_template_id', $temp->id)->get();
          }
          
          $value['type'] = json_encode($doc->toArray());
          return $value;
        });
        return \Response::json($data);
    }

    public function getSelectSp(Request $request){
        $search = trim($request->q);
        $type = trim($request->type);//sp,amandemen,adendum dll
        $type_id = trim($request->type_id);//sp,amandemen,adendum dll

        if (empty($type)) {
            return \Response::json([]);
        }
        $data = $this->documents
                     ->select('documents.id','documents.doc_no','documents.doc_startdate','documents.doc_enddate','documents.doc_parent_id','documents.doc_title','documents.doc_template_id','documents.supplier_id')
                     ->with('jenis','supplier','pic')
                      ->where('documents.doc_type','sp')
                      ->whereNotNull('documents.doc_no')
                      ->where('documents.doc_parent',0);
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('documents.doc_no', 'like', '%'.$search.'%');
              $q->orWhere('documents.doc_title', 'like', '%'.$search.'%');
          });
        }
        if(!\Auth::user()->hasRole('admin')){
          $data->join('users_pegawai','users_pegawai.users_id','=','documents.user_id');
          $data->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');
          $data->where('pegawai.objiddivisi',\App\User::get_divisi_by_user_id());
        }
        $data = $data->paginate(30);
        // dd($data);
        $data->getCollection()->transform(function ($value) use ($type){
          $type=DocType::select('id')->where('name',$type)->first();
          $temp = DocTemplate::select('id')->where('id_doc_type', $type->id)->first();
          $doc = Documents::where('doc_parent', 0)->where('doc_parent_id', $value['id'])->where('doc_template_id', $temp->id)->get();
          $doc_parent = Documents::select('doc_title','doc_date')->where('id', $value['doc_parent_id'])->first();
          $value['parent_title'] = $doc_parent->doc_title;
          $value['parent_date'] = $doc_parent->doc_date;
          $value['type'] = json_encode($doc->toArray());
          return $value;
        });
        return \Response::json($data);
    }
    public function getPosisi(Request $request){
        $unit = trim($request->unit);

        if (empty($unit)) {
            return \Response::json([]);
        }
        $data = \App\User::get_posisi_by_unit($unit)->get();
        return \Response::json($data);
    }
}
