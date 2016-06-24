<?php
function yearsPage($det=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('class'=>'paper'));
					$CI->html->sForm("academic/years_db","general-form");
						$CI->html->hidden('id',iSetObj($det,'id'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(6);
								$CI->html->H(4,"General Information",array('class'=>'form-titler'));
								$CI->html->inputPaper('Name:','name',iSetObj($det,'name'),null,array('class'=>'rOkay'));
								$CI->html->inputPaper('Start Date:','start_date',(iSetObjDate($det,'start_date')),null,array('class'=>'pick-date'),"fa-calendar");
								$CI->html->inputPaper('End Date:','end_date',(iSetObjDate($det,'end_date')),null,array('class'=>'pick-date'),"fa-calendar");
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eForm();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}
function coursesPage($det=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('class'=>'paper'));
					$CI->html->sForm("academic/courses_db","general-form");
						$CI->html->hidden('id',iSetObj($det,'id'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(6);
								$CI->html->H(4,"General Information",array('class'=>'form-titler'));
								$CI->html->inputPaper('Code:','code',iSetObj($det,'code'),null,array('class'=>'rOkay'));
								$CI->html->inputPaper('Name:','name',iSetObj($det,'name'),null,array('class'=>'rOkay'));
								$CI->html->inputPaper('Description:','description',iSetObj($det,'description'),null,array('class'=>'rOkay'));
							$CI->html->eDivCol();
						$CI->html->eDivRow();
						$CI->html->H(4,"",array('class'=>'page-header'));
						$CI->html->sDivRow();
							$CI->html->sDivCol();
								$CI->html->H(4,"Assign Subjects",array('class'=>'form-titler'));
									$CI->html->sDivRow();
										$CI->html->sDivCol(6);	
											$CI->html->subjectsDropPaper('Subject:','subject',null,null,array('class'=>'rOkay'));
										$CI->html->eDivCol();
										$CI->html->sDivCol(1);
											$CI->html->button(fa('fa-plus').' ADD',array('class'=>'btn-sm btn-flat'),'primary');	
										$CI->html->eDivCol();
									$CI->html->eDivRow();
									$CI->html->sDivRow();
										$CI->html->sDivCol(6);
											$CI->html->sTable(array('class'=>'table table-striped'));
												$CI->html->sTablehead();
													$CI->html->sRow();
														$CI->html->th('Code');
														$CI->html->th('Name');
														$CI->html->th(' ');
													$CI->html->eRow();
												$CI->html->eTablehead();
											$CI->html->eTable();
										$CI->html->eDivCol();
									$CI->html->eDivRow();
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eForm();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}
function batchesPage($det=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('class'=>'paper'));
					$CI->html->sForm("academic/batches_db","general-form");
						$CI->html->hidden('id',iSetObj($det,'id'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(6);
								$CI->html->H(4,"General Information",array('class'=>'form-titler'));
								$CI->html->inputPaper('Code:','code',iSetObj($det,'code'),null,array('class'=>'rOkay'));
								$CI->html->inputPaper('Name:','name',iSetObj($det,'name'),null,array('class'=>'rOkay'));
								$CI->html->courseDropPaper('Course:','course_id',iSetObj($det,'course_id'),null,array('class'=>'rOkay'));
								$CI->html->inputPaper('Start Date:','start_date',(iSetObjDate($det,'start_date')),null,array('class'=>'pick-date'),"fa-calendar");
								$CI->html->inputPaper('End Date:','end_date',(iSetObjDate($det,'end_date')),null,array('class'=>'pick-date'),"fa-calendar");
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eForm();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}
function subjectsPage($det=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('class'=>'paper'));
					$CI->html->sForm("academic/subjects_db","general-form");
						$CI->html->hidden('id',iSetObj($det,'id'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(6);
								$CI->html->H(4,"General Information",array('class'=>'form-titler'));
								$CI->html->inputPaper('Code:','code',iSetObj($det,'code'),null,array('class'=>'rOkay'));
								$CI->html->inputPaper('Name:','name',iSetObj($det,'name'),null,array('class'=>'rOkay'));
								$CI->html->inputPaper('Description:','description',iSetObj($det,'description'),null,array('class'=>'rOkay'));
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eForm();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}