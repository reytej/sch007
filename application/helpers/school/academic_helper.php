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
function coursesPage($det=array(),$subjects=array(),$items=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('class'=>'paper'));
					$CI->html->sForm("academic/courses_db","general-form");
						$CI->html->hidden('id',iSetObj($det,'id'));
						$CI->html->sDivRow(array('style'=>'margin-top:10px;'));
							$CI->html->sDivCol(2);
								$CI->html->inputPaper('','code',iSetObj($det,'code',next_code('courses')),'Code',array('class'=>'rOkay'));
							$CI->html->eDivCol();
							$CI->html->sDivCol(6);
								$CI->html->inputPaper('','name',iSetObj($det,'name'),'Course Name',array('class'=>'rOkay'));
							$CI->html->eDivCol();
						$CI->html->eDivRow();
						$CI->html->sDivRow();
							$CI->html->sDivCol(8);
								$CI->html->inputPaper('','description',iSetObj($det,'description'),'Description',array('class'=>'rOkay'));
							$CI->html->eDivCol();
						$CI->html->eDivRow();
						$CI->html->sTab(array('class'=>'paper-tab','style'=>'margin-top:20px;'));
							$tabs = array(fa('fa-book').' Subjects'=>array('href'=>'#subjects-pane'),
										  fa('fa-cubes').' Items'=>array('href'=>'#items-pane'),
										 );
							$CI->html->tabHead($tabs,null,array());
							$CI->html->sTabBody();
								$CI->html->sTabPane(array('id'=>'subjects-pane','class'=>'tab-pane active'));
									// $CI->html->H(4,"",array('class'=>'page-header'));
									// $CI->html->H(4,"Subjects",array('class'=>'form-titler'));
									$CI->html->sDivRow();
										$CI->html->sDivCol(8);
												$CI->html->sDivRow();
													$CI->html->sDivCol(10);	
														$pop = array(
															"href"  => "academic/subjects_form?viewpop=1",
															"params"=> array(
																"title" => "Create New Subject",
																"id"    => "create-subj-pop"
															),
														);
														$CI->html->subjectsDropPaper('Subject:','subject',null,null,array('class'=>'rOkay','pop-form'=>$pop));
													$CI->html->eDivCol();
													$CI->html->sDivCol(2,'right');
														$CI->html->button(fa('fa-plus').' ADD',array('id'=>'add-subj-btn','class'=>'btn-sm btn-flat'),'primary');	
													$CI->html->eDivCol();
												$CI->html->eDivRow();
												$CI->html->sDivRow();
													$CI->html->sDivCol(12);
														$CI->html->sTable(array('class'=>'table paper-table','id'=>'main-tbl'));
															$CI->html->sTablehead();
																$CI->html->sRow();
																	$CI->html->th('Code');
																	$CI->html->th('Name');
																	$CI->html->th(' ');
																$CI->html->eRow();
															$CI->html->eTablehead();
															$CI->html->sTableBody();
																foreach ($subjects as $ctr => $row) {
																	$CI->html->sRow(array('id'=>'row-'.$ctr));
																		$link = $CI->html->A(fa('fa-remove fa-lg'),'#',array('class'=>'remove','id'=>'remove-'.$ctr,'ref'=>$ctr,'return'=>'true'));
																		$CI->html->td($row['subj_code']);
																		$CI->html->td($row['subj_name']);
																		$CI->html->td($link,array('style'=>'text-align:right;margin:0px;'));
																	$CI->html->eRow();
																}
															$CI->html->eTableBody();
														$CI->html->eTable();
													$CI->html->eDivCol();
												$CI->html->eDivRow();
										$CI->html->eDivCol();
									$CI->html->eDivRow();
								$CI->html->eTabPane();
								$CI->html->sTabPane(array('id'=>'items-pane','class'=>'tab-pane'));
									// $CI->html->H(4,"",array('class'=>'page-header'));
									// $CI->html->H(4,"Items",array('class'=>'form-titler'));
									$CI->html->sDivRow();
										$CI->html->sDivCol(12);
											$CI->html->sTable(array('class'=>'table paper-table','id'=>'items-tbl'));
												$CI->html->sTablehead();
													$CI->html->sRow();
														$CI->html->th('Item');
														$CI->html->th('Qty');
														$CI->html->th('UOM');
														$CI->html->th('Price');
														$CI->html->th('Subtotal');
														$CI->html->th(' ');
													$CI->html->eRow();
												$CI->html->eTablehead();
												$CI->html->sTableBody();
													$grandTotal = 0;
													foreach ($items as $id => $row) {
														$CI->html->sRow(array('id'=>'rtbl-row-'.$id));
															$CI->html->td($row['item_name']);
															$CI->html->td($row['qty']);
															$CI->html->td($row['uom']);
															$CI->html->td(num($row['price']));
															$lineTotal = $row['qty'] * $row['price'];
															$CI->html->td(num($lineTotal));
															$del = $CI->html->A(fa('fa-trash fa-lg'),'#',array('class'=>'del','ref'=>$id,'id'=>'del-'.$id,'return'=>true));
															$CI->html->td($del,array("style"=>'text-align:right'));
														$CI->html->eRow();	
														$grandTotal += $lineTotal;										
													}
													$CI->html->sRow(array('class'=>'form-row'));
														$CI->html->sTd(array('style'=>'width:300px;'));
															$CI->html->itemsDrop("","item_id",null,null,array('class'=>'rtbl-txt paper-select show-tick','data-live-search'=>'true'));
														$CI->html->eTd();
														$CI->html->sTd(array('style'=>'width:80px;'));
															$CI->html->input("","qty",null,null,array('class'=>'rtbl-txt paper-input'));
														$CI->html->eTd();
														$CI->html->sTd();
															$CI->html->span("",array('id'=>'uom-txt','class'=>'rtbl-txt'));
															$CI->html->hidden("uom");
														$CI->html->eTd();
														$CI->html->sTd();
															$CI->html->span(num(0),array('id'=>'price-txt','class'=>'rtbl-txt'));
															$CI->html->hidden("price");
														$CI->html->eTd();
														$CI->html->sTd();
															$CI->html->span(num(0),array('id'=>'total-txt','class'=>'rtbl-txt'));
														$CI->html->eTd();
														$CI->html->td("",array('style'=>'text-align:right'));
													$CI->html->eRow();
													$CI->html->sRow();
														$CI->html->td("");
														$CI->html->td("");
														$CI->html->td("");
														$CI->html->td("<b>Grand Total</b>");
														$CI->html->td(num($grandTotal),array('id'=>'grand-total-txt'));
														$CI->html->td("");
													$CI->html->eRow();
												$CI->html->eTableBody();
											$CI->html->eTable();
										$CI->html->eDivCol();
									$CI->html->eDivRow();
								$CI->html->eTabPane();
							$CI->html->eTabBody();
						$CI->html->eTab();						
					$CI->html->eForm();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}
