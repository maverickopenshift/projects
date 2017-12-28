<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
use Modules\Supplier\Entities\SupplierActivity as Comments;

class UserSupplierCommentController extends Controller
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
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('usersupplier::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('usersupplier::create');
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
        return view('usersupplier::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('usersupplier::edit');
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
