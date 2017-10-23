<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use App\Role;
use App\Helpers\Helpers;
use Modules\Supplier\Entities\Supplier;
use Datatables;
use Validator;
use Response;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['page_title'] = 'Supplier';
        return view('supplier::index')->with($data);
    }
    public function data()
    {
        $sql = Supplier::with('user')->get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
              $roles = htmlspecialchars(json_encode($data->roles), ENT_QUOTES, 'UTF-8');
                            return '
                            <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-roles="'.$roles.'">
            <i class="glyphicon glyphicon-edit"></i> Edit
            </button><button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete">
            <i class="glyphicon glyphicon-trash"></i> Delete
            </button></div>';
            })
            ->addColumn('role_name', function (User $user) {
                return $user->roles->map(function ($role) {
                    return $role->display_name;
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
    public function create()
    {
        $data['page_title'] = 'Add Supplier';
        return view('supplier::create')->with($data);
    }
    
    public function store(Request $request)
    {
      //dd($request->all());
      $rules = array (
          'bdn_usaha'         => 'required|max:250|min:2|regex:/^[a-z0-9 .\-]+$/i',
          'nm_vendor'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'nm_vendor_uq'      => 'max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'prinsipal_st'      => 'required|boolean',
          'klasifikasi_usaha.*' => 'required|regex:/^[a-z0-9 .\-]+$/i',
          'pengalaman_kerja'  => 'required|min:30|regex:/^[a-z0-9 .\-]+$/i',
          'alamat'            => 'required|max:1000|min:10|regex:/^[a-z0-9 .\-]+$/i',
          'kota'              => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'kd_pos'            => 'required|digits_between:3,20',
          'telepon'           => 'required|digits_between:7,20',
          'fax'               => 'required|digits_between:7,20',
          'email'             => 'required|max:50|min:4|email',
          'password'          => 'required|max:50|min:6|confirmed',
          'web_site'          => 'sometimes|nullable|url',
          'induk_perus'       => 'sometimes|nullable|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'anak_perusahaan.*' => 'sometimes|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'asset'             => 'required|max:500|min:3|digits_between:3,50',
          'bank_nama'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'bank_cabang'       => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'bank_norek'        => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'bank_kota'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'akte_awal_no'      => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'akte_awal_tg'      => 'required|date_format:"Y-m-d"',
          'akte_awal_notaris' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'akte_akhir_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'akte_akhir_tg'     => 'required|date_format:"Y-m-d"',
          'akte_akhir_notaris'=> 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'siup_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'siup_tg_terbit'     => 'required|date_format:"Y-m-d"',
          'siup_tg_expired'     => 'required|date_format:"Y-m-d"',
          'siup_kualifikasi'     => 'required|in:"1","2","3"',
          'pkp'      => 'required|boolean',
          'npwp_no'     => 'required_if:pkp,"1"|nullable|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'npwp_tg'     => 'required_if:pkp,"1"|nullable|date_format:"Y-m-d"',
          'tdp_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'tdp_tg_terbit'     => 'required|date_format:"Y-m-d"',
          'tdp_tg_expired'     => 'required|date_format:"Y-m-d"',
          'idp_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'idp_tg_terbit'     => 'required|date_format:"Y-m-d"',
          'idp_tg_expired'     => 'required|date_format:"Y-m-d"',
          'iujk_no'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'iujk_tg_terbit'     => 'required|date_format:"Y-m-d"',
          'iujk_tg_expired'     => 'required|date_format:"Y-m-d"',
          'nm_direktur_utama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'nm_komisaris_utama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'cp1_nama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          'cp1_telp'     => 'required|digits_between:7,20',
          'cp1_email'     => 'required|max:50|min:4|email',
          'jml_peg_domestik'     => 'required|integer',
          'jml_peg_asing'     => 'required|integer',
          'legal_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i', 
          'legal_dokumen.*.file' => 'required|mimes:pdf', 
          'sertifikat_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i', 
          'sertifikat_dokumen.*.file' => 'required|mimes:pdf', 
          // 'password' => 'required|confirmed|max:50|min:5',
      );
      $validator = Validator::make($request->all(), $rules,Helpers::error_submit_supplier());
      if ($validator->fails ()){
        return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
      }
      else {
        return redirect()->back()
                    ->withInput($request->input());
      }
    }
}
