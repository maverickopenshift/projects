<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Role;
use App\Permission;
use Datatables;
use Validator;
use Response;

class RolesController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Roles';
        $data['permissions'] = Permission::all();
        return view("users::roles.index")->with($data);
    }
    public function data()
    {
        $sql = Role::with('permissions')->get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
              $perm = htmlspecialchars(json_encode($data->permissions), ENT_QUOTES, 'UTF-8');
                            return '
                            <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-permissions="'.$perm.'">
            <i class="glyphicon glyphicon-edit"></i> Edit
            </button><button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete">
            <i class="glyphicon glyphicon-trash"></i> Delete
            </button></div>';
            })
            ->addColumn('permission_name', function(Role $role){
                return $role->permissions->map(function($permission){
                    return $permission->display_name;
                })->implode(' , ');   

            })
            ->filterColumn('updated_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(c_others.updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(c_others.created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
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
              'display_name' => 'required|unique:roles,display_name,'.$request->id.'|max:250|min:3',
              'description' => 'required|min:5',
          );
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails ())
              return Response::json (array(
                  'errors' => $validator->getMessageBag()->toArray()
              ));
          else {
              $perm = $request->permissions;
              $data = Role::where('id','=',$request->id)->first();
              $data->display_name = $request->display_name;
              $data->description = $request->description;
              $data->name = str_slug($data->display_name);
              $data->save();
              if(count($perm)>0){
                $data->permissions()->sync($perm);
              }
              return response()->json($data);
          }
  	}
    public function add(Request $request)
    {
        $rules = array (
            'display_name' => 'required|unique:roles,display_name|max:250|min:3',
            'description' => 'required|min:5',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
            $perm = $request->permissions;
            $slug = str_slug($request->display_name);
            $data = new Role();
            $data->display_name = $request->display_name;
            $data->description = $request->description;
            $data->name = $slug;
            $data->save ();
            if(count($perm)>0){
              $data->permissions()->attach($perm);
            }
            return response()->json($data);
        }
    }
    public function delete(Request $request)
    {
          $data = Role::where('id','=',$request->id)->delete();
          return response()->json($data);
    }
}
