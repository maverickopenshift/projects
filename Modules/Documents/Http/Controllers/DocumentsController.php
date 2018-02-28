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
use Modules\Documents\Entities\DocActivity;
use Modules\Documents\Entities\DocComment as Comments;
use Modules\Documents\Http\Controllers\DocumentsListController as DocList;
use Modules\Documents\Entities\DocChildLatest;
use App\Helpers\Helpers;
use Excel;
use Validator;
use Auth;

use Modules\Documents\Entities\Sap;

class DocumentsController extends Controller
{
    protected $documents;
    protected $docList;

    public function __construct(Documents $documents,DocList $docList)
    {
        $this->documents = $documents;
        $this->docList = $docList;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
      
      $status = $request->status;
      $status_arr = ['proses','selesai','draft','tracking','tutup','close'];
      if(!in_array($status,$status_arr)){
        abort(404);
      }
      foreach ($status_arr as $key => $st){
        if($status==$st){
          $status_no = $key;
        }
      }

      if($status=="tutup"){
        $status_no = '1';
      }else if($status=="close"){
        $status_no='4';
      }

      if($status!=='selesai' && $status!=='tutup' && $status!=='close'){
        return $this->docList->list($request,$status_no);
      }

      if ($request->ajax()) {
          $limit = 25;
          $search = $request->q;
          $unit = $request->unit;
          $posisi = $request->posisi;
          $divisi = $request->divisi;
          $jenis = $request->jenis;
          $open = $request->open;
          $range = $request->range;
          $dari = $request->dari;
          $sampai = $request->sampai;

          if(!empty($open)){            
            if($open==1){
              $status_no=1;
            }elseif($open==2){
              $status_no=4;
            }
          }

          if(!empty($request->limit)){
            $limit = $request->limit;
          }

          if(in_array($request->child,[1,2,3])){
            $documents = $this->documents->oldest('documents.created_at');

            $documents->leftJoin('documents as child','child.doc_parent_id','=','documents.id');
            $documents->leftJoin('documents as child2','child2.doc_parent_id','=','child.id');
            $documents->where('documents.doc_parent',0);
            $documents->where('documents.doc_parent_id',$request->parent_id);
            $documents->whereRaw('(child.`doc_signing`='.$status_no.' OR child2.`doc_signing`='.$status_no.' OR documents.`doc_signing`='.$status_no.')');
            $documents->selectRaw('DISTINCT (documents.id) , documents.*');
          }
          else{
            $documents = $this->documents->latest('documents.updated_at');

            $documents->leftJoin('documents as child','child.doc_parent_id','=','documents.id');
            $documents->leftJoin('documents as child2','child2.doc_parent_id','=','child.id');
            $documents->leftJoin('documents as child3','child3.doc_parent_id','=','child2.id');
            $documents->selectRaw('DISTINCT (documents.id) , documents.*');
            $documents->where('documents.doc_parent',1);

            $documents->whereRaw('(child.`doc_signing`='.$status_no.' OR child2.`doc_signing`='.$status_no.' OR child3.`doc_signing`='.$status_no.' OR documents.`doc_signing`='.$status_no.')');
            if(!empty($request->q)){
              $documents->where(function($q) use ($search) {
                  $q->orWhere('documents.doc_no', 'like', '%'.$search.'%');
                  $q->orWhere('documents.doc_title', 'like', '%'.$search.'%');
                      $q->orWhere('child.doc_no', 'like', '%'.$search.'%');
                      $q->orWhere('child.doc_title', 'like', '%'.$search.'%');
                          $q->orWhere('child2.doc_no', 'like', '%'.$search.'%');
                          $q->orWhere('child2.doc_title', 'like', '%'.$search.'%');
                              $q->orWhere('child3.doc_no', 'like', '%'.$search.'%');
                              $q->orWhere('child3.doc_title', 'like', '%'.$search.'%');
              });
            }
            if(!empty($jenis)){
              $documents->where(function($q) use ($jenis) {
                  $q->orWhere('documents.doc_type',$jenis);
                  $q->orWhere('child.doc_type',$jenis);
                  $q->orWhere('child2.doc_type',$jenis);
                  $q->orWhere('child3.doc_type',$jenis);
              });
            }
            if(!empty($range)){
              $documents->where(function($q) use ($range) {
                $q->orwhereRaw("documents.doc_enddate >= last_day(now()) + interval 1 day - interval $range month");
                $q->orwhereRaw("child.doc_enddate >= last_day(now()) + interval 1 day - interval $range month");
                $q->orwhereRaw("child2.doc_enddate >= last_day(now()) + interval 1 day - interval $range month");
                $q->orwhereRaw("child3.doc_enddate >= last_day(now()) + interval 1 day - interval $range month");
              });
            }
            if(!empty($dari)){

              $documents->where(function($q) use ($dari) {
                $q->orwhere('documents.doc_enddate','>=',"$dari");
                $q->orwhere('child.doc_enddate','>=',"$dari");
                $q->orwhere('child2.doc_enddate','>=',"$dari");
                $q->orwhere('child3.doc_enddate','>=',"$dari");
              });
            }
            if(!empty($sampai)){
              $documents->where(function($q) use ($sampai) {
                $q->orwhere('documents.doc_enddate','<=',"$sampai");
                $q->orwhere('child.doc_enddate','<=',"$sampai");
                $q->orwhere('child2.doc_enddate','<=',"$sampai");
                $q->orwhere('child3.doc_enddate','<=',"$sampai");
              });
            }
          }

          if(!empty($divisi) && \Auth::user()->hasRole('admin')){
            $documents->join('users_pegawai as up','up.users_id','=','documents.user_id');
            $documents->join('pegawai as g','g.n_nik','=','up.nik');
            $documents->where('g.objiddivisi',$divisi);
          }

          if(!empty($unit) && !empty($divisi)){
            if(!empty($posisi)){
              $documents->where('g.objidposisi',$posisi);
            }
            $documents->where('g.objidunit',$unit);
          }

          if(!\Auth::user()->hasRole('admin')){
            $documents->join('users_pegawai','users_pegawai.users_id','=','documents.user_id');
            $documents->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');
            $documents->where('pegawai.objiddivisi',\App\User::get_divisi_by_user_id());
          }
          else{

          }

          $documents = $documents->with(['jenis','supplier','pic']);
          $documents = $documents->paginate($limit);
          $documents->getCollection()->transform(function ($value)use ($status_no,$status) {

            $value['total_child']=$this->documents->total_child($value['id'],$status_no);

            $edit = '';
            if($value['doc_signing']==0 && \Laratrust::can('approve-kontrak')){
              $view = '<a class="btn btn-xs btn-primary" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-eye"></i> PERLU DI PROSES </a>';
            }else{
              $view = '<a class="btn btn-xs btn-primary" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-eye"></i> LIHAT</a>';
            }

            if(!\Laratrust::hasRole('approver') && !\Laratrust::hasRole('monitor') ){
              $edit = '<a class="btn btn-xs btn-info" href="'.route('doc.edit',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-edit"></i> EDIT</a>';
            }

            if($status=='tutup' && \Laratrust::can('tutup-kontrak')){
                $tutup = '<a class="btn btn-xs btn-danger" href="'.route('doc.closing',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-close"></i> CLOSING</a>';
            }

            if($status == 'tutup'){
              if($value['doc_parent_id']==null){
                $value['link'] = $view.$edit.$tutup;
              }else{
                if($value['doc_parent_id']!=null && $value['doc_type']=="sp"){
                  $value['link'] = $view.$edit.$tutup;
                }else{
                  $value['link'] = $view.$edit;
                }
              }
            }else{
              $value['link'] = $view.$edit;
            }

            if($value['doc_signing']==4){
              $value['link'] = $view;
            }

            $value['status'] = Helpers::label_status($value['doc_signing'],$value['doc_status'],$value['doc_signing_reason']);
            $value['sup_name']= $value->supplier->bdn_usaha.'.'.$value->supplier->nm_vendor;
            $doc_no = (!empty($value->doc_no))?' - '.$value->doc_no:'';
            $myArray = explode('||', $value->doc_title);
            $value['title'] = $myArray[0].$doc_no;
            return $value;
          });

          return Response::json($documents);
     }
      $data['page_title'] = 'Data Dokumen '.ucfirst($status);
      $data['doc_status'] = $status;
      return view('documents::list-selesai')->with($data);
    }

    public function view(Request $request)
    {
      $id = $request->id;
      $doc_type = DocType::where('name','=',$request->type)->first();
      $dt = $this->documents->where('id','=',$id)->with('pemilik_kontrak','jenis','supplier','pic','boq','lampiran_ttd','latar_belakang','pasal','asuransi','scope_perubahan','po','sow_boq','latar_belakang_surat_pengikatan','latar_belakang_mou','scope_perubahan_side_letter','latar_belakang_optional','latar_belakang_ketetapan_pemenang','latar_belakang_kesanggupan_mitra','latar_belakang_rks')->first();

      if(!$doc_type || !$dt){
        abort(404);
      }
      if(!$this->documents->check_permission_doc($id,$doc_type->name)){
        abort(404);
      }
      if(in_array($request->type,['khs','turnkey'])){
        if(count($dt->latar_belakang_surat_pengikatan)>0){
          foreach($dt->latar_belakang_surat_pengikatan as $key => $val){
            $query_latar_belakang_surat_pengikatan=$this->documents->selectRaw("id,doc_title,doc_no,doc_startdate,doc_enddate")->where('id','=',$val->meta_desc)->with('lampiran_ttd')->first();
          }
          $data['latar_belakang_surat_pengikatan']=$query_latar_belakang_surat_pengikatan;
        }

        if(count($dt->latar_belakang_mou)>0){
          foreach($dt->latar_belakang_mou as $key => $val){
            $query_latar_belakang_mou=$this->documents->selectRaw("id,doc_title,doc_no,doc_startdate,doc_enddate")->where('id','=',$val->meta_desc)->with('lampiran_ttd')->first();
          }
          $data['latar_belakang_mou']=$query_latar_belakang_mou;
        }
      }
      $data['doc_type'] = $doc_type;
      $data['page_title'] = 'View Kontrak - '.$doc_type['title'];
      $data['doc'] = $dt;
      $data['id'] = $id;

      $data['pegawai'] = \App\User::get_user_pegawai();
      $data['pegawai_pihak1'] = \DB::table('pegawai')->where('n_nik',$dt->doc_pihak1_nama)->first();
      $data['pegawai_konseptor'] = \DB::table('users_pegawai as a')
                                  ->join('pegawai as b','a.nik','=','b.n_nik')
                                  ->where('a.users_id',$dt->user_id)->first();
      $data['doc_parent'] = \DB::table('documents')->where('id',$dt->doc_parent_id)->first();

      $objiddivisi=$dt->pemilik_kontrak->meta_name;
      $objidunit=$dt->pemilik_kontrak->meta_title;
      $data['divisi'] = \DB::table('rptom')->where('objiddivisi',$objiddivisi)->first();
      $data['unit_bisnis'] = \DB::table('rptom')->where('objidunit',$objidunit)->first();

      // dd($data);
      return view('documents::view')->with($data);
    }

    public function getPo(Request $request){

      $search = trim($request->po);

      if (empty($search)) {
        return Response::json(['status'=>false]);
      }
      if(config('app.env')=='production'){
        $sap = Sap::get_po($search);
        return Response::json($sap);
      }
      else{
        $sql = \DB::table('dummy_po')->where('no_po','=',$search)->get();
        return Response::json(['status'=>true,'data'=>$sql,'length'=>count($sql)]);
      }
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

    public function getKontrak(Request $request)
    {
      if ($request->ajax()) {

        $doc = $this->documents->where('documents.id',$request->id)->whereNull('doc_no')
                               ->join('pegawai', 'documents.doc_pihak1_nama', '=', 'pegawai.n_nik')
                               ->select('documents.*', 'pegawai.n_nik', 'pegawai.v_nama_karyawan', 'pegawai.v_short_posisi', 'pegawai.c_kode_unit', 'pegawai.v_short_unit')
                               ->first();
        if($doc){
          $no_kontrak=$this->documents->create_no_kontrak($doc->doc_template_id,$doc->id);
          $loker=$this->documents->get_loker($doc->id);

          $data['judul'] = $doc->doc_title;
          $data['nik'] = $doc->n_nik;
          $data['nama_pgw'] = $doc->v_nama_karyawan;
          $data['jabatan'] = $doc->v_short_posisi;
          $data['loker'] = $doc->c_kode_unit;
          $data['nama_loker'] = $doc->v_short_unit;
          // dd($jdl_kontrak);

          return Response::json(['status'=>true,'doc_no'=>$no_kontrak, 'doc_loker'=>$loker, 'data'=>$data]);
        }
        return Response::json(['status'=>false]);
      }
      abort(500);
      // dd("hai");
    }

    public function approve(Request $request)
    {
      if ($request->ajax()) {
        if($request->no_kontrak == null){
          $doc = $this->documents->where('id',$request->id)->whereNull('doc_no')->first();

          $doc->doc_no = $this->documents->create_no_kontrak($doc->doc_template_id,$doc->id);
          $doc->doc_signing = 1;
          $doc->doc_status = 0;
          $doc->doc_signing_date = \DB::raw('NOW()');
          $doc->doc_data =  json_encode(['signing_by_userid'=>\Auth::id()]);
          $doc->save();
        }else{
          $doc = $this->documents->where('id',$request->id)->first();

          $doc->doc_signing = 1;
          $doc->doc_status = 0;
          $doc->doc_signing_date = \DB::raw('NOW()');
          $doc->doc_data =  json_encode(['signing_by_userid'=>\Auth::id()]);
          $doc->save();
        }
        if($doc){

          $comment = new Comments();
          $comment->content = $request->komentar;
          $comment->documents_id = $request->id;
          $comment->users_id = \Auth::id();
          $comment->status = 1;
          $comment->data = "Approved";
          $comment->save();

          // $log_activity = new DocActivity();
          // $log_activity->users_id = Auth::id();
          // $log_activity->documents_id = $request->id;
          // $log_activity->activity = "Approved";
          // $log_activity->date = new \DateTime();
          // $log_activity->save();

          //$request->session()->flash('alert-success', 'Data berhasil disetujui!');
          return Response::json(['status'=>true,'doc_no'=>$doc->doc_no,'csrf_token'=>csrf_token()]);
        }
        return Response::json(['status'=>false]);
      }
      abort(500);
    }

    public function hapus(Request $request)
    {
      if ($request->ajax()) {
        if(\Laratrust::hasRole('admin')){
          $doc = $this->documents
              ->where('id',$request->id)
              ->first();
        }else{
          $doc = $this->documents
              ->where('id',$request->id)
              ->where('user_id',Auth::id())
              ->first();
        }
        if($doc){
          $doc->doc_signing = 4;
          $doc->doc_data =  json_encode(['hapus_by_userid'=>\Auth::id()]);
          $doc->save();
          return Response::json(['status'=>true]);
        }
        return Response::json(['status'=>false]);
      }
    }

    public function reject(Request $request)
    {
      if ($request->ajax()) {

        if($request->no_kontrak == ""){
          $doc = $this->documents->where('id',$request->id)->whereNull('doc_no')->first();
        }
        else{
          $doc = $this->documents->where('id',$request->id)->first();
        }
        if($doc){
          $rules['reason'] = 'required|min:5|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i';
          $validator = Validator::make($request->all(), $rules,['reason.required'=>'Alasan harus diisi!','reason.regex'=>'Format penulisan tidak valid!','reason.min'=>'Inputan minimal 5 karakter']);
          if ($validator->fails ()){
            return Response::json(['status'=>false,'msg'=>$validator->errors()->first()]);
          }
          else{
            $doc->doc_status = 0;
            $doc->doc_signing = 3;
            $doc->doc_signing_date   = \DB::raw('NOW()');
            $doc->doc_signing_reason = $request->reason;
            $doc->doc_data =  json_encode(['rejected_by_userid'=>\Auth::id()]);
            $doc->save();

            $comment = new Comments();
            $comment->content = $request->reason;
            $comment->documents_id = $request->id;
            $comment->users_id = \Auth::id();
            $comment->status = 1;
            $comment->data = "Returned";
            $comment->save();

            // $log_activity = new DocActivity();
            // $log_activity->users_id = Auth::id();
            // $log_activity->documents_id = $request->id;
            // $log_activity->activity = "Returned";
            // $log_activity->date = new \DateTime();
            // $log_activity->save();
            $dt_c = Comments::where('id',$comment->id)->with('user')->first();
            //$request->session()->flash('alert-success', 'Data berhasil disetujui!');
            return Response::json(['status'=>true,'doc_no'=>$doc->doc_no,'csrf_token'=>csrf_token(),'data'=>$dt_c]);
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
        $data = $this->documents->select('documents.id','documents.doc_no','documents.doc_date','documents.doc_title','documents.doc_template_id','documents.doc_startdate','documents.doc_enddate','documents.supplier_id')
        ->with('jenis','supplier','pic')->whereNotNull('documents.doc_no')->where('documents.doc_parent',1)->where('documents.doc_signing', 1);
        if($type=='sp'){
          $data->where('documents.doc_type','khs');
        }elseif($type=='mou'){
          $data->where('documents.doc_type','mou');
        }elseif($type=='surat_pengikatan'){
          $data->where('documents.doc_type','surat_pengikatan');
        }elseif($type=='amandemen_kontrak_khs'){
          $data->where('documents.doc_type','khs');
        }elseif($type=='amandemen_kontrak_turnkey'){
          $data->where('documents.doc_type','turnkey');
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

        if($type!="all"){
          $data->getCollection()->transform(function ($value) use ($type){
            $types=DocType::select('id')->where('name',$type)->first();
            $temp = DocTemplate::select('id')->where('id_doc_type', $types->id)->first();
            if($type=='sp'){
              $parent = Documents::select('id')
                          ->where('documents.doc_parent', 0)
                          ->where('documents.doc_type','amandemen_kontrak')
                          ->where('documents.doc_signing', 1)
                          ->where('documents.doc_parent_id', $value['id'])
                          ->get();

                          $valu[] = $value['id'];
                          foreach ($parent as $key => $d) {
                            $valu[] = $d->id;
                          }

                          $doc = Documents::selectRaw('documents.*,doc.doc_title as title,doc.doc_no as num')
                                      ->where('documents.doc_parent', 0)
                                      ->where('documents.doc_type','sp')
                                      ->where('documents.doc_signing', 1)
                                      ->where('documents.doc_template_id', $temp->id)
                                      // ->leftJoin('documents as parent','parent.doc_parent_id','=','documents.id')
                                      ->join('documents as doc','doc.id','=','documents.doc_parent_id')
                                      ->whereIn('documents.doc_parent_id', $valu)
                                      ->orderBy('documents.id', 'asc')
                                      ->get();
                          // dd($doc);
            }
            else{
             $doc = Documents::selectRaw('documents.*')
                        ->where('documents.doc_parent', 0)
                        ->where('documents.doc_signing', 1)
                        ->where('documents.doc_parent_id', $value['id'])
                        ->where('documents.doc_template_id', $temp->id)
                        ->get();
            }

            $ttd=DocMeta::where('meta_type','lampiran_ttd')->where('documents_id',$value['id'])->get();
            $ttd->map(function($item, $key) use ($type){
                $item->url=route('doc.file',['filename'=>$item->meta_file,'type'=>$type.'_lampiran_ttd']);

                return $item;
            });

            $value['lampiran_ttd'] = $ttd;
            $value['type'] = json_encode($doc->toArray());
            return $value;
          });
        }

        return \Response::json($data);
    }

    public function getSelectKontrakSP(Request $request){
      // dd("hai");
        $search = trim($request->q);
        $type = trim($request->type);//sp,amandemen,adendum dll
        if (empty($type)) {
            return \Response::json([]);
        }
        $data = $this->documents->select('documents.id','documents.doc_no','documents.doc_date','documents.doc_title','documents.doc_template_id','documents.doc_startdate','documents.doc_enddate','documents.supplier_id')
        ->with('jenis','supplier','pic')->whereNotNull('documents.doc_no')->where('documents.doc_parent',1)->where('documents.doc_signing', 1)->where('documents.doc_type','khs');

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
        // dd($data->toSql());
        $data = $data->paginate(30);

        $data->getCollection()->transform(function ($value) use ($type){
          $types=DocType::select('id')->where('name',$type)->first();
          $temp = DocTemplate::select('id')->where('id_doc_type', $types->id)->first();
          if($type=='sp'){
            $parent = Documents::select('id')
                        ->where('documents.doc_parent', 0)
                        ->where('documents.doc_type','amandemen_kontrak')
                        ->where('documents.doc_signing', 1)
                        ->where('documents.doc_parent_id', $value['id'])
                        ->get();

                        $valu[] = $value['id'];
                        // // dd(array_splice($parent,0,2,$val));
                        foreach ($parent as $key => $d) {
                          $valu[] = $d->id;
                        }

                        $doc = Documents::selectRaw('documents.*,doc.doc_title as title,doc.doc_no as num')
                                    ->where('documents.doc_parent', 0)
                                    ->where('documents.doc_type','sp')
                                    ->where('documents.doc_signing', 1)
                                    ->where('documents.doc_template_id', $temp->id)
                                    // ->leftJoin('documents as parent','parent.doc_parent_id','=','documents.id')
                                    ->join('documents as doc','doc.id','=','documents.doc_parent_id')
                                    ->whereIn('documents.doc_parent_id', $valu)
                                    ->orderBy('documents.id', 'asc')
                                    ->get();
                        // dd($doc);
          }
          else{
           $doc = Documents::selectRaw('documents.*')
                      ->where('documents.doc_parent', 0)
                      ->where('documents.doc_signing', 1)
                      ->where('documents.doc_parent_id', $value['id'])
                      ->where('documents.doc_template_id', $temp->id)
                      ->get();
          }

          $ttd=DocMeta::where('meta_type','lampiran_ttd')->where('documents_id',$value['id'])->get();
          $ttd->map(function($item, $key) use ($type){
              $item->url=route('doc.file',['filename'=>$item->meta_file,'type'=>$type.'_lampiran_ttd']);

              return $item;
          });

          $value['lampiran_ttd'] = $ttd;
          $value['type'] = json_encode($doc->toArray());
          return $value;
        });


        return \Response::json($data);
    }

    // public function getSelectSp(Request $request){
    //     $search = trim($request->q);
    //     $type = trim($request->type);//sp,amandemen,adendum dll
    //     $type_id = trim($request->type_id);//sp,amandemen,adendum dll
    //
    //     if (empty($type)) {
    //         return \Response::json([]);
    //     }
    //
    //     $data = DocChildLatest::selectRaw('doc_child_latest.*')
    //             ->with('jenis')
    //             ->where('doc_child_latest.doc_type','sp')
    //             ->whereNotNull('doc_child_latest.doc_no')
    //             ->where('doc_child_latest.doc_parent',0);
    //     if(!empty($search)){
    //       $data->where(function($q) use ($search) {
    //           $q->orWhere('doc_child_latest.doc_no', 'like', '%'.$search.'%');
    //           $q->orWhere('doc_child_latest.doc_title', 'like', '%'.$search.'%');
    //       });
    //     }
    //     if(!\Auth::user()->hasRole('admin')){
    //       $data->join('users_pegawai','users_pegawai.users_id','=','doc_child_latest.user_id');
    //       $data->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');
    //       $data->where('pegawai.objiddivisi',\App\User::get_divisi_by_user_id());
    //     }
    //     $data->orderBy('doc_child_latest.created_at','DESC');
    //     // dd($data->toSql());exit;
    //     $data = $data->paginate(30);
    //     // dd($data);
    //     $data->getCollection()->transform(function ($value) use ($type){
    //       $type=DocType::select('id')->where('name',$type)->first();
    //       $temp = DocTemplate::select('id')->where('id_doc_type', $type->id)->first();
    //       $doc = Documents::where('doc_parent', 0)->where('doc_parent_id', $value['id'])->where('doc_template_id', $temp->id)->get();
    //       $doc_parent = Documents::select('doc_title','doc_date','doc_parent_id','doc_no','doc_startdate','doc_enddate')->where('id', $value['doc_parent_id'])->first();
    //       $doc_parent_first = Documents::select('doc_title','doc_date','doc_no','doc_startdate','doc_enddate')->where('id', $doc_parent->doc_parent_id)->first();
    //       $value['parent_title'] = $doc_parent->doc_title;
    //       $parent_first = null;
    //       $parent_no = null;
    //       if($doc_parent_first){
    //         $parent_first = $doc_parent_first->doc_title;
    //         $parent_no = $doc_parent_first->doc_no;
    //       }
    //       $value['parent_title_first'] = $parent_first;
    //       $value['parent_no_first'] = $parent_no;
    //       $value['parent_date'] = $doc_parent->doc_date;
    //       $value['parent_no'] = $doc_parent->doc_no;
    //       $value['type'] = json_encode($doc->toArray());
    //       return $value;
    //     });
    //     return \Response::json($data);
    // }

    public function getSelectSp(Request $request){
        $id_kon = trim($request->id);
        $search = trim($request->q);
        $type = trim($request->type);//sp,amandemen,adendum dll
        $type_id = trim($request->type_id);//sp,amandemen,adendum dll

        if (empty($type)) {
            return \Response::json([]);
        }

          $parent = Documents::select('id')
                      ->where('documents.doc_parent', 0)
                      ->where('documents.doc_type','amandemen_kontrak')
                      ->where('documents.doc_signing', 1)
                      ->where('documents.doc_parent_id', $id_kon)
                      ->get();
                      // dd($parent);

            $valu[] = $id_kon;
            foreach ($parent as $key => $d) {
              $valu[] = $d->id;
            }
            // dd($valu);
            $data = $this->documents->select('documents.id','documents.doc_no','documents.doc_startdate','documents.doc_enddate','documents.doc_parent_id','documents.doc_title','documents.doc_template_id','documents.supplier_id')
                              ->with('jenis','supplier','pic')
                              ->join('documents as doc','doc.id','=','documents.doc_parent_id')
                              ->where('documents.doc_parent', 0)
                              ->where('documents.doc_type','sp')
                              ->where('documents.doc_signing', 1)
                              ->whereIn('documents.doc_parent_id', $valu)
                              ->orderBy('documents.id', 'asc');
                              // ->get();
                        // dd($data);

        // $data = $this->documents
        //              ->select('documents.id','documents.doc_no','documents.doc_startdate','documents.doc_enddate','documents.doc_parent_id','documents.doc_title','documents.doc_template_id','documents.supplier_id')
        //              ->with('jenis','supplier','pic')
        //               ->where('documents.doc_type','sp')
        //               ->whereNotNull('documents.doc_no')
        //               ->where('documents.doc_signing', 1)
        //               ->where('documents.doc_parent',0)
        //               ->where('documents.doc_parent_id',$id_kon);
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('documents.doc_no', 'like', '%'.$search.'%');
              $q->orWhere('documents.doc_title', 'like', '%'.$search.'%');
          });
        }
        // if(!\Auth::user()->hasRole('admin')){
        //   $data->join('users_pegawai','users_pegawai.users_id','=','documents.user_id');
        //   $data->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');
        //   $data->where('pegawai.objiddivisi',\App\User::get_divisi_by_user_id());
        // }
        // dd($data->toSql());
        $data = $data->paginate(30);
        // dd($data);
        $data->getCollection()->transform(function ($value) use ($type){
                $type=DocType::select('id')->where('name',$type)->first();
                $temp = DocTemplate::select('id')->where('id_doc_type', $type->id)->first();
                $doc = Documents::where('doc_parent', 0)->where('doc_parent_id', $value['id'])->where('doc_signing', 1)->where('doc_template_id', $temp->id)->get();
                $doc_parent = Documents::select('doc_title','doc_date','doc_parent_id','doc_no','doc_startdate','doc_enddate')->where('id', $value['doc_parent_id'])->first();
                $doc_parent_first = Documents::select('doc_title','doc_date','doc_no','doc_startdate','doc_enddate')->where('id', $doc_parent->doc_parent_id)->first();
                $value['parent_title'] = $doc_parent->doc_title;
                $parent_first = null;
                $parent_no = null;
                if($doc_parent_first){
                  $parent_first = $doc_parent_first->doc_title;
                  $parent_no = $doc_parent_first->doc_no;
                }
                $value['parent_title_first'] = $parent_first;
                $value['parent_no_first'] = $parent_no;
                $value['parent_date'] = $doc_parent->doc_date;
                $value['parent_no'] = $doc_parent->doc_no;
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

    public function getUnit(Request $request){
        $divisi = trim($request->divisi);

        if (empty($divisi)) {
            return \Response::json([]);
        }
        $data = \App\User::get_unit_by_disivi2($divisi)->get();
        return \Response::json($data);
    }

    public function upload_boq_harga_satuan(Request $request){
      if ($request->ajax()){

        $data = Excel::load($request->file('daftar_harga')->getRealPath(), function ($reader) {
        })->get();

        $header = ['KODE_ITEM','ITEM','SATUAN','MTU','HARGA','HARGA_JASA','KETERANGAN'];
        $colomn = $data->first()->keys()->toArray();
        dd($colomn);

        if(!empty($data) && count($colomn) == 7){
          foreach ($data as $key => $value) {

            $insert[] = ['kode_item' => $value->KODE_ITEM,
                         'item' => $value->ITEM,
                         'satuan' => $value->SATUAN,
                         'mtu' => $value->MTU,
                         'harga' => $value->HARGA,
                         'harga_jasa' => $value->HARGA_JASA,
                         'keterangan' => $value->KETERANGAN,
                       ];
          }

          return Response::json (array(
            'hasil' => $data
          ));
        }else{
          return Response::json (array(
            'error' => $data
          ));
        }
      }

        /*
        $data = Excel::load($request->file('supplier_sap')->getRealPath(), function ($reader) {

        })->get();
        $header = ['cl','vendor','cty','name_1','city','postalcode','rg','searchterm','street','date','title','created_by','group','language','vat_registration_no'];
        $colomn = $data->first()->keys()->toArray();


      if(!empty($data) && count($colomn) == 15){
          foreach ($data as $key => $value) {
            $tgl = date_create($value->date);
            $date = date_format($tgl,"Y/m/d");

            $insert[] = ['users_id' => Auth::id(),
                         'ci' => $value->cl,
                         'vendor' => $value->vendor,
                         'cty' => $value->cty,
                         'name_1' => $value->name_1,
                         'city' => $value->city,
                         'postalcode' => $value->postalcode,
                         'rg' => $value->rg,
                         'searchterm' => $value->searchterm,
                         'street' => $value->street,
                         'title' => $value->title,
                         'date' => $date,
                         'created_by' => $value->created_by,
                         'group' => $value->group,
                         'language' => $value->language,
                         'vat_registration_no' => $value->vat_registration_no,
                         'upload_date' => new \DateTime(),
                         'upload_by' => Auth::user()->username,
                       ];
          }
          if(!empty($insert)){
            DB::table('supplier_sap')->insert($insert);
            // $request->session()->flash('alert-success', 'Data berhasil disimsssssan');
            return Response::json(['status'=>true,'csrf_token'=>csrf_token()]);
          }
          else{
            return Response::json(['status'=>false]);
          }
      }
      else{
        return Response::json(['status'=>false]);
      }
    }
    else{
      return Response::json(['status'=>false]);
    }
    */
  }

  public function upload_boq(Request $request){

  }


}
