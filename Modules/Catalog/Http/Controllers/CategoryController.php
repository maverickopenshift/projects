<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Catalog\Entities\CatalogProduct as CatalogProduct;
use App\Permission as Auth;
use App\User;
use Response;
use Excel;
use Datatables;
use Validator;

class CategoryController extends Controller
{
    public function index(Request $request){
        $data['page_title'] = 'Taxonomy';
        return view('catalog::category')->with($data);
    }

    public function bulk(Request $request){
        $data['page_title'] = 'Taxonomy';
        return view('catalog::category_bulk')->with($data);
    }

    public function bulk_add(Request $request){
        $rules = array();
        
        foreach($request->f_kode as $key => $val){
            $rules['f_kode.'.$key]          = 'required|max:20|min:5|regex:/^[a-z0-9 .\-]+$/i';
            $rules['f_nama.'.$key]          = 'required|max:500|min:1|regex:/^[a-z0-9 .\-]+$/i';
        }

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {

            $kode = array_replace($request->f_kode ,array_fill_keys(array_keys($request->f_kode, null),''));
            $count = array_count_values($kode);
            foreach($request->f_kode as $key => $val)
            {

                if($count[$val]>1) {
                    $validator->errors()->add("f_kode.$key", "Kode Tidak Boleh Sama!");
                }else{
                    $count_kode=CatalogCategory::where('code',$val)->count();
                    if($count_kode!=0){
                        $validator->errors()->add("f_kode.$key", "Kode Tidak Boleh Sama! Sudah ada di database");
                    }
                }

                if($request['f_kodeparent'][$key]!=''){
                    $count_parent=CatalogCategory::where('code',$request['f_kodeparent'][$key])->count();
                    if($count_parent==0){
                        $validator->errors()->add("f_kodeparent.$key", "Kode parent tidak ditemukan");
                    }
                }
            }
        });

        if ($validator->fails ()){
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
              ));
        }else{  
            if(count($request->f_kode)>0){
                foreach($request->f_kode as $key => $val){
                    if(!empty($val)){
                        $proses                         = new CatalogCategory();
                        $proses->code                   = $request['f_kode'][$key];
                        $proses->display_name           = $request['f_nama'][$key];
                        $proses->name                   = str_slug($request['f_nama'][$key]);

                        if($request['f_kodeparent'][$key]!=''){
                            $parent=CatalogCategory::where('code',$request['f_kodeparent'][$key])->first();
                            $proses->parent_id              = $parent->id;    
                        }else{
                            $proses->parent_id              = 0;
                        }
                        
                        $proses->desc                   = '';
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

    public function bulk_upload(Request $request){
        if ($request->ajax()) {
            $data = Excel::load($request->file('upload-taxonomy')->getRealPath(), function ($reader) {})->get();
            $header = ['kode_parent','kode','nama'];
            $jml_header = '3';

            if(!empty($data) && $data->first() != null ){
                $colomn = $data->first()->keys()->toArray();

                if(!empty($data) && count($colomn) == $jml_header && $colomn == $header){
                    $hasil=array();
                    $arraykode=array();
                    $arrayparent=array();

                    for($i=0;$i<count($data);$i++){
                        $arraykode[]=$data[$i]['kode'];
                    }

                    for($i=0;$i<count($data);$i++){
                        $arrayparent[]=$data[$i]['kode_parent'];
                    }

                    $cek_kode           = array_replace($arraykode ,array_fill_keys(array_keys($arraykode, null),''));
                    $cek_kode_parent    = array_replace($arrayparent ,array_fill_keys(array_keys($arrayparent, null),''));
                    $hitung_kode        = array_count_values($cek_kode);
                    $hitung_kode_parent = array_count_values($cek_kode_parent);                    

                    for($i=0;$i<count($data);$i++){
                        $hasil[$i]['id_parent']         = 0;
                        
                        if($data[$i]['kode_parent']==""){
                            $hasil[$i]['kode_parent']       = "";
                        }else{
                            $hasil[$i]['kode_parent']       = $data[$i]['kode_parent'];
                        }
                        
                        $hasil[$i]['kode']              = $data[$i]['kode'];
                        $hasil[$i]['nama']              = $data[$i]['nama'];
                        $hasil[$i]['error_kode_parent'] = '';
                        $hasil[$i]['error_kode']        = '';

                        if($data[$i]['kode_parent']!=''){
                            $count_parent=CatalogCategory::where('code',$data[$i]['kode_parent'])->count();
                            if($count_parent!=0){
                                $parent=CatalogCategory::where('code',$data[$i]['kode_parent'])->first();
                                $hasil[$i]['id_parent']     = $parent->id;
                            }else{
                                $hasil[$i]['id_parent']     = 0;
                                $hasil[$i]['error_kode_parent']  = "Data Parent tidak ditemukan";
                            }
                        }

                        $count_kode=CatalogCategory::where('code',$data[$i]['kode'])->count();
                        if($count_kode!=0){
                            $hasil[$i]['error_kode']  = "Kode ini sudah digunakan";
                        }                        
                    }

                    return Response::json(['status'=>true,'csrf_token'=>csrf_token(),'data'=>$hasil]);
                }else{
                    return Response::json(['status'=>false,'test'=>1]);
                }
            }else{
                return Response::json(['status'=>false,'test'=>2]);
            }
        }else{
            return Response::json(['status'=>false,'test'=>3]);
        }
    }

    public function get_category(Request $request){
        $data['category']=CatalogCategory::where('id',$request->id)->get();
        $data['induk']=CatalogCategory::selectRaw('id, display_name as text')->where('id','!=',$request->id)->get();

        return Response::json($data);
    }

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
            'f_kodekategori' => 'required|min:5|max:20|regex:/^[a-z0-9]+$/i',
            'f_namakategori' => 'required|min:1|max:250|regex:/^[a-z0-9 .\-]+$/i',
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
