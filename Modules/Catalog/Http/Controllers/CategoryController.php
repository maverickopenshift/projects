<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Catalog\Entities\CatalogProduct as CatalogProduct;
use App\Permission as Auth;
use App\User;
use Response;
use Datatables;

class CategoryController extends Controller
{
    public function index(Request $request){
        return view('catalog::category2');
    }

    public function get_category(Request $request){
        $result=CatalogCategory::where('id',$request->id)->get();

        return Response::json($result);
    }

    public function datatables(Request $request){
        $data=CatalogCategory::get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';

                    if(\Auth::user()->hasPermission('catalog-product')){
                        $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-category"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="category" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                    }

                    if(\Auth::user()->hasPermission('hapus-catalog-category')){
                        $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="category" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                    }

                    $act .='</div>';
                    return $act;
                    })
                ->make(true);
    }

    public function get_category_all($parent_id){
        $result=CatalogCategory::where('parent_id',$parent_id)->get();
        $hasil=array();
            for($i=0;$i<count($result);$i++){
                $hasil[$i]['id']=$result[$i]->id;
                $hasil[$i]['text']=$result[$i]->code ." - ". $result[$i]->display_name;
                $hasil[$i]['data']['desc']=$result[$i]->desc;
                $hitung=CatalogCategory::where('parent_id',$result[$i]->id)->count();
                if($hitung!=0){
                    $hasil[$i]['children']=$this->get_category_all($result[$i]->id);
                }
            }
        return $hasil;
    }

    public function proses(Request $request){
        //dd($request->input());
        if($request->f_id==0){
            $proses=new CatalogCategory();
            $proses->code=$request->f_kodekategori;
            $proses->display_name=$request->f_namakategori;
            $proses->name=str_slug($request->f_namakategori);
            $proses->parent_id=$request->f_parentid;
            $proses->desc=$request->f_deskripsikategori;
            $proses->save();
        }else{
            $proses=CatalogCategory::where('id',$request->f_id)->first();
            $proses->code=$request->f_kodekategori;
            $proses->display_name=$request->f_namakategori;
            $proses->name=str_slug($request->f_namakategori);
            $proses->parent_id=$request->f_parentid;
            $proses->desc=$request->f_deskripsikategori;
            $proses->save();
        }
        
    	
    	return redirect()->route('catalog.category');
    }

    public function delete(Request $request){
        $cek_category=CatalogCategory::where('parent_id',$request->id)->count();
        $cek_product=CatalogProduct::where('catalog_category_id',$request->id)->count();

        if($cek_product==0 && $cek_product==0){
            $proses=CatalogCategory::where('id',$request->id)->first()->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
