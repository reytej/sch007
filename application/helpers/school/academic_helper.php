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