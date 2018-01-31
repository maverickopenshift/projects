<?php
namespace App\Helpers;

use App\Helpers\PdfRotate;

class PDF extends PdfRotate {

    public $_tplIdx;
    public $file;
    public $nama;
    public $nik;
    
    function __construct($file,$nama,$nik){
      parent::__construct();
      $this->file = $file;
      $this->nama = $nama;
      $this->nik = $nik;
    }
    
    public function Header() {
        
        //Put the watermark
        $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 40, 100, 100, 0, 'PNG');
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(20, 230, $this->nama.'-'.$this->nik, 45);
        
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