<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\Helpers;
use App\Helpers\CustomErrors;
use Modules\Supplier\Entities\SupplierSap as Sap;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Entities\SupplierMetadata;
use Modules\Supplier\Entities\SupplierActivity;
use App\User;
use Excel;
use DB;
use Auth;
use Validator;
use Response;

class UploadSapController extends Controller
{
  public function store(Request $request)
  {
    if ($request->ajax()) {
        $data = Excel::load($request->file('supplier_sap')->getRealPath(), function ($reader) {

        })->get();
        $header = ['cl','vendor','cty','name_1','city','postalcode','rg','searchterm','street','date','title','created_by','group','language','vat_registration_no'];
        $colomn = $data->first()->keys()->toArray();

        if(!empty($data) && count($colomn) == 15){
          foreach ($data as $key => $value) {
            $tgl = date_create($value->date);
            $date = date_format($tgl,"Y/m/d");

            $insert[] = ['users_id' => Auth::id(),
                         'ci' => $value->cl,
                         'vendor' => $value->vendor,
                         'cty' => $value->cty,
                         'name_1' => $value->name_1,
                         'city' => $value->city,
                         'postalcode' => $value->postalcode,
                         'rg' => $value->rg,
                         'searchterm' => $value->searchterm,
                         'street' => $value->street,
                         'title' => $value->title,
                         'date' => $date,
                         'created_by' => $value->created_by,
                         'group' => $value->group,
                         'language' => $value->language,
                         'vat_registration_no' => $value->vat_registration_no,
                         'upload_date' => new \DateTime(),
                         'upload_by' => Auth::user()->username,
                       ];
          }
          if(!empty($insert)){
            DB::table('supplier_sap')->insert($insert);
            // $request->session()->flash('alert-success', 'Data berhasil disimsssssan');
            return Response::json(['status'=>true,'csrf_token'=>csrf_token()]);
          }
          else{
            return Response::json(['status'=>false]);
          }
      }
      else{
        return Response::json(['status'=>false]);
      }
    }
    else{
      return Response::json(['status'=>false]);
    }
}

