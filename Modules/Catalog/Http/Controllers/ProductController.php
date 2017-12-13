<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProduct as CatalogProduct;
use Modules\Documents\Entities\DocBoq as DocBoq;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Response;

class ProductController extends Controller
{
    public function index(Request $request){
        $data['category']=CatalogCategory::get();    
        $data['product']=\DB::table('catalog_product as a')
                        ->selectRaw('a.*,b.display_name as category_name')
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->get();
        //$data['product']=CatalogProduct::join('')->get();           
        return view('catalog::product')->with($data);
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
        if(count($request->f_kodeproduct)>0){
            foreach($request->f_kodeproduct as $key => $val){
                if(!empty($val)){
                    $proses = new CatalogProduct();
                    $proses->catalog_category_id = $request['f_indukproduct'][$key];
                    $proses->code = $request['f_kodeproduct'][$key];
                    $proses->name =$request['f_namaproduct'][$key];
                    $proses->unit = $request['f_unitproduct'][$key];
                    $proses->currency = $request['f_matauang'][$key];
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

    public function delete(Request $request)
    {
        $proses=CatalogProduct::where('id',$request->id)->delete();
        
        return redirect()->route('catalog.product');
    }
}
