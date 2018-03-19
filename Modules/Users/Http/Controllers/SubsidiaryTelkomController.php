<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use Modules\Users\Entities\SubsidiaryTelkom;
use Modules\Users\Entities\PegawaiSubsidiary;
use Modules\Users\Entities\UsersPegawai;
use Modules\Users\Entities\Pegawai;
use Modules\Users\Entities\UsersAtasan as Atasan;
use Datatables;
use Response;
use Validator;

class SubsidiaryTelkomController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      $data['page_title'] = 'Subsidiary Telkom';
      return view('users::subsidiary-telkom')->with($data);
    }
    public function data()
    {
        $sql = SubsidiaryTelkom::get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              $modal = '#form-modal';
              $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
              $act= '<div>';
              if(\Auth::user()->hasPermission('ubah-user')){
                  $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="'.$modal.'"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'">
  <i class="glyphicon glyphicon-edit"></i> Edit
  </button>';
              }
              if(\Auth::user()->hasPermission('hapus-user')){
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
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function add(Request $request)
    {
        if (!$request->ajax()) {abort(404);};
        $rules = array (
            'name'     => 'required|max:250|min:3',
            'address' => 'required|max:1250|min:3',
            'phone'    => 'required|max:15|min:5',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails ()){
          return Response::json (array(
              'errors' => $validator->getMessageBag()->toArray()
          ));
        }
            
        else {
          $data = new SubsidiaryTelkom();
          $data->name = $request->name;
          $data->address = $request->address;
          $data->phone = $request->phone;
          $data->save ();
          return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
      if (!$request->ajax()) {abort(404);};
      $rules = array (
          'id'     => 'exists:subsidiary_telkom,id',
          'name'     => 'required|max:250|min:3',
          'address' => 'required|max:1250|min:3',
          'phone'    => 'required|max:15|min:5',
      );
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails ()){
        return Response::json (array(
            'errors' => $validator->getMessageBag()->toArray()
        ));
      }
          
      else {
        $data = SubsidiaryTelkom::where('id',$request->id)->first();
        $data->name = $request->name;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->save ();
        return response()->json($data);
      }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete(Request $request)
    {
      if (!$request->ajax()) {abort(404);};
      $data = SubsidiaryTelkom::where('id',$request->id)->first();
      if(!$data){abort(404);}
      $delete=SubsidiaryTelkom::where('id',$request->id)->delete();
      if($delete){
        return response()->json([
          'status' => true,
          'msg'    => 'Data berhasil dihapus'
        ]);
      }
      return response()->json([
        'status' => false,
        'msg'    => 'Data tidak dapat dihapus'
      ]);
    }
    public function getSelect(Request $request){
        $search = trim($request->q);

        // if (empty($search)) {
        //     return \Response::json([]);
        // }
        $data = SubsidiaryTelkom::get_data($search)->paginate(30);
        return \Response::json($data);
    }
    public function addUser(Request $request)
    {
      if (!$request->ajax()) {abort(404);};
      $rules = array (
          'subsidiary_telkom' => 'required|exists:subsidiary_telkom,id',
          'name'     => 'required|max:250|min:3',
          'username' => 'required|unique:users,username|max:250|min:3',
          'email'    => 'required|email|unique:users,email|max:250|min:5',
          'phone'    => 'sometimes|nullable|max:15|min:5',
          'password' => 'required|confirmed|max:50|min:5',
          'roles'    => 'required|exists:roles,id',
          'divisi'   => 'required|max:250|min:2',
          'unit'     => 'required|max:250|min:2',
          'jabatan'  => 'required|max:250|min:2',
      );
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
        $data = new User();
        $data->name = $request->name;
        $data->username = $request->username;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->user_type = 'subsidiary';
        $data->save ();
        $data->attachRole($request->roles);
        
        $peg_non = new PegawaiSubsidiary();
        $peg_non->subsidiary_id = $request->subsidiary_telkom;
        $peg_non->n_tahun = date('Y');
        $peg_non->n_bulan = date('m');
        $peg_non->n_nik = $request->username;
        $peg_non->v_nama_karyawan = $request->name;
        $peg_non->v_short_divisi = $request->divisi;
        $peg_non->d_tgl_divisi = date('Y-m-d');
        $peg_non->v_short_unit = $request->unit;
        $peg_non->v_long_unit = $request->unit;
        $peg_non->d_tgl_unit = date('Y-m-d');
        $peg_non->v_short_posisi = $request->jabatan;
        $peg_non->v_long_posisi = $request->jabatan;
        $peg_non->d_tgl_posisi = date('Y-m-d');
        $peg_non->save();
        
        $peg = new UsersPegawai();
        $peg->users_id = $data->id;
        $peg->nik = $data->username;
        $peg->save();
        
        if (count($request->atasan_id)>0 && $request->has(['atasan_id'])) {
            foreach($request->atasan_id as $key=>$v){
              $atasan = new Atasan();
              $atasan->users_pegawai_id = $peg->id;
              $atasan->nik = $v;
              $atasan->save();
            }
        }
        Pegawai::callProc($data->username,'subsidiary');
        return response()->json($data);
      }
    }
    public function updateUser(Request $request)
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
            'divisi'   => 'required|max:250|min:2',
            'unit'     => 'required|max:250|min:2',
            'jabatan'  => 'required|max:250|min:2',
        );
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
          $data = User::where('id','=',$request->id)->first();
          $data->name = $request->name;
          $data->username = $request->username;
          $data->phone = $request->phone;
          $data->email = $request->email;
          $data->save ();
          $data->syncRoles([$request->roles]);
          
          $pegs = UsersPegawai::get_by_userid($id,'subsidiary');
          $peg = UsersPegawai::where('nik','=',$pegs->n_nik)->first();
          $peg_non = PegawaiSubsidiary::where('n_nik',$pegs->n_nik)->first();
          
          $peg->nik = $data->username;
          $peg->save();
          
          
          $peg_non->subsidiary_id = $request->subsidiary_telkom;
          $peg_non->n_tahun = date('Y');
          $peg_non->n_bulan = date('m');
          $peg_non->n_nik = $request->username;
          $peg_non->v_nama_karyawan = $request->name;
          $peg_non->v_short_divisi = $request->divisi;
          $peg_non->d_tgl_divisi = date('Y-m-d');
          $peg_non->v_short_unit = $request->unit;
          $peg_non->v_long_unit = $request->unit;
          $peg_non->d_tgl_unit = date('Y-m-d');
          $peg_non->v_short_posisi = $request->jabatan;
          $peg_non->v_long_posisi = $request->jabatan;
          $peg_non->d_tgl_posisi = date('Y-m-d');
          $peg_non->save();
          Atasan::where('users_pegawai_id',$pegs->ids)->delete();
          
          if (count($request->atasan_id)>0 &&   $request->has(['atasan_id'])) {
              foreach($request->atasan_id as $key=>$v){
                $atasan = new Atasan();
                $atasan->users_pegawai_id = $pegs->ids;
                $atasan->nik = $v;
                $atasan->save();
              }
          }
          Pegawai::callProc($data->username,'subsidiary');
          return response()->json($data);
        }
    }
}
