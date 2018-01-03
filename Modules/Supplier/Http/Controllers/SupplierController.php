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
    public function index()
    {
      $username=auth()->user()->username;
      $sql = supplier::where('kd_vendor','=',$username)->first();

      $notif = "Belum Disetujui";
            if($sql){
              if($sql->vendor_status  == '1'){
                $notif="Sudah Disetujui";
              }
            }
        $data['page_title'] = 'Supplier';
        return view('supplier::index')->with($data);
    }
    public function data()
    {
        $sql = Supplier::with('user','supplierSap')->get();
        // dd($sql);
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
                $sts = "Tidak Disetujui";
              }else{
                $sts = "-";
              }
              return $sts;
            })
            ->addColumn('action', function ($data) {
              // dd($data->vendor_status);

                $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                $roles = htmlspecialchars(json_encode($data->roles), ENT_QUOTES, 'UTF-8');
              $act= '<div class="">';
              if(\Auth::user()->hasPermission('ubah-supplier')){
                  $act .='<a href="'.route('supplier.lihat',['id'=>$data->id,'status'=>'lihat']).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Lihat</a> <br>';
              }
              if(\Auth::user()->hasPermission('ubah-supplier')){
                if($data->id_sap==="" || $data->id_sap==null){
                  $act .='<a href="'.route('supplier.mapping.sap',['id'=>$data->id]).'" class="btn btn-success btn-xs">Link To SAP</a> <br>';
                }else{
                  $act .='<button class="btn btn-danger btn-xs unlink_btn" data-id="'.$data->id.'">Unlink To SAP</button> <br>';
                }

              }
  //             if(\Auth::user()->hasPermission('ubah-supplier')){
  //                 $act .='<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#form-modal"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-roles="'.$roles.'">
  // <i class="glyphicon glyphicon-edit"></i> Edit Status</button>';
  //             }
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

        // if (empty($search)) {
        //     return \Response::json([]);
        // }
        $data = Supplier::select('id','nm_vendor','kd_vendor','bdn_usaha');
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('nm_vendor', 'like', '%'.$search.'%');
              $q->orWhere('kd_vendor', 'like', '%'.$search.'%');
          });
        }
        $data = $data->paginate(30);
        return \Response::json($data);
    }
}
