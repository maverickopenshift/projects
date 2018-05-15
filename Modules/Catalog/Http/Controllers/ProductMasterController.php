<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProductMaster as CatalogProductMaster;
use Modules\Catalog\Entities\CatalogProductLogistic as CatalogProductLogistic;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Catalog\Entities\CatalogSatuan as CatalogSatuan;
use Modules\Supplier\Entities\Supplier as Supplier;
use Modules\Documents\Entities\DocBoq as DocBoq;
use App\Helpers\Helpers;
use App\Permission;
use App\User;
use Illuminate\Support\Facades\File;
use Response;
use Validator;
use Datatables;
use Auth;
use DB;
use Excel;
use Image;

class ProductMasterController extends Controller
{
    public function index(Request $request){
        if($request->id_kategori!=0){
            $data['kategori']=CatalogCategory::where('id',$request->id_kategori)->first();    
        }
        
        $data['page_title'] = 'Master Item';
        return view('catalog::product_master')->with($data);
    }

    public function bulk(Request $request){
        $data['page_title'] = 'Master Item';
        return view('catalog::product_master_bulk')->with($data);
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

    public function get_satuan(Request $request){
        $search = trim($request->q);
        $data = CatalogSatuan::selectRaw('id as id, nama_satuan as text');

        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('nama_satuan', 'like', '%'.$search.'%');
          });
        }
        
        $data = $data->paginate(30);
        return \Response::json($data);
    }

    public function get_select_category(Request $request){
        $search = trim($request->q);
        $data = CatalogCategory::selectRaw('id as id, concat(code," - ",display_name) as text');

        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('display_name', 'like', '%'.$search.'%');
          });
        }
        
        $data = $data->paginate(30);
        return \Response::json($data);
    }

    public function add_ajax(Request $request){
        $rules = array();

        foreach($request->f_kodeproduct as $key => $val){
            $rules['f_kodeproduct.'.$key]   = 'required|max:20|min:1|regex:/^[a-z0-9 .\-]+$/i';
            $rules['f_ketproduct.'.$key]    = 'required|max:500|min:1|regex:/^[a-z0-9 .\-]+$/i';
            $rules['f_unitproduct.'.$key]   = 'required';
            $rules['f_gambar.'.$key]   = 'required';
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
                    $count_product=CatalogProductMaster::where('kode_product',$val)->count();
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
                $pegawai = User::get_user_pegawai();

                foreach($request->f_kodeproduct as $key => $val){
                    if(!empty($val)){
                        $proses                         = new CatalogProductMaster();
                        $proses->user_id                = Auth::id();
                        $proses->catalog_category_id    = $request['f_parentid'];
                        $proses->kode_product           = $request['f_kodeproduct'][$key];
                        $proses->keterangan_product     = $request['f_ketproduct'][$key];
                        $proses->satuan_id              = $request['f_unitproduct'][$key];

                        $proses->divisi                 = $pegawai->divisi;
                        $proses->unit_bisnis            = $pegawai->unit_bisnis;
                        $proses->unit_kerja             = $pegawai->unit_kerja;

                        if(isset($request['f_gambar'][$key])){
                            $file = $request['f_gambar'][$key];
                            $extension = $file->getClientOriginalExtension();
                            $filename=str_slug('master_item_'. strtolower($val)).'_'.time().'_'.str_random(5).'.'.$extension;                            
                            
                            $image_resize = Image::make($file->getRealPath());              
                            $image_resize->resize(null, 300, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });

                            File::exists(storage_path('app/master_item/')) or File::makeDirectory(storage_path('app/master_item/'));
                            $image_resize->save(storage_path('app/master_item/' .$filename));
                            
                            $proses->image_product = $filename;
                        }
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

    public function bulk_add(Request $request){
        $rules = array();

        foreach($request->f_kodeproduct as $key => $val){
            $rules['f_idcategory.'.$key]    = 'required';
            $rules['f_kodeproduct.'.$key]   = 'required|max:20|min:1|regex:/^[a-z0-9 .\-]+$/i';
            $rules['f_ketproduct.'.$key]    = 'required|max:500|min:1|regex:/^[a-z0-9 .\-]+$/i';
            $rules['f_unitproduct.'.$key]   = 'required';
            $rules['f_gambar.'.$key]        = 'required';
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
                    $count_product=CatalogProductMaster::where('kode_product',$val)->count();
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
                $pegawai = User::get_user_pegawai();
                foreach($request->f_kodeproduct as $key => $val){
                    if(!empty($val)){
                        $proses                         = new CatalogProductMaster();
                        $proses->user_id                = Auth::id();
                        $proses->catalog_category_id    = $request['f_idcategory'][$key];
                        $proses->kode_product           = $request['f_kodeproduct'][$key];
                        $proses->keterangan_product     = $request['f_ketproduct'][$key];
                        $proses->satuan_id              = $request['f_unitproduct'][$key];

                        $proses->divisi                 = $pegawai->divisi;
                        $proses->unit_bisnis            = $pegawai->unit_bisnis;
                        $proses->unit_kerja             = $pegawai->unit_kerja;

                        if(isset($request['f_gambar'][$key])){
                            $file = $request['f_gambar'][$key];
                            $extension = $file->getClientOriginalExtension();
                            $filename=str_slug('master_item_'. strtolower($val)).'_'.time().'_'.str_random(5).'.'.$extension;                            
                            
                            $image_resize = Image::make($file->getRealPath());              
                            $image_resize->resize(null, 300, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                            $image_resize->save(storage_path('app/master_item/' .$filename));
                            $proses->image_product = $filename;
                        }
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
            'f_kodeproduct' => 'required|max:20|min:1|regex:/^[a-z0-9 .\-]+$/i',
            'f_ketproduct'  => 'required|max:500|min:1|regex:/^[a-z0-9 .\-]+$/i',
            'f_unitproduct' => 'required',
        );

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        $validator->after(function ($validator) use ($request) {

            $cek_kode=CatalogProductMaster::where('id',$request->f_id)->first();
            if($cek_kode->kode_product != $request->f_kodeproduct){
                $count_product=CatalogProductMaster::where('kode_product',$request->f_kodeproduct)->count();
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
            $pegawai = User::get_user_pegawai();
            
            $proses                         = CatalogProductMaster::where('id',$request->f_id)->first();
            $proses->user_id                = Auth::id();
            $proses->catalog_category_id    = $request->f_produk_parent;
            $proses->kode_product           = $request->f_kodeproduct;
            $proses->keterangan_product     = $request->f_ketproduct;
            $proses->satuan_id              = $request->f_unitproduct;

            $proses->divisi                 = $pegawai->divisi;
                        $proses->unit_bisnis            = $pegawai->unit_bisnis;
                        $proses->unit_kerja             = $pegawai->unit_kerja;

            if(isset($request['f_gambar'])){
                $file = $request['f_gambar'];
                $extension = $file->getClientOriginalExtension();
                $filename=str_slug('master_item_'. strtolower($request->f_kodeproduct)).'_'.time().'_'.str_random(5).'.'.$extension;                            

                $image_resize = Image::make($file->getRealPath());              
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image_resize->save(storage_path('app/master_item/' .$filename));

                $proses->image_product = $filename;
            }
            $proses->save();   

            return Response::json (array(
                'status' => 'all'
            ));
        }
    }

    public function delete(Request $request){
        $cek_logistic = CatalogProductLogistic::where('product_master_id',$request->id)->count();
        if($cek_logistic==0){
            $proses=CatalogProductMaster::where('id',$request->id)->delete();
            return 1;    
        }else{
            return 0;
        }
    }
    
    public function upload(Request $request){
        if ($request->ajax()) {
            $data = Excel::load($request->file('upload-product-master')->getRealPath(), function ($reader) {})->get();
            $header = ['kode','keterangan','satuan'];
            $jml_header = '3';

            if(!empty($data) && $data->first() != null ){
                $colomn = $data->first()->keys()->toArray();

                if(!empty($data) && count($colomn) == $jml_header && $colomn == $header){
                    $hasil=array();

                    for($i=0;$i<count($data);$i++){
                        $hasil[$i]['kode']          = $data[$i]['kode'];
                        $hasil[$i]['keterangan']    = $data[$i]['keterangan'];
                        $hasil[$i]['satuan']        = $data[$i]['satuan'];

                        $count_satuan=CatalogSatuan::where('nama_satuan',$data[$i]['satuan'])->count();
                        if($count_satuan!=0){
                            $satuan=CatalogSatuan::where('nama_satuan',$data[$i]['satuan'])->first();
                            $hasil[$i]['no_satuan']=$satuan->id;
                        }else{
                            $hasil[$i]['no_satuan']=0;
                        }
                    }

                    return Response::json(['status'=>true,'csrf_token'=>csrf_token(),'data'=>$hasil]);
                }else{
                    return Response::json(['status'=>false]);
                }
            }else{
                return Response::json(['status'=>false]);
            }
        }else{
            return Response::json(['status'=>false]);
        }
    }

    public function upload_bulk(Request $request){
        if ($request->ajax()) {
            $data = Excel::load($request->file('upload-product-master')->getRealPath(), function ($reader) {})->get();
            $header = ['kode_kategori','kode','keterangan','satuan'];
            $jml_header = '4';

            if(!empty($data) && $data->first() != null ){
                $colomn = $data->first()->keys()->toArray();

                if(!empty($data) && count($colomn) == $jml_header && $colomn == $header){
                    $hasil=array();

                    for($i=0;$i<count($data);$i++){
                        $hasil[$i]['id_kategori']   = 0;
                        $hasil[$i]['kode_kategori'] = $data[$i]['kode_kategori'];
                        $hasil[$i]['kode']          = $data[$i]['kode'];
                        $hasil[$i]['keterangan']    = $data[$i]['keterangan'];
                        $hasil[$i]['satuan']        = $data[$i]['satuan'];
                        $hasil[$i]['error_kategori']= "";
                        $hasil[$i]['error_satuan']  = "";

                        $count_satuan=CatalogSatuan::where('nama_satuan',$data[$i]['satuan'])->count();
                        if($count_satuan!=0){
                            $satuan=CatalogSatuan::where('nama_satuan',$data[$i]['satuan'])->first();
                            $hasil[$i]['no_satuan']     = $satuan->id;
                        }else{
                            $hasil[$i]['no_satuan']     = 0;
                            $hasil[$i]['error_satuan']  = "Data Satuan tidak ditemukan";
                        }

                        $count_kategori=CatalogCategory::where('code',$data[$i]['kode_kategori'])->count();
                        if($count_kategori!=0){
                            $kategori=CatalogCategory::where('code',$data[$i]['kode_kategori'])->first();
                            $hasil[$i]['id_kategori'] =$kategori->id;
                        }else{
                            $hasil[$i]['error_kategori']= "Data kategori tidak ditemukan";
                        }
                    }

                    return Response::json(['status'=>true,'csrf_token'=>csrf_token(),'data'=>$hasil]);
                }else{
                    return Response::json(['status'=>false]);
                }
            }else{
                return Response::json(['status'=>false]);
            }
        }else{
            return Response::json(['status'=>false]);
        }
    }
}
