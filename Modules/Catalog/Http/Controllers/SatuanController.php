<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogSatuan as CatalogSatuan;
use Modules\Catalog\Entities\CatalogProductMaster as CatalogProductMaster;
use App\Permission as Auth;
use App\User;
use Response;
use Datatables;
use Validator;

class SatuanController extends Controller
{
    public function index(Request $request){
        $data['page_title'] = 'Satuan';
        return view('catalog::list_product_satuan')->with($data);
    }

    public function index_satuan_datatables(Request $request){
        $data=CatalogSatuan::get();

        return Datatables::of($data)
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                            $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-satuan"  data-title="Edit" data-data="'.$dataAttr.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                            $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                    $act .='</div>';
                    return $act;
                })
                ->make(true);
    }

    public function add(Request $request){
        $rules = array();
        $rules['f_namasatuan']   = 'required|max:20|min:1|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {
            $count=CatalogSatuan::where('nama_satuan',$request->f_namasatuan)->count();
            if($count!=0){
                $validator->errors()->add("f_namasatuan", "Nama Satuan Sudah ada");
            }
        });

        if ($validator->fails ()){
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
              ));
        }else{
            $proses = new CatalogSatuan();
            $proses->nama_satuan = $request['f_namasatuan'];
            $proses->save();   
            
            $request->session()->flash('alert-success', 'Data berhasil disimpan');
            return Response::json (array(
                'status' => 'all'
            ));
        }        
    }

    public function edit(Request $request){
        $rules = array();
        $rules['f_namasatuan']   = 'required|max:20|min:1|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {
            $cek_kode=CatalogSatuan::where('id',$request->f_id)->first();
            if($cek_kode->nama_satuan != $request->f_namasatuan){
                $count=CatalogSatuan::where('nama_satuan',$request->f_namasatuan)
                    ->where('nama_satuan',"!=",$cek_kode->nama_satuan)->count();
                if($count!=0){
                    $validator->errors()->add("f_namasatuan", "Nama satuan Sudah ada");
                }
            }
        });

        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            $proses                 = CatalogSatuan::where('id',$request->f_id)->first();
            $proses->nama_satuan    = $request->f_namasatuan;
            $proses->save();   

            return Response::json (array(
                'status' => 'all'
            ));
        }
    }

    public function delete(Request $request){
        $cek_satuan=CatalogProductMaster::where("satuan_id",$request->id)->count();
        if($cek_satuan==0){
            $proses=CatalogSatuan::where('id',$request->id)->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
