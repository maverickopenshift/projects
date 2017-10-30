<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Datatables;
use Validator;
use Response;

class DocTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['page_title'] = 'Template Pasal-Pasal';
        return view('documents::doc-template.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Template Pasal-Pasal';
        $data['data_action'] = route('doc.template.store');
        $data['data_class'] = 'form-add';
        return view('documents::doc-template.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $rules = array (
          'type' => 'required',
          'category' => 'required|unique:doc_template,id_doc_type|unique:doc_template,id_doc_category',
          'pasal.*' => 'required|min:3|max:20',
          'isi.*' => 'required|min:10',
          'judul.*' => 'required|min:5',
      );
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails ())
          return Response::json (array(
              'errors' => $validator->getMessageBag()->toArray()
          ));
      else {
          // $data = new BadanUsaha();
          // $data->text = $request->text;
          // $data->save ();
          // return response()->json($data);
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
}
