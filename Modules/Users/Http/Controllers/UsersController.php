<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use App\Role;
use Modules\Users\Entities\UsersAtasan as Atasan;
use Modules\Users\Entities\UsersPegawai as Pegawai;
use Modules\Documents\Entities\Documents as Doc;
use Illuminate\Support\Facades\Log;
use Datatables;
use Validator;
use Response;
use App\Mail\SendEmailUser;
use Mail;
use App\Helpers\Helpers as Helper;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $data['page_title'] = 'Users';
        $data['roles'] = Role::all();
        return view('users::index')->with($data);
    }
    public function data()
    {
        $sql = User::with('roles')->get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
              $roles = htmlspecialchars(json_encode($data->roles), ENT_QUOTES, 'UTF-8');
              $act= '<div>';
              if(\Auth::user()->hasPermission('ubah-user')){
                  $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-edit"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-roles="'.$roles.'">
  <i class="glyphicon glyphicon-edit"></i> Edit
  </button>';
              }
              if(\Auth::user()->hasPermission('ubah-user')){
                  $act .='<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-reset"  data-title="Reset" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-roles="'.$roles.'">
  <i class="glyphicon glyphicon-edit"></i> Reset Password
  </button>';
              }
              if(\Auth::user()->hasPermission('hapus-user')){
                $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete">
<i class="glyphicon glyphicon-trash"></i> Delete
</button>';
              }
              return $act.'</div>';
            })
            ->addColumn('role_name', function (User $user) {
                return $user->roles->map(function ($role) {
                    return $role->display_name;
                })->implode(' , ');
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
        if (!$request->ajax()) {abort(404);};
        $id = $request->id;
          $rules = array (
              'name' => 'required|max:250|min:3',
              'username' => 'required|unique:users,username,'.$request->id.'|max:250|min:3',
              'email' => 'required|unique:users,email,'.$request->id.'|max:250|min:5',
              // 'phone' => 'required|max:15|min:5',
              'roles_edit.*' => 'required',
              // 'password' => 'required|confirmed|max:50|min:5',
          );
          $validator = Validator::make($request->all(), $rules);
          $validator->after(function ($validator) use ($request) {
              if (!isset($request->roles_edit)) {
                  $validator->errors()->add('roles_edit', 'Roles harus dipilih');
              }
          });
          if ($validator->fails ())
              return Response::json (array(
                  'errors' => $validator->getMessageBag()->toArray()
              ));
          else {
              $roles = $request->roles_edit;
              $data = User::where('id','=',$request->id)->first();
              if(!Pegawai::is_pegawai($id)){
                $data->name = $request->name;
                $data->username = $request->username;
                $data->email = $request->email;
                $data->phone = $request->phone;
              }
              $data->save();
              $data->roles()->sync($roles);
              
              if (count($request->atasan_id)>0 && $request->has(['atasan_id'])) {
                $peg = Pegawai::get_by_userid($id);  
                  Atasan::where('users_pegawai_id',$peg->ids)->delete();
                  foreach($request->atasan_id as $key=>$v){
                    $atasan = new Atasan();
                    $atasan->users_pegawai_id = $peg->ids;
                    $atasan->nik = $v;
                    $atasan->save();
                  }
              }
              return response()->json($data);
          }
    }
    public function reset(Request $request)
    {
          $rules = array (
              'reset_password' => 'required|max:50|min:5',
              'konfirmasi_password' => 'required|max:50|min:5|same:reset_password',
              // 'password' => 'required|confirmed|max:50|min:5',
          );
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails ())
              return Response::json (array(
                  'errors' => $validator->getMessageBag()->toArray()
              ));
          else {
              $roles = $request->roles;
              $data = User::where('id','=',$request->id)->first();
              $data->password = bcrypt($request->reset_password);
              $data->save();
              return response()->json($data);
          }
    }
    public function add(Request $request)
    {
      if (!$request->ajax()) {abort(404);};
        $rules = array (
            'name' => 'required|max:250|min:3',
            'username' => 'required|unique:users,username|max:250|min:3',
            'email' => 'required|unique:users,email|max:250|min:5',
            'phone' => 'sometimes|nullable|max:15|min:5',
            'password' => 'required|confirmed|max:50|min:5',
            'roles.*' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
            if (!isset($request->roles)) {
                $validator->errors()->add('roles', 'Roles harus dipilih');
            }
        });
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
            $data = new User();
            $data->name = $request->name;
            $data->username = $request->username;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->password = bcrypt($request->password);
            $roles = $request->roles;
            $data->save ();
            $data->attachRoles($roles);

            $peg = new Pegawai();
            $peg->users_id = $data->id;
            $peg->nik = $data->username;
            $peg->save();

            if ($request->has(['atasan_id'])) {
                foreach($request->atasan_id as $key=>$v){
                  $atasan = new Atasan();
                  $atasan->users_pegawai_id = $peg->id;
                  $atasan->nik = $v;
                  $atasan->save();
                }
            }

            $sendTo = $request->email;
            $subject = 'User Registration - Do Not Reply';
            $email_password= $request->password;
            $email_username = $request->username;

            Log::info('Start');
            Mail::to($sendTo)
                ->queue(new SendEmailUser($email_password, $email_username, $subject));
            log::info('End');

            return response()->json($data);
        }
    }
    public function delete(Request $request)
    {
          $data = User::where('id','=',$request->id)->delete();
          return response()->json($data);
    }
    public function getSelectUserTelkom(Request $request){
        $search = trim($request->q);
        $type = trim($request->type);
        $posisi = trim($request->posisi);

        // if (empty($search)) {
        //     return \Response::json([]);
        // }
        $data = User::get_user_telkom($search,$type,$posisi)->paginate(30);
        return \Response::json($data);
    }
    public function getSelectUserTelkomByNik(Request $request){
        $search = trim($request->nik);

        if (empty($search)) {
            return \Response::json([]);
        }
        $data = User::get_user_telkom_by_nik($search)->first();
        if($data){
          return \Response::json(array('status'=>true,'data'=>$data));
        }
        return \Response::json(array('status'=>false));
    }
    public function getSelectUserVendor(Request $request){
        $search = trim($request->q);

        // if (empty($search)) {
        //     return \Response::json([]);
        // }
        $data = User::get_user_vendor($search)->paginate(30);
        return \Response::json($data);
    }
    public function getSelectKonseptor(Request $request){
        $search = trim($request->q);
        $id = trim($request->id);
        $parent = trim($request->parent);
        $data = User::get_user_by_role('konseptor');
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('users.username', 'like', '%'.$search.'%');
              $q->orWhere('users.name', 'like', '%'.$search.'%');
          });
        }
        if(!empty($parent)){
          $userid = Doc::select('user_id')->where('id',$parent)->first();
          $divisi = User::get_divisi_by_user_id($userid->user_id);
          $data->where('pegawai.objiddivisi',$divisi);
        }
        if(!empty($id)){
          $data->where('users.id',$id);
          $data = $data->first();
          $data->approver = Helper::get_approver_by_id($data->id);
          $data->pihak1 = Helper::get_pihak1_by_id($data->id);
        }
        else{
          $data = $data->paginate(30);
          $data->getCollection()->transform(function ($value) {
            $value->approver = Helper::get_approver_by_id($value->id);
            $value->pihak1 = Helper::get_pihak1_by_id($value->id);
            return $value;
          });
        }
        return \Response::json($data);
    }
    public function getAtasanByUserid(Request $request){
        $id = trim($request->id);

        if (empty($id)) {
            return \Response::json([]);
        }
        $data = Atasan::get_by_userid($id);
        return \Response::json(['is_pegawai'=>Pegawai::is_pegawai($id),'pegawai'=>Pegawai::get_by_userid($id),'atasan'=>$data]);
    }
}
