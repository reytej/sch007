<?php
function enrollmentForm($det=array()){
	$CI =& get_instance();
		$CI->html->sBox('solid');
			$CI->html->sBoxBody();
				$CI->html->sDivRow();
					$CI->html->sDivCol(5);
						$CI->html->studentsDropPaper("Student:","student");
						$CI->html->courseDropPaper("Course:","course");
						$CI->html->courseDropPaper("Batch:","batch");
					$CI->html->eDivCol();
					$CI->html->sDivCol(5,'right',2);
						$url = base_url().'dist/img/no-photo.jpg';
						$CI->html->img($url,array('style'=>'height:100px;','class'=>'media-object thumbnail pull-right','id'=>'target'));
					$CI->html->eDivCol();
				$CI->html->eDivRow();
				$CI->html->sDivRow();
					$CI->html->sDivCol(5);
						$CI->html->sTable(array('class'=>'table paper-table'));
							$CI->html->sTableHead();
								$CI->html->sRow();
									$CI->html->th('Code');
									$CI->html->th('Subject');
									$CI->html->th(' ');
								$CI->html->eRow();
							$CI->html->eTableHead();
							$CI->html->sTableBody();
								
							$CI->html->eTableBody();
						$CI->html->eTable();
					$CI->html->eDivCol();
				$CI->html->eDivRow();
			$CI->html->eBoxBody();
		$CI->html->eBox();
	return $CI->html->code();
}
