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
									$html .= '<br>';
									$html .= '<small>'.$comp['comp_address'].'</small>';
									
								$html .= '</td>';
							$html .= '</tr>';
						$html .= '</table>';
						$html .= '<table style="font-size:6px;">';
							$html .= '<tr>';
								$html .= '<td width="60">Student Name:</td>';
								$html .= '<td width="150">Reynaldo Tejada</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td width="60">Course:</td>';
								$html .= '<td width="150">Kindergarten</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td width="60">Batch:</td>';
								$html .= '<td width="150">Kindergarten 2016 - 2017</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td width="60">Section:</td>';
								$html .= '<td width="150">Hope</td>';
							$html .= '</tr>';
						$html .= '</table>';
						$html .= '<br>';
						$html .= '<br>';
						$html .= '<table style="font-size:6px;">';
							$html .= '<tr>';
								$html .= '<th>Particular</th>';
								$html .= '<th>Due Date</th>';
								$html .= '<th>Amount Due</th>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>Monthly Payment</td>';
								$html .= '<td>06/07/2016</td>';
								$html .= '<td>PHP 20,000</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td>Monthly Payment</td>';
								$html .= '<td>07/07/2016</td>';
								$html .= '<td>PHP 20,000</td>';
							$html .= '</tr>';
						$html .= '</table>';
				$html .= '</td>';
			$html .= "</tr>";	
		$html .= '</table>';

		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$pdf->Output('My-File-Name.pdf', 'I');
	}
}
