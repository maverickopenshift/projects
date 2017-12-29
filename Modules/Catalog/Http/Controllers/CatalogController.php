<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProduct as CatalogProduct;
use Modules\Documents\Entities\DocBoq as DocBoq;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Documents\Entities\Documents as Documents;
use Response;

class CatalogController extends Controller
{
    public function index(Request $request){
        $data['category']=CatalogCategory::get();    
        $data['product']=\DB::table('catalog_product as a')
                        ->selectRaw('a.*,b.display_name as category_name')
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->get();        

        return view('catalog::catalog')->with($data);
    } 

    public function get_no_kontrak(Request $request){
    	$documents=Documents::selectRaw('id, doc_no as text')->where('doc_signing',1)->get();

        return Response::json($documents);
    } 

    public function cari_no_kontrak(Request $request){
        $data=DocBoq::where('documents_id',$request->id)->get();
        return Response::json($data);
    }    
}
