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
      if ($request->ajax()) {
          $limit = 25;
          if(!empty($request->limit)){
            $limit = $request->limit;
          }
          $documents = $this->documents->latest('created_at')->where('doc_parent',1)->with('jenis','supplier','pic')->paginate($limit);
          $documents->getCollection()->transform(function ($value) {
            $sp = $this->documents->get_child('sp',$value['id']);
            $aman_sp = $this->documents->get_child('amandemen_sp',$value['id']);
            $aman_kon = $this->documents->get_child('amandemen_kontrak',$value['id']);
            $adendum = $this->documents->get_child('adendum',$value['id']);
            $side_letter = $this->documents->get_child('side_letter',$value['id']);
            if($sp>0 || $aman_sp>0 || $aman_kon>0 || $adendum>0 || $side_letter>0){
              $value['doc_no'] = $value['doc_no'].'<br/>'
              .Helpers::create_button('SP',$sp)
              .Helpers::create_button('Amandemen SP',$aman_sp,'info')
              .Helpers::create_button('Amandemen Kontrak',$aman_kon,'danger')
              .Helpers::create_button('Adendum',$adendum,'warning')
              .Helpers::create_button('Side Letter',$side_letter,'info');
            }
            if($value['doc_signing']==0){
              $value['link'] = '<a class="btn btn-xs btn-success" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'">Setujui</a>';
            }
            else{
              $value['link'] = '<a class="btn btn-xs btn-primary" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'">Lihat</a>';
            }
            $value['supplier']['nm_vendor'] = $value->supplier->bdn_usaha.'.'.$value->supplier->nm_vendor;
            // $value->doc_title = $value->doc_title.' <i>'.$value->supplier_id.'</i>';
            return $value;
          });
          return Response::json($documents);
     }

      $data['page_title'] = 'Data Kontrak';
      return view('documents::index')->with($data);
    }
    public function view(Request $request)
    {
      $id = $request->id;
      $doc_type = DocType::where('name','=',$request->type)->first();
      $dt = $this->documents->where('id','=',$id)->with('jenis','supplier','pic')->first();
      //dd($dt);
      if(!$doc_type || !$dt){
        abort(404);
      }
      $data['doc_type'] = $doc_type;
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
          $doc->doc_no = $this->documents->create_no_kontrak($doc->doc_template_id);
          $doc->doc_signing = 1;
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

    public function getSelectKontrak(Request $request){
        $search = trim($request->q);
        $type = trim($request->type);//sp,amandemen,adendum dll

        if (empty($type)) {
            return \Response::json([]);
        }
        $data = $this->documents->select('id','doc_no','doc_date','doc_title','doc_template_id','supplier_id')->with('jenis','supplier','pic')->whereNotNull('doc_no')->where('doc_parent',1);
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('doc_no', 'like', '%'.$search.'%');
              $q->orWhere('doc_title', 'like', '%'.$search.'%');
          });
        }
        $data = $data->paginate(30);
        //dd($data);
        $data->getCollection()->transform(function ($value) use ($type){
          $type=DocType::where('name',$type)->first();
          $temp = DocTemplate::where('id_doc_type', $type->id)->first();
          $doc = Documents::where('doc_parent', 0)->where('doc_parent_id', $value['id'])->where('doc_template_id', $temp->id)->get();
          $value['type'] = json_encode($doc->toArray());
          return $value;
        });
        return \Response::json($data);
    }

    public function getSelectSp(Request $request){
        $search = trim($request->q);
        $type = trim($request->type);//sp,amandemen,adendum dll

        if (empty($type)) {
            return \Response::json([]);
        }
        $data = $this->documents->select('id','doc_no','doc_date','doc_title','doc_template_id','supplier_id')->with('jenis','supplier','pic')->whereNotNull('doc_no')->where('doc_parent',0);
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('doc_no', 'like', '%'.$search.'%');
              $q->orWhere('doc_title', 'like', '%'.$search.'%');
          });
        }
        $data = $data->paginate(30);
        // dd($data);
        $data->getCollection()->transform(function ($value) use ($type){
          $type=DocType::where('name',$type)->first();
          $temp = DocTemplate::where('id_doc_type', $type->id)->first();
          $doc = Documents::where('doc_parent', 0)->where('doc_parent_id', $value['id'])->where('doc_template_id', $temp->id)->get();
          $value['type'] = json_encode($doc->toArray());
          return $value;
        });
        return \Response::json($data);
    }
}
