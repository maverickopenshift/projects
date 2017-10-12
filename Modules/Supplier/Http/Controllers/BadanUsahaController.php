<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Supplier\Entities\BadanUsaha;
use Datatables;
use Validator;
use Response;

class BadanUsahaController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {
      $data['page_title'] = 'Badan Usaha';
      return view('supplier::badan-usaha.index')->with($data);
  }
  public function data()
  {
      $sql = BadanUsaha::get();
      return Datatables::of($sql)
          ->addIndexColumn()
          ->addColumn('action', function ($data) {
            $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                          return '
                          <div class="btn-group">
                          <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'">
          <i class="glyphicon glyphicon-edit"></i> Edit
          </button><button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete">
          <i class="glyphicon glyphicon-trash"></i> Delete
          </button></div>';
          })
          ->filterColumn('updated_at', function ($query, $keyword) {
              $query->whereRaw("DATE_FORMAT(updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
          })
          ->filterColumn('created_at', function ($query, $keyword) {
              $query->whereRaw("DATE_FORMAT(created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
          })
          ->editColumn('updated_at', function ($data) {
              if($data->updated_at){
                  return $data->updated_at->format('d-m-Y H:i');
              }
              return;
          })
          ->editColumn('created_at', function ($data) {
              if($data->created_at){
                  return $data->created_at->format('d-m-Y H:i');
              }
              return;
          })
          ->make(true);
  }
  public function update(Request $request)
  {
        $rules = array (
            'text' => 'required|unique:badan_usaha,text,'.$request->id.'|min:3',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
            $data = BadanUsaha::where('id','=',$request->id)->first();
            $data->text = $request->text;
            $data->save();
            return response()->json($data);
        }
  }
  public function add(Request $request)
  {
      $rules = array (
          'text' => 'required|unique:badan_usaha,text|min:3',
      );
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails ())
          return Response::json (array(
              'errors' => $validator->getMessageBag()->toArray()
          ));
      else {
          $data = new BadanUsaha();
          $data->text = $request->text;
          $data->save ();
          return response()->json($data);
      }
  }
  public function delete(Request $request)
  {
        $data = BadanUsaha::where('id','=',$request->id)->delete();
        return response()->json($data);
  }
}
