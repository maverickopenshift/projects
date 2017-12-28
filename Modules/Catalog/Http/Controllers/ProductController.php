<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProduct as CatalogProduct;
use Modules\Documents\Entities\DocBoq as DocBoq;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use App\Permission as Auth;
//use App\User;
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
        return view('catalog::product2')->with($data);
    }

    public function datatables(Request $request){
        if($request->parent_id==0){
            $data=CatalogProduct::get();
        }else{
            $data=CatalogProduct::where('catalog_category_id',$request->parent_id)->get();
        }

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';

                    if(\Auth::user()->hasPermission('catalog-product')){
                        $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                    }

                    if(\Auth::user()->hasPermission('hapus-catalog-product')){
                        $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
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
        /*
        $rules = [];
        $rules['f_kodeproduct']='required|max:20|min:5|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_namaproduct']='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_unitproduct']='required|max:30|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_mtuproduct']='required';
        $rules['f_hargaproduct']='required|max:20|min:1|regex:/^[0-9]+$/';
        $rules['f_descproduct']='max:300|regex:/^[a-z0-9 .\-]+$/i';
        
        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());

        if ($validator->fails ()){
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }else{
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
        //}        
    }

    public function edit(Request $request){
        $rules = array (
            'f_kodeproduk' => 'required|min:2|max:250',
            'f_namaproduk' => 'required|min:2|max:250',
            'f_unitproduk' => 'required|min:2|max:250',
            'f_matauangproduk' => 'required|min:2|max:250',
            'f_hargaproduk' => 'required|min:2|max:250',
            'f_descproduk' => 'required|min:2|max:500',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            $proses = CatalogProduct::where('id',$request->f_id)->first();
            $proses->catalog_category_id = $request->f_parentid;
            $proses->code = $request->f_kodeproduk;
            $proses->name =$request->f_namaproduk;
            $proses->unit = $request->f_unitproduk;
            $proses->currency = $request->f_matauangproduk;
            $proses->price = $request->f_hargaproduk;
            $proses->desc = $request->f_descproduk;
            $proses->keyword = "";
            $proses->save();   

            return response()->json($proses);
        }
    }

    public function edit_proses(Request $request){
        $proses = CatalogProduct::where('id',$request->f_id)->first();
        $proses->catalog_category_id = $request->f_parentid;
        $proses->code = $request->f_kodeproduct;
        $proses->name =$request->f_namaproduct;
        $proses->unit = $request->f_unitproduct;
        $proses->currency = $request->f_matauang;
        $proses->price = $request->f_hargaproduct;
        $proses->desc = $request->f_descproduct;
        $proses->keyword = "";   

        return redirect()->route('catalog.product');
    }

    public function delete(Request $request){
        $proses=CatalogProduct::where('id',$request->id)->delete();
        return 1;
    }
}
