<?php
namespace App\Helpers\Pdf\Proposal;
use TCPDF;


class beesafe extends TCPDF
{
    public function Header() {
        $this->setJPEGQuality(300);
		$this->Image('assets/img/kop/Beesafe1.png', 137, 9, 50, 18, 'PNG', 'http://www.beesafe.co.id', '', true, 1000, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 20);
		$this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        
    }
}

