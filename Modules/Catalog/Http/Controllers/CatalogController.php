<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProductMaster as CatalogProductMaster;
use Modules\Catalog\Entities\CatalogProductLogistic as CatalogProductLogistic;
use Modules\Documents\Entities\DocBoq as DocBoq;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Documents\Entities\Documents as Documents;
use Auth;
use Response;
use Datatables;
use DB;

class CatalogController extends Controller
{   
    public function index_product_master(Request $request){
        $data['category']=CatalogCategory::get();    
        $data['page_title'] = 'List Master Item';
        return view('catalog::list_product_master')->with($data);
    }

    public function get_category($id, $sub){
        $result=CatalogCategory::where('parent_id',$id)->get();
        $hasil=array();
        $x=0;
        if($sub==0){
            $hasil[$x]=$id;
            $x++;
        }

        for($i=0;$i<count($result);$i++){
            if($id!=$result[$i]->id){
                $hasil[$x]=$result[$i]->id;
                $x++;

                $hitung=CatalogCategory::where('parent_id',$result[$i]->id)->count();
                if($hitung!=0){
                    $result_child=$this->get_category($result[$i]->id, 1);
                    for($y=0;$y<count($result_child);$y++){
                        $hasil[$x]=$result_child[$y];
                        $x++;
                    }
                }
            }
        }

        return $hasil;
    }

    public function index_product_master_datatables(Request $request){
        if($request->parent_id==0){
            $data=DB::table('catalog_product_master as a')
                    ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                    ->selectRaw("a.*,b.display_name as category_name")
                    ->where('a.user_id',Auth::id())
                    ->get();
                    
        }else{
            $data=DB::table('catalog_product_master as a')
                    ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                    ->selectRaw("a.*,b.display_name as category_name")
                    ->whereIn('b.id', $this->get_category($request->parent_id,0))
                    ->where('a.user_id',Auth::id())
                    ->get();
        }

        if($request->type==1){
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                        if($data->user_id==Auth::id()){
                            $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Ubah</button>';
                            $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Hapus</button>';
                        }
                    $act .='</div>';
                    return $act;
                })
                ->make(true);
        }else{
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                        $act .='<a href="'. route('catalog.product.logistic') .'?id_product='.$data->id.'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i> Price</a>';
                        $act .='<a data-id="'. $data->id .'" class="btn btn-primary btn-xs detail_price"><i class="glyphicon glyphicon-edit"></i> Detail</a>';
                    $act .='</div>';
                    return $act;
                })
                ->make(true);
        }
    }

    public function index_product_logistic(Request $request){
        $data['category']=CatalogCategory::get();
        $data['page_title'] = 'List Item Price';
        return view('catalog::list_product_logistic')->with($data);
    }
    
    public function index_product_logistic_datatables(Request $request){
        if($request->id==0){
            $data=DB::table('catalog_product_logistic as a')
                    ->join('catalog_product_master as b','b.id','=','a.product_master_id')
                    ->selectRaw("a.*, b.kode_product as kode_product, b.user_id")
                    ->get();                    
        }else{
            $data=DB::table('catalog_product_logistic as a')
                    ->join('catalog_product_master as b','b.id','=','a.product_master_id')
                    ->selectRaw("a.*, b.kode_product as kode_product, b.user_id")
                    ->where('a.product_master_id',$request->id)
                    ->get();
        }

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                        if($data->user_id==Auth::id()){
                            $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                            $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                        }

                    $act .='</div>';
                    return $act;
                })
                ->make(true);
    }
}
