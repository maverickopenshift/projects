<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use App\Role;
use Modules\Users\Entities\UsersAtasan as Atasan;
use Modules\Users\Entities\UsersApprover as Approver;
use Modules\Users\Entities\UsersPegawai;
use Modules\Users\Entities\Pegawai;
use Modules\Users\Entities\UsersPgs;
use Modules\Users\Entities\PegawaiNonorganik;
use Modules\Documents\Entities\Documents as Doc;
use Illuminate\Support\Facades\Log;
use Datatables;
use Validator;
use Response;
use DB;
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
              $user_type = User::check_usertype($data->username);
              $other = '';
              if($user_type=='organik'){
                $is_pgs = false;
                $modal = '#form-modal';
                $peg = Pegawai::where('n_nik',$data->username)->first();
                $pgs = UsersPgs::where('users_id','=',$data->id)->first();
                if($pgs){
                  $is_pgs = true;
                }
                $atasan = Atasan::get_by_userid($data->id);
                $approver = Approver::get_by_userid($data->id);
                $other_ar = [
                  'pegawai'  => $peg,
                  'atasan'   => $atasan,
                  'approver' => $approver,
                  'is_pgs'   => $is_pgs,
                  'pgs'      => $pgs
                ];
                $other = htmlspecialchars(json_encode($other_ar), ENT_QUOTES, 'UTF-8');
              }
              else if($user_type=='nonorganik'){
                $modal = '#form-modal-nonorganik';
                $peg = PegawaiNonorganik::where('n_nik',$data->username)->first();
                $atasan = Atasan::get_by_userid($data->id);
                $other_ar = [
                  'pegawai'  => $peg,
                  'atasan'   => $atasan
                ];
                $other = htmlspecialchars(json_encode($other_ar), ENT_QUOTES, 'UTF-8');
              }
              else{
                $modal = '#form-modal-edit';
              }
              $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
              $roles = htmlspecialchars(json_encode($data->roles), ENT_QUOTES, 'UTF-8');
              $act= '<div>';
              if(\Auth::user()->hasPermission('ubah-user') && $user_type!='vendor'){
                  $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="'.$modal.'"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-roles="'.$roles.'" data-other="'.$other.'">
  <i class="glyphicon glyphicon-edit"></i> Edit
  </button>';
              }
              if(\Auth::user()->hasPermission('ubah-user') && $user_type!='organik'){
                  $act .='<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-reset"  data-title="Reset" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-roles="'.$roles.'">
  <i class="glyphicon glyphicon-edit"></i> Reset Password
  </button>';
              }
              if(\Auth::user()->hasPermission('hapus-user') && $user_type!='admin' && $user_type!='vendor'){
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
              'user_search' => 'required|exists:pegawai,id',
              'username' => 'required|unique:users,username,'.$request->id.'|max:250|min:3',
              'email' => 'required|email|unique:users,email,'.$request->id.'|max:250|min:5',
              'phone' => 'sometimes|nullable|max:15|min:5',
              'roles' => 'required|exists:roles,id',
              'user_type'    => 'required|in:ubis,witel|max:5|min:4',
              // 'password' => 'required|confirmed|max:50|min:5',
          );
          if($request->user_pgs=='yes'){
            $rules['pgs_divisi_or'] = 'required|exists:rptom,objiddivisi';
            $rules['pgs_unit_or'] = 'required|exists:rptom,objidunit';
            $rules['pgs_jabatan_or'] = 'required|exists:rptom,objidposisi';
            $rules['pgs_roles_or'] = 'required|exists:roles,id';
          }
          $msg = [
            'username.unique' => 'Pegawai yang Anda pilih sudah Ada',
            'email.unique' => 'Pegawai yang Anda pilih sudah Ada',
          ];
          $validator = Validator::make($request->all(), $rules,$msg);
          $validator->after(function ($validator) use ($request) {
              // if (!isset($request->roles_edit)) {
              //     $validator->errors()->add('roles_edit', 'Roles harus dipilih');
              // }
          });
          if ($validator->fails ())
              return Response::json (array(
                  'errors' => $validator->getMessageBag()->toArray()
              ));
          else {
              $peg = Pegawai::where('id',$request->user_search)->first();
              $data = User::where('id','=',$request->id)->first();
              $data->name = $peg->v_nama_karyawan;
              $data->username = $peg->n_nik;
              $data->phone = $request->phone;
              $data->email = $peg->n_nik.'@telkom.co.id';
              $data->user_type = $request->user_type;
              $data->save();
              $data->syncRoles([$request->roles]);
              // $data->roles()->sync($roles);
              $peg = UsersPegawai::get_by_userid($id);
              $peg->nik = $data->username;
              $peg->save();
              
              if (count($request->atasan_id)>0 && $request->has(['atasan_id'])) {
                  Atasan::where('users_pegawai_id',$peg->ids)->delete();
                  foreach($request->atasan_id as $key=>$v){
                    $atasan = new Atasan();
                    $atasan->users_pegawai_id = $peg->ids;
                    $atasan->nik = $v;
                    $atasan->save();
                  }
              }
              // if (count($request->approver_id)>0 && $request->has(['approver_id'])) {
              //     foreach($request->approver_id as $key=>$v){
              //       $approver = new Approver();
              //       $approver->users_pegawai_id = $peg->ids;
              //       $approver->nik = $v;
              //       $approver->save();
              //     }
              // }
              if($request->user_pgs=='yes'){
                $pgs = UsersPgs::where('users_id','=',$data->id)->first();
                if(!$pgs){
                  $pgs = new UsersPgs();
                  $pgs->users_id = $data->id;
                }
                $pgs_divisi =  DB::table('rptom')->where('objiddivisi',$request->pgs_divisi_or)->first();
                $pgs->objiddivisi = $pgs_divisi->objiddivisi;
                $pgs->c_kode_divisi = $pgs_divisi->c_kode_divisi;
                $pgs->v_short_divisi = $pgs_divisi->v_short_divisi;
              
                $pgs_unit =  DB::table('rptom')->where('objidunit',$request->pgs_unit_or)->first();
                $pgs->objidunit = $pgs_unit->objidunit;
                $pgs->c_kode_unit = $pgs_unit->c_kode_unit;
                $pgs->v_short_unit = $pgs_unit->v_short_unit;
              
                $pgs_posisi = DB::table('rptom')->where('objidposisi',$request->pgs_jabatan_or)->first();
                $pgs->objidposisi = $pgs_posisi->objidposisi;
                $pgs->c_kode_posisi = $pgs_posisi->c_kode_posisi;
                $pgs->v_short_posisi = $pgs_posisi->v_short_posisi;
              
                $pgs->role_id = $request->pgs_roles_or;
                $pgs->role_id_first = $request->roles;
                $pgs->save();
              }
              else{
                UsersPgs::where('users_id','=',$data->id)->delete();
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
    public function addNonorganik(Request $request)
    {
      if (!$request->ajax()) {abort(404);};
      //dd($request->all());
        $rules = array (
            'name'     => 'required|max:250|min:3',
            'username' => 'required|unique:users,username|max:250|min:3',
            'email'    => 'required|email|unique:users,email|max:250|min:5',
            'phone'    => 'sometimes|nullable|max:15|min:5',
            'password' => 'required|confirmed|max:50|min:5',
            'roles'    => 'required|exists:roles,id',
            'user_type'    => 'required|in:ubis,witel,subsidiary|max:10|min:4',
            // 'select_divisi'    => 'required|exists:rptom,objiddivisi',
            // 'select_unit'    => 'required|exists:rptom,objidunit',
            // 'select_posisi'    => 'required|exists:rptom,objidposisi',
        );
        if($request->user_type != 'subsidiary'){
          $rules['select_divisi'] = 'required|exists:rptom,objiddivisi';
          $rules['select_unit'] = 'required|exists:rptom,objidunit';
          $rules['select_posisi'] = 'required|exists:rptom,objidposisi';
        }
        if($request->user_pgs=='yes'){
          $rules['pgs_divisi'] = 'required|exists:rptom,objiddivisi';
          $rules['pgs_unit'] = 'required|exists:rptom,objidunit';
          $rules['pgs_jabatan'] = 'required|exists:rptom,objidposisi';
          $rules['pgs_roles'] = 'required|exists:roles,id';
        }
        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
            // if (!isset($request->roles)) {
            //     $validator->errors()->add('roles', 'Roles harus dipilih');
            // }
        });
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
          //dd($request->all());
            $data = new User();
            $data->name = $request->name;
            $data->username = $request->username;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->password = bcrypt($request->password);
            $data->user_type = $request->user_type;
            $data->save ();
            $data->attachRole($request->roles);
            
            $peg_non = new PegawaiNonorganik();
            $peg_non->n_tahun = date('Y');
            $peg_non->n_bulan = date('m');
            $peg_non->n_nik = $request->username;
            $peg_non->v_nama_karyawan = $request->name;
            if($request->user_type != 'subsidiary'){
              $divisi = DB::table('rptom')->where('objiddivisi',$request->select_divisi)->first();
              $peg_non->objiddivisi = $divisi->objiddivisi;
              $peg_non->c_kode_divisi = $divisi->c_kode_divisi;
              $peg_non->v_short_divisi = $divisi->v_short_divisi;
              $peg_non->d_tgl_divisi = date('Y-m-d');
              
              $unit = DB::table('rptom')->where('objidunit',$request->select_unit)->first();
              $peg_non->objidunit = $unit->objidunit;
              $peg_non->c_kode_unit = $unit->c_kode_unit;
              $peg_non->v_short_unit = $unit->v_short_unit;
              $peg_non->v_long_unit = $unit->v_long_unit;
              $peg_non->d_tgl_unit = date('Y-m-d');
              
              $posisi = DB::table('rptom')->where('objidposisi',$request->select_posisi)->first();
              $peg_non->objidposisi = $posisi->objidposisi;
              $peg_non->c_kode_posisi = $posisi->c_kode_posisi;
              $peg_non->v_short_posisi = $posisi->v_short_posisi;
              $peg_non->v_long_posisi = $posisi->v_long_posisi;
              $peg_non->d_tgl_posisi = date('Y-m-d');
            }
            $peg_non->save();
            
            $peg = new UsersPegawai();
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
            
            // if ($request->has(['approver_id'])) {
            //     foreach($request->approver_id as $key=>$v){
            //       $approver = new Approver();
            //       $approver->users_pegawai_id = $peg->id;
            //       $approver->nik = $v;
            //       $approver->save();
            //     }
            // }
            // if($request->user_pgs=='yes'){
            //   $pgs = new UsersPgs();
            //   $pgs->users_id = $data->id;
            // 
            //   $pgs_divisi =  DB::table('rptom')->where('objiddivisi',$request->pgs_divisi)->first();
            //   $pgs->objiddivisi = $pgs_divisi->objiddivisi;
            //   $pgs->c_kode_divisi = $pgs_divisi->c_kode_divisi;
            //   $pgs->v_short_divisi = $pgs_divisi->v_short_divisi;
            // 
            //   $pgs_unit =  DB::table('rptom')->where('objidunit',$request->pgs_unit)->first();
            //   $pgs->objidunit = $pgs_unit->objidunit;
            //   $pgs->c_kode_unit = $pgs_unit->c_kode_unit;
            //   $pgs->v_short_unit = $pgs_unit->v_short_unit;
            // 
            //   $pgs_posisi = DB::table('rptom')->where('objidposisi',$request->pgs_jabatan)->first();
            //   $pgs->objidposisi = $pgs_posisi->objidposisi;
            //   $pgs->c_kode_posisi = $pgs_posisi->c_kode_posisi;
            //   $pgs->v_short_posisi = $pgs_posisi->v_short_posisi;
            // 
            //   $pgs->role_id = $request->pgs_roles;
            //   $pgs->role_id_first = $request->roles;
            //   $pgs->save();
            // }
            // Log::info('Start');
            // Mail::to($sendTo)
            //     ->queue(new SendEmailUser($email_password, $email_username, $subject));
            // log::info('End');

            return response()->json($data);
        }
    }
    public function add(Request $request)
    {
      if (!$request->ajax()) {abort(404);};
        $rules = array (
            'user_search' => 'required|exists:pegawai,id',
            'username' => 'required|unique:users,username|max:250|min:3',
            'email'    => 'required|email|unique:users,email|max:250|min:5',
            'phone'    => 'sometimes|nullable|max:15|min:5',
            'roles' => 'required|exists:roles,id',
            'user_type'    => 'required|in:ubis,witel|max:5|min:4',
        );
        if($request->user_pgs=='yes'){
          $rules['pgs_divisi_or'] = 'required|exists:rptom,objiddivisi';
          $rules['pgs_unit_or'] = 'required|exists:rptom,objidunit';
          $rules['pgs_jabatan_or'] = 'required|exists:rptom,objidposisi';
          $rules['pgs_roles_or'] = 'required|exists:roles,id';
        }
        $msg = [
          'username.unique' => 'Pegawai yang Anda pilih sudah Ada',
          'email.unique' => 'Pegawai yang Anda pilih sudah Ada',
        ];
        $validator = Validator::make($request->all(), $rules,$msg);
        $validator->after(function ($validator) use ($request) {
            // if (!isset($request->roles)) {
            //     $validator->errors()->add('roles', 'Roles harus dipilih');
            // }
        });
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
            $peg = Pegawai::where('id',$request->user_search)->first();
            $data = new User();
            $data->name = $peg->v_nama_karyawan;
            $data->username = $peg->n_nik;
            $data->phone = $request->phone;
            $data->email = $peg->n_nik.'@telkom.co.id';
            $data->password = bcrypt(config('app.password_default'));
            $data->user_type = $request->user_type;
            $data->save ();
            $data->attachRole($request->roles);

            $peg = new UsersPegawai();
            $peg->users_id = $data->id;
            $peg->nik = $data->username;
            $peg->save();

            if (count($request->atasan_id)>0 &&  $request->has(['atasan_id'])) {
                foreach($request->atasan_id as $key=>$v){
                  $atasan = new Atasan();
                  $atasan->users_pegawai_id = $peg->id;
                  $atasan->nik = $v;
                  $atasan->save();
                }
            }
            // if ($request->has(['approver_id'])) {
            //     foreach($request->approver_id as $key=>$v){
            //       $approver = new Approver();
            //       $approver->users_pegawai_id = $peg->id;
            //       $approver->nik = $v;
            //       $approver->save();
            //     }
            // }
            if($request->user_pgs=='yes'){
              $pgs = new UsersPgs();
              $pgs->users_id = $data->id;
            
              $pgs_divisi =  DB::table('rptom')->where('objiddivisi',$request->pgs_divisi_or)->first();
              $pgs->objiddivisi = $pgs_divisi->objiddivisi;
              $pgs->c_kode_divisi = $pgs_divisi->c_kode_divisi;
              $pgs->v_short_divisi = $pgs_divisi->v_short_divisi;
            
              $pgs_unit =  DB::table('rptom')->where('objidunit',$request->pgs_unit_or)->first();
              $pgs->objidunit = $pgs_unit->objidunit;
              $pgs->c_kode_unit = $pgs_unit->c_kode_unit;
              $pgs->v_short_unit = $pgs_unit->v_short_unit;
            
              $pgs_posisi = DB::table('rptom')->where('objidposisi',$request->pgs_jabatan_or)->first();
              $pgs->objidposisi = $pgs_posisi->objidposisi;
              $pgs->c_kode_posisi = $pgs_posisi->c_kode_posisi;
              $pgs->v_short_posisi = $pgs_posisi->v_short_posisi;
            
              $pgs->role_id = $request->pgs_roles_or;
              $pgs->role_id_first = $request->roles;
              $pgs->save();
            }
            // $sendTo = $request->email;
            // $subject = 'User Registration - Do Not Reply';
            // $email_password= $request->password;
            // $email_username = $request->username;
            // 
            // Log::info('Start');
            // Mail::to($sendTo)
            //     ->queue(new SendEmailUser($email_password, $email_username, $subject));
            // log::info('End');

            return response()->json($data);
        }
    }
    public function updateNonorganik(Request $request)
    {
      if (!$request->ajax()) {abort(404);};
      //dd($request->all());
        $id = $request->id;
        $rules = array (
            'name'     => 'required|max:250|min:3',
            'username' => 'required|unique:users,username,'.$request->id.'|max:250|min:3',
            'email'    => 'required|email|unique:users,email,'.$request->id.'|max:250|min:5',
            'phone'    => 'sometimes|nullable|max:15|min:5',
            'roles'    => 'required|exists:roles,id',
            'user_type'    => 'required|in:ubis,witel,subsidiary|max:10|min:4',
            // 'select_divisi'    => 'required|exists:rptom,objiddivisi',
            // 'select_unit'    => 'required|exists:rptom,objidunit',
            // 'select_posisi'    => 'required|exists:rptom,objidposisi',
        );
        if($request->user_type != 'subsidiary'){
          $rules['select_divisi'] = 'required|exists:rptom,objiddivisi';
          $rules['select_unit'] = 'required|exists:rptom,objidunit';
          $rules['select_posisi'] = 'required|exists:rptom,objidposisi';
        }
        // if($request->user_pgs=='yes'){
        //   $rules['pgs_divisi'] = 'required|exists:rptom,objiddivisi';
        //   $rules['pgs_unit'] = 'required|exists:rptom,objidunit';
        //   $rules['pgs_jabatan'] = 'required|exists:rptom,objidposisi';
        //   $rules['pgs_roles'] = 'required|exists:roles,id';
        // }
        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
            // if (!isset($request->roles)) {
            //     $validator->errors()->add('roles', 'Roles harus dipilih');
            // }
        });
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
          //dd($request->all());
            $data = User::where('id','=',$request->id)->first();
            $data->name = $request->name;
            $data->username = $request->username;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->user_type = $request->user_type;
            $data->save ();
            $data->syncRoles([$request->roles]);
            
            $pegs = UsersPegawai::get_by_userid($id,'nonorganik');
            $peg = UsersPegawai::where('nik','=',$pegs->n_nik)->first();
            $peg_non = PegawaiNonorganik::where('n_nik',$data->username)->first();
            if(!$peg_non){
              PegawaiNonorganik::where('n_nik',$pegs->n_nik)->delete();
              $peg_non = new PegawaiNonorganik();
            }
            $peg->nik = $data->username;
            $peg->save();
            
            $peg_non->n_tahun = date('Y');
            $peg_non->n_bulan = date('m');
            $peg_non->n_nik = $data->username;
            $peg_non->v_nama_karyawan = $data->name;
            if($request->user_type != 'subsidiary'){
              $divisi = DB::table('rptom')->where('objiddivisi',$request->select_divisi)->first();
              $peg_non->objiddivisi = $divisi->objiddivisi;
              $peg_non->c_kode_divisi = $divisi->c_kode_divisi;
              $peg_non->v_short_divisi = $divisi->v_short_divisi;
              $peg_non->d_tgl_divisi = date('Y-m-d');
              
              $unit = DB::table('rptom')->where('objidunit',$request->select_unit)->first();
              $peg_non->objidunit = $unit->objidunit;
              $peg_non->c_kode_unit = $unit->c_kode_unit;
              $peg_non->v_short_unit = $unit->v_short_unit;
              $peg_non->v_long_unit = $unit->v_long_unit;
              $peg_non->d_tgl_unit = date('Y-m-d');
              
              $posisi = DB::table('rptom')->where('objidposisi',$request->select_posisi)->first();
              $peg_non->objidposisi = $posisi->objidposisi;
              $peg_non->c_kode_posisi = $posisi->c_kode_posisi;
              $peg_non->v_short_posisi = $posisi->v_short_posisi;
              $peg_non->v_long_posisi = $posisi->v_long_posisi;
              $peg_non->d_tgl_posisi = date('Y-m-d');
            }
            $peg_non->save();
            

            if (count($request->atasan_id)>0 &&   $request->has(['atasan_id'])) {
                Atasan::where('users_pegawai_id',$pegs->ids)->delete();
                foreach($request->atasan_id as $key=>$v){
                  $atasan = new Atasan();
                  $atasan->users_pegawai_id = $pegs->ids;
                  $atasan->nik = $v;
                  $atasan->save();
                }
            }
            
            // if ($request->has(['approver_id'])) {
            //     foreach($request->approver_id as $key=>$v){
            //       $approver = new Approver();
            //       $approver->users_pegawai_id = $peg->id;
            //       $approver->nik = $v;
            //       $approver->save();
            //     }
            // }
            // if($request->user_pgs=='yes'){
            //   $pgs = new UsersPgs();
            //   $pgs->users_id = $data->id;
            // 
            //   $pgs_divisi =  DB::table('rptom')->where('objiddivisi',$request->pgs_divisi)->first();
            //   $pgs->objiddivisi = $pgs_divisi->objiddivisi;
            //   $pgs->c_kode_divisi = $pgs_divisi->c_kode_divisi;
            //   $pgs->v_short_divisi = $pgs_divisi->v_short_divisi;
            // 
            //   $pgs_unit =  DB::table('rptom')->where('objidunit',$request->pgs_unit)->first();
            //   $pgs->objidunit = $pgs_unit->objidunit;
            //   $pgs->c_kode_unit = $pgs_unit->c_kode_unit;
            //   $pgs->v_short_unit = $pgs_unit->v_short_unit;
            // 
            //   $pgs_posisi = DB::table('rptom')->where('objidposisi',$request->pgs_jabatan)->first();
            //   $pgs->objidposisi = $pgs_posisi->objidposisi;
            //   $pgs->c_kode_posisi = $pgs_posisi->c_kode_posisi;
            //   $pgs->v_short_posisi = $pgs_posisi->v_short_posisi;
            // 
            //   $pgs->role_id = $request->pgs_roles;
            //   $pgs->role_id_first = $request->roles;
            //   $pgs->save();
            // }
            // Log::info('Start');
            // Mail::to($sendTo)
            //     ->queue(new SendEmailUser($email_password, $email_username, $subject));
            // log::info('End');

            return response()->json($data);
        }
    }
    public function delete(Request $request)
    {
          $doc = Doc::where('user_id',$request->id)->count();
          $status = false;$msg = 'Ada sesuatu yang salah, silahkan coba lagi';
          if($doc>0){
            $msg = 'User tidak dapat dihapus, karena memiliki dokumen';
          }
          else{
            $user = User::where('id','=',$request->id)->first();
            if($user){
              $user_type = User::check_usertype($user->username);
              if(!in_array($user_type,['admin','vendor'])){
                $user_peg = UsersPegawai::where('users_id','=',$request->id)->get();
                // dd($user_peg);
                if($user_peg){
                  foreach($user_peg as $up){
                    Atasan::where('users_pegawai_id',$up->id)->delete();
                    Approver::where('users_pegawai_id',$up->id)->delete();
                  }
                }
                UsersPgs::where('users_id','=',$request->id)->delete();
                if($user_type=='nonorganik'){
                  PegawaiNonorganik::where('n_nik',$user->username)->delete();
                }
                UsersPegawai::where('users_id','=',$request->id)->delete();
                User::where('id',$request->id)->delete();
                $status = true;
                $msg = 'Data berhasil dihapus';
              }
              else{
                $msg = 'User ini tidak dapat dihapus';
              }
            }
          }
          //$data = User::where('id','=',$request->id)->delete();
          return response()->json([
            'status' => $status,
            'msg'    => $msg
          ]);
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
        return \Response::json(['is_pegawai'=>UsersPegawai::is_pegawai($id),'pegawai'=>UsersPegawai::get_by_userid($id),'atasan'=>$data]);
  }
  public function getSelect(Request $request){
        $type = trim($request->type);
        $divisi = trim($request->divisi);
        $unit = trim($request->unit);
        $q = trim($request->q);
        
        if($type=='divisi'){
          $data = User::get_all_disivi($q);
          $data = $data->paginate(30);
          return \Response::json($data);
        }
        if($type=='unit'){
          $data = User::get_unit($q,$divisi);
          $data = $data->paginate(30);
          return \Response::json($data);
        }
        if($type=='posisi'){
          $data = User::get_posisi($q,$unit);
          $data = $data->paginate(30);
          return \Response::json($data);
        }
        return \Response::json([]);
  }
  public function form(Request $request){
    $t_type = ($request->type=='organik')?'Organik':'Non-Organik';
    $data = [
      'page_title' => 'Tambah User '.$t_type,
      'type' => $request->type
    ];
    return view('users::form')->with($data);
  }
  public function store(Request $request){
    exit;
  }
}
