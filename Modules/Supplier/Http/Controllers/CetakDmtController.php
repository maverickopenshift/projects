<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Entities\SupplierMetadata;
use Modules\Config\Entities\Config;
use Response;
use PDF;

class CetakDmtController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function pdf(Request $request)
    {
      // dd("yoo");

      $id = $request->id;

      $sup = Supplier::where('id', $id)->first();

      $metadata_direktur = SupplierMetadata::where('id_object', $id)->where('object_key', 'nm_direktur_utama')->first();
      $metadata_klasifikasi = SupplierMetadata::where('id_object', $id)->where('object_key', 'klasifikasi_usaha')->get();
      foreach($metadata_klasifikasi as $metadata_klasifikasi){
        $d = json_decode($metadata_klasifikasi->object_value);
        $klasifikasi_kode[] = $d->kode;
        $klasifikasi_text[] = $d->text;
      }
      $klasifikasi_kode = $klasifikasi_kode;
      $klasifikasi_text = $klasifikasi_text;
      // dd($klasifikasi_text);
      $pimpinan = strtoupper($metadata_direktur->object_value);
      $nama = ucwords($sup->nm_vendor);
      $bdn_usaha = strtoupper($sup->bdn_usaha);
      $nama_perusahaan = strtoupper($nama.", ".$bdn_usaha);
      $alamat = $sup->alamat;
      $kota = $sup->kota;
      $kode_sup = $sup->kd_vendor;

      $config = Config::where('object_key','=','set-dmt')->first();
      $d = json_decode($config->object_value);
      $nama_pegawai = strtoupper($d->v_nama_karyawan);
      $jabatan = strtoupper($d->jabatan);
      $kota_dmt = ucwords($d->kota);

      // dd($nama_pegawai);
      $sup = new Supplier();
      $kode = $sup->gen_dmtnomer();
      $endDate = date('Y-m-d', strtotime('+2 years'));
      $date = date('d-M-Y');
      // dd($kode);
      if($sup){
        $data = Supplier::where('id',$id)->first();
        $data->no_rekanan_telkom = $kode;
        $data->tg_rekanan_expired = $endDate;
        // $data->save();
        $pdf = PDF::loadView('supplier::partials.dmt', ['pimpinan' => $pimpinan, 'nama_perusahaan' => $nama_perusahaan,
                            'alamat' => $alamat, 'kode' => $kode, 'kota' => $kota, 'date' => $date,
                            'klasifikasi_text' => $klasifikasi_text, 'klasifikasi_kode' => $klasifikasi_kode,
                            'nama_pegawai' => $nama_pegawai, 'jabatan' => $jabatan, 'kota_dmt' => $kota_dmt,]);
        return $pdf->stream('dmt-'.$kode_sup.'.pdf');
      }else{
        abort(500);
      }
    }

    public function pdfUlang(Request $request)
    {
      // dd("yoo");

      $id = $request->id;

      $sup = Supplier::where('id', $id)->first();

      $metadata_direktur = SupplierMetadata::where('id_object', $id)->where('object_key', 'nm_direktur_utama')->first();
      $metadata_klasifikasi = SupplierMetadata::where('id_object', $id)->where('object_key', 'klasifikasi_usaha')->get();
      foreach($metadata_klasifikasi as $metadata_klasifikasi){
        $d = json_decode($metadata_klasifikasi->object_value);
        $klasifikasi_kode[] = $d->kode;
        $klasifikasi_text[] = $d->text;
      }
      $klasifikasi_kode = $klasifikasi_kode;
      $klasifikasi_text = $klasifikasi_text;
      $pimpinan = strtoupper($metadata_direktur->object_value);
      $nama = ucwords($sup->nm_vendor);
      $bdn_usaha = strtoupper($sup->bdn_usaha);
      $nama_perusahaan = strtoupper($nama.", ".$bdn_usaha);
      $alamat = $sup->alamat;
      $kota = $sup->kota;
      $kode_sup = $sup->kd_vendor;
      $kode = $sup->no_rekanan_telkom;
      $date = date('d-M-Y');
      // dd($date);
      // dd($kode_sup);
      // $endDate = date('Y-m-d', strtotime('+2 years'));
        $pdf = PDF::loadView('supplier::partials.dmt', ['pimpinan' => $pimpinan, 'nama_perusahaan' => $nama_perusahaan,
                            'alamat' => $alamat, 'kode' => $kode, 'kota' => $kota, 'date' => $date,
                            'klasifikasi_text' => $klasifikasi_text, 'klasifikasi_kode' => $klasifikasi_kode]);
        return $pdf->stream('dmt-'.$kode_sup.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('supplier::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('supplier::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
