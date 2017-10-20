<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\supplier;
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
          $data = new supplier();
          $data->id_user = "35";
          $data->kd_vendor = "VR0044";

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

          $data->cp1_nama = $request->nm_kontak;
          $data->cp1_telp = $request->phone_kontak;
          $data->cp1_email = $request->alamat_email;
          $data->jml_peg_domestik = $request->jum_dom;
          $data->jml_peg_asing = $request->jum_as;
          $data->save();
          return response()->json($data);

}
}
