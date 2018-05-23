<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogGroupCoverage as CatalogGroupCoverage;
use Modules\Catalog\Entities\CatalogCoverage as CatalogCoverage;
use App\Permission as Auth;
use App\User;
use Response;
use Datatables;
use Validator;

class GroupCoverageController extends Controller
{
    public function index(Request $request){
        $data['page_title'] = 'Group Coverage';
        return view('catalog::list_product_group_coverage')->with($data);
    }

    public function index_group_coverage_datatables(Request $request){
        $data=CatalogGroupCoverage::get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                $act= '<div class="btn-group">';
                        $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-group-coverage"  data-title="Edit" data-data="'.$dataAttr.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                        $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                $act .='</div>';
                return $act;
            })
            ->make(true);
    }

    public function add(Request $request){
        $rules = array();
        $rules['f_namagroupcoverage']   = 'required|max:50|min:1|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {
            $count=CatalogGroupCoverage::where('nama_group_coverage',$request->f_namagroupcoverage)->count();
            if($count!=0){
                $validator->errors()->add("f_namagroupcoverage", "Nama Group Coverage Sudah ada");
            }
        });

        if ($validator->fails ()){
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
              ));
        }else{
            $proses = new CatalogGroupCoverage();
            $proses->nama_group_coverage = $request->f_namagroupcoverage;
            $proses->save();   
            
            $request->session()->flash('alert-success', 'Data berhasil disimpan');
            return Response::json (array(
                'status' => 'all'
            ));
        }        
    }

    public function edit(Request $request){
        $rules = array();
        $rules['f_namagroupcoverage']   = 'required|max:20|min:1|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {

            $cek_kode=CatalogGroupCoverage::where('id',$request->f_id)->first();
            if($cek_kode->nama_group_coverage != $request->f_namagroupcoverages){
                $count=CatalogGroupCoverage::where('nama_group_coverage',$request->f_namagroupcoverage)
                    ->where('nama_group_coverage',"!=",$cek_kode->nama_group_coverage)->count();
                if($count!=0){
                    $validator->errors()->add("f_namagroupcoverage", "Nama Group Coverage Sudah ada");
                }
            }
        });

        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            $proses = CatalogGroupCoverage::where('id',$request->f_id)->first();
            $proses->nama_group_coverage = $request->f_namagroupcoverage;
            $proses->save();   

            return Response::json (array(
                'status' => 'all'
            ));
        }
    }

    public function delete(Request $request){
        $cek_satuan=CatalogCoverage::where("group_coverage_id",$request->id)->count();
        if($cek_satuan==0){
            $proses=CatalogGroupCoverage::where('id',$request->id)->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
