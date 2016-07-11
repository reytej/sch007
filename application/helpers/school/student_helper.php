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
					$CI->html->sDiv(array('style'=>'position:relative;width:100%;background-color:#ddd;'));
						$CI->html->img($url,array('style'=>'width:100%;max-height:300px;','id'=>'profile-pic'));
						
						if(iSetObj($det,"id")){
							$CI->html->sDiv(array('style'=>'position:absolute;bottom:0;left:0;width:100%;height:25px;text-align:right;padding-right:5px;color:#fff'));
								$CI->html->A(fa('fa-camera fa-lg'),'#',array('style'=>'color:#fff;','id'=>'target'));
								$CI->html->sForm("students/pic_upload","pic-form");
									$CI->html->file('fileUpload',array('style'=>'display:none;'));
									$CI->html->hidden('id',iSetObj($det,'id'));
								$CI->html->eForm();
							$CI->html->eDiv();
						}
					$CI->html->eDiv();

					if(iSetObj($det,"id")){
						$student = iSetObj($det,"fname")." ".iSetObj($det,"mname")." ".iSetObj($det,"lname")." ".iSetObj($det,"suffix");
						$CI->html->H(5,"[".iSetObj($det,"code")."] ".ucwords(strtolower($student)),array('style'=>'text-align:center;'));
						$CI->html->H(6,"Reg Date: ".iSetObjDate($det,"reg_date"),array('style'=>'text-align:center;'));						
					}
					
				$CI->html->eBoxBody();
			$CI->html->eBox();
			$CI->html->sDiv(array('class'=>'btn-group-vertical btn-profile-vertical','style'=>'width:100%;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);'));
				
				$CI->html->button(fa('fa-info-circle').' General Details',array('class'=>'load-btns btn-block btn-flat btn-white','load'=>'students/profile_general'));
				if(iSetObj($det,"id")){
					$CI->html->button(fa('fa-university').' Academic Details',array('class'=>'load-btns btn-block btn-flat btn-white','load'=>'students/profile_academic'));
					$CI->html->button(fa('fa-money').' Payment Balance',array('class'=>'load-btns btn-block btn-flat btn-white','load'=>'students/profile_balance'));
				}

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
function generalDetails($next_ref="",$det=array()){
	$CI =& get_instance();
	
		$CI->html->sForm("students/profile_general_db","general-form");
			$CI->html->hidden('id',iSetObj($det,'id'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(1);
					$CI->html->sDivRow(array('class'=>'div-under-no-spaces','style'=>'margin-top:20px;'));
						$CI->html->sDivCol();
							$params = array('class'=>'rOkay input-lg');
							if(iSetObj($det,'id')){
								$params['readOnly'] = 'readOnly';
							}
							$CI->html->inputPaper(null,'Code',iSetObj($det,'code',$next_ref),'Student Code',$params);
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
					$CI->html->button(fa('fa-save').' Save Details',array('class'=>'btn-flat','id'=>'save-btn'),'success');
				$CI->html->eDivCol();
			$CI->html->eDivRow();
		$CI->html->eForm();
	return $CI->html->code();
}
function balanceDetails($result=array()){
	$CI =& get_instance();
		$CI->html->sTable(array('class'=>'table paper-table','id'=>'balance-tbl'));
			$CI->html->sTablehead();
				$CI->html->sRow();
					$CI->html->th('Reference');
					$CI->html->th('Particular');
					$CI->html->th('Due Date');
					$CI->html->th('Amount Due');
					$CI->html->th('Amount Paid');
					$CI->html->th('Paid Date');
					$CI->html->th('Balance');
				$CI->html->eRow();
			$CI->html->eTablehead();
			$CI->html->sTableBody();
				$total_balance = 0;
				$total_paid = 0;
				$total_due = 0;
				foreach ($result as $res) {
					$CI->html->sRow();
						$CI->html->td($res->trans_ref);
						$particular = "Monthly Payment";
						if($res->type == 'dp')
							$particular = "Down Payment";
						$CI->html->td($particular);
						$CI->html->td(sql2Date($res->due_date));
						$CI->html->td(num($res->amount));
						$total_due += $res->amount;
						$total_paid += $res->pay;
						$balance = $res->amount - $res->pay;
						$total_balance += $balance;
						$CI->html->td(num($res->pay));
						$CI->html->td(iSetObjDate($res,'pay_date'));
						$CI->html->td(num($balance));
					$CI->html->eRow();
				}
				$CI->html->sRow();
					$CI->html->td("",array('colspan'=>'5'));
					$CI->html->td('Total Amount Due',array('style'=>'font-weight:bold;text-align:left'));
					$CI->html->td(num($total_due),array('style'=>'font-weight:bold;text-align:left'));
				$CI->html->eRow();
				$CI->html->sRow();
					$CI->html->td("",array('colspan'=>'5'));
					$CI->html->td('Total Amount Paid',array('style'=>'font-weight:bold;text-align:left'));
					$CI->html->td(num($total_paid),array('style'=>'font-weight:bold;text-align:left'));
				$CI->html->eRow();
				$CI->html->sRow();
					$CI->html->td("",array('colspan'=>'5'));
					$CI->html->td('Remaining Balance',array('style'=>'font-weight:bold;text-align:left'));
					$CI->html->td(num($total_balance),array('style'=>'font-weight:bold;text-align:left'));
				$CI->html->eRow();
			$CI->html->eTableBody();
		$CI->html->eTable();
	return $CI->html->code();
}
function academicDetails($res=array(),$now=null,$subjects=array()){
	$CI =& get_instance();
		if(strtotime($now) > strtotime($res->end_date)){
			$CI->html->H(4,"Not Yet Enrolled",array('style'=>'text-align:center;'));
		    return $CI->html->code();
		}
		$name = $res->fname." ".$res->mname." ".$res->lname." ".$res->suffix;
		$adviser = ucFix($res->tc_fname." ".$res->tc_mname." ".$res->tc_lname." ".$res->tc_suffix);
		$course = ucFix($res->course_name);
		$batch = ucFix($res->batch_name);
		$section = ucFix($res->section_name);                
		$CI->html->H(3,$course.' <small style="font-style:italic;">('.sql2Date($res->start_date).' - '.sql2Date($res->end_date).')</small>');
		$CI->html->H(4,$batch);
		$CI->html->H(4,$section." - ".$adviser);
		$CI->html->H(4,"",array('class'=>'page-header'));
		// $CI->html->H(6,"Class Schedule",array('class'=>'form-titler','style'=>'font-size:16px;'));
		$CI->html->sTable(array('class'=>'table paper-table','id'=>'schedule-tbl'));
			$days = array('mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday','sun'=>'Sunday');
			$CI->html->sTablehead();
				$CI->html->sRow();
					$CI->html->th('Subject');
					foreach ($days as $day) {
						$CI->html->th($day);
					}
				$CI->html->eRow();
			$CI->html->eTablehead();
			$CI->html->sTableBody();
				foreach ($subjects as $subj_id => $sub) {
					$CI->html->sRow();
						foreach ($sub as $code => $val) {
							$CI->html->td($val);
						}
					$CI->html->eRow();					
				}
			$CI->html->eTableBody();
		$CI->html->eTable();	
	return $CI->html->code();
}

