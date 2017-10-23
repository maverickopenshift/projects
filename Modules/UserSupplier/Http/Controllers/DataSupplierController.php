<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\supplier;

use App\Helpers\Helpers;
use Datatables;
use Validator;
use Response;

class DataSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      $data['page_title'] = 'Data Supplier';
      return view("usersupplier::dataSupplier.index")->with($data);
    }

    public function data()
    {
      $id_session=auth()->user()->id;
      $sql = supplier::where('id_user','=',$id_session)->get();
      return Datatables::of($sql)
          ->addIndexColumn()
          ->filterColumn('created_at', function ($query, $keyword) {
              $query->whereRaw("DATE_FORMAT(c_others.created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
          })
          ->editColumn('created_at', function ($data) {
              if($data->updated_at){
                  return $data->updated_at->format('d-m-Y H:i');
              }
              return;
          })
          ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
     public function tambah()
     {
         $data['page_title'] = 'Kelengkapan Data Supplier';
         return view('usersupplier::dataSupplier.create')->with($data);
     }

     public function add(Request $request)
     {
       $rules = array (
           'bdn_usaha'         => 'required|max:250|min:2|regex:/^[a-z0-9 .\-]+$/i',
           'nm_vendor'         => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
           'prinsipal_st'      => 'required|boolean',
           'klasifikasi_usaha.*' => 'required|regex:/^[a-z0-9 .\-]+$/i',
           'pengalaman_kerja'  => 'required|min:30|regex:/^[a-z0-9 .\-]+$/i',

           'alamat'            => 'required|max:1000|min:10|regex:/^[a-z0-9 .\-]+$/i',
           'kota'              => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
           'kd_pos'            => 'required|digits_between:3,20',
           'telepon'           => 'required|digits_between:7,20',
           'fax'               => 'required|digits_between:7,20',
           'email'             => 'required|max:50|min:4|email',
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
           'legal_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          //  'legal_dokumen.*.file' => 'required|mimes:pdf',
           'sertifikat_dokumen.*.name' => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
          //  'sertifikat_dokumen.*.file' => 'required|mimes:pdf',

           'nm_direktur_utama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
           'nm_komisaris_utama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
           'cp1_nama'     => 'required|max:500|min:3|regex:/^[a-z0-9 .\-]+$/i',
           'cp1_telp'     => 'required|digits_between:7,20',
           'cp1_email'     => 'required|max:50|min:4|email',
           'jml_peg_domestik'     => 'required|integer',
           'jml_peg_asing'     => 'required|integer',

           // 'password' => 'required|confirmed|max:50|min:5',
       );
       $validator = Validator::make($request->all(), $rules,Helpers::error_submit_supplier());
       if ($validator->fails ()){
         return redirect()->back()
                     ->withInput($request->input())
                     ->withErrors($validator);
       }
       else {
         dd($request);
          $id_usr = auth()->user()->id;
          $usr_nm = auth()->user()->username;
          $data = new supplier();
          $data->id_user = $id_usr;
          $data->kd_vendor = $usr_nm;

          $data->bdn_usaha = $request->bdn_usaha;
          $data->nm_vendor = $request->nm_vendor;
          $data->prinsipal_st = $request->prinsipal_st;

          $data->alamat = $request->alamat;
          $data->kota = $request->kota;
          $data->kd_pos = $request->kd_pos;
          $data->negara = $request->negara;
          $data->telepon = $request->telepon;
          $data->fax = $request->fax;
          $data->email = $request->email;
          $data->web_site = $request->web_site;
          $data->induk_perus = $request->induk_perus;

          $data->asset = $request->asset;
          $data->bank_nama = $request->bank_nama;
          $data->bank_cabang = $request->bank_cabang;
          $data->bank_norek = $request->bank_norek;

          $data->akte_awal_no = $request->akte_awal_no;
          $data->akte_awal_tg = $request->akte_awal_tg;
          $data->akte_awal_notaris = $request->akte_awal_notaris;
          $data->akte_akhir_no = $request->akte_akhir_no;
          $data->akte_akhir_tg = $request->akte_akhir_tg;
          $data->akte_akhir_notaris = $request->akte_akhir_notaris;
          $data->siup_no = $request->siup_no;
          $data->siup_tg_terbit = $request->siup_tg_terbit;
          $data->siup_tg_expired = $request->siup_tg_expired;
          $data->siup_kualifikasi = $request->siup_kualifikasi;
          $data->pkp = $request->pkp;
          $data->npwp_no = $request->npwp_no;
          $data->npwp_tg = $request->npwp_tg;
          $data->tdp_no = $request->tdp_no;
          $data->tdp_tg_terbit = $request->tdp_tg_terbit;
          $data->tdp_tg_expired = $request->tdp_tg_expired;
          $data->idp_no = $request->idp_no;
          $data->idp_tg_terbit = $request->idp_tg_terbit;
          $data->idp_tg_expired = $request->idp_tg_expired;
          $data->iujk_no = $request->iujk_no;
          $data->iujk_tg_terbit = $request->iujk_tg_terbit;
          $data->iujk_tg_expired = $request->iujk_tg_expired;

          $data->cp1_nama = $request->nm_kontak;
          $data->cp1_telp = $request->phone_kontak;
          $data->cp1_email = $request->alamat_email;
          $data->jml_peg_domestik = $request->jum_dom;
          $data->jml_peg_asing = $request->jum_as;
          $data->save();


        }
        return response()->json($data);

}
}
