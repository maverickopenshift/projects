<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProduct as CatalogProduct;
use Modules\Documents\Entities\DocBoq as DocBoq;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Documents\Entities\Documents as Documents;
use Response;
use DB;

class CatalogController extends Controller
{
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

    /*
    public function get_no_kontrak(Request $request){
    	$documents=Documents::selectRaw("id, concat(doc_no,' ',doc_title) as text")->where('doc_signing',1)->get();

        return Response::json($documents);
    } 
    */

    public function cari_no_kontrak(Request $request){
        $data=DB::connection('mysql')
            ->table('documents as a')
            ->join('doc_boq as b','a.id','=','b.documents_id')
            ->join('supplier as c','a.supplier_id','=','c.id')
            ->selectRaw("b.*, c.bdn_usaha, c.nm_vendor")
            ->where('b.documents_id',$request->id)
            ->get();
        return Response::json($data);
        /*
        $data=DocBoq::where('documents_id',$request->id)->get();
        return Response::json($data);
        */
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
}
