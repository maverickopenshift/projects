<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;

class CategoryController extends Controller
{
    public function index(Request $request){
    	if($request->id==0){
    		$dt=CatalogCategory::get();
    		$dt->map(function($item, $key){
				$hasil=CatalogCategory::where('id',$item->parent_id)->first();
				$item->parent_name=$hasil['display_name'];
				return $item;
			});
    		$data['category']=$dt;
    		$data['judul']="Tambah Kategori";
    	}else{
    		$data['data']=CatalogCategory::where('id',$request->id)->first();
    		$dt=CatalogCategory::get();
    		$dt->map(function($item, $key){
				$hasil=CatalogCategory::where('id',$item->parent_id)->first();
				$item->parent_name=$hasil['display_name'];
				return $item;
			});
    		$data['category']=$dt;
    		$data['judul']="Edit Kategori";
    	}    	

        return view('catalog::category')->with($data);
    }

    public function proses(Request $request){
    	
    	if($request->f_id==0){
    		$proses=new CatalogCategory();
	    	$proses->code=$request->f_kodekategori;
	    	$proses->display_name=$request->f_namakategori;
	    	$proses->name=str_slug($request->f_namakategori);
	    	$proses->parent_id=$request->f_indukkategori;
	    	$proses->desc=$request->f_deskripsikategori;
	    	$proses->save();
    	}else{
    		$proses=CatalogCategory::where('id',$request->f_id)->first();
	    	$proses->code=$request->f_kodekategori;
	    	$proses->display_name=$request->f_namakategori;
	    	$proses->name=str_slug($request->f_namakategori);
	    	$proses->parent_id=$request->f_indukkategori;
	    	$proses->desc=$request->f_deskripsikategori;
	    	$proses->save();
    	}
    	

    	return redirect()->route('catalog.category');
    }

    public function delete(Request $request)
	{
	    $proses=CatalogCategory::where('id',$request->f_id)->delete();
	    return redirect()->route('catalog.category');
	}
}
