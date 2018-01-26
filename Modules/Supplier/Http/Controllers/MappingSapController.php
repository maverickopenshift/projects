<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Entities\SupplierSap as Sap;

class MappingSapController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
    $id_sup = $request->id;
    $supplier = Supplier::where('id',$id_sup)->first();
    if(!$supplier){
      abort(500);
    }
    $nama_vendor = $supplier->nm_vendor;
    $kota = $supplier->kota;
    $alamat = $supplier->alamat;

    $sap = Sap::where('city',$kota)
    ->Orwhere('name_1', 'like', '%'.$nama_vendor.'%')
    ->Orwhere('street', 'like', '%'.$alamat.'%')->get();
    // dd($sap);
    $action_type="mapping";
    // dd($sap->toArray());
    $page_title = 'Supplier SAP';

        return view('supplier::sap.mapping_sap')->with(compact('sap','page_title','action_type','id_sup'));
    }

    public function simpan(Request $request)
    {
      if ($request->ajax()) {
        $sap_update = Sap::whereIn('id',$request->cb_sap)->update(['supplier_id' => $request->id_sup]);

      if($sap_update){
        $supplier = Supplier::where('id',$request->id_sup)->first();
        $cb_array = implode(",",$request->cb_sap);
        $supplier->id_sap = $cb_array;
        $supplier->save();

        return Response::json(['status'=>true,'csrf_token'=>csrf_token()]);
      }
      return Response::json(['status'=>false]);
    }
    abort(500);

    }

    public function hapus(Request $request)
    {
      if ($request->ajax()) {
        $user = Supplier::where('id',$request->id)->first();

      if($user){
        $id_sap = $user->id_sap;
        $cb_array = explode(",",$id_sap);
        $sap_update = Sap::whereIn('id',$cb_array)->update(['supplier_id' => ""]);

          $user->id_sap = null;
          $user->save();



        //$request->session()->flash('alert-success', 'Data berhasil disetujui!');
        return Response::json(['status'=>true,'csrf_token'=>csrf_token()]);
      }
      return Response::json(['status'=>false]);
    }
    abort(500);
    }
}
