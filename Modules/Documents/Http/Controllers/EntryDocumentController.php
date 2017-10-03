<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\Documents;

class EntryDocumentController extends Controller
{
    protected $fields=[];
    public function __construct(Request $req){
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
        $data['page_title'] = 'Entry Dokumen Baru - '.$doc_type['title'];
        $data['doc_type'] = $doc_type;
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
}
