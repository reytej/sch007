<?php
function attendanceForm($now=null,$teacher,$batch_id,$sect_id,$subj_id){
	$CI =& get_instance();
	$CI->html->sBox('solid',array('style'=>'margin:0px;'));
		$CI->html->sBoxBody();
			$CI->html->sForm("","search-form");
				$CI->html->hidden('teacher',$teacher);
				$CI->html->hidden('batch_id',$batch_id);
				$CI->html->hidden('sect_id',$sect_id);
				$CI->html->hidden('subj_id',$subj_id);
				$CI->html->sDivRow(array('style'=>'margin-top:10px;padding-left:200px;'));
					$CI->html->sDivCol(3);
						$dates = rangeWeek($now);
						$CI->html->inputPaper('From Date:','from_date',date('m/01/Y',strtotime($now)),null,array('class'=>'pick-date rOkay','ro-msg'=>'From date must not be empty'));
					$CI->html->eDivCol();
					$CI->html->sDivCol(3);
						$CI->html->inputPaper('To Date:','to_date',date('m/t/Y',strtotime($now)),null,array('class'=>'pick-date rOkay','ro-msg'=>'From date must not be empty'));
					$CI->html->eDivCol();
					$CI->html->sDivCol(3);
						$CI->html->button(fa('fa-search')." Search",array('id'=>'search-btn','class'=>'btn-sm btn-flat'),'primary');
					$CI->html->eDivCol();
				$CI->html->eDivRow();
			$CI->html->eForm();
			$months = getDatesOfMonths();
			$CI->html->sDiv(array('class'=>'fixed-tbl-div','style'=>'margin-top:20px;margin-bottom:10px;'));
				$CI->html->sTable(array('class'=>'table fixed-tbl paper-table','id'=>'attendance-tbl'));
					$CI->html->sTablehead();
					$CI->html->eTablehead();
					$CI->html->sTableBody();
					$CI->html->eTableBody();
				$CI->html->eTable();
			$CI->html->eDiv();
		$CI->html->eBoxBody();
	$CI->html->eBox();
	return $CI->html->code();
}
function activitiesForm($now=null,$teacher,$batch_id,$sect_id,$subj_id){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody();
					$CI->html->sDivRow();
						$CI->html->sDivCol(4);
							$CI->html->inputPaper('Title:','title',null,null,array('class'=>'rOkay'));
						$CI->html->eDivCol();
					$CI->html->eDivRow();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}



