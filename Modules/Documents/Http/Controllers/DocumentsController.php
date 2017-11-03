<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Datatables;
use Response;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
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
          abort(500);
      }
      $sql = \DB::table('dummy_po')->where('no_po','=',$search)->get();
      dd($sql);
      return Datatables::of($sql)
          ->addIndexColumn()
          ->make(true);
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
