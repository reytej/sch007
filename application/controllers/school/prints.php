<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(realpath(dirname(__FILE__) . '/..')."/core/print_headers.php");
class Prints extends Print_headers {
	public function __construct(){
		parent::__construct();
	}
	public function bills(){
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Test');

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(5,5,5);
		$pdf->SetAutoPageBreak(true);

		$comp = $this->get_company_details();

		$pdf->AddPage();

		$html = '';
		$col = 3;
		$colW = 188;
		$colH = 200;
		$ctr = 0;
		$html .= '<table  cellpadding="5" style="font-size:8px;">';
			$html .= "<tr>";
				$html .= '<td height="'.$colH.'" width="'.$colW.'" style="border: 1px solid #000;">';
						$html .= '<table cellspacing="1">';
							$html .= '<tr>';
								$html .= '<td width="30">';
									$html .= '<img src="'.$comp['comp_logo'].'" height="30" width="30">';
								$html .= '</td>';
								$html .= '<td>';
									$html .= $comp['comp_name'];
								$html .= '</td>';
							$html .= '</tr>';
						$html .= '</table>';
				$html .= '</td>';
				
				$html .= '<td height="'.$colH.'" width="'.$colW.'" style="border: 1px solid #000;">';
				$html .= '</td>';
				
				$html .= '<td height="'.$colH.'" width="'.$colW.'" style="border: 1px solid #000;">';
				
				$html .= '</td>';
			$html .= "</tr>";	
		$html .= '</table>';

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$pdf->Output('My-File-Name.pdf', 'I');
	}
}
