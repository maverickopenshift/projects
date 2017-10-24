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
        $data['page_title'] = 'Supplier';
        return view('supplier::index')->with($data);
    }
    public function data()
    {
        $sql = Supplier::with('user')->get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                            return '
                            <div class="btn-group">
                            <a href="'.route('supplier.edit',['id'=>$data->id]).'" class="btn btn-primary btn-xs">
            <i class="glyphicon glyphicon-list-alt"></i> Lihat
            </a><button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete">
            <i class="glyphicon glyphicon-trash"></i> Delete
            </button></div>';
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
