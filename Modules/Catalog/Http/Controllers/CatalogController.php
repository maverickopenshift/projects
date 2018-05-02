<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\CatalogProductMaster as CatalogProductMaster;
use Modules\Catalog\Entities\CatalogProductLogistic as CatalogProductLogistic;
use Modules\Documents\Entities\DocBoq as DocBoq;
use Modules\Catalog\Entities\CatalogCategory as CatalogCategory;
use Modules\Documents\Entities\Documents as Documents;
use App\User;
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
        $pengguna=Auth::id();
        if($request->parent_id==0){
            $data=DB::table('catalog_product_master as a')
                    ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                    ->join('catalog_satuan as c','c.id','=','a.satuan_id')
                    ->selectRaw("a.*,b.display_name as category_name, c.nama_satuan as nama_satuan")
                    ->orderbyRaw("(CASE WHEN user_id = $pengguna THEN 1 ELSE 2 END)")
                    ->get();
                    
        }else{
            $data=DB::table('catalog_product_master as a')
                    ->join('catalog_category as b','b.id','=','a.catalog_category_id')
                    ->join('catalog_satuan as c','c.id','=','a.satuan_id')
                    ->selectRaw("a.*,b.display_name as category_name, c.nama_satuan as nama_satuan")
                    ->whereIn('b.id', $this->get_category($request->parent_id,0))
                    ->orderbyRaw("CASE WHEN user_id = $pengguna THEN 1 ELSE 2 END")
                    ->get();
        }

        if($request->type==1){
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if(Auth::user()->hasPermission('katalog-master-item-proses')){
                        $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                        $act= '<div class="btn-group">';
                            if($data->user_id==Auth::id()){
                                $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Ubah</button>';
                                $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Hapus</button>';
                            }
                        $act .='</div>';
                        return $act;
                    }
                })
                ->make(true);
        }else{
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                        if(Auth::user()->hasPermission('katalog-item-price-proses')){
                        $act .='<a href="'. route('catalog.product.logistic') .'?id_product='.$data->id.'" class="btn btn-success btn-xs btn-price-add"><i class="glyphicon glyphicon-plus"></i> Price</a>';
                        }
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
        $data['user'] = User::get_user_pegawai();
        
        return view('catalog::list_product_logistic')->with($data);
    }
    
    public function index_product_logistic_datatables(Request $request){
        $pengguna=Auth::id();
        $data=DB::table('catalog_product_logistic as a')
                ->leftjoin('documents as c','c.id','=','a.referensi_logistic')
                ->selectRaw("a.*, c.doc_no")
                ->where('a.product_master_id',$request->id)
                ->orderbyRaw("(CASE WHEN a.user_id = $pengguna THEN 1 ELSE 2 END)");
        
        if($request->f_caritext!=""){
            $data->where(function ($query) use ($request) {
                $query->orwhere('c.doc_no', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.referensi_logistic', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.lokasi_logistic', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.harga_barang_logistic', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.harga_jasa_logistic', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.referensi_logistic', 'like' , '%'.$request->f_caritext.'%');
            });
        }

        if($request->divisi!=""){
            $data->where('a.divisi',$request->divisi);
        }

        if($request->unit_bisnis!=""){
            $data->where('a.unit_bisnis',$request->unit_bisnis);
        }

        if($request->unit_kerja!=""){
            $data->where('a.unit_kerja',$request->unit_kerja);
        }

        $data->get();
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                        if(Auth::user()->hasPermission('katalog-item-price-proses') && $data->user_id==Auth::id()){
                            $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                            $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                        }
                    $act .='</div>';
                    return $act;
                })
                ->editColumn('referensi_fix', function($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');

                    if($data->jenis_referensi==2){
                        $act=$data->referensi_logistic;
                    }else{
                        $act=$data->doc_no;
                    }
                    return $act;
                })
                ->make(true);
    }

    public function index_kontrak_datatables(Request $request){
        $pengguna=Auth::id();
        $data=Documents::where('doc_signing','1');

        if(!empty($request->cari)){
            $data->where(function($q) use ($request) {
                $q->orWhere('doc_no', 'like', '%'.$request->cari.'%');
                $q->orWhere('doc_title', 'like', '%'.$request->cari.'%');
            });
        }

        $data->get();        

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                $act    = '<div class="btn-group">';
                $act   .= '<button type="button" class="btn btn-primary btn-xs btn-pilih-kontrak" data-data="'.$dataAttr.'">
                            <i class="glyphicon glyphicon-ok"></i> Pilih
                           </button>';
                $act   .= '</div>';
                return $act;
            })
            ->make(true);
    }

    public function index_product_kontrak(Request $request){
        //$data['category']=CatalogCategory::get();
        $data['page_title'] = 'List Kontrak';
        $data['user'] = User::get_user_pegawai();
        
        return view('catalog::list_product_kontrak')->with($data);
    }

    public function index_product_kontrak_datatables(Request $request){
        $pengguna=Auth::id();
        $data=DB::table('catalog_product_logistic as a')
                ->join('documents as b','b.id','=','a.referensi_logistic')
                ->selectRaw("a.*, b.doc_title, b.doc_no, b.doc_type")
                ->where('a.jenis_referensi','1')
                ->orderbyRaw("(CASE WHEN a.user_id = $pengguna THEN 1 ELSE 2 END)")
                ->groupby('a.referensi_logistic')
                ->get();
        
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                    $act .='<a data-id="'. $data->referensi_logistic .'" class="btn btn-primary btn-xs detail_price"><i class="glyphicon glyphicon-edit"></i> Detail</a>';
                    $act .='</div>';
                    return $act;
                })
                ->make(true);
    }

    public function index_product_kontrak_logistic_datatables(Request $request){
        $pengguna=Auth::id();
        $data=DB::table('catalog_product_logistic as a')
                ->join('catalog_product_master as b','b.id','=','a.product_master_id')
                ->selectRaw("a.*, b.kode_product as kode_product")
                ->where('a.referensi_logistic',$request->id)
                ->where('a.jenis_referensi',1)
                ->orderbyRaw("(CASE WHEN a.user_id = $pengguna THEN 1 ELSE 2 END)");

        if($request->f_caritext!=""){
            $data->where(function ($query) use ($request) {
                $query->orwhere('a.lokasi_logistic', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.harga_barang_logistic', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.harga_jasa_logistic', 'like' , '%'.$request->f_caritext.'%');
            });
        }

        if($request->divisi!=""){
            $data->where('a.divisi',$request->divisi);
        }

        if($request->unit_bisnis!=""){
            $data->where('a.unit_bisnis',$request->unit_bisnis);
        }

        if($request->unit_kerja!=""){
            $data->where('a.unit_kerja',$request->unit_kerja);
        }

        $data->get();        

        return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
    }
}
