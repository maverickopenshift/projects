<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Permission;
use Datatables;
use Validator;
use Response;

class PermissionsController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Permissions';
        return view("users::permissions.index")->with($data);
    }
    public function data()
    {
        $sql = Permission::get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
              $act= '<div class="btn-group">';
              if(\Auth::user()->hasPermission('ubah-permission')){
                  $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
              }
              if(\Auth::user()->hasPermission('hapus-permission')){
                $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
              }
              return $act.'</div>';
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
              'display_name' => 'required|unique:permissions,display_name,'.$request->id.'|max:250|min:3',
              'description' => 'required|min:5',
          );
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails ())
              return Response::json (array(
                  'errors' => $validator->getMessageBag()->toArray()
              ));
          else {
              $data = Permission::where('id','=',$request->id)->first();
              $data->display_name = $request->display_name;
              $data->description = $request->description;
              $data->name = str_slug($data->display_name);
              $data->save();
              return response()->json($data);
          }
  	}
    public function add(Request $request)
    {
        $rules = array (
            'display_name' => 'required|unique:permissions,display_name|max:250|min:3',
            'description' => 'required|min:5',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
            $slug = str_slug($request->display_name);
            $data = new Permission();
            $data->display_name = $request->display_name;
            $data->description = $request->description;
            $data->name = $slug;
            $data->save ();
            return response()->json($data);
        }
    }
    public function delete(Request $request)
    {
          $data = Permission::where('id','=',$request->id)->delete();
          return response()->json($data);
    }
}
