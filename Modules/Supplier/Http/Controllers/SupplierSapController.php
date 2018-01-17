<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use Modules\Supplier\Entities\SupplierSap;
use Modules\Supplier\Entities\SupplierMetadata;
use App\Helpers\Helpers;
use Datatables;
use Response;

class SupplierSapController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['page_title'] = 'Supplier SAP';
        return view('supplier::sap.index_sap')->with($data);
    }
     public function data()
     {
         $sql = SupplierSap::with('user')->get();
         // dd($sql);
         return Datatables::of($sql)
             ->addIndexColumn()
             ->addColumn('action', function ($data) {
               // dd($data->vendor_status);

                 $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                 $roles = htmlspecialchars(json_encode($data->roles), ENT_QUOTES, 'UTF-8');
               $act= '<div class="">';
               if(\Auth::user()->hasPermission('ubah-supplier')){
                   $act .='<a href="'.route('supplier.sap.lihat',['id'=>$data->id]).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Lihat</a> <br>';
               }
               if(\Auth::user()->hasPermission('hapus-supplier')){
                 $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button> <br>';
               }
               return $act.'</div>';
             })
             ->filterColumn('upload_date', function ($query, $keyword) {
                 $query->whereRaw("DATE_FORMAT(c_others.upload_date,'%Y/%m/%d') like ?", ["%$keyword%"]);
             })
             ->make(true);
     }

     public function lihat(Request $request)
     {
       $id = $request->id;
       $supplierSap = SupplierSap::where('id',$id)->first();
       if(!$supplierSap){
         abort(500);
       }
       $page_title = 'Lihat Supplier';
       return view('supplier::sap.form')->with(compact('supplierSap','page_title','id'));
       dd($supplierSap);
     }
}
