<?php
function rolesForm($det=array(),$navs=array()){
	$CI =& get_instance();
		$CI->html->sForm("admin/roles_db","roles-form");
		$CI->html->hidden('id',iSetObj($det,'id'));
		$CI->html->sBox('solid');
			$CI->html->sBoxBody(array('class'=>'paper'));
				$CI->html->sDivRow();
					$CI->html->sDivCol(3);
						$CI->html->input('Role name','role_name',iSetObj($det,'role'),null,array('class'=>'rOkay'));
					$CI->html->eDivCol();
					$CI->html->sDivCol(7);
						$CI->html->input('Description','description',iSetObj($det,'description'),null,array('class'=>'rOkay'));
					$CI->html->eDivCol();
					$CI->html->sDivCol(2,'left',0,array('style'=>'padding-top:23px;'));
						$CI->html->button(fa('fa-save')." SAVE ",array('id'=>'save-btn','class'=>'btn-flat','style'=>'margin-right:10px;'),'success');
						$CI->html->A(fa('fa-reply'),base_url()."admin/roles",array('class'=>'btn btn-primary btn-flat'));
					$CI->html->eDivCol();
				$CI->html->eDivRow();
			$CI->html->eBoxBody();
		$CI->html->eBox();
		$CI->html->sBox('solid');
			$CI->html->sBoxBody(array('class'=>'paper'));
				$access = explode(',',iSetObj($det,'access'));
				foreach ($navs as $code => $row) {
					if($row['exclude'] == 0){
						$CI->html->sDivRow();
							$CI->html->sDivCol();
								$check = false;
		                    	if(in_array($code, $access))
			                    	$check = true;
			                    $checkbox = $CI->html->checkbox($row['title'],'roles[]',$code,array('return'=>true,'id'=>$code,'class'=>'check'),$check);
								$CI->html->H(4,$checkbox);
								if(is_array($row['path'])){	
									$CI->html->append(underRoles($row['path'],$access,$code));
								}	
							$CI->html->eDivCol();
						$CI->html->eDivRow();
								
					}
				}
			$CI->html->eBoxBody();
		$CI->html->eBox();
		$CI->html->eForm();
	return $CI->html->code();
}
function underRoles($nav=array(),$access=array(),$main=null){
	$CI =& get_instance();	
	foreach ($nav as $code => $nv) {
		$CI->html->sDivRow(array('style'=>'margin-left:10px;'));
			$CI->html->sDivCol();
				$check = false;
            	if(in_array($code, $access))
                	$check = true;
				$CI->html->checkbox($nv['title'],'roles[]',$code,array('class'=>$main." check",'parent'=>$main,'id'=>$code),$check);
				if(is_array($nv['path'])){
					$CI->html->append(underRoles($nv['path'],$access,$main." ".$code." "));
				}
			$CI->html->eDivCol();
		$CI->html->eDivRow();	
	}
	return $CI->html->code();
}
?>