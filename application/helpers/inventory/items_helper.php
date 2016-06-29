<?php
function itemsPage($det=array(),$img=array()){
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
								$CI->html->sForm("items/pic_upload","pic-form");
									$CI->html->file('fileUpload',array('style'=>'display:none;'));
									$CI->html->hidden('id',iSetObj($det,'id'));
								$CI->html->eForm();
							$CI->html->eDiv();
						}
					$CI->html->eDiv();

					if(iSetObj($det,"id")){
						$name = iSetObj($det,"name");
						$CI->html->H(5,"[".iSetObj($det,"code")."] ".ucwords(strtolower($name)),array('style'=>'text-align:center;'));
						$CI->html->H(6,"Reg Date: ".iSetObjDate($det,"reg_date"),array('style'=>'text-align:center;'));						
					}
					
				$CI->html->eBoxBody();
			$CI->html->eBox();
			$CI->html->sDiv(array('class'=>'btn-group-vertical btn-profile-vertical','style'=>'width:100%;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);'));
				$CI->html->button(fa('fa-info-circle').' General Details',array('class'=>'load-btns btn-block btn-flat btn-white','load'=>'items/general'));
			$CI->html->eDiv();
		$CI->html->eDivCol();
		$CI->html->sDivCol(10);
			
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('id'=>'load-div','item'=>iSetObj($det,"id")));
				$CI->html->eBoxBody();
			$CI->html->eBox();

		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}
function itemGeneralDetails($det=array()){
	$CI =& get_instance();
		$CI->html->sForm("items/general_db","general-form");
			$CI->html->hidden('id',iSetObj($det,'id'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(1);
					$CI->html->sDivRow(array('class'=>'div-under-no-spaces','style'=>'margin-top:20px;'));
						$CI->html->sDivCol();
							$params = array('class'=>'rOkay input-lg');
							if(iSetObj($det,'id')){
								$params['readOnly'] = 'readOnly';
							}
							$CI->html->inputPaper(null,'code',iSetObj($det,'code'),'Student Code',$params);
						$CI->html->eDivCol();
					$CI->html->eDivRow();
				$CI->html->eDivCol();
				$CI->html->sDivCol(11);
					$CI->html->sDivRow(array('class'=>'div-under-no-spaces','style'=>'margin-top:20px;'));
						$CI->html->sDivCol(4);
							$CI->html->inputPaper(null,'name',iSetObj($det,'name'),'Item Name',array('class'=>'rOkay input-lg'));
						$CI->html->eDivCol();
					$CI->html->eDivRow();
				$CI->html->eDivCol();
			$CI->html->eDivRow();

			$CI->html->H(4,"",array('class'=>'page-header'));
			$CI->html->H(4,"General Details",array('class'=>'form-titler'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(5);
					$CI->html->textareaPaper('Description:','description',iSetObj($det,'description'),null,array('class'=>'rOkay'));
				$CI->html->eDivCol();
				$CI->html->sDivCol(5,'left',2);
					$CI->html->itemCategoriesDropPaper('Category:','cat_id',iSetObj($det,'cat_id'),null,array('class'=>'rOkay'));
					$CI->html->itemTypeDropPaper('Item Type:','type',iSetObj($det,'type'),null,array('class'=>'rOkay'));
					$CI->html->uomDropPaper('UOM:','uom',iSetObj($det,'uom'),null,array('class'=>'rOkay'));
				$CI->html->eDivCol();
			$CI->html->eDivRow();
			$CI->html->H(4,"Pricing Details",array('class'=>'form-titler'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(5);
					$CI->html->inputPaper('Price:','price',iSetObj($det,'price'),null,array('class'=>'rOkay'),'fa-money');
					$CI->html->itemTaxTypeDropPaper('Tax Type:','tax_type_id',iSetObj($det,'tax_type_id'),null,array('class'=>'rOkay'));
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
function itemCategoriesPage($det=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('class'=>'paper'));
					$CI->html->sForm("items/item_categories_db","general-form");
						$CI->html->hidden('id',iSetObj($det,'id'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(6);
								$CI->html->H(4,"General Information",array('class'=>'form-titler'));
								$CI->html->inputPaper('Name:','name',iSetObj($det,'name'),null,array('class'=>'rOkay'));
								$CI->html->uomDropPaper('UOM:','uom',iSetObj($det,'uom'),null,array('class'=>'rOkay'));
								$CI->html->itemTypeDropPaper('Item Type:','type',iSetObj($det,'type'),null,array('class'=>'rOkay'));
								$CI->html->itemTaxTypeDropPaper('Tax Type:','tax_type_id',iSetObj($det,'tax_type_id'),null,array('class'=>'rOkay'));
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eForm();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}
