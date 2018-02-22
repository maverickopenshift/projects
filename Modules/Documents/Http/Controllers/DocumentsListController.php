<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Response;

use Modules\Documents\Entities\Documents;
use App\Helpers\Helpers;

class DocumentsListController extends Controller
{
  protected $documents;
  public function __construct(Documents $doc)
  {
      $this->documents = $doc;
  }

  public function list($request,$status_no)
  {
    $status = $request->status;
    if(\Laratrust::hasRole('konseptor')){
      if($status=='tracking'){
        $status_no = 0;
      }
      if($status=='proses'){
        $status_no = 3;
      }
      if($status=='draft'){
        $status_no = 2;
      }
    }

    if ($request->ajax()) {
        $limit = 25;
        $search = $request->q;
        $unit = $request->unit;
        $posisi = $request->posisi;
        $divisi = $request->divisi;
        $jenis = $request->jenis;
        if(!empty($request->limit)){
          $limit = $request->limit;
        }
        
        $documents = $this->documents->latest('documents.updated_at');
        $documents->selectRaw('DISTINCT (documents.id) , documents.*');
        $documents->whereRaw('(documents.`doc_signing`='.$status_no.')');

        if(!empty($request->q)){
          $documents->where(function($q) use ($search) {
              $q->orWhere('documents.doc_no', 'like', '%'.$search.'%');
              $q->orWhere('documents.doc_title', 'like', '%'.$search.'%');
          });
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
        if(!empty($jenis)){
          $documents->where('documents.doc_type',$jenis);
        }

        if(!\Auth::user()->hasRole('admin')){
          $documents->join('users_pegawai','users_pegawai.users_id','=','documents.user_id');
          $documents->join('pegawai','pegawai.n_nik','=','users_pegawai.nik');
          $documents->where('pegawai.objiddivisi',\App\User::get_divisi_by_user_id());
        }
        $documents = $documents->with(['pegawai','users','jenis','supplier','pic']);
        $documents = $documents->paginate($limit);
        
        $documents->getCollection()->transform(function ($value) use ($status_no) { 
          if($value['doc_signing'] != '2'){
            $n_nik = $value->pegawai->n_nik;
            $v_nama_karyawan = $value->pegawai->v_nama_karyawan;
          }else{
            $username = $value->users->username;
            $name = $value->users->name;
          }
          
          $value['total_child']=0;
          $edit = '';
          if($value['doc_signing']==0 && \Laratrust::can('approve-kontrak')){
            $view = '<a class="btn btn-xs btn-primary" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-eye"></i> PERLU DI PROSES </a>';
          }else{
            $view = '<a class="btn btn-xs btn-primary" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-eye"></i> LIHAT</a>';
          }

          if(!\Laratrust::hasRole('approver') && !\Laratrust::hasRole('monitor') ){
            $edit = '<a class="btn btn-xs btn-info" href="'.route('doc.edit',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-edit"></i> EDIT</a>';
          }

          if($status_no == "0"){
            $value['link'] = $view;
          }else {
            $value['link'] = $view.$edit;
          }

          if($value['doc_signing'] == '0'){
            $value['status'] = Helpers::label_status($value['doc_signing'],$value['doc_status'],$value['doc_signing_reason'])." <small> : ".$v_nama_karyawan." (".$n_nik.")</small>";
          }else{
            $value['status'] = Helpers::label_status($value['doc_signing'],$value['doc_status'],$value['doc_signing_reason'])." <small> To ".$name." (".$username.")</small>";
          }

          $value['sup_name']= $value->supplier->bdn_usaha.'.'.$value->supplier->nm_vendor;

          //split judul kontrak (||)
          $myArray = explode('||', $value->doc_title);
          $doc_no = (!empty($value->doc_no))?' - '.$value->doc_no:'';
          $value['title'] = $myArray[0].Documents::get_parent_title($value).$doc_no;
          return $value;
          
        });
        
        return Response::json($documents);
    }
    $data['page_title'] = 'Data Dokumen '.ucfirst($status);
    $data['doc_status'] = $status;
    return view('documents::list-others')->with($data);
  }
}
