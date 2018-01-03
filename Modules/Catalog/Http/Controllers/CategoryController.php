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
use Validator;

class CategoryController extends Controller
{
    public function index(Request $request){
        return view('catalog::category');
    }

    public function get_category(Request $request){
        $data['category']=CatalogCategory::where('id',$request->id)->get();
        $data['induk']=CatalogCategory::selectRaw('id, display_name as text')->where('id','!=',$request->id)->get();

        return Response::json($data);
    }

    /*
    public function get_category_induk(Request $request){
        $result=CatalogCategory::selectRaw('id, code, display_name')->where('id','!=',$request->id)->get();        

        $hasil=array();
        $hasil[0]['id']=0;
        $hasil[0]['text']="Tidak Memiliki Induk";

        for($i=0;$i<count($result);$i++){
            $hasil[$i+1]['id']=$result[$i]->id;
            $hasil[$i+1]['text']=$result[$i]->code ." - ". $result[$i]->display_name;
        }

        return Response::json($hasil);
    } 
    */

    public function get_category_induk(Request $request){
        $id=$request->id;
        $parent_id=$request->parent_id;
        $result=CatalogCategory::where('parent_id',$parent_id)->get();
        $hasil=array();
        $hasil[0]['id']=0;
        $hasil[0]['text']="Tidak Memiliki Induk";
        $x=1;
            for($i=0;$i<count($result);$i++){
                if($id!=$result[$i]->id){
                    $hasil[$x]['id']=$result[$i]->id;
                    $hasil[$x]['text']=$result[$i]->code ." - ". $result[$i]->display_name;
                    $x++;

                    $hitung=CatalogCategory::where('parent_id',$result[$i]->id)->count();
                    if($hitung!=0){
                        $result_child=$this->get_category_induk2($id, $result[$i]->id);
                        for($y=0;$y<count($result_child);$y++){
                            $hasil[$x]['id']=$result_child[$y]['id'];
                            $hasil[$x]['text']=$result_child[$y]['text'];
                            $x++;
                        }
                    }    
                }                
            }
        return $hasil;
    }

    public function get_category_induk2($id,$parent_id){
        $result=CatalogCategory::where('parent_id',$parent_id)->get();
        $hasil=array();
        $x=0;
            for($i=0;$i<count($result);$i++){
                if($id!=$result[$i]->id){
                    $hasil[$x]['id']=$result[$i]->id;
                    $hasil[$x]['text']=$result[$i]->code ." - ". $result[$i]->display_name;
                    $x++;

                    $hitung=CatalogCategory::where('parent_id',$result[$i]->id)->count();
                    if($hitung!=0){
                        $result_child=$this->get_category_induk2($id, $result[$i]->id);
                        for($y=0;$y<count($result_child);$y++){
                            $hasil[$x]['id']=$result_child[$y]['id'];
                            $hasil[$x]['text']=$result_child[$y]['text'];
                            $x++;
                        }
                    }    
                }                
            }
        return $hasil;
    }

    public function datatables(Request $request){

        if($request->parent_id==0){
            $data=CatalogCategory::get();
        }else{
            $data=CatalogCategory::where('parent_id',$request->parent_id)->get();
        }        

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';

                    if(\Auth::user()->hasPermission('ubah-catalog-category')){
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
                $hasil[$i]['data']['parent_id']=$result[$i]->parent_id;
                $hasil[$i]['data']['code']=$result[$i]->code;
                $hasil[$i]['data']['name']=$result[$i]->display_name;
                $hasil[$i]['data']['desc']=$result[$i]->desc;
                $hitung=CatalogCategory::where('parent_id',$result[$i]->id)->count();
                if($hitung!=0){
                    $hasil[$i]['children']=$this->get_category_all($result[$i]->id);
                }
            }
        return $hasil;
    }

    public function proses(Request $request){
        $rules = array (
            'f_kodekategori' => 'required|min:5|max:10|regex:/^[0-9]+$/i',
            'f_namakategori' => 'required|min:5|max:250|regex:/^[a-z0-9 .\-]+$/i',
            'f_deskripsikategori' => 'required|min:5|max:500|regex:/^[a-z0-9 .\-]+$/i',
        );

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());

        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            if($request->f_id==0){
                $hitung=CatalogCategory::where('code',$request->f_kodekategori)->count();
                if($hitung==0){
                    $proses=new CatalogCategory();
                    $proses->code=$request->f_kodekategori;
                    $proses->display_name=$request->f_namakategori;
                    $proses->name=str_slug($request->f_namakategori);
                    $proses->parent_id=$request->f_parentid;
                    $proses->desc=$request->f_deskripsikategori;
                    $proses->save();

                    return 1;
                }else{
                    return 0;
                }                
            }else{
                $hitung=CatalogCategory::where('id','!=',$request->f_id)->where('code',$request->f_kodekategori)->count();

                if($hitung==0){
                    $proses=CatalogCategory::where('id',$request->f_id)->first();
                    $proses->code=$request->f_kodekategori;
                    $proses->display_name=$request->f_namakategori;
                    $proses->name=str_slug($request->f_namakategori);
                    $proses->parent_id=$request->f_parentid_select;
                    $proses->desc=$request->f_deskripsikategori;
                    $proses->save();

                    return 1;
                }else{
                    return 0;
                }
            }
        }
    }

    public function delete(Request $request){
        $cek_category=CatalogCategory::where('parent_id',$request->id)->count();
        $cek_product=CatalogProduct::where('catalog_category_id',$request->id)->count();

        if($cek_category==0 and $cek_product==0){
            $proses=CatalogCategory::where('id',$request->id)->first()->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
