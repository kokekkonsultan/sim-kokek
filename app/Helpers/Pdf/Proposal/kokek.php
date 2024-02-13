<?php
namespace App\Helpers\Pdf\Proposal;
use TCPDF;


class kokek extends TCPDF
{
    public function Header() {

        $this->setJPEGQuality(300);
        $this->Image('assets/img/kop/kc-bsi-logo-2.jpg', 22, 10, 80, 15, 'PNG', 'http://www.kokek.com', '', true, 1000, '', false, false, 0, false, false, false);
		$this->Image('assets/img/kop/arrow-logo.png', 178, 10, 14, 14, 'PNG', 'http://www.kokek.com', '', true, 1000, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 20);
		$this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {

        $this->SetY(-28);
        $this->SetFont('helvetica', '', 7);
        $this->setCellPaddings(1, 1, 1, 1);
        $this->setCellMargins(8, 1, 1, 1);

        $html = '
		<table width="100%" border="0">
		  <tr>
		  <td width="25%"><strong style="color: #FF6600; font-size:11px;">Head Office</strong><br/>
                Jl. Prapen Indah J-12 A<br/>
		        Surabaya 60299<br />
		        <b>Telp.</b>  031 - 8490807
		    </td>
		    <td width="36%"><strong style="color: #FF6600; font-size:11px;">Representative Office</strong><br/>
                Menara Cakrawala Lt 12, Unit 1205A<br />
		        Jl. M.H. Thamrin No.9 Jakarta Pusat 10340<br />
		        <b>Telp.</b> +021-50106260 Ext 1004-1008
		    </td>
		    <td width="25%" valign="top"><strong style="color: #FF6600; font-size:11px;">Contact</strong><br />
		    	<b>Website.</b> www.kokek.com<br />
		      	<b>E-Mail.</b> info@kokek.com<br />
		      	<b>WhatsApp.</b> 0895 2681 4555</td>
		  </tr>
		</table>
		';

        $this->writeHTML($html, true, false, true, false, '');
    }
}

