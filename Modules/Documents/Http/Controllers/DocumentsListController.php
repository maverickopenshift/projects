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
    }
    if ($request->ajax()) {
        $limit = 25;
        $search = $request->q;
        $unit = $request->unit;
        $posisi = $request->posisi;
        $jenis = $request->jenis;
        if(!empty($request->limit)){
          $limit = $request->limit;
        }
        $documents = $this->documents
            ->latest('documents.updated_at')
        ;
        $documents->selectRaw('DISTINCT (documents.id) , documents.*');
        $documents->whereRaw('(documents.`doc_signing`='.$status_no.')');
        if(!empty($request->q)){
          $documents->where(function($q) use ($search) {
              $q->orWhere('documents.doc_no', 'like', '%'.$search.'%');
              $q->orWhere('documents.doc_title', 'like', '%'.$search.'%');
          });
        }
        if(!empty($unit)){
          $documents->join('users_pegawai as up','up.users_id','=','documents.user_id');
          $documents->join('pegawai as g','g.n_nik','=','up.nik');
          if(!empty($posisi)){
            $documents->where('g.objidposisi',$posisi);
          }
          $documents->where('g.objidunit',$unit);
        }
        if(!empty($jenis)){
          $documents->where('documents.doc_type',$jenis);
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
          $value['total_child']=0;
          $edit = '';
          if($value['doc_signing']==0 && \Laratrust::can('approve-kontrak')){
            $view = '<a class="btn btn-xs btn-primary" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-eye"></i> LIHAT</a>';
          }
          else{
            $view = '<a class="btn btn-xs btn-primary" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-eye"></i> LIHAT</a>';
          }
          if(!\Laratrust::hasRole('approver') ){
            $edit = '<a class="btn btn-xs btn-info" href="'.route('doc.edit',['type'=>$value['doc_type'],'id'=>$value['id']]).'"><i class="fa fa-edit"></i> EDIT</a>';
          }
          $value['link'] = $view.$edit;
          $value['status'] = Helpers::label_status($value['doc_signing'],$value['doc_status'],$value['doc_signing_reason']);
          $value['sup_name']= $value->supplier->bdn_usaha.'.'.$value->supplier->nm_vendor;
          $value['title'] = $value->doc_title.Documents::get_parent_title($value);
          // $value['supplier']['nm_vendor'] = $value->supplier->bdn_usaha.'.'.$value->supplier->nm_vendor;
          // $value->doc_title = $value->doc_title.' <i>'.$value->supplier_id.'</i>';
          return $value;
        });
        return Response::json($documents);
    }
    $data['page_title'] = 'Data Dokumen '.ucfirst($status);
    $data['doc_status'] = $status;
    return view('documents::list-others')->with($data);
  }
}
