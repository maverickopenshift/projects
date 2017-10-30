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

        $sql = Supplier::with('user')->get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              $act= '<div class="btn-group">';
              if(\Auth::user()->hasPermission('ubah-supplier')){
                  $act .='<a href="'.route('supplier.edit',['id'=>$data->id]).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Lihat</a> <br>';
              }
              if(\Auth::user()->hasPermission('ubah-supplier')){
                  $act .='<a href="'.route('supplier.edit',['id'=>$data->id]).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Edit Status</a>';
              }
              if(\Auth::user()->hasPermission('hapus-supplier')){
                $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button> <br>';
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
}
