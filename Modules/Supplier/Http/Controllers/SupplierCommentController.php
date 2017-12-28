<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
use Modules\Supplier\Entities\SupplierActivity as Comments;
use Validator;

class SupplierCommentController extends Controller
{
  public function comments(Request $request)
  {
      $dt = Comments::where('supplier_id',$request->id)->with('user')->get();

      return Response::json([
        'status' => true,
        'length' => count($dt),
        'data' => $dt,
      ]);
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
    public function store(Request $request)
    {
    }

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
