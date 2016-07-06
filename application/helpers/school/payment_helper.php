<?php
function paymentForm($now=null,$next_ref=null,$det=array()){
	$CI =& get_instance();
	$CI->html->sForm("payment/db","general-form");
	$CI->html->sBox('solid');
		$CI->html->sBoxBody();
			$CI->html->sDivRow(array('style'=>'margin-top:10px;'));
				$CI->html->sDivCol(4);
					$CI->html->studentsDropPaper("Student:","student",null);
				$CI->html->eDivCol();
				$CI->html->sDivCol(4);
					$CI->html->inputPaper('Reference:',"trans_ref",$next_ref,null,array());
				$CI->html->eDivCol();
				$CI->html->sDivCol(4);
					$date = sql2Date($now);
					$CI->html->inputPaper('Trans Date:',"trans_date",$date,null,array('class'=>'pick-date'));
				$CI->html->eDivCol();
			$CI->html->eDivRow();
			$CI->html->sTab(array('class'=>'paper-tab','style'=>'margin-top:5px;'));
				$tabs = array(fa('fa-money').' Cash'=>array('href'=>'#cash-pane'),
							  fa('fa-credit-card').' Credit Card'=>array('href'=>'#credit-pane'),
							  fa('fa-pencil-square').' Check'=>array('href'=>'#check-pane'),
							 );
				$CI->html->tabHead($tabs,null,array());
				$CI->html->sTabBody();
					$CI->html->sTabPane(array('id'=>'cash-pane','class'=>'tab-pane active'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(3);
								$CI->html->inputPaper('Amount:','cash_amt',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(3);
								$CI->html->button("ADD",array('ref'=>'cash','class'=>'amt-btns btn-flat btn-sm'),'primary');
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eTabPane();
					$CI->html->sTabPane(array('id'=>'credit-pane','class'=>'tab-pane'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(2);
								$CI->html->inputPaper('Amount:','credit_amt',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(3);
								$CI->html->inputPaper('Bank:','credit_bank',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(3);
								$CI->html->inputPaper('Card No.:','credit_card_no',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(3);
								$CI->html->inputPaper('Approval Code:','credit_approval',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(1);
								$CI->html->button("ADD",array('ref'=>'credit','class'=>'amt-btns btn-flat btn-sm'),'primary');
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eTabPane();
					$CI->html->sTabPane(array('id'=>'check-pane','class'=>'tab-pane'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(2);
								$CI->html->inputPaper('Amount:','check_amt',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(3);
								$CI->html->inputPaper('Bank:','check_bank',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(2);
								$CI->html->inputPaper('Branch:','check_branch',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(2);
								$CI->html->inputPaper('Check No.:','check_no',null,null,array('class'=>''));
							$CI->html->eDivCol();
							$CI->html->sDivCol(2);
								$CI->html->inputPaper('Check Date:','check_date',sql2Date($now),null,array('class'=>'pick-date'));
							$CI->html->eDivCol();
							$CI->html->sDivCol(1);
								$CI->html->button("ADD",array('ref'=>'check','class'=>'amt-btns btn-flat btn-sm'),'primary');
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eTabPane();
				$CI->html->eTabBody();
			$CI->html->eTab();		
			$CI->html->H(4,"",array('class'=>'page-header'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(6);
					$CI->html->sTable(array('class'=>'table paper-table','id'=>'payment-tbl'));
						$CI->html->sTablehead();
							$CI->html->sRow();
								$CI->html->th('#');
								$CI->html->th('Type');
								$CI->html->th('Amount');
								$CI->html->th('');
							$CI->html->eRow();
						$CI->html->eTablehead();
						$CI->html->sTableBody();
							$CI->html->sRow(array('id'=>'payments-none'));
								$CI->html->td('<center>Add Payment.</center>',array('colspan'=>'100%'));
							$CI->html->eRow();
						$CI->html->eTableBody();
					$CI->html->eTable();
				$CI->html->eDivCol();
				$CI->html->sDivCol(6);
					$CI->html->textPaper('Total Amount To Allocate:',num(0),array('id'=>'total-allocate-txt'));
					$CI->html->hidden('total-allocate',num(0));
					$CI->html->textPaper('Total Amount Left:',num(0),array('id'=>'left-allocate-txt'));
					$CI->html->hidden('left-allocate',num(0));
				$CI->html->eDivCol();
			$CI->html->eDivRow();	
			$CI->html->H(4,"",array('class'=>'page-header'));		
			$CI->html->sDivRow();
				$CI->html->sDivCol();
					$CI->html->sTable(array('class'=>'table paper-table','id'=>'sched-tbl'));
						$CI->html->sTablehead();
							$CI->html->sRow();
								$CI->html->th('Reference');
								$CI->html->th('Particular');
								$CI->html->th('Due Date');
								$CI->html->th('Due Amount');
								$CI->html->th('Amount Paid');
								$CI->html->th('Balance');
								$CI->html->th('Amount Tender');
								$CI->html->th('');
							$CI->html->eRow();
						$CI->html->eTablehead();
						$CI->html->sTableBody();
							$CI->html->sRow(array('class'=>'dues-rows'));
								$CI->html->td('<center>Select A Student.</center>',array('colspan'=>'100%'));
							$CI->html->eRow();
						$CI->html->eTableBody();
					$CI->html->eTable();
				$CI->html->eDivCol();
			$CI->html->eDivRow();
			$CI->html->sDivRow();
				$CI->html->sDivCol();
					$CI->html->textarea("","remarks",null,"Add Remarks Here...");			
				$CI->html->eDivCol();
				// $CI->html->sDivCol(6);
				// 	$CI->html->textPaper('Total Tendered:',num(0));
				// 	$CI->html->textPaper('Remaining Balance:',num(0));
				// $CI->html->eDivCol();
			$CI->html->eDivRow();

		$CI->html->eBoxBody();
	$CI->html->eBox();
	$CI->html->eForm();
	return $CI->html->code();
}
function billingPage($id,$title="",$tbl_name="",$form="",$default_view="grid",$view="all",$filter=false){
	$CI =& get_instance();
	$CI->html->sDiv(array('class'=>'list-page','id'=>$id));
		$CI->html->sDiv(array('class'=>'list-page-head'));
			$CI->html->sDivRow();
				$CI->html->sDivCol(6);
					$CI->html->H(3,$title,array('class'=>'list-page-title'));
				$CI->html->eDivCol();
				$CI->html->sDivCol(6);
				$CI->html->eDivCol();
			$CI->html->eDivRow();
			$CI->html->sDivRow();
				$CI->html->sDivCol(5);
					if($form != "")
						$CI->html->button(fa('fa-plus fa-fw').' CREATE',array('class'=>'btn-create btn-flat pull-left'),'success');
				$CI->html->eDivCol();
				$CI->html->sDivCol(3,'left');
					$CI->html->sDiv(array('class'=>'list-page-pagi pull-left'));
					$CI->html->eDiv();
				$CI->html->eDivCol();
				$CI->html->sDivCol(4,'right');
					$grid = "";
					$list = "";
					// $CI->html->button(fa('fa-filter'),array('class'=>'btn-flat pull-right'),'primary');
					$fil = "";
					if($filter)
						$fil = '<button type="button" class="btn-view-filter btn btn-info btn-flat" style="margin-right:5px;">'.fa('fa-filter').'</button>';
					$CI->html->append($fil);
					if($view == "all"){
						$g = "";
						if($default_view == 'grid')
							$g = "active";
						$grid = '<button type="button" class="btn-views btn-view-grid btn btn-default btn-flat '.$g.'">'.fa('fa-table').'</button>';
						
						$l = "";
						if($default_view == 'list')
							$l = "active";
						$list = '<button type="button" class="btn-views btn-view-list btn btn-default btn-flat '.$l.'">'.fa('fa-list').'</button>';
					}

					$CI->html->append('
						<div class="btn-group pull-right" data-toggle="btn-toggle" role="group" >'.$grid.$list.'</div>
					');
				$CI->html->eDivCol();
			$CI->html->eDivRow();
		$CI->html->eDiv();
		$CI->html->sDiv(array('class'=>'list-page-body'));
			$param = array('class'=>'list-load','form'=>$form,'table'=>$tbl_name,'view'=>$view,'dflt-view'=>$default_view);
			if($filter)
				$param['table_search'] = $tbl_name."_filter";
			$CI->html->sDiv($param);

			$CI->html->eDiv();		
		$CI->html->eDiv();
	$CI->html->eDiv();
	return $CI->html->code();
}


