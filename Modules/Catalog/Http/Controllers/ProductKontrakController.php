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

class ProductKontrakController extends Controller
{
    public function index(Request $request){
        $data['page_title'] = 'Item Price';
        $data['pegawai'] = User::get_user_pegawai();

        return view('catalog::product_kontrak')->with($data);
    }
    /*
    public function get_kontrak(Request $request){
        $search = trim($request->q);
        $data = Documents::selectRaw('id, doc_no as text')
                ->where('doc_signing','1');

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
                ->where('doc_signing','1')
                ->get();

        $hasil=array();
        for($i=0;$i<count($data);$i++){
            $hasil[$i]['id']=$data[$i]->id;
            $hasil[$i]['text']=$data[$i]->text;
        }

        return Response::json($hasil);
    }

    public function get_kontrak_cari(Request $request){
        $data=Documents::where('doc_signing',1);

        if(!empty($request->cari)){
          $data->where(function($q) use ($request) {
              $q->orWhere('doc_no', 'like', '%'.$request->cari.'%');
              $q->orWhere('doc_title', 'like', '%'.$request->cari.'%');
          });
        }

        $data = $data->get();
        return Response::json($data);
    }
    */

    public function add_ajax(Request $request){

        if(count($request->f_kodemaster)>0){
            foreach($request->f_kodemaster as $key => $val){
                    if(!empty($val) && $request['f_id_master_item'][$key]!=0 && $request['f_referensi'][$key]!=0){
                        $proses = new CatalogProductLogistic();
                        $pegawai = User::get_user_pegawai();
                        $proses->user_id = Auth::id();
                        $proses->product_master_id      = $request['f_id_master_item'][$key];
                        $proses->lokasi_logistic        = $request['f_lokasi'][$key];
                        $proses->harga_barang_logistic  = Helpers::input_rupiah($request['f_hargabarang'][$key]);
                        $proses->harga_jasa_logistic    = Helpers::input_rupiah($request['f_hargajasa'][$key]);
                        $proses->jenis_referensi        = 1;
                        
                        $proses->referensi_logistic     = $request['f_referensi'][$key];

                        $proses->divisi                 = $pegawai->divisi;
                        $proses->unit_bisnis            = $pegawai->unit_bisnis;
                        $proses->unit_kerja             = $pegawai->unit_kerja;

                        $proses->save();
                    }
            }
        }
        $request->session()->flash('alert-success', 'Data berhasil disimpan');
        return Response::json (array(
            'status' => 'all'
        ));
    }

    public function edit(Request $request){
        /*
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
        */
    }

    public function delete(Request $request){
        /*
        $proses=CatalogProductLogistic::where('id',$request->id)->delete();
        return 1;
        */
    }

    public function upload(Request $request){
        if ($request->ajax()) {
            $data = Excel::load($request->file('upload-product-kontrak')->getRealPath(), function ($reader) {})->get();
            
            $header = ['kode_master_item','price_coverage','harga_barang','harga_jasa','no_kontrak'];
            $jml_header = '5';
            
            if(!empty($data) && $data->first() != null ){
                $colomn = $data->first()->keys()->toArray();
                if(count($colomn) == $jml_header && $colomn == $header){
                    $hasil=array();

                    for($i=0;$i<count($data);$i++){
                        $hasil[$i]['kode_master_item']          = $data[$i]['kode_master_item'];
                        $hasil[$i]['price_coverage']            = $data[$i]['price_coverage'];
                        $hasil[$i]['harga_barang']              = $data[$i]['harga_barang'];
                        $hasil[$i]['harga_jasa']                = $data[$i]['harga_jasa'];
                        $hasil[$i]['no_kontrak']                = $data[$i]['no_kontrak'];
                        $hasil[$i]['error_kontrak']             = "";
                        $hasil[$i]['kode_master_item_error']    = "";
                        $hasil[$i]['flag']                      = "";

                        $count_kode=CatalogProductMaster::where('kode_product',$data[$i]['kode_master_item'])->count();
                        if($count_kode!=0){
                            $kode=CatalogProductMaster::where('kode_product',$data[$i]['kode_master_item'])->first();
                            $hasil[$i]['id_master_item']=$kode->id;
                            $hasil[$i]['kode_master_item_error']="";
                        }else{
                            $hasil[$i]['id_master_item']=0;
                            $hasil[$i]['kode_master_item_error']="Data tidak ditemukan";
                        }


                        $count_doc=Documents::where('doc_no',$data[$i]['no_kontrak'])->count();
                        if($count_doc!=0){
                            $doc=Documents::where('doc_no',$data[$i]['no_kontrak'])->first();
                            $hasil[$i]['id_kontrak']=$doc->id;

                            if($doc->doc_type=="khs"){
                                $hasil[$i]['flag'] = "true";
                            }
                        }else{
                            $hasil[$i]['id_kontrak']=0;
                            $hasil[$i]['error_kontrak']="Data tidak ditemukan";
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
