<?php
function enrollmentForm($now=null,$next_ref=null,$en=array(),$details=array(),$img=array()){
	$CI =& get_instance();
		$CI->html->sForm("enrollment/db","enrollment-form");
		$CI->html->hidden('enroll_id',iSetObj($en,'id'));
		$CI->html->sBox('solid');
			$CI->html->sBoxBody();
				$CI->html->sDivRow();
					$CI->html->sDivCol(5);
						$CI->html->studentsDropPaper("Student:","student",iSetObj($en,'student_id'));
						$CI->html->courseDropPaper("Course:","course",iSetObj($en,'course_id'));
						$CI->html->batchDropPaper("Batch:","batch",iSetObj($en,'batch_id'));
						$CI->html->sectionsDropPaper("Section:","section",iSetObj($en,'section_id'));
					$CI->html->eDivCol();
					$CI->html->sDivCol(3);
						$params = array();
						if(iSetObj($en,'id'))
							$params['readOnly'] = 'readOnly';
						$CI->html->inputPaper('Reference:',"trans_ref",$next_ref,null,$params);
						$date = sql2Date($now);
						if(iSetObj($en,'trans_date'))
							$date = sql2Date($now);
						$CI->html->inputPaper('Trans Date:',"trans_date",$date,null,array('class'=>'pick-date'));
					$CI->html->eDivCol();
					$CI->html->sDivCol(4,'right');
						$url = base_url().'dist/img/no-photo.jpg';
						if(iSetObj($img,'img_path') != ""){					
							$url = base_url().$img->img_path;
						}
						$CI->html->img($url,array('style'=>'height:150px;','class'=>'media-object thumbnail pull-right','id'=>'std-img'));
					$CI->html->eDivCol();
				$CI->html->eDivRow();
				$CI->html->sTab(array('class'=>'paper-tab','style'=>'margin-top:5px;'));
					$tabs = array(fa('fa-book').' Subjects'=>array('href'=>'#subjects-pane'),
								  fa('fa-cubes').' Items'=>array('href'=>'#items-pane'),
								  fa('fa-calendar').' Payment Schedule'=>array('href'=>'#payments-pane'),
								 );
					$CI->html->tabHead($tabs,null,array());
					$CI->html->sTabBody();
						$CI->html->sTabPane(array('id'=>'subjects-pane','class'=>'tab-pane active'));
							$CI->html->sDivRow();
								$CI->html->sDivCol(6);
									$CI->html->sTable(array('class'=>'table paper-table','id'=>'subjects-tbl'));
										$CI->html->sTablehead();
											$CI->html->sRow();
												$CI->html->th('Code');
												$CI->html->th('Name');
											$CI->html->eRow();
										$CI->html->eTablehead();
										$CI->html->sTableBody();
											if(isset($details['subjects'])){
												$subjects = $details['subjects'];
												foreach ($subjects as $ctr => $sub) {
													$CI->html->sRow();
														$CI->html->td($sub['subj_code']);
														$CI->html->td($sub['subj_name']);
													$CI->html->eRow();
												}
											}
										$CI->html->eTableBody();
									$CI->html->eTable();
								$CI->html->eDivCol();
							$CI->html->eDivRow();	
						$CI->html->eTabPane();
						$CI->html->sTabPane(array('id'=>'items-pane','class'=>'tab-pane'));
							$CI->html->sTable(array('class'=>'table paper-table','id'=>'items-tbl'));
								$CI->html->sTablehead();
									$CI->html->sRow();
										$CI->html->th('Item');
										$CI->html->th('Qty');
										$CI->html->th('UOM');
										$CI->html->th('Price');
										$CI->html->th('Subtotal');
										$CI->html->th('');
									$CI->html->eRow();
								$CI->html->eTablehead();
								$CI->html->sTableBody();
									$grandTotal = 0;
									if(isset($details['items'])){
										$items = $details['items'];
										foreach ($items as $ctr => $itm) {
											$CI->html->sRow();
												$CI->html->td($itm['item_name']);
												$CI->html->td($itm['qty']);
												$CI->html->td($itm['uom']);
												$CI->html->td(num($itm['price']));
												$subtotal = $itm['price'] * $itm['qty'];
												$CI->html->td(num($subtotal));
												$CI->html->td('');
											$CI->html->eRow();
											$grandTotal += $subtotal;
										}
									}
									$CI->html->sRow();
										$CI->html->td('');
										$CI->html->td('');
										$CI->html->td('');
										$CI->html->td('<b>Grand Total</b>');
										$CI->html->td(num($grandTotal),array('id'=>'grand-total-txt'));
										$CI->html->td('');
									$CI->html->eRow();
								$CI->html->eTableBody();
							$CI->html->eTable();
						$CI->html->eTabPane();
						$CI->html->sTabPane(array('id'=>'payments-pane','class'=>'tab-pane'));
							$CI->html->sDivRow();
								$CI->html->sDivCol(5);
									$CI->html->hidden('pay_term_id',3);
									$CI->html->hidden('no_months',iSetObj($en,'no_months',0));
									$CI->html->hidden('down_payment',0);
									$CI->html->hidden('dp_use_1',1);
									$totalP = 0;
									if(iSetObj($en,'id'))
										$totalP = iSetObj($en,'total_amount',0) / iSetObj($en,'no_months',0);
									$CI->html->hidden('total_payment',$totalP);
									$CI->html->hidden('day_of_month',5);
									$date_range = '';
									if(iSetObj($en,'id'))
										$date_range = iSetObjDate($en,'start_date')." - ".iSetObjDate($en,'end_date');
									$CI->html->inputPaper('Date Range:','date_range',$date_range,null,array('class'=>''),'fa-calendar');
								$CI->html->eDivCol();
								$CI->html->sDivCol(5,'left',2);
									// $CI->html->textPaper('Total Months: ',num(0,0),array('id'=>'total-months-txt'));
									// $CI->html->textPaper('Monthly Payment: ',num($grandTotal),array('id'=>'payment-total-txt'));
								$CI->html->eDivCol();
							$CI->html->eDivRow();
							$CI->html->sDivRow(array('style'=>'margin-top:10px;'));
								$CI->html->sDivCol();
									$CI->html->sTable(array('class'=>'table paper-table','id'=>'payments-tbl'));
										$CI->html->sTablehead();
											$CI->html->sRow();
												$CI->html->th('#',array('style'=>'width:30px;'));
												$CI->html->th('Particular');
												$CI->html->th('Due Date');
												$CI->html->th('Amount Due');
											$CI->html->eRow();
										$CI->html->eTablehead();
										$CI->html->sTableBody();
											if(isset($details['payments'])){
												$payTotal = 0;
												$payments = $details['payments'];
												foreach ($payments as $ctr => $pay) {
													$CI->html->sRow(array('class'=>'pay-rows'));
														$CI->html->td($ctr+1);
														$txt = "Monthly Payment";
														if($pay['type'] == 'dp')
															$txt = "Down Payment";
														$CI->html->td($txt);
														$CI->html->td(sql2Date($pay['due_date']));
														$CI->html->td(num($pay['amount']));													
													$CI->html->eRow();
													$payTotal += $pay['amount'];
												}
												$CI->html->sRow(array('class'=>'pay-rows'));
													$CI->html->td('');
													$CI->html->td('');
													$CI->html->td('<b>Total Payment</b>');
													$CI->html->td('<b>'.num($payTotal).'</b>');
												$CI->html->eRow();
											}
										$CI->html->eTableBody();
									$CI->html->eTable();
								$CI->html->eDivCol();
							$CI->html->eDivRow();
						$CI->html->eTabPane();
					$CI->html->eTabBody();
				$CI->html->eTab();			
			$CI->html->eBoxBody();
		$CI->html->eBox();
		$CI->html->eForm();
	return $CI->html->code();
}