function batchesPage($det=array(),$sections=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('class'=>'paper'));
					$CI->html->sForm("academic/batches_db","general-form");
						$CI->html->hidden('id',iSetObj($det,'id'));
						$CI->html->sDivRow(array('style'=>'margin-top:10px;'));
							$CI->html->sDivCol(2);
								$CI->html->inputPaper('','code',iSetObj($det,'code',next_code('course_batches')),'Batch Code',array('class'=>'rOkay'));
							$CI->html->eDivCol();
							$CI->html->sDivCol(6);
								$CI->html->inputPaper('','name',iSetObj($det,'name'),'Batch Name',array('class'=>'rOkay'));
							$CI->html->eDivCol();
						$CI->html->eDivRow();
						$CI->html->sTab(array('class'=>'paper-tab','style'=>'margin-top:20px;'));
							$tabs = array(fa('fa-info-circle').' General Details'=>array('href'=>'#general-pane'),
										  fa('fa-flag').' Sections'=>array('href'=>'#sections-pane'),
										 );
							$CI->html->tabHead($tabs,null,array());
							$CI->html->sTabBody();
								$CI->html->sTabPane(array('id'=>'general-pane','class'=>'tab-pane active'));
									$CI->html->sDivRow();
										$CI->html->sDivCol(6);
											$pop = array(
												"href"  => base_url()."academic/courses_form",
											);
											$CI->html->courseDropPaper('Course:','course_id',iSetObj($det,'course_id'),null,array('class'=>'rOkay','pop-form'=>$pop));
											$CI->html->inputPaper('Start Date:','start_date',(iSetObjDate($det,'start_date')),null,array('class'=>'pick-date'),"fa-calendar");
											$CI->html->inputPaper('End Date:','end_date',(iSetObjDate($det,'end_date')),null,array('class'=>'pick-date'),"fa-calendar");
											// $CI->html->teachersDropPaper('Course:','course_id',iSetObj($det,'course_id'),null,array('class'=>'rOkay'));
										$CI->html->eDivCol();
									$CI->html->eDivRow();
								$CI->html->eTabPane();
								$CI->html->sTabPane(array('id'=>'sections-pane','class'=>'tab-pane'));
									$CI->html->sDivRow();
										$CI->html->sDivCol(8);
												$CI->html->sDivRow();
													$CI->html->sDivCol(5);	
														$pop = array(
															"href"  => "academic/sections_form?viewpop=1",
															"params"=> array(
																"title" => "Create New Section",
																"id"    => "create-sect-pop"
															),
														);
														$CI->html->sectionsDropPaper('Section:','section',null,null,array('class'=>'','pop-form'=>$pop));
													$CI->html->eDivCol();
													$CI->html->sDivCol(5);	
														$CI->html->teachersDropPaper('Teacher:','teacher',null,null,array('class'=>''));
													$CI->html->eDivCol();
													$CI->html->sDivCol(2,'right');
														$CI->html->button(fa('fa-plus').' ADD',array('id'=>'add-sec-btn','class'=>'btn-sm btn-flat'),'primary');	
													$CI->html->eDivCol();
												$CI->html->eDivRow();
												$CI->html->sDivRow();
													$CI->html->sDivCol(12);
														$CI->html->sTable(array('class'=>'table paper-table','id'=>'sections-tbl'));
															$CI->html->sTablehead();
																$CI->html->sRow();
																	$CI->html->th('Section');
																	$CI->html->th('Teacher');
																	$CI->html->th(' ');
																$CI->html->eRow();
															$CI->html->eTablehead();
															$CI->html->sTableBody();
																foreach ($sections as $ctr => $row) {
																	$CI->html->sRow(array('id'=>'row-'.$ctr));
																		$link = $CI->html->A(fa('fa-remove fa-lg'),'#',array('class'=>'remove','id'=>'remove-'.$ctr,'ref'=>$ctr,'return'=>'true'));
																		$CI->html->td($row['sec_name']);
																		$CI->html->td($row['teacher_name']);
																		$CI->html->td($link,array('style'=>'text-align:right;margin:0px;'));
																	$CI->html->eRow();
																}
															$CI->html->eTableBody();
														$CI->html->eTable();
													$CI->html->eDivCol();
												$CI->html->eDivRow();
										$CI->html->eDivCol();
									$CI->html->eDivRow();
								$CI->html->eTabPane();
							$CI->html->eTabBody();
						$CI->html->eTab();	
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
								$CI->html->inputPaper('Code:','code',iSetObj($det,'code',next_code('subjects')),null,array('class'=>'rOkay'));
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
function sectionsPage($det=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(10,'left',1);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody(array('class'=>'paper'));
					$CI->html->sForm("academic/sections_db","general-form");
						$CI->html->hidden('id',iSetObj($det,'id'));
						$CI->html->sDivRow();
							$CI->html->sDivCol(6);
								$CI->html->H(4,"General Information",array('class'=>'form-titler'));
								$CI->html->inputPaper('Code:','code',iSetObj($det,'code',next_code('sections')),null,array('class'=>'rOkay'));
								$CI->html->inputPaper('Name:','name',iSetObj($det,'name'),null,array('class'=>'rOkay'));
							$CI->html->eDivCol();
						$CI->html->eDivRow();
					$CI->html->eForm();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}
function schedulePage($det=array()){
	$CI =& get_instance();
	$CI->html->sDivRow();
		$CI->html->sDivCol(3);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody();
					$CI->html->sForm("academic/schedule_db","general-form");
						$CI->html->courseDropPaper("Course:","course",null,null);
						$CI->html->selectPaper("Batch:","batch",array(),null,'Select Batch');
						$CI->html->selectPaper("Section:","section",array(),null,'Select Section');
						$CI->html->daysDropPaper('Select Day:','day');
					$CI->html->eForm();	
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
		$CI->html->sDivCol(9);
			$CI->html->sBox('solid');
				$CI->html->sBoxBody();
					$CI->html->sDiv(array('id'=>'time-tbl'));
					$CI->html->eDiv();
				$CI->html->eBoxBody();
			$CI->html->eBox();
		$CI->html->eDivCol();
	$CI->html->eDivRow();
	return $CI->html->code();
}