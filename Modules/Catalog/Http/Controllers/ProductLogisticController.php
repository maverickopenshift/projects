<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProductMaster as CatalogProductMaster;
use Modules\Catalog\Entities\CatalogProductLogistic as CatalogProductLogistic;
use Modules\Documents\Entities\Documents as Documents;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Catalog\Entities\CatalogGroupCoverage as CatalogGroupCoverage;
use Modules\Catalog\Entities\CatalogCoverage as CatalogCoverage;
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
                        ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                        ->join('catalog_satuan as c','c.id','=','a.satuan_id')
                        ->selectRaw('a.*,b.display_name as category_name,  c.nama_satuan as nama_satuan')
                        ->where('a.id',$request->id_product)
                        ->first();
        $data['page_title'] = 'Item Price';
        $data['pegawai'] = User::get_user_pegawai();
        
        return view('catalog::product_logistic')->with($data);
    }

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

    public function add_ajax(Request $request){
        $rules = array();
        if(count($request->f_hargabarang)>0){
            foreach($request->f_hargabarang as $key  => $val){
                $rules['f_nogroupcoverage.'.$key]   ='required|min:1';
                $rules['f_nocoverage.'.$key]        ='required|min:1';
                $rules['f_hargabarang.'.$key]       ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
                $rules['f_hargajasa.'.$key]         ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
                $rules['f_jenis.'.$key]             ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
                $rules['f_referensi.'.$key]         ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
            }
        }

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());

        if ($validator->fails ()){
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
              ));
        }else{
            if(count($request->f_nogroupcoverage)>0){                
                foreach($request->f_nogroupcoverage as $key => $val){
                    if(!empty($val)){

                        $proses = new CatalogProductLogistic();
                        $pegawai = User::get_user_pegawai();
                        $proses->user_id = Auth::id();
                        $proses->product_master_id      = $request->f_idproduct;
                        
                        $proses->group_coverage_id      = $request['f_nogroupcoverage'][$key];
                        $proses->coverage_id            = $request['f_nocoverage'][$key];

                        $proses->harga_barang_logistic  = Helpers::input_rupiah($request['f_hargabarang'][$key]);
                        $proses->harga_jasa_logistic    = Helpers::input_rupiah($request['f_hargajasa'][$key]);
                        $proses->jenis_referensi        = $request['f_jenis'][$key];

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
    }

    public function edit(Request $request){
        $rules = array();
        $rules['f_nogroupcoverage'] ='required|min:1';
        $rules['f_nocoverage']      ='required|min:1';
        $rules['f_hargabarang']     ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_hargajasa']       ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_jenis']           ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';
        $rules['f_referensi']       ='required|max:100|min:1|regex:/^[a-z0-9 .\-]+$/i';

        $validator = Validator::make($request->all(), $rules, \App\Helpers\CustomErrors::catalog());
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else{
            $proses = CatalogProductLogistic::where('id',$request->f_id)->first();
            $proses->group_coverage_id      = $request->f_nogroupcoverage;
            $proses->coverage_id            = $request->f_nocoverage;

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

    public function upload(Request $request){
        if ($request->ajax()) {
            $data = Excel::load($request->file('upload-product-price')->getRealPath(), function ($reader) {})->get();
            $header = ['group_coverage','coverage','harga_barang','harga_jasa','jenis_referensi','referensi'];
            $jml_header = '6';

            if(!empty($data) && $data->first() != null ){
                $colomn = $data->first()->keys()->toArray();
                if(!empty($data) && count($colomn) == $jml_header && $colomn == $header){
                    $hasil=array();

                    for($i=0;$i<count($data);$i++){
                        $hasil[$i]['id_group_coverage']   = 0;
                        $hasil[$i]['id_coverage']         = 0;
                        $hasil[$i]['id_kontrak']          = 0;
                        $hasil[$i]['error_coverage']      = "";
                        $hasil[$i]['error_group_coverage']= "";
                        $hasil[$i]['error_referensi']     = "";
                        $hasil[$i]['group_coverage']      = "";
                        $hasil[$i]['coverage']            = "";
                        $hasil[$i]['harga_jasa']          = $data[$i]['harga_jasa'];
                        $hasil[$i]['harga_barang']        = $data[$i]['harga_barang'];
                        $hasil[$i]['jenis_referensi']     = 1;
                        $hasil[$i]['referensi']           = $data[$i]['referensi'];
                        $hasil[$i]['khs']                 = 2;

                        
                        $count_group_coverage=CatalogGroupCoverage::where('nama_group_coverage',$data[$i]['group_coverage'])->count();
                        if($count_group_coverage!=0){
                            $groupcoverage=CatalogGroupCoverage::where('nama_group_coverage',$data[$i]['group_coverage'])->first();

                            $hasil[$i]['id_group_coverage']= $groupcoverage->id;
                            $hasil[$i]['group_coverage']   = $groupcoverage->nama_group_coverage;
                        }else{
                            $hasil[$i]['id_group_coverage']=0;
                            $hasil[$i]['error_group_coverage']= "Data Group Coverage tidak ditemukan";
                        }

                        $count_coverage=CatalogCoverage::where('nama_coverage',$data[$i]['coverage'])->count();
                        if($count_coverage!=0){
                            $coverage=CatalogCoverage::where('nama_coverage',$data[$i]['coverage'])->first();
                            $hasil[$i]['id_coverage']   = $coverage->id;
                            $hasil[$i]['coverage']      = $coverage->nama_coverage;
                        }else{
                            $hasil[$i]['id_coverage']=0;
                            $hasil[$i]['error_coverage']= "Data Coverage tidak ditemukan";
                        }

                        if($data[$i]['jenis_referensi']=="kontrak"){
                            $count_kontrak=Documents::where('doc_no',$data[$i]['referensi'])->where('doc_signing','1')->count();
                            if($count_kontrak!=0){
                                $kontrak=Documents::where('doc_no',$data[$i]['referensi'])->where('doc_signing','1')->first();
                                $hasil[$i]['id_kontrak']          = $kontrak->id;
                                $hasil[$i]['referensi']           = $kontrak->doc_no;

                                if($kontrak->doc_type="khs"){
                                    $hasil[$i]['khs']             = 1;
                                }
                            }else{
                                $hasil[$i]['error_referensi']     = "Data Kontrak tidak ditemukan";
                                $hasil[$i]['referensi']           = "";
                            }
                        }else{
                            $hasil[$i]['jenis_referensi'] = 2;
                        }
                        
                    }

                    return Response::json(['status'=>true,'csrf_token'=>csrf_token(),'data'=>$hasil]);
                }else{
                    return Response::json(['status'=>false,'fix'=>1]);
                }
            }else{
                return Response::json(['status'=>false,'fix'=>2]);
            }
        }else{
            return Response::json(['status'=>false,'fix'=>3]);
        }
    }
}
