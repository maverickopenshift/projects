<?php
namespace App\Helpers;

use App\Helpers\PdfRotate;

class PDF extends PdfRotate {

    public $_tplIdx;
    public $file;
    public $nama;
    public $nik;
    
    function __construct($file,$nik,$nama){
      parent::__construct();
      $this->file = $file;
      $this->nama = $nama;
      $this->nik = $nik;
    }
    
    public function Header() {
        
        //Put the watermark
        $this->SetFont('Arial', 'B', 45);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(80, 130, $this->nik, 45);
        $this->RotatedText(50, 180, $this->nama, 45);
        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($this->file);
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx, 0, 0, 200);
        
        
    }

    public function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

}