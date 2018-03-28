<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProductMaster as CatalogProductMaster;
use Modules\Catalog\Entities\CatalogProductLogistic as CatalogProductLogistic;
use Modules\Documents\Entities\Documents as Documents;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use App\Permission as Auth;

use App\Helpers\Helpers;
use Response;
use Validator;
use Datatables;
use DB;

class ProductLogisticController extends Controller
{
    public function index(Request $request){
        $data['product']=\DB::table('catalog_product_master as a')
                        ->selectRaw('a.*,b.display_name as category_name')
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->where('a.id',$request->id_product)
                        ->first();          
        $data['page_title'] = 'Item Price';
        return view('catalog::product_logistic')->with($data);
    }
    /*
    public function get_kode_product_master(Request $request){
        $search = trim($request->q);
        if($request->parent_id==""){
            $data = CatalogProductMaster::selectRaw('id, kode_product as text');
        }else{
            $data = CatalogProductMaster::selectRaw('id, kode_product as text')
            ->where('catalog_category_id',$request->parent_id);
        }
                    

        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('kode_product', 'like', '%'.$search.'%');
          });
        }
        $data = $data->paginate(30);
        return \Response::json($data);
    }
    */

    public function get_kontrak(Request $request){
        $search = trim($request->q);
        $data = Documents::selectRaw('id, doc_no as text')
                ->where('doc_type','turnkey')
                ->where('doc_type','sp')
                ->where('doc_signing','1')
        ;
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('doc_no', 'like', '%'.$search.'%');
          });
        }
        $data = $data->paginate(30);
        return \Response::json($data);
    }
    /*
    public function get_kode_product_master_normal(Request $request){
        $result=CatalogProductMaster::selectRaw('id, kode_product as text')->get();

        $hasil=array();
        for($i=0;$i<count($result);$i++){
            $hasil[$i]['id']=$result[$i]->id;
            $hasil[$i]['text']=$result[$i]->text;
        }

        return Response::json($hasil);
    }
    */

    public function get_kontrak_normal(Request $request){
        $result=Documents::selectRaw('id, doc_no as text')
                ->where('doc_type','turnkey')
                ->where('doc_type','sp')
                ->where('doc_signing','1')->get();

        $hasil=array();
        for($i=0;$i<count($result);$i++){
            $hasil[$i]['id']=$result[$i]->id;
            $hasil[$i]['text']=$result[$i]->text;
        }

        return Response::json($hasil);
    }

    public function add_ajax(Request $request){
        $rules = array();
        if(count($request->f_lokasi)>0){
            foreach($request->f_lokasi as $key  => $val){
                $rules['f_lokasi.'.$key]        ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
                $rules['f_hargabarang.'.$key]   ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
                $rules['f_hargajasa.'.$key]     ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
                $rules['f_jenis.'.$key]         ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
                $rules['f_referensi.'.$key]     ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
            }
        }

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        
        if ($validator->fails ()){
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
              ));
        }else{            
            if(count($request->f_lokasi)>0){
                foreach($request->f_lokasi as $key => $val){
                    if(!empty($val)){
                        $proses = new CatalogProductLogistic();
                        $proses->product_master_id      = $request->f_idproduct;
                        $proses->lokasi_logistic        = $request['f_lokasi'][$key];
                        $proses->harga_barang_logistic  = Helpers::input_rupiah($request['f_hargabarang'][$key]);
                        $proses->harga_jasa_logistic    = Helpers::input_rupiah($request['f_hargajasa'][$key]);
                        $proses->jenis_referensi        = $request['f_jenis'][$key];
                        $proses->referensi_logistic     = $request['f_referensi'][$key];
                        $proses->save();
                    }
                }
            }
            
            return Response::json (array(
                'status' => 'all'
            ));
        }        
    }

    public function edit(Request $request){
        $rules = array();
        $rules['f_kodeproduct']   ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_lokasi']        ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_hargabarang']   ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_hargajasa']     ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_jenis']         ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_referensi']     ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            $proses = CatalogProductLogistic::where('id',$request->f_id)->first();
            $proses->product_master_id      = $request->f_kodeproduct;
            $proses->lokasi_logistic        = $request->f_lokasi;
            $proses->harga_barang_logistic  = $request->f_hargabarang;
            $proses->harga_jasa_logistic    = $request->f_hargajasa;
            $proses->jenis_referensi        = $request->f_jenis;
            $proses->referensi_logistic     = $request->f_referensi;
            $proses->save();   

            return Response::json (array(
                'status' => 'all'
            ));
        }
    }

    public function delete(Request $request){
        $proses=CatalogProductLogistic::where('id',$request->id)->delete();
        return 1;
    }

    /*
    public function get_product_induk(Request $request){
        $result=CatalogCategory::selectRaw('id, code, display_name')->get();

        $hasil=array();
        for($i=0;$i<count($result);$i++){
            $hasil[$i]['id']=$result[$i]->id;
            $hasil[$i]['text']=$result[$i]->code ." - ". $result[$i]->display_name;
        }

        return Response::json($hasil);
    }

    public function get_product_supplier(Request $request){
        $result=Supplier::selectRaw('id, bdn_usaha, nm_vendor')->get();

        $hasil=array();
        for($i=0;$i<count($result);$i++){
            $hasil[$i]['id']=$result[$i]->id;
            $hasil[$i]['text']=$result[$i]->bdn_usaha ." - ". $result[$i]->nm_vendor;
        }

        return Response::json($hasil);
    }

    public function datatables(Request $request){
        if($request->parent_id==0){
            
            //$data=CatalogProduct::get();
            $data=DB::table('catalog_product as a')
                    ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                    ->join('supplier as c','c.id','=','a.supplier_id')
                    ->selectRaw("a.*,b.display_name as category_name, concat(c.bdn_usaha,' ',c.nm_vendor) as supplier_nama")
                    ->get();
                    
        }else{
            //$data=CatalogProduct::where('catalog_category_id',$request->parent_id)->get();
            $data=DB::table('catalog_product as a')
                    ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                    ->join('supplier as c','c.id','=','a.supplier_id')
                    ->selectRaw("a.*,b.display_name as category_name, concat(c.bdn_usaha,' ',c.nm_vendor) as supplier_nama")
                    ->where('a.catalog_category_id',$request->parent_id)
                    ->get();
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
            //$data=DocBoq::where('id',$request->id)->get();
            $data=DB::connection('mysql')
                ->table('documents as a')
                ->join('doc_boq as b','a.id','=','b.documents_id')
                ->join('supplier as c','a.supplier_id','=','c.id')
                ->selectRaw("b.*, a.supplier_id, c.bdn_usaha, c.nm_vendor")
                ->where('b.id',$request->id)
                ->get();
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

    public function add_ajax(Request $request){
        $rules = array();

        foreach($request->f_kodeproduct as $key => $val){
            $rules['f_nosupplier.'.$key]   ='required';
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
            $kode = array_replace($request->f_kodeproduct ,array_fill_keys(array_keys($request->f_kodeproduct, null),''));
            $count = array_count_values($kode);
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
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
              ));
        }else{            
            if(count($request->f_kodeproduct)>0){
                foreach($request->f_kodeproduct as $key => $val){
                    if(!empty($val)){
                        $proses = new CatalogProduct();
                        $proses->catalog_category_id = $request['f_parentid'];
                        $proses->supplier_id = $request['f_nosupplier'][$key];
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
            
            $request->session()->flash('alert-success', 'Data berhasil disimpan');
            return Response::json (array(
                'status' => 'all'
            ));
        }        
    }

    public function edit(Request $request){
        $rules = array (
            'f_nosupplier' => 'required',
            'f_kodeproduct' => 'required|max:20|min:5|regex:/^[a-z0-9 .\-]+$/i',
            'f_namaproduct' => 'required|max:500|min:5|regex:/^[a-z0-9 .\-]+$/i',
            'f_unitproduct' => 'required|max:50|min:2|regex:/^[a-z0-9 .\-]+$/i',
            'f_mtuproduct' => 'required',
            'f_hargaproduct' => 'required|max:500|min:1|regex:/^[0-9 .]+$/i',
            'f_hargajasa' => 'required|max:500|min:1|regex:/^[0-9 .]+$/i',
            'f_descproduct' => 'required|max:500|regex:/^[a-z0-9 .\-]+$/i',
        );
        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {

            $cek_kode=CatalogProduct::where('id',$request->f_id)->first();
            if($cek_kode->code != $request->f_kodeproduct){
                $count_product=CatalogProduct::where('code',$request->f_kodeproduct)->count();
                if($count_product!=0){
                    $validator->errors()->add("f_kodeproduct", "Kode Tidak Boleh Sama! Sudah ada di database");       
                }
            }
        });

        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            $proses = CatalogProduct::where('id',$request->f_id)->first();
            $proses->catalog_category_id = $request->f_produk_parent;
            $proses->supplier_id = $request->f_nosupplier;
            $proses->code = $request->f_kodeproduct;
            $proses->name =$request->f_namaproduct;
            $proses->unit = $request->f_unitproduct;
            $proses->currency = $request->f_mtuproduct;
            $proses->price = $request->f_hargaproduct;
            $proses->price_jasa = $request->f_hargajasa;
            $proses->desc = $request->f_descproduct;
            $proses->keyword = "";
            $proses->save();   

            return Response::json (array(
                'status' => 'all'
            ));
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

    public function get_no_supplier(Request $request){
        $search = trim($request->q);

        $data=Supplier::selectRaw("id, concat(bdn_usaha,' ',nm_vendor) as text");
        if(!empty($search)){
            $data->where(function($q) use ($search) {
                $q->orWhere('bdn_usaha', 'like', '%'.$search.'%');
                $q->orWhere('nm_vendor', 'like', '%'.$search.'%');
            });
        }
        $data = $data->paginate(30);

        return Response::json($data);
    }
    */
}
