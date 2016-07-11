<?php
function attendanceForm($now=null){
	$CI =& get_instance();
	$CI->html->sBox('solid',array('style'=>'margin:0px;'));
		$CI->html->sBoxBody();
		$months = getDatesOfMonths();
			$CI->html->sDiv(array('class'=>'fixed-tbl-div'));
			$CI->html->sTable(array('class'=>'table fixed-tbl paper-table','id'=>'attendance-tbl'));
				$CI->html->sTablehead();
					$CI->html->sRow();
						$CI->html->th('',array('class'=>'headcol'));
						foreach ($months as $val) {
							$CI->html->th(date('l',strtotime($val)),array('style'=>'width:150px;text-align:center;font-weight:bold;background-color:#72AFD2;color:#fff'));
						}
					$CI->html->eRow();
					$CI->html->sRow();
						$CI->html->th('Student',array('class'=>'headcol','style'=>'background-color:#72AFD2;color:#fff'));
						foreach ($months as $val) {
							$CI->html->th(sql2Date($val),array('style'=>'width:150px;text-align:center;border-top:2px solid #f4f4f4;font-weight:normal;background-color:#f1f1f1;'));
						}
					$CI->html->eRow();
				$CI->html->eTablehead();
			$CI->html->eTable();
			$CI->html->eDiv();
		$CI->html->eBoxBody();
	$CI->html->eBox();
	return $CI->html->code();
}

