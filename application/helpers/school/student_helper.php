<?php
function studentsProfile($det=array(),$img=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(2);
			$CI->html->sBox('solid',array('style'=>'margin-bottom:5px;'));
				$CI->html->sBoxBody();
					$url = base_url().'dist/img/no-photo.jpg';
					if(iSetObj($img,'img_path') != ""){					
						$url = base_url().$img->img_path;
					}
					$CI->html->img($url,array('style'=>'width:100%;max-height:300px;'));
					$student = iSetObj($det,"fname")." ".iSetObj($det,"mname")." ".iSetObj($det,"lname")." ".iSetObj($det,"suffix");
					$CI->html->H(4,"[".iSetObj($det,"code")."] ".ucwords(strtolower($student)),array('style'=>'text-align:center;'));
					$CI->html->H(5,"Reg Date: ".iSetObjDate($det,"reg_date"),array('style'=>'text-align:center;'));
				$CI->html->eBoxBody();
			$CI->html->eBox();
			$CI->html->sDiv(array('class'=>'btn-group-vertical btn-profile-vertical','style'=>'width:100%;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);'));
				$CI->html->button(fa('fa-info-circle').' General Details',array('class'=>'load-btns btn-block btn-flat btn-white','load'=>'students/profile_general'));
				$CI->html->button(fa('fa-users').' Guardian Details',array('class'=>'load-btns btn-block btn-flat btn-white','load'=>'students/profile_guardian'));
			$CI->html->eDiv();
		$CI->html->eDivCol();
		$CI->html->sDivCol(10);
			
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('id'=>'load-div','student'=>iSetObj($det,"id")));
				$CI->html->eBoxBody();
			$CI->html->eBox();

		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}
function generalDetails($det=array()){
	$CI =& get_instance();
	
		$CI->html->sForm("users/db","users-form");
			$CI->html->hidden('id',iSetObj($det,'id'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(1);
					$CI->html->sDivRow(array('class'=>'div-under-no-spaces','style'=>'margin-top:20px;'));
						$CI->html->sDivCol();
							$CI->html->inputPaper(null,'Code',iSetObj($det,'code'),'Student Code',array('class'=>'rOkay input-lg'));
						$CI->html->eDivCol();
					$CI->html->eDivRow();
				$CI->html->eDivCol();
				$CI->html->sDivCol(8);
					$CI->html->sDivRow(array('class'=>'div-under-no-spaces','style'=>'margin-top:20px;'));
						$CI->html->sDivCol(3);
							$CI->html->inputPaper(null,'fname',iSetObj($det,'fname'),'First Name',array('class'=>'rOkay input-lg'));
						$CI->html->eDivCol();
						$CI->html->sDivCol(3);
							$CI->html->inputPaper(null,'mname',iSetObj($det,'mname'),'Middle Name',array('class'=>'input-lg'));
						$CI->html->eDivCol();
						$CI->html->sDivCol(3);
							$CI->html->inputPaper(null,'lname',iSetObj($det,'lname'),'Last Name',array('class'=>'rOkay input-lg'));
						$CI->html->eDivCol();
						$CI->html->sDivCol(1);
							$CI->html->inputPaper(null,'suffix',iSetObj($det,'suffix'),'Suffix',array('class'=>'input-lg'));
						$CI->html->eDivCol();
					$CI->html->eDivRow();
				$CI->html->eDivCol();
			$CI->html->eDivRow();
			$CI->html->H(4,"",array('class'=>'page-header'));
			$CI->html->H(4,"General Information",array('class'=>'form-titler'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(5);
					$CI->html->inputPaper('Birth Date:','bday',iSetObjDate($det,'bday'),null,array('class'=>'pick-date'),'fa-calendar');
					$CI->html->inputPaper('Blood Type:','blood_type',iSetObj($det,'blood_type'),null,array('class'=>''));
					$CI->html->genderDropPaper('Gender:','sex',iSetObj($det,'sex'),null,array('class'=>''));
				$CI->html->eDivCol();
				$CI->html->sDivCol(5,'left',2);
					$CI->html->inputPaper('Nationality:','nationality',iSetObj($det,'nationality'),null,array('class'=>''));
					$CI->html->inputPaper('Language:','language',iSetObj($det,'language'),null,array('class'=>''));
					$CI->html->inputPaper('Religion:','religion',iSetObj($det,'religion'),null,array('class'=>''));
				$CI->html->eDivCol();
			$CI->html->eDivRow();
			$CI->html->H(4,"Contact Information",array('class'=>'form-titler'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(5);
					$CI->html->textareaPaper('Present Address:','pres_address',iSetObj($det,'pres_address'),null,array('class'=>''));
					$CI->html->inputPaper('Phone Number:','phone',iSetObj($det,'phone'),null,array('class'=>''),'fa-phone');
					$CI->html->inputPaper('Mobile Number:','mobile',iSetObj($det,'mobile'),null,array('class'=>''),'fa-phone');
				$CI->html->eDivCol();
				$CI->html->sDivCol(5,'left',2);
					$CI->html->textareaPaper('Permanent Address:','perm_address',iSetObj($det,'perm_address'),null,array('class'=>''));
					$CI->html->inputPaper('Email Address:','email',iSetObj($det,'email'),null,array('class'=>''),'fa-envelope');
				$CI->html->eDivCol();
			$CI->html->eDivRow();
			$CI->html->sDivRow(array('style'=>'margin-bottom:20px;margin-top:20px;'));
				$CI->html->sDivCol(12,'center');
					$CI->html->button(fa('fa-save').' Save Details',array('class'=>'btn-flat'),'success');
				$CI->html->eDivCol();
			$CI->html->eDivRow();
		$CI->html->eForm();

	return $CI->html->code();
}

