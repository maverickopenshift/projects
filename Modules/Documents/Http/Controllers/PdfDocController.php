<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Helpers\Pdf;

class PdfDocController extends Controller
{
  public function index(Request $req){
    // dd($req->id);
    $type = $req->type;
    $filename = $req->filename;
    //if($type=='document')
    $file = storage_path('app/document/'.$type.'/' . $filename);
    //$file = storage_path("app/document/adendum/doc_lampiran__adendum-kontrak-1_1510160861_yt6kp.pdf");
    $nama = 'Irfan';
    $nik = '009923232';
    $pdf = new Pdf($file,$req->nama,$req->nik);
    //$pdf = new FPDI();
    $pdf->AddPage();
    $pdf->SetFont('arial', '', 12);


    /*$txt = "FPDF is a PHP class which allows to generate PDF files with pure PHP, that is to say " .
            "without using the PDFlib library. F from FPDF stands for Free: you may use it for any " .
            "kind of usage and modify it to suit your needs.\n\n";
    for ($i = 0; $i < 25; $i++) {
        $pdf->MultiCell(0, 5, $txt, 0, 'J');
    }*/


    if($pdf->numPages>1) {
        for($i=2;$i<=$pdf->numPages;$i++) {
            $pdf->_tplIdx = $pdf->importPage($i);
            $pdf->AddPage();
        }
    }

    $pdf->Output(); 
    exit;
  }
}
