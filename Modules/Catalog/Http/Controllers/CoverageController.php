<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogCoverage as CatalogCoverage;
use Modules\Catalog\Entities\CatalogGroupCoverage as CatalogGroupCoverage;
use Modules\Catalog\Entities\CatalogProductLogistic as CatalogProductLogistic;
use App\Permission as Auth;
use App\User;
use Response;
use DB;
use Datatables;
use Validator;

class CoverageController extends Controller
{
    public function index(Request $request){
        $data['page_title'] = 'Coverage';
        return view('catalog::list_product_coverage')->with($data);
    }

    public function get_group_coverage(Request $request){
        $search = trim($request->q);
        $data = CatalogGroupCoverage::selectRaw('id as id, nama_group_coverage as text');

        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('nama_group_coverage', 'like', '%'.$search.'%');
          });
        }
        
        $data = $data->paginate(30);
        return \Response::json($data);
    }

    public function get_group_coverage_normal(Request $request){
        $data = CatalogGroupCoverage::selectRaw('id, nama_group_coverage as text')
                ->get();

        $hasil=array();
        for($i=0;$i<count($data);$i++){
            $hasil[$i]['id']=$data[$i]->id;
            $hasil[$i]['text']=$data[$i]->text;
        }

        return Response::json($hasil);
    }

    public function get_coverage(Request $request){
        $search = trim($request->q);
        $data = CatalogCoverage::selectRaw('id as id, nama_coverage as text')
                ->where('group_coverage_id',$request->id_group_coverage);

        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('nama_coverage', 'like', '%'.$search.'%');
          });
        }
        
        $data = $data->paginate(30);

        return \Response::json($data);
    }

    public function index_coverage_datatables(Request $request){
        $data=DB::table('catalog_coverage as a')
                    ->join('catalog_group_coverage as b','b.id','=','a.group_coverage_id')
                    ->selectRaw("a.*, b.nama_group_coverage")
                    ->orderby('a.group_coverage_id')
                    ->get();

        return Datatables::of($data)
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                            $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-coverage"  data-title="Edit" data-data="'.$dataAttr.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                            $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                    $act .='</div>';
                    return $act;
                })
                ->make(true);
    }

    public function add(Request $request){
        $rules = array();
        $rules['f_namacoverage']   = 'required|max:50|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_nogroupcoverage']   = 'required|max:50|min:1|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {
            $count=CatalogCoverage::where('nama_coverage',$request->f_namacoverage)->count();
            if($count!=0){
                $validator->errors()->add("f_namacoverage", "Nama Coverage Sudah ada");
            }
        });

        if ($validator->fails ()){
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
              ));
        }else{
            $proses = new CatalogCoverage();
            $proses->nama_coverage      = $request['f_namacoverage'];
            $proses->group_coverage_id  = $request['f_nogroupcoverage'];
            $proses->save();   
            
            $request->session()->flash('alert-success', 'Data berhasil disimpan');
            return Response::json (array(
                'status' => 'all'
            ));
        }        
    }

    public function edit(Request $request){
        $rules = array();
        $rules['f_namacoverage']   = 'required|max:20|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_nogroupcoverage']   = 'required|max:50|min:1|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {

            $cek_kode=CatalogCoverage::where('id',$request->f_id)->first();
            if($cek_kode->nama_coverage != $request->f_namacoverage){
                $count=CatalogCoverage::where('nama_coverage',$request->f_namacoverage)
                    ->where('nama_coverage',"!=",$cek_kode->nama_coverage)->count();
                if($count!=0){
                    $validator->errors()->add("f_namacoverage", "Nama coverage Sudah ada");
                }
            }
        });

        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            $proses                     = CatalogCoverage::where('id',$request->f_id)->first();
            $proses->nama_coverage      = $request->f_namacoverage;
            $proses->group_coverage_id  = $request->f_nogroupcoverage;
            $proses->save();

            return Response::json (array(
                'status' => 'all'
            ));
        }
    }

    public function delete(Request $request){
        $cek_satuan=CatalogProductLogistic::where("coverage_id",$request->id)->count();
        if($cek_satuan==0){
            $proses=CatalogCoverage::where('id',$request->id)->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
