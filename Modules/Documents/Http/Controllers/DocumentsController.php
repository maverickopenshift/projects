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
          // $documents->getCollection()->transform(function ($value) {
          //   $value->doc_title = $value->doc_title.' <i>'.$value->supplier_id.'</i>';
          //   return $value;
          // });
          return Response::json($documents);
      }

      //return view('articles.index', compact('articles'));
      return view('documents::index');
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
}
