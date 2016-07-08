<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(realpath(dirname(__FILE__) . '/..')."/core/print_headers.php");
class Prints extends Print_headers {
	public function __construct(){
		parent::__construct();
	}
	public function bills(){
		$title = "Billings";
		$fileName = "Billings";
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(5,5,5);
		$pdf->SetAutoPageBreak(true);
		$pdf->AddPage();
		$html = '';

		if(!isset($_GET['tagid'])){
			$html .= '<table>';
				$html .= '<tr><td style="text-align:center;">NO RESULTS FOUND</td></tr>';
			$html .= '</table>';
			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			$pdf->Output($fileName,'I');
			return false;
		}
		$comp = $this->get_company_details();
		$ids = explode(',',$_GET['tagid']);
		foreach ($ids as $i => $val) {
			if($val == "")
				unset($ids[$i]);
		}
		if(count($ids) == 0){
			$html .= '<table>';
				$html .= '<tr><td style="text-align:center;">NO RESULTS FOUND</td></tr>';
			$html .= '</table>';
			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			$pdf->Output($fileName,'I');
			return false;
		}

		$post = array();
		$args = array();
		$join = array();
		$order = array();
		$table = 'enroll_payments';
		$select[0] = 'enroll_payments.*,enrolls.trans_ref,
		              students.fname as std_fname,students.mname as std_mname,students.lname as std_lname,students.suffix as std_suffix,
		              courses.name as course_name,
	                  course_batches.name as batch_name,
	                  sections.name as section_name';
		$select[1] = false;
		$join['students'] = "enroll_payments.student_id = students.id";
		$join['enrolls'] = 'enroll_payments.enroll_id = enrolls.id';
		$join['courses'] = "enrolls.course_id = courses.id";
        $join['course_batches'] = "enrolls.batch_id = course_batches.id";
        $join['sections'] = "enrolls.section_id = sections.id";

		$group = null;
		$args["DATE(enroll_payments.due_date) <= DATE(NOW())"] = array('use'=>'where','val'=>"",'third'=>false);
		$args["enroll_payments.amount > enroll_payments.pay"] = array('use'=>'where','val'=>"",'third'=>false);
		$args['enroll_payments.id'] = $ids;
		$items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,$group);

		
		
		$col = 2;
		$colW = 562;
		// $colH = 200;
		// echo $this->site_model->db->last_query();
		// return false;
		if(count($items) > 0){
			$html .= '<table  cellpadding="5" style="font-size:10px;">';
			$ctr = 1;
			$curr = "";

			foreach ($items as $res) {
				if($curr != $res->student_id){
					if($ctr != 1){
									$html .= '<tr>';
										$html .= '<td></td>';
										$html .= '<td></td>';
										$html .= '<td></td>';
										$html .= '<td style="font-weight:bold;">Total Balance Due</td>';
										$html .= '<td style="font-weight:bold;">PHP '.num($subBalance).'</td>';
									$html .= '</tr>';
								$html .= '</table>';
							$html .= '</td>';
						$html .= '</tr>';
					}	
				$html .= '<tr>';
					$html .= '<td width="'.$colW.'" style="border: 1px solid #000;">';
						$html .= '<table cellspacing="1">';
							$html .= '<tr>';
								$html .= '<td width="40">';
									$html .= '<img src="'.$comp['comp_logo'].'" height="40" width="40">';
								$html .= '</td>';
								$html .= '<td>';
									$html .= $comp['comp_name'];
									$html .= '<br>';
									$html .= '<small>'.$comp['comp_address'].'</small>';
									$html .= '<br>';
									$html .= '<small>'.$comp['comp_contact_no'].'</small>';
								$html .= '</td>';
							$html .= '</tr>';
						$html .= '</table>';
						$name  = $res->std_fname." ".$res->std_mname." ".$res->std_lname." ".$res->std_suffix;
						$html .= '<table style="font-size:8px;">';
							$html .= '<tr>';
								$html .= '<td width="80">Student Name:</td>';
								$html .= '<td width="250">'.ucFix($name).'</td>';
								$html .= '<td width="80">Course:</td>';
								$html .= '<td width="250">'.ucFix($res->course_name).'</td>';
							$html .= '</tr>';
							$html .= '<tr>';
								$html .= '<td width="80">Batch:</td>';
								$html .= '<td width="250">'.ucFix($res->batch_name).'</td>';
								$html .= '<td width="80">Section:</td>';
								$html .= '<td width="250">'.ucFix($res->section_name).'</td>';
							$html .= '</tr>';
						$html .= '</table>';
						$html .= '<br>';
						$html .= '<br>';
						$html .= '<table style="font-size:8px;" cellpadding="3">';
							$html .= '<tr style="background-color:#f1f1f1;font-weight:bold;">';
								$html .= '<th>Particular</th>';
								$html .= '<th>Due Date</th>';
								$html .= '<th>Amount Due</th>';
								$html .= '<th>Amount Paid</th>';
								$html .= '<th>Balance</th>';
							$html .= '</tr>';
					$curr = $res->student_id;
					$subBalance = 0;			
				}			
							$html .= '<tr>';
								$particular = "Monthly Payment";
								if($res->type == 'dp')
									$particular = "Down Payment";
								$html .= '<td>'.$particular.'</td>';
								$html .= '<td>'.sql2Date($res->due_date).'</td>';
								$balance = $res->amount - $res->pay;
								$subBalance += $balance;
								$html .= '<td>PHP '.num($res->amount).'</td>';
								$html .= '<td>PHP '.num($res->pay).'</td>';
								$html .= '<td>PHP '.num($balance).'</td>';
							$html .= '</tr>';
							// $html .= '<tr>';
							// 	$html .= '<td></td>';
							// 	$html .= '<td></td>';
							// 	$html .= '<td></td>';
							// 	$html .= '<td style="font-weight:bold;">Total Balance Due</td>';
							// 	$html .= '<td style="font-weight:bold;">PHP '.num($balance).'</td>';
							// $html .= '</tr>';
				$ctr++;
			}	
					$html .= '<tr>';
						$html .= '<td></td>';
						$html .= '<td></td>';
						$html .= '<td></td>';
						$html .= '<td style="font-weight:bold;">Total Balance Due</td>';
						$html .= '<td style="font-weight:bold;">PHP '.num($subBalance).'</td>';
					$html .= '</tr>';
					$html .= '</table>';
				$html .= '</td>';
			$html .= '</tr>';

			$html .= '</table>';
		}
		else{
			$html .= '<table>';
				$html .= '<tr><td style="text-align:center;">NO RESULTS FOUND</td></tr>';
			$html .= '</table>';
		}
		// echo $html;
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$pdf->Output($fileName,'I');
	}
}
