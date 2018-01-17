<?php

namespace Modules\Config\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Config\Entities\Config;
use Datatables;
use Validator;
use Response;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['page_title'] = 'Config';
        return view('config::index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
     public function data()
     {
       $sql = Config::get();
       return Datatables::of($sql)
           ->addIndexColumn()
           ->addColumn('action', function ($data) {
             $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
             $act= '<div>';
             if(\Auth::user()->hasPermission('ubah-config')){
                 $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" >
     <i class="glyphicon glyphicon-edit"></i> Edit
     </button>';
             }
             if(\Auth::user()->hasPermission('hapus-config')){
               $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete">
     <i class="glyphicon glyphicon-trash"></i> Delete
     </button>';
             }
             return $act.'</div>';
           })
           ->filterColumn('updated_at', function ($query, $keyword) {
               $query->whereRaw("DATE_FORMAT(updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
           })
           ->filterColumn('created_at', function ($query, $keyword) {
               $query->whereRaw("DATE_FORMAT(created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
           })
           // ->editColumn('updated_at', function ($data) {
           //     if($data->updated_at){
           //         return $data->updated_at->format('d-m-Y H:i');
           //     }
           //     return;
           // })
           // ->editColumn('created_at', function ($data) {
           //     if($data->created_at){
           //         return $data->created_at->format('d-m-Y H:i');
           //     }
           //     return;
           // })
           ->make(true);
     }
     public function update(Request $request)
   	{
           $rules = array (
               'description' => 'required|min:1',
           );
           $validator = Validator::make($request->all(), $rules);
           if ($validator->fails ())
               return Response::json (array(
                   'errors' => $validator->getMessageBag()->toArray()
               ));
           else {
               $data = Config::where('id','=',$request->id)->first();
               $data->object_value = $request->description;
               $data->save();
               return response()->json($data);
           }
   	}
    public function add(Request $request)
    {
        $rules = array (
            'display_name' => 'required|max:250|min:3',
            'description' => 'required|min:1',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
            $data = new Config();
            $data->object_key = str_slug($request->display_name);
            $data->object_value = $request->description;
            $data->save ();
            return response()->json($data);
        }
    }
    public function delete(Request $request)
    {
          $data = Config::where('id','=',$request->id)->delete();
          return response()->json($data);
    }
}