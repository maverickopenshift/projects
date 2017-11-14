<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use App\Role;
use Modules\Users\Entities\UsersAtasan as Atasan;
use Modules\Users\Entities\UsersPegawai as Pegawai;
use Illuminate\Support\Facades\Log;
use Datatables;
use Validator;
use Response;
use App\Mail\SendEmailUser;
use Mail;

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
                  $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-roles="'.$roles.'">
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
              'name' => 'required|max:250|min:3',
              'username' => 'required|unique:users,username,'.$request->id.'|max:250|min:3',
              'email' => 'required|unique:users,email,'.$request->id.'|max:250|min:5',
              'phone' => 'required|max:15|min:5',
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
              $data->name = $request->name;
              $data->username = $request->username;
              $data->email = $request->email;
              $data->phone = $request->phone;
              $data->save();
              //if(count($roles)>0){
                $data->roles()->sync($roles);
              //}
              // else{
              //   $data->roles()->sync([]);
              // }
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
        $rules = array (
            'name' => 'required|max:250|min:3',
            'username' => 'required|unique:users,username|max:250|min:3',
            'email' => 'required|unique:users,email|max:250|min:5',
            'phone' => 'sometimes|nullable|max:15|min:5',
            'password' => 'required|confirmed|max:50|min:5',
        );
        $validator = Validator::make($request->all(), $rules);
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

            // $sendTo = $request->input('email');
            $sendTo = 'annisadaguslita@gmail.com';
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
}
