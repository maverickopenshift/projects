<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
use Modules\Documents\Entities\DocActivity as doc_activity;


class DocLogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function logActivity(Request $request)
    {
      $dt = doc_activity::where('documents.id',$request->id)
                    ->join('documents', 'doc_activity.documents_id', '=', 'documents.id')
                    ->join('users', 'doc_activity.users_id', '=', 'users.id')
                    ->select('doc_activity.*', 'documents.doc_title', 'users.name', 'users.username')
                    ->get();
      // dd($dt);
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
