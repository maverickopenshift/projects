<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProductMaster as CatalogProductMaster;
use Modules\Catalog\Entities\CatalogProductLogistic as CatalogProductLogistic;
use Modules\Documents\Entities\Documents as Documents;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use App\Permission;
use App\User;
use App\Helpers\Helpers;
use Auth;
use Response;
use Validator;
use Datatables;
use DB;
use Excel;

class ProductLogisticController extends Controller
{
    public function index(Request $request){
        $data['product']=\DB::table('catalog_product_master as a')
                        ->selectRaw('a.*,b.display_name as category_name')
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->where('a.id',$request->id_product)
                        ->first();          
        $data['page_title'] = 'Item Price';
        $data['pegawai'] = User::get_user_pegawai();
        //dd($data);

        return view('catalog::product_logistic')->with($data);
    }

    public function get_kontrak(Request $request){
        $search = trim($request->q);
        $data = Documents::selectRaw('id, doc_no as text')
                ->where('doc_signing','1');

        $data->where(function($q){
            $q->orWhere('doc_type', 'turnkey');
            $q->orWhere('doc_type', 'sp');
        });

        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('doc_no', 'like', '%'.$search.'%');
          });
        }
        
        $data = $data->paginate(30);
        return \Response::json($data);
    }

    public function get_kontrak_normal(Request $request){        
        $data = Documents::selectRaw('id, doc_no as text')
                ->where('doc_signing','1');

        $data->where(function($q){
            $q->orWhere('doc_type', 'turnkey');
            $q->orWhere('doc_type', 'sp');
        });
                
        $data = $data->get();

        $hasil=array();
        for($i=0;$i<count($data);$i++){
            $hasil[$i]['id']=$data[$i]->id;
            $hasil[$i]['text']=$data[$i]->text;
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
                        $pegawai = User::get_user_pegawai();
                        $proses->user_id = Auth::id();
                        $proses->product_master_id      = $request->f_idproduct;
                        $proses->lokasi_logistic        = $request['f_lokasi'][$key];
                        $proses->harga_barang_logistic  = Helpers::input_rupiah($request['f_hargabarang'][$key]);
                        $proses->harga_jasa_logistic    = Helpers::input_rupiah($request['f_hargajasa'][$key]);
                        $proses->jenis_referensi        = $request['f_jenis'][$key];

                        if($request['f_jenis'][$key]==1){
                            $doc_cari=Documents::select('doc_no')
                                ->where('id',$request['f_referensi'][$key])
                                ->first();

                            $ref=$doc_cari->doc_no;
                        }else{
                            $ref=$request['f_referensi'][$key];
                        }
                        
                        $proses->referensi_logistic     = $ref;

                        $proses->divisi                 = $pegawai->divisi;
                        $proses->unit_bisnis            = $pegawai->unit_bisnis;
                        $proses->unit_kerja             = $pegawai->unit_kerja;

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

    public function upload(Request $request)
    {
        if ($request->ajax()) {
            $data = Excel::load($request->file('upload-product-price')->getRealPath(), function ($reader) {})->get();
            $header = ['lokasi','harga_barang','harga_jasa'];
            $jml_header = '3';

            $colomn = $data->first()->keys()->toArray();

            if(!empty($data) && count($colomn) == $jml_header && $colomn == $header){
                return Response::json(['status'=>true,'csrf_token'=>csrf_token(),'data'=>$data]);
            }else{
                return Response::json(['status'=>false]);
            }
        }else{
            return Response::json(['status'=>false]);
        }
    }
}