  public function importExcel(Request $request)
      {
          if($request->hasFile('import_file')){
              Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
                  foreach ($reader->toArray() as $key => $row) {
                      $data['title'] = $row['title'];
                      $data['description'] = $row['description'];

                      if(!empty($data)) {
                          DB::table('post')->insert($data);
                      }
                  }
              });
          }

          Session::put('success', 'Youe file successfully import in database!!!');

          return back();
      }

      public function uploadsmile(Request $request)
      {
        // dd("haiSmile");
        if ($request->ajax()) {
            $data = Excel::load($request->file('supplier_smile')->getRealPath(), function ($reader) {

            })->formatDates(true, 'Y-m-d')->get();
            // dd($data)
            $header = ['kd_vendor','bdn_usaha','nm_vendor','nm_vendor_uq','alamat','negara','kota','kd_pos','telepon','fax','e_mail','web_site','induk_perush','induk_perush_kd',
                      'akte_awal_no','akte_awal_tg','akte_awal_notaris','akte_akhir_no','akte_akhir_tg','akte_akhir_notaris','siup_no','siup_tg_terbit','siup_tg_expired','siup_kualifikasi',
                      'pkp','npwp_no','npwp_tg','tdp_no','tdp_tg_terbit','tdp_tg_expired','idp_no','idp_tg_terbit','idp_tg_expired','iujk_no','iujk_tg_terbit','iujk_tg_expired','modal_dasar',
                      'asset','bank_nama','bank_cabang','bank_kota','bank_norek','jml_peg_domestik','jml_peg_asing','st_aktif','app_jml','app_posisi','app_proses','no_agen','kode_loker','tg_register',
                      'tg_approval','no_rekanan_telkom','kd_file','kd_vendor_old','proses_ke','tg_toc','grup','ciqs_no','ciqs_tg_terbit','ciqs_tg_expired',
                      'prinsipal_st','prinsipal_no','prinsipal_tg_terbit','prinsipal_tg_expired','cp1_nama','cp1_telp','cp1_email','cp2_nama','cp2_telp','cp2_email','tg_rekanan_expired','kementrian_sk','kementrian_tg'];
// count=78

            $colomn = $data->first()->keys()->toArray();
            // dd(count($colomn));
            if($colomn!==$header || count($colomn) !== 74 || empty($data)){
              return Response::json(['status'=>false]);
            }else{
              // dd($data);
              foreach ($data as $key => $value) {
                // $tgl = date_create($value->date);
                // $date = date_format($tgl,"Y/m/d");
                $user = new User();
                $user->name = $value->nm_vendor;
                $user->username = $value->kd_vendor;
                $user->phone = $value->telepon;
                $user->email = $value->e_mail;
                  $bdn_usaha = $value->bdn_usaha;
                  $inisial = $value->nm_vendor_uq;
                  $gabung = $bdn_usaha." - ".$inisial;
                $user->data = $gabung;
                $user->confirmed = 1;
                $user->actived = 1;
                $user->password = bcrypt(config('app.password_default'));
                $user->save();
                $user->attachRole('vendor');

                $data = new Supplier();
                $data->id_user = Auth::id();
                $data->kd_vendor = $value->kd_vendor;
                $data->bdn_usaha = $value->bdn_usaha;
                $data->nm_vendor = $value->nm_vendor;
                $data->nm_vendor_uq = $value->nm_vendor_uq;
                $data->alamat = $value->alamat;
                $data->negara = $value->negara;
                $data->kota = $value->kota;
                $data->kd_pos = $value->kd_pos;
                $data->telepon = $value->telepon;
                $data->fax = $value->fax;
                $data->email = $value->e_mail;
                $data->web_site = $value->web_site;
                $data->induk_perus = $value->induk_perush;
                $data->induk_perus_kd = $value->induk_perush_kd;
                $data->akte_awal_no = $value->akte_awal_no;
                $data->akte_awal_tg = $value->akte_awal_tg;
                $data->akte_awal_notaris = $value->akte_awal_notaris;
                $data->akte_akhir_no = $value->akte_akhir_no;
                $data->akte_akhir_tg = $value->akte_akhir_tg;
                $data->akte_akhir_notaris = $value->akte_akhir_notaris;
                $data->siup_no = $value->siup_no;
                $data->siup_tg_terbit = $value->siup_tg_terbit;
                $data->siup_tg_expired = $value->siup_tg_expired;
                $data->siup_kualifikasi = $value->siup_kualifikasi;
                $data->pkp = $value->pkp;
                $data->npwp_no = $value->npwp_no;
                $data->npwp_tg = $value->npwp_tg;
                $data->tdp_no = $value->tdp_no;
                $data->tdp_tg_terbit = $value->tdp_tg_terbit;
                $data->tdp_tg_expired = $value->tdp_tg_expired;
                $data->idp_no = $value->idp_no;
                $data->idp_tg_terbit = $value->idp_tg_terbit;
                $data->idp_tg_expired = $value->idp_tg_expired;
                $data->modal_dasar = $value->modal_dasar;
                $data->asset = $value->asset;
                $data->bank_nama = $value->bank_nama;
                $data->bank_cabang = $value->bank_cabang;
                $data->bank_norek = $value->bank_norek;
                $data->jml_peg_domestik = $value->jml_peg_domestik;
                $data->jml_peg_asing = $value->jml_peg_asing;
                $data->st_aktif = $value->st_aktif;
                $data->app_jml = $value->app_jml;
                $data->app_posisi = $value->app_posisi;
                $data->app_proses = $value->app_proses;
                $data->no_agen = $value->no_agen;
                $data->kode_loker = $value->kode_loker;
                $data->no_rekanan_telkom = $value->no_rekanan_telkom;
                $data->kd_file = $value->kd_file;
                $data->kd_vendor_old = $value->kd_vendor_old;
                $data->proses_ke = $value->proses_ke;
                $data->tg_toc = $value->tg_toc;
                $data->grup = $value->grup;
                $data->ciqs_no = $value->ciqs_no;
                $data->ciqs_tg_terbit = $value->ciqs_tg_terbit;
                $data->ciqs_tg_expired = $value->ciqs_tg_expired;
                $data->prinsipal_st = $value->prinsipal_st;
                $data->prinsipal_no = $value->prinsipal_no;
                $data->prinsipal_tg_terbit = $value->prinsipal_tg_terbit;
                $data->prinsipal_tg_expired = $value->prinsipal_tg_expired;
                $data->cp1_nama = $value->cp1_nama;
                $data->cp1_telp = $value->cp1_telp;
                $data->cp1_email = $value->cp1_email;
                $data->cp2_nama = $value->cp2_nama;
                $data->cp2_telp = $value->cp2_telp;
                $data->cp2_email = $value->cp2_email;
                $data->tg_rekanan_expired = $value->tg_rekanan_expired;
                $data->kementrian_sk = $value->kementrian_sk;
                $data->kementrian_tg = $value->kementrian_tg;
                $data->vendor_status = 1;
                $data->approval_at = $value->tg_approval;
                $data->created_by = \Auth::user()->username;
                $data->created_at = $value->tg_register;
                $data->updated_at = new \DateTime();
                $data->save();

                $mt_data = new SupplierMetadata();
                $mt_data->id_object    = $data->id;
                $mt_data->object_type  = 'vendor';
                $mt_data->object_key   = 'sertifikat_dokumen';
                $mt_data->object_value = json_encode(['iujk_no' => $value->iujk_no, 'iujk_tg_terbit' => $value->iujk_tg_terbit,
                                         'iujk_tg_expired'=> $value->iujk_tg_expired, 'name'=>null,'file'=>null]);
                $mt_data->save();

                $mt_data = new SupplierMetadata();
                $mt_data->id_object    = $data->id;
                $mt_data->object_type  = 'vendor';
                $mt_data->object_key   = 'bank_kota';
                $mt_data->object_value = $value->bank_kota;
                $mt_data->save();

                $mt_data = new SupplierMetadata();
                $mt_data->id_object    = $data->id;
                $mt_data->object_type  = 'vendor';
                $mt_data->object_key   = 'pengalaman_kerja';
                $mt_data->object_value = null;
                $mt_data->save();

                $mt_data = new SupplierMetadata();
                $mt_data->id_object    = $data->id;
                $mt_data->object_type  = 'vendor';
                $mt_data->object_key   = 'nm_direktur_utama';
                $mt_data->object_value = null;
                $mt_data->save();

                $mt_data = new SupplierMetadata();
                $mt_data->id_object    = $data->id;
                $mt_data->object_type  = 'vendor';
                $mt_data->object_key   = 'nm_komisaris_utama';
                $mt_data->object_value = null;
                $mt_data->save();

                $mt_data = new SupplierMetadata();
                $mt_data->id_object    = $data->id;
                $mt_data->object_type  = 'vendor';
                $mt_data->object_key   = 'klasifikasi_usaha';
                $mt_data->object_value = null;
                $mt_data->save();

                $mt_data = new SupplierMetadata();
                $mt_data->id_object    = $data->id;
                $mt_data->object_type  = 'vendor';
                $mt_data->object_key   = 'anak_perusahaan';
                $mt_data->object_value = null;
                $mt_data->save();

                $mt_data = new SupplierMetadata();
                $mt_data->id_object    = $data->id;
                $mt_data->object_type  = 'vendor';
                $mt_data->object_key   = 'legal_dokumen';
                $mt_data->object_value = json_encode(['name'=>null,'file'=>null]);
                $mt_data->save();

                $log_activity = new SupplierActivity();
                $log_activity->users_id = Auth::id();
                $log_activity->supplier_id = $data->id;
                $log_activity->activity = "Submitted";
                $log_activity->date = new \DateTime();
                $log_activity->komentar = "Upload From Smile";
                $log_activity->save();

              }
            }
          }
        else{
          return Response::json(['status'=>false]);
        }
    }


}
