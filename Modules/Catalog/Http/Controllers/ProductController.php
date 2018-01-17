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
        $data['page_title'] = 'Item Katalog';
        return view('catalog::product')->with($data);
    }

    public function get_product_induk(Request $request){
        $result=CatalogCategory::selectRaw('id, code, display_name')->get();

        $hasil=array();
        for($i=0;$i<count($result);$i++){
            $hasil[$i]['id']=$result[$i]->id;
            $hasil[$i]['text']=$result[$i]->code ." - ". $result[$i]->display_name;
        }

        return Response::json($hasil);
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

                    if(\Auth::user()->hasPermission('ubah-catalog-product')){
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
        $rules = array();

        foreach($request->f_kodeproduct as $key => $val){
            $rules['f_kodeproduct.'.$key]   ='required|max:20|min:5|regex:/^[a-z0-9 .\-]+$/i';
            $rules['f_namaproduct.'.$key]   ='required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i';
            $rules['f_unitproduct.'.$key]   ='required|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i';
            $rules['f_mtuproduct.'.$key]    ='required';
            $rules['f_hargaproduct.'.$key]  ='required|max:500|min:1|regex:/^[0-9 .]+$/i';
            $rules['f_hargajasa.'.$key]  ='required|max:500|min:1|regex:/^[0-9 .]+$/i';
            $rules['f_descproduct.'.$key]   ='required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        }
        
        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {
            $count = array_count_values($request->f_kodeproduct);
            foreach($request->f_kodeproduct as $key => $val)
            {
                if($count[$val]>1) {
                    $validator->errors()->add("f_kodeproduct.$key", "Kode Tidak Boleh Sama!");
                }else{
                    $count_product=CatalogProduct::where('code',$val)->count();
                    if($count_product!=0){
                        $validator->errors()->add("f_kodeproduct.$key", "Kode Tidak Boleh Sama! Sudah ada di database");       
                    }
                }
            }
        });

        if ($validator->fails ()){
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }else{
            
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
                        $proses->price_jasa = $request['f_hargajasa'][$key];
                        $proses->desc = $request['f_descproduct'][$key];
                        $proses->keyword = "";
                        $proses->save();
                    }
                }
            }

            return redirect()->route('catalog.product');
        }        
    }

    public function edit(Request $request){
        $rules = array (
            'f_kodeproduct' => 'required|max:20|min:5|regex:/^[a-z0-9 .\-]+$/i',
            'f_namaproduct' => 'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i',
            'f_unitproduct' => 'required|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i',
            'f_mtuproduct' => 'required',
            'f_hargaproduct' => 'required|max:500|min:1|regex:/^[0-9 .]+$/i',
            'f_hargajasa' => 'required|max:500|min:1|regex:/^[0-9 .]+$/i',
            'f_descproduct' => 'required|max:500|regex:/^[a-z0-9 .\-]+$/i',
        );
        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            $proses = CatalogProduct::where('id',$request->f_id)->first();
            $proses->catalog_category_id = $request->f_produk_parent;
            $proses->code = $request->f_kodeproduct;
            $proses->name =$request->f_namaproduct;
            $proses->unit = $request->f_unitproduct;
            $proses->currency = $request->f_mtuproduct;
            $proses->price = $request->f_hargaproduct;
            $proses->price_jasa = $request->f_hargajasa;
            $proses->desc = $request->f_descproduct;
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
        $proses->price_jasa = $request->f_hargajasa;
        $proses->desc = $request->f_descproduct;
        $proses->keyword = "";   

        return redirect()->route('catalog.product');
    }

    public function delete(Request $request){
        $proses=CatalogProduct::where('id',$request->id)->delete();
        return 1;
    }
}
