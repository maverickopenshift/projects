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

class ProductKontrakController extends Controller
{
    public function index(Request $request){
        $data['page_title'] = 'Item Price';
        $data['pegawai'] = User::get_user_pegawai();

        return view('catalog::product_kontrak')->with($data);
    }

    public function add_ajax(Request $request){
        if(count($request->f_id_master_item)>0){
            foreach($request->f_id_master_item as $key => $val){
                    if(!empty($val) && $request['f_id_master_item'][$key]!=0 && $request['f_referensi'][$key]!=0){
                        $proses = new CatalogProductLogistic();
                        $pegawai = User::get_user_pegawai();
                        $proses->user_id = Auth::id();
                        $proses->product_master_id      = $request['f_id_master_item'][$key];
                        $proses->group_coverage_id      = $request['f_nogroupcoverage'][$key];
                        $proses->coverage_id            = $request['f_nocoverage'][$key];

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

            $request->session()->flash('alert-success', 'Data berhasil disimpan');
            return Response::json (array(
                'status' => 'all'
            ));
        }else{
            $request->session()->flash('alert-danger', 'Data gagal disimpan');
            return Response::json (array(
                'status' => 'all'
            ));
        }
        
    }

    public function upload(Request $request){
        if ($request->ajax()) {
            $data = Excel::load($request->file('upload-product-kontrak')->getRealPath(), function ($reader) {})->get();
            
            $header = ['kode_master_item','group_coverage','coverage','harga_barang','harga_jasa','no_kontrak'];
            $jml_header = '6';
            
            if(!empty($data) && $data->first() != null ){
                $colomn = $data->first()->keys()->toArray();
                if(count($colomn) == $jml_header && $colomn == $header){
                    $hasil=array();

                    for($i=0;$i<count($data);$i++){
                        $hasil[$i]['kode_master_item']          = $data[$i]['kode_master_item'];
                        //$hasil[$i]['price_coverage']            = $data[$i]['price_coverage'];
                        $hasil[$i]['harga_barang']              = $data[$i]['harga_barang'];
                        $hasil[$i]['harga_jasa']                = $data[$i]['harga_jasa'];
                        $hasil[$i]['no_kontrak']                = $data[$i]['no_kontrak'];
                        $hasil[$i]['error_kontrak']             = "";
                        $hasil[$i]['kode_master_item_error']    = "";
                        $hasil[$i]['flag']                      = "";

                        $hasil[$i]['id_group_coverage']   = 0;
                        $hasil[$i]['id_coverage']         = 0;
                        $hasil[$i]['coverage_error']      = "";
                        $hasil[$i]['group_coverage_error']= "";
                        $hasil[$i]['group_coverage']      = $data[$i]['group_coverage'];
                        $hasil[$i]['coverage']            = $data[$i]['coverage'];

                        $count_kode=CatalogProductMaster::where('kode_product',$data[$i]['kode_master_item'])->count();
                        if($count_kode!=0){
                            $kode=CatalogProductMaster::where('kode_product',$data[$i]['kode_master_item'])->first();
                            $hasil[$i]['id_master_item']=$kode->id;
                            $hasil[$i]['kode_master_item_error']="";
                        }else{
                            $hasil[$i]['id_master_item']=0;
                            $hasil[$i]['kode_master_item_error']="Data tidak ditemukan";
                        }

                        $count_group_coverage=CatalogGroupCoverage::where('nama_group_coverage',$data[$i]['group_coverage'])->count();
                        if($count_group_coverage!=0){
                            $groupcoverage=CatalogGroupCoverage::where('nama_group_coverage',$data[$i]['group_coverage'])->first();

                            $hasil[$i]['id_group_coverage']= $groupcoverage->id;
                            $hasil[$i]['group_coverage']   = $groupcoverage->nama_group_coverage;
                        }else{
                            $hasil[$i]['id_group_coverage']=0;
                            $hasil[$i]['group_coverage_error']= "Data Group Coverage tidak ditemukan";
                        }

                        $count_coverage=CatalogCoverage::where('nama_coverage',$data[$i]['coverage'])->count();
                        if($count_coverage!=0){
                            $coverage=CatalogCoverage::where('nama_coverage',$data[$i]['coverage'])->first();
                            $hasil[$i]['id_coverage']   = $coverage->id;
                            $hasil[$i]['coverage']      = $coverage->nama_coverage;
                        }else{
                            $hasil[$i]['id_coverage']=0;
                            $hasil[$i]['coverage_error']= "Data Coverage tidak ditemukan";
                        }

                        $count_doc=Documents::where('doc_no',$data[$i]['no_kontrak'])->where('doc_signing',1)->count();
                        if($count_doc!=0){
                            $doc=Documents::where('doc_no',$data[$i]['no_kontrak'])->where('doc_signing',1)->first();
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
