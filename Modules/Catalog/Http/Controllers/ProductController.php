<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProduct as CatalogProduct;
use Modules\Documents\Entities\DocBoq as DocBoq;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use App\Permission as Auth;
use Response;
use Validator;
use Datatables;

class ProductController extends Controller
{
    public function index(Request $request){
        $data['category']=CatalogCategory::get();    
        $data['product']=\DB::table('catalog_product as a')
                        ->selectRaw('a.*,b.display_name as category_name')
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->get();
        //$data['product']=CatalogProduct::join('')->get();           
        return view('catalog::product2')->with($data);
    }

    public function datatables(Request $request){
        $data=\DB::table('catalog_product as a')
                ->selectRaw('a.*,b.display_name as category_name')
                ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                ->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                    
                    if(\Auth::user()->hasPermission('ubah-permission')){
                        $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                    }
                    
                    if(\Auth::user()->hasPermission('hapus-catalog-product')){
                        $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product"  data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                    }
                    
                    $act .='</div>';
                    return $act;
                    })
                ->make(true);
    }

    public function boq(Request $request){
        if($request->id==0){
            $data=DocBoq::get();
        }else{
            $data=DocBoq::where('id',$request->id)->get();
        }
        

        return Response::json($data);
    }

    public function add(Request $request){
        $rules = [];
        $rules['f_kodeproduct']='required|max:20|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_namaproduct']='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_unitproduct']='required|max:30|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_mtuproduct']='required';
        $rules['f_hargaproduct']='required|max:20|min:1|regex:/^[0-9]+$/';
        $rules['f_descproduct']='max:300|regex:/^[a-z0-9 .\-]+$/i';
        /*
        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());

        if ($validator->fails ()){
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
        */
        
        if(count($request->f_kodeproduct)>0){
            foreach($request->f_kodeproduct as $key => $val){
                if(!empty($val)){
                    $proses = new CatalogProduct();
                    $proses->catalog_category_id = $request['f_parentid'];
                    $proses->code = $request['f_kodeproduct'][$key];
                    $proses->name =$request['f_namaproduct'][$key];
                    $proses->unit = $request['f_unitproduct'][$key];
                    $proses->currency = $request['f_mtuproduct'][$key];
                    $proses->price = $request['f_hargaproduct'][$key];
                    $proses->desc = $request['f_descproduct'][$key];
                    $proses->keyword = "";
                    $proses->save();
                }
            }
        }
        return redirect()->route('catalog.product');
        
    }

    public function edit(Request $request){
        $data['category']=CatalogCategory::get();
        $data['data']=CatalogProduct::where('id',$request->id)->first();           
        
        return view('catalog::product_input')->with($data);
    }

    public function edit_proses(Request $request){
        $proses = CatalogProduct::where('id',$request->id)->first();
        $proses->catalog_category_id = $request->f_indukproduct;
        $proses->code = $request->f_kodeproduct;
        $proses->name =$request->f_namaproduct;
        $proses->unit = $request->f_unitproduct;
        $proses->currency = $request->f_matauang;
        $proses->price = $request->f_hargaproduct;
        $proses->desc = $request->f_descproduct;
        $proses->keyword = "";
        $proses->save();

        return redirect()->route('catalog.product');
    }

    public function delete(Request $request){
        $proses=CatalogProduct::where('id',$request->id)->delete();
        return 1;
    }
}
