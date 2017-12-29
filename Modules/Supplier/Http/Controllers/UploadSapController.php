<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UploadSapController extends Controller
{
  public function store(Request $request)
  {
    dd("hai");

    $upload=$request->file('supplier_sap');
    $filePath=$upload->getRealPath();

    $delimeter = ';';
    $file=fopen($filePath, 'r');

    $header= fgetcsv($file, 1000, $delimeter);

    dd($header);
  }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('supplier::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('supplier::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */


    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('supplier::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('supplier::edit');
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
