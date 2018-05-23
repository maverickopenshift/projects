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
use App\Helpers\Helpers;
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
        $pegawai = User::get_user_pegawai();
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
                ->addColumn('action', function ($data)  use ($pegawai) {
                    if($pegawai->divisi==$data->divisi){
                        $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                        $act= '<div class="btn-group">';
                            if($data->user_id==Auth::id()){
                                $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Ubah</button>';
                                $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-target="#modal-delete" data-toggle="modal" ><i class="glyphicon glyphicon-trash"></i> Hapus</button>';
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
                        $act .='<a data-id="'. $data->id .'" data-kode="'. $data->kode_product .'" data-ket="'. $data->nama_product .'" class="btn btn-primary btn-xs detail_price"><i class="glyphicon glyphicon-edit"></i> Detail</a>';
                    $act .='</div>';
                    return $act;
                })
                ->make(true);
        }
    }

    public function index_product_logistic(Request $request){
        $data['category']   = CatalogCategory::get();
        $data['page_title'] = 'List Item Price';
        $data['user']       = User::get_user_pegawai();

        $data['no_product'] = $request->get('no_product') ?: 0;
        if($data['no_product']!=0){
            $masteritem=CatalogProductMaster::where('id',$data['no_product'])->first();

            $data['kode_product']      = $masteritem->kode_product;
            $data['nama_product']       = $masteritem->nama_product;
        }else{
            $data['kode_product']      = "";
            $data['nama_product']       = "";
        }
        
        return view('catalog::list_product_logistic')->with($data);
    }
    
    public function index_product_logistic_datatables(Request $request){
        $pengguna=Auth::id();
        $pegawai = User::get_user_pegawai();
        $data=DB::table('catalog_product_logistic as a')
                ->join('catalog_coverage as b','b.id','=','a.coverage_id')
                ->join('catalog_group_coverage as d','d.id','=','a.group_coverage_id')
                ->leftjoin('documents as c','c.id','=','a.referensi_logistic')
                ->selectRaw("a.*, b.nama_coverage, d.nama_group_coverage, c.doc_no")
                ->where('a.product_master_id',$request->id)
                ->orderbyRaw("(CASE WHEN a.user_id = $pengguna THEN 1 ELSE 2 END)");
        
        if($request->f_caritext!=""){
            $data->where(function ($query) use ($request) {
                $query->orwhere('c.doc_no', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.referensi_logistic', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('b.nama_coverage', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('d.nama_group_coverage', 'like' , '%'.$request->f_caritext.'%')
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
                ->addColumn('action', function ($data) use ($pegawai) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act= '<div class="btn-group">';
                        if(Auth::user()->hasPermission('katalog-item-price-proses') && $data->divisi==$pegawai->divisi){
                            $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-product"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'" data-type="product" ><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                            $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-type="product" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                        }
                    $act .='</div>';
                    return $act;
                })
                ->addColumn('flag', function ($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    if($data->jenis_referensi==1){
                        $doc=Documents::where('id',$data->referensi_logistic)->first();
                        if($doc->doc_type=="khs"){
                            $act="KHS";    
                        }else{
                            $act='';
                        }
                    }else{
                        $act='';
                    }
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

    public function index_product_logistic_view(Request $request){
        $data['category']   = CatalogCategory::get();
        $data['page_title'] = 'List Item';
        $data['user']       = User::get_user_pegawai();

        $data['no_product'] = $request->get('no_product') ?: 0;
        if($data['no_product']!=0){
            $masteritem=CatalogProductMaster::where('id',$data['no_product'])->first();

            $data['kode_product']      = $masteritem->kode_product;
            $data['ket_product']       = $masteritem->keterangan_product;
        }else{
            $data['kode_product']      = "";
            $data['ket_product']       = "";
        }

        $result=CatalogCategory::where('parent_id',0)->get();
        $hasil=array();
        $x=0;
        
        for($i=0;$i<count($result);$i++){
            $hasil[$x]['id']=$result[$i]->id;
            $hasil[$x]['text']=$result[$i]->code ." - ". $result[$i]->display_name;
            $hasil[$x]['child']=1;

            $x++;
            
            $result_child1=CatalogCategory::where('parent_id',$result[$i]->id)->get();
            for($j=0;$j<count($result_child1);$j++){
                $hasil[$x]['id']=$result_child1[$j]->id;
                $hasil[$x]['text']=$result_child1[$j]->code ." - ". $result_child1[$j]->display_name;
                $hasil[$x]['child']=2;
                $x++;
                
                $result_child2=CatalogCategory::where('parent_id',$result_child1[$j]->id)->get();
                for($k=0;$k<count($result_child2);$k++){
                    $hasil[$x]['id']=$result_child2[$k]->id;
                    $hasil[$x]['text']=$result_child2[$k]->code ." - ". $result_child2[$k]->display_name;
                    $hasil[$x]['child']=3;
                    $x++;
                    
                    $result_child3=CatalogCategory::where('parent_id',$result_child2[$k]->id)->get();
                    for($l=0;$l<count($result_child3);$l++){
                        $hasil[$x]['id']=$result_child3[$l]->id;
                        $hasil[$x]['text']=$result_child3[$l]->code ." - ". $result_child3[$l]->display_name;
                        $hasil[$x]['child']=4;
                        $x++;

                        $result_child4=CatalogCategory::where('parent_id',$result_child3[$l]->id)->get();
                        for($m=0;$m<count($result_child4);$m++){
                            $hasil[$x]['id']=$result_child4[$m]->id;
                            $hasil[$x]['text']=$result_child4[$m]->code ." - ". $result_child4[$m]->display_name;
                            $hasil[$x]['child']=5;
                            $x++;

                            $result_child5=CatalogCategory::where('parent_id',$result_child4[$m]->id)->get();
                            for($n=0;$n<count($result_child5);$n++){
                                $hasil[$x]['id']=$result_child5[$n]->id;
                                $hasil[$x]['text']=$result_child5[$n]->code ." - ". $result_child5[$n]->display_name;
                                $hasil[$x]['child']=6;
                                $x++;
                            }
                        }
                    }
                }
                
            }
        }

        $data['kategori'] = $hasil;
        
        return view('catalog::list_product_logistic_view')->with($data);
    }

    public function index_product_logistic_view_datatables(Request $request){
        $pengguna=Auth::id();
        $pegawai = User::get_user_pegawai();
        $data=DB::table('catalog_product_logistic as a')
                ->join('catalog_coverage as b','b.id','=','a.coverage_id')
                ->leftjoin('documents as c','c.id','=','a.referensi_logistic')
                ->leftjoin('supplier as h','h.id','=','c.supplier_id')
                ->join('catalog_group_coverage as d','d.id','=','a.group_coverage_id')
                ->join('catalog_product_master as e','e.id','=','a.product_master_id')
                ->join('catalog_satuan as f','f.id','=','e.satuan_id')
                ->join('catalog_category as g','g.id','=','e.catalog_category_id')

                ->selectRaw("a.*, b.nama_coverage, d.nama_group_coverage, c.doc_no, f.nama_satuan, e.kode_product, e.nama_product, concat(g.code,' - ',g.display_name) as taxonomy, e.image_product, concat(h.bdn_usaha,'.',h.nm_vendor) as nama_supplier, c.doc_startdate, c.doc_enddate, c.doc_type")
                ->orderbyRaw("(CASE WHEN a.user_id = $pengguna THEN 1 ELSE 2 END)");
        
        if($request->f_caritext!=""){
            $data->where(function ($query) use ($request) {
                $query->orwhere('c.doc_no', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('a.referensi_logistic', 'like' , '%'.$request->f_caritext.'%')

                      ->orwhere('e.kode_product', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('e.nama_product', 'like' , '%'.$request->f_caritext.'%')

                      ->orwhere('g.code', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('g.display_name', 'like' , '%'.$request->f_caritext.'%')

                      ->orwhere('f.nama_satuan', 'like' , '%'.$request->f_caritext.'%');
            });
        }

        if($request->f_nokategori!=""){
            $data->whereIn('e.catalog_category_id', $this->get_category($request->f_nokategori,0));
        }

        if($request->f_nogroupcoverage!=""){
            $data->where('a.group_coverage_id',$request->f_nogroupcoverage);
        }

        if($request->f_nocoverage!=""){
            $data->where('a.coverage_id',$request->f_nocoverage);
        }

        if($request->f_nosupplier!=""){
            $data->where('h.id',$request->f_nosupplier);
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
            ->addColumn('flag', function ($data) {
                $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                if($data->jenis_referensi==1){
                    $doc=Documents::where('id',$data->referensi_logistic)->first();
                    if($doc->doc_type=="khs"){
                        $act="KHS";    
                    }else{
                        $act='';
                    }
                }else{
                    $act='';
                }
                return $act;
            })
            /*
            ->editColumn('referensi_fix', function($data) {
                $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');

                if($data->jenis_referensi==2){
                    $act=$data->referensi_logistic;
                }else{
                    $act=$data->doc_no;
                }
                return $act;
            })
            */

            ->addColumn('action', function ($data) {
                $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                $act    = '<div class="btn-group">';
                $act    .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal-detail"  data-title="Detail" data-data="'.$dataAttr.'"><i class="glyphicon glyphicon-edit"></i> Detail</button>';
                $act   .= '</div>';
                return $act;
            })
            ->make(true);
    }

    public function index_kontrak_datatables(Request $request){
        $pengguna=Auth::id();
        $data=DB::table('documents as a')
        ->join('supplier as b','a.supplier_id','=','b.id')
        ->selectRaw('a.*, b.bdn_usaha, b.nm_vendor')
        ->where('a.doc_signing','1');        

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
            ->editColumn('nama_supplier', function($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act = $data->bdn_usaha .'.'. $data->nm_vendor;
                    return $act;
                })
            ->make(true);
    }

    public function index_product_kontrak(Request $request){
        //$data['category']=CatalogCategory::get();
        $data['page_title'] = 'List Item Kontrak';
        $data['user'] = User::get_user_pegawai();
        
        return view('catalog::list_product_kontrak')->with($data);
    }

    public function index_product_kontrak_datatables(Request $request){
        $pengguna=Auth::id();
        $data=DB::table('catalog_product_logistic as a')
                ->join('documents as b','b.id','=','a.referensi_logistic')
                ->join('supplier as c','c.id','=','b.supplier_id')
                ->selectRaw("a.*, b.doc_title, b.doc_no, b.doc_type, b.doc_startdate, b.doc_enddate, concat(c.bdn_usaha,'.', c.nm_vendor) as nama_supplier")
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
                /*
                ->editColumn('nama_supplier', function($data) {
                    $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                    $act = $data->bdn_usaha .'.'. $data->nm_vendor;
                    return $act;
                })
                */
                ->make(true);
    }

    public function index_product_kontrak_logistic_datatables(Request $request){
        $pengguna=Auth::id();
        $data=DB::table('catalog_product_logistic as a')
                ->join('catalog_product_master as b','b.id','=','a.product_master_id')
                ->join('catalog_group_coverage as c','c.id','=','a.group_coverage_id')
                ->join('catalog_coverage as d','d.id','=','a.coverage_id')
                ->selectRaw("a.*, b.kode_product as kode_product, c.nama_group_coverage, d.nama_coverage")
                ->where('a.referensi_logistic',$request->id)
                ->where('a.jenis_referensi',1)
                ->orderbyRaw("(CASE WHEN a.user_id = $pengguna THEN 1 ELSE 2 END)");

        if($request->f_caritext!=""){
            $data->where(function ($query) use ($request) {
                $query->orwhere('c.nama_group_coverage', 'like' , '%'.$request->f_caritext.'%')
                      ->orwhere('d.nama_coverage', 'like' , '%'.$request->f_caritext.'%')
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
