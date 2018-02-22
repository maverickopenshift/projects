<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use App\Role;
use App\Helpers\Helpers;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Entities\SupplierMetadata;
use Datatables;
use Validator;
use Response;
use DB;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
      $username=auth()->user()->username;
      $status = $request->status;
      if($status == "proses"){
        $sql = Supplier::with('user','supplierSap')
        ->where('vendor_status', '=', '0')->paginate(50);
      }else{
        $sql = Supplier::with('user','supplierSap')->paginate(50);
      }
      
      $kode_sap = "99999";
      $page_title = 'Supplier';
      $sts = $status;
      return view('supplier::index')->with(compact('sql','page_title','sts'));
    }

    public function data(Request $request)
    {
      $sql = Supplier::with('user','supplierSap');
      $status = $request->status;
      if($status == "proses"){
        $sql->where('vendor_status', '=', '0');
      }
      $sql->get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('id_sap', function ($data){
              if($data->id_sap==="" || $data->id_sap==null){
                $sap = "-";
              }else{
                foreach ($data->supplierSap as $key => $v) {
                  $vendor[] = $v->vendor;
                }
                $kalimat = implode(', ',$vendor);
                $sap = $kalimat;
              }
              return $sap;
            })
            ->addColumn('vendor_status', function ($data){
              if($data->vendor_status==0){
                $sts = 'Belum Disetujui';
              }else if($data->vendor_status==1){
                $sts = "Sudah Disetujui";
              }else if($data->vendor_status==2){
                $sts = "Data Dikembalikan";
              }else{
                $sts = "-";
              }
              return $sts;
            })
            ->addColumn('action', function ($data) {
                $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                $roles = htmlspecialchars(json_encode($data->roles), ENT_QUOTES, 'UTF-8');
              $act= '<div class="">';
              if(\Auth::user()->hasPermission('ubah-supplier')){
                  $act .='<a href="'.route('supplier.lihat',['id'=>$data->id,'status'=>'lihat']).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Lihat</a> <br>';
              }
              if($data->vendor_status !== 0){
                if(\Auth::user()->hasPermission('ubah-supplier')){
                  if($data->id_sap==="" || $data->id_sap==null){
                    $act .='<a href="'.route('supplier.mapping.sap',['id'=>$data->id]).'" class="btn btn-success btn-xs">Link To SAP</a> <br>';
                  }else{
                    $act .='<button class="btn btn-danger btn-xs unlink_btn" data-id="'.$data->id.'">Unlink To SAP</button> <br>';
                  }

                }
              }
              if(\Auth::user()->hasPermission('hapus-supplier')){
                $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Deleteeee</button> <br>';
              }
              return $act.'</div>';
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
    
    public function getSelect(Request $request){
        $search = trim($request->q);

        $data = Supplier::select('id','nm_vendor','kd_vendor','bdn_usaha')->where('vendor_status', '=', '1');
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('nm_vendor', 'like', '%'.$search.'%');
              $q->orWhere('kd_vendor', 'like', '%'.$search.'%');
          });
        }
        $data = $data->paginate(30);
        return \Response::json($data);
    }

    public function filtersupplier(Request $request){
      $isi = $request->kode;
      // dd($isi);
      if($isi == "sudah_mapping"){
        $data = Supplier::with('user','supplierSap')->whereNotNull('id_sap')->Where('id_sap','<>','')->get();
      }else if($isi == "belum_mapping"){
        $data = Supplier::with('user','supplierSap')->whereNull('id_sap')->get();
      }else if($isi == ""){
        $data = Supplier::with('user','supplierSap')->get();
      }else {
        $data = Supplier::with('user','supplierSap')->where('vendor_status',$isi)->get();
      }
        return Response::json($data);
    }
}
