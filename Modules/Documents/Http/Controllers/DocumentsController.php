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
          $documents = $this->documents->latest('created_at')->paginate($limit);
          $documents->getCollection()->transform(function ($value) {
            $value['link'] = '<a class="btn btn-xs btn-success" href="'.route('doc.view',['type'=>$value['doc_type'],'id'=>$value['id']]).'">Setujui</a>';
            // $value->doc_title = $value->doc_title.' <i>'.$value->supplier_id.'</i>';
            return $value;
          });
          return Response::json($documents);
      }

      //return view('articles.index', compact('articles'));
      return view('documents::index');
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
        return Response::json(['status'=>true]);
      }
      abort(500);
    }
}
