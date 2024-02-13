<?php
namespace App\Helpers\Pdf\Proposal;
use TCPDF;


class chesna extends TCPDF
{
    public function Header() {

        $this->setJPEGQuality(300);
		$this->Image('assets/img/kop/Chesna1.png', 3.8, 0, 206, 43, 'PNG', 'https://www.chesna.co.id', '', true, 1000, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 20);
		$this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        $this->setJPEGQuality(300);
		$this->Image('assets/img/kop/Chesna2.png', 0, 271, 211, 30, 'PNG', 'https://www.chesna.co.id', '', true, 1000, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 20);
		$this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
}

