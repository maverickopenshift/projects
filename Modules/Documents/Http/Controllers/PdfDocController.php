<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use App\Helpers\Pdf;

class PdfDocController extends Controller
{
  public function index(Request $req){
    $type = $req->type;
    $filename = $req->filename;
    $file = storage_path('app/document/'.$type.'/' . $filename);
    $users_id = \Auth::id();
    date_default_timezone_set('Asia/Jakarta');
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");

    $sql = \DB::table('users')
          ->join('users_pegawai', 'users_pegawai.users_id', '=', 'users.id')  
          ->join('pegawai', 'users_pegawai.nik', '=', 'pegawai.n_nik')
          ->select('pegawai.n_nik', 'pegawai.v_nama_karyawan')
          ->where('users_pegawai.users_id',$users_id)->get();

    $id = DB::table('log_download')->insertGetId(
        ['users_id' => $users_id, 'documents_name' => $filename, 'created_at' => $created_at, 'updated_at' => $updated_at]
    );

    $nik = '';
    $nama = '';      
    foreach ($sql as $key => $value) {
        $nik = $value->n_nik;
        $nama= $value->v_nama_karyawan;
    }

    $pdf = new Pdf($file,$nik,$nama);
    $pdf->AddPage();
    $pdf->SetFont('arial', '', 12);

    if($pdf->numPages>1) {
        for($i=2;$i<=$pdf->numPages;$i++) {
            //$pdf->endPage();
            $pdf->_tplIdx = $pdf->importPage($i);
            $pdf->AddPage();
        }
    }

    $pdf->Output(); 
    exit;
  }
}
