<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProductMaster as CatalogProductMaster;
use Modules\Catalog\Entities\CatalogProductLogistic as CatalogProductLogistic;
use Modules\Documents\Entities\DocBoq as DocBoq;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Documents\Entities\Documents as Documents;
use Response;
use Datatables;
use DB;

class CatalogController extends Controller
{   
    /*
    public function index(Request $request){
        $data['category']=CatalogCategory::get();    
        $data['product']=\DB::table('catalog_product as a')
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->join('supplier as c','c.id','=','a.supplier_id')
                        ->selectRaw('a.*,b.display_name as category_name, c.bdn_usaha, c.nm_vendor')
                        ->get();        
        $data['page_title'] = 'List Item Katalog';
        return view('catalog::catalog')->with($data);
    }
    */

    public function index_product_master(Request $request){
        $data['category']=CatalogCategory::get();    
        $data['product_master']=\DB::table('catalog_product_master as a')
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->selectRaw('a.*,b.display_name as category_name')
                        ->get();        
        $data['page_title'] = 'List Master Item';
        return view('catalog::list_product_master')->with($data);
    }

    public function index_product_master_datatables(Request $request){
        if($request->parent_id==0){
            $data=DB::table('catalog_product_master as a')
                    ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                    ->selectRaw("a.*,b.display_name as category_name")
                    ->get();
                    
        }else{
            $data=DB::table('catalog_product_master as a')
                    ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                    ->selectRaw("a.*,b.display_name as category_name")
                    ->where('a.catalog_category_id',$request->parent_id)
                    ->get();
        }

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                        $act .='<a href="'. route('catalog.product.logistic') .'?id_product='.$data->id.'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i> Price</a>';
                        $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Ubah</button>';
                        $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Hapus</button>';
                    $act .='</div>';
                    return $act;
                })
                ->make(true);
    }

    public function index_product_logistic(Request $request){
        $data['category']=CatalogCategory::get();    
        $data['product_logistic']=\DB::table('catalog_product_logistic as a')
                        ->join('catalog_product_master as b','b.id','=','a.product_master_id')
                        ->selectRaw('a.*')
                        ->get();        
        $data['page_title'] = 'List Item Price';
        return view('catalog::list_product_logistic')->with($data);
    }

    public function index_product_logistic_datatables(Request $request){
        if($request->parent_id==0){
            $data=DB::table('catalog_product_logistic as a')
                    ->join('catalog_product_master as b','b.id','=','a.product_master_id')
                    ->selectRaw("a.*, b.kode_product as kode_product")
                    ->get();                    
        }else{
            $data=DB::table('catalog_product_logistic as a')
                    ->join('catalog_product_master as b','b.id','=','a.product_master_id')
                    ->selectRaw("a.*, b.kode_product as kode_product")
                    ->where('b.catalog_category_id',$request->parent_id)
                    ->get();
        }

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';

                    //if(\Auth::user()->hasPermission('ubah-catalog-product')){
                        $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                    //}

                    //if(\Auth::user()->hasPermission('hapus-catalog-product')){
                        $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                    //}

                    $act .='</div>';
                    return $act;
                    })
                ->make(true);
    }
    /*
    public function index_product_logistic(Request $request){
        $data['category']=CatalogCategory::get();    
        $data['product']=\DB::table('catalog_product as a')
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->join('supplier as c','c.id','=','a.supplier_id')
                        ->selectRaw('a.*,b.display_name as category_name, c.bdn_usaha, c.nm_vendor')
                        ->get();        
        $data['page_title'] = 'List Item Katalog';
        return view('catalog::catalog')->with($data);
    }

    
    public function get_no_kontrak(Request $request){
    	$documents=Documents::selectRaw("id, concat(doc_no,' ',doc_title) as text")->where('doc_signing',1)->get();

        return Response::json($documents);
    } 
    */
    /*
    public function cari_no_kontrak(Request $request){
        $data=DB::connection('mysql')
            ->table('documents as a')
            ->join('doc_boq as b','a.id','=','b.documents_id')
            ->join('supplier as c','a.supplier_id','=','c.id')
            ->selectRaw("b.*, c.bdn_usaha, c.nm_vendor")
            ->where('b.documents_id',$request->id)
            ->get();
        return Response::json($data);
    }

    public function get_no_kontrak(Request $request){
        $search = trim($request->q);

        $data=Documents::selectRaw("id, concat(doc_no,' ',doc_title) as text")
                    ->where('doc_signing',1);
        if(!empty($search)){
            $data->where(function($q) use ($search) {
                $q->orWhere('doc_no', 'like', '%'.$search.'%');
                $q->orWhere('doc_title', 'like', '%'.$search.'%');
            });
        }
        $data = $data->paginate(30);

        return Response::json($data);
    }
    */
}
