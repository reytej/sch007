<script>
$(document).ready(function(){
	<?php if($use_js == 'paymentListJs'): ?>
		$('#payments-list').rList({
			onComplete 		:  	function(data){
									$('.void-btn').each(function(){
										$(this).rVoid({loadUrl:$(this).attr('href')});
									})
								}
		});
	<?php elseif($use_js == 'paymentFormJs'): ?>
		$('#save-btn').click(function(){
			var check = checkTenders();
			if(check){
				var btn = $(this);
				var noError = $('#general-form').rOkay({
	    			btn_load		: 	btn,
					bnt_load_remove	: 	true,
					asJson			: 	true,
					onComplete		: 	function(data){
											if(data.error == 0){
												location.reload();
											}
											else{
												$.alertMsg({msg:data.msg,type:'error'});
											}
										},
	    		});
			}
			return false;
		});
		function checkTenders(){
			var total = parseFloat($('#total-allocate').val());	
			var tenders = 0;
			$('.tenders').each(function(){
				var val = $(this).val();
				if(isNumber(val)){
					tenders += parseFloat(val);
				}
			});
			if(total == 0){
				$.alertMsg({'msg':'No Payment Amount Added.','type':'error'});
				return false;
			}
			else if(tenders == 0){
				$.alertMsg({'msg':'No Payment Tendered','type':'error'});
				return false;
			}
			else if((total - tenders) > 0){
				$.alertMsg({'msg':'Please input all allocated Amount.','type':'error'});
				return false;
			}
			else{
				return true;
			}
		}
		$('.amt-btns').each(function(){
			$(this).click(function(){
				var type = $(this).attr('ref');
				var formData = $('#'+type+'-pane').serializeAnything();
				var tbl = $('#payment-tbl > tbody');
				formData += '&type='+type;
				$.post(baseUrl+'payment/add_payment_cart',formData,function(data){
					tbl.find('#payments-none').hide();
					var html = data.html;
					tbl.append(html);
					$('#'+type+'_amt').val('');
					var sess = data.sess;
					$('#del-pay-'+sess['id']).click(function(){
						$.post(baseUrl+'cart/remove/payments/'+sess['id'],function(data){
							tbl.find('#payments-row-'+sess['id']).remove();
							totalPayments();
							$('.tenders').val("");
						});
					});
					totalPayments();
				},'json').fail( function(xhr, textStatus, errorThrown) {
		           alert(xhr.responseText);
		        });
				return false;
			});
		});
		function totalPayments(){
			var tbl = $('#payment-tbl > tbody');
			$.post(baseUrl+'cart/all/payments',function(data){
				var total_amount = 0
				var left_amount = 0
				$.each(data,function(lineID,row){
					total_amount += parseFloat(row['amount']);
				});
				left_amount = total_amount;
				$('#total-allocate-txt').number(total_amount,2);	
				$('#total-allocate').val(total_amount);	
				$('#left-allocate-txt').number(left_amount,2);	
				$('#left-allocate').val(left_amount);	
			},'json').fail( function(xhr, textStatus, errorThrown) {
	           alert(xhr.responseText);
	        });
		}
		$('#student').change(function(){
			loadDues();
			return false;
		});
		function loadDues(){
			var id = $('#student').val();
			var tbl = $('#sched-tbl > tbody');
			tbl.find('.dues-rows').remove();
			$.post(baseUrl+'payment/get_student_dues/'+id,function(data){
				var html = data.html;
				tbl.append(html);	
				$('.tenders').each(function(){
					$(this).on('blur',function(){
						var val = $(this).val();
						if(!isNumber(val)){
							if(val != ""){
								$.alertMsg({'msg':'Invalid Amount','type':'error'});
								$(this).val("");
							}
						}	
						totalAllocate();
					});
				});
				$('.all-ins').each(function(){
					$(this).click(function(){
						var lineID = $(this).attr('ref');
						var left = $('#left-allocate').val();	
						$('#tender-'+lineID).val(left);
						totalAllocate();
						return false;
					});
				});
				$('.all-dels').each(function(){
					$(this).click(function(){
						var lineID = $(this).attr('ref');
						$('#tender-'+lineID).val("");
						totalAllocate();
						return false;
					});
				});	
			},'json').fail( function(xhr, textStatus, errorThrown) {
	           alert(xhr.responseText);
	        });
		}
		function totalAllocate() {
			var total = parseFloat($('#total-allocate').val());	
			var left = 0;
			var allocated = 0;
			$('.tenders').each(function(){
				var val = $(this).val();
				if(isNumber(val)){
					allocated += parseFloat(val);
				}
			});
			if(allocated == 0)
				left = total;
			else
				left = total - allocated;
			console.log(left);
			$('#left-allocate-txt').number(left,2);	
			$('#left-allocate').val(left);	
		}	
		function isNumber(n) {
 			 return !isNaN(parseFloat(n)) && isFinite(n);
		}
	<?php elseif($use_js == 'balancesJs'): ?>
		$('#balance-list').rList({
			onComplete 		:  	function(data){
									$('.view-btn').each(function(){
										$(this).rView();
									});
								}
		});
	<?php elseif($use_js == 'billingJs'): ?>
		$('#billing-list').rList({
			onComplete 		:  	function(data){
									console.log(data);
								},
			gridClick 		:  	function(data){
									addSelected(data.tagid);									
								}
		});
		$('#select-all-btn').click(function(){
			if($(this).hasClass('on-select')){
				$('.grid-boxes').each(function(){
					var tagid = $(this).attr('ref');
					var grid = $('#grid-box-'+tagid);
					if(!grid.hasClass('selected')){
						addOverlay(tagid);
					}	
				});
				$(this).html('<i class="fa fa-fw fa-times"></i> Unselect All');
				$(this).removeClass('btn-success');
				$(this).removeClass('on-select');
				$(this).addClass('un-select');
				$(this).addClass('btn-danger');
			}
			else{
				$('.grid-boxes').each(function(){
					var tagid = $(this).attr('ref');
					var grid = $('#grid-box-'+tagid);
					if(grid.hasClass('selected')){
						removeOverlay(tagid);
					}	
				});
				$(this).html('<i class="fa fa-fw fa-check"></i> Select All');
				$(this).addClass('on-select');
				$(this).removeClass('un-select');
				$(this).addClass('btn-success');
				$(this).removeClass('btn-danger');
			}
			return false;
		});
		function addSelected(tagid){
			var grid = $('#grid-box-'+tagid);
			if(!grid.hasClass('selected')){
				addOverlay(tagid);
			}
			else{
				removeOverlay(tagid);
			}
		}
		function removeOverlay(tagid){
			var grid = $('#grid-box-'+tagid);
			grid.find('.grid-overlay').remove();
			grid.removeClass('selected');
		}	
		function addOverlay(tagid){
			var grid = $('#grid-box-'+tagid);
			var box = $('#grid-box-'+tagid).find('.info-box');
			$('<div class="grid-overlay"><div style="padding:5px;"><i class = "fa fa-check fa-3x fa-fw" ></i></div></div>').css({
			    position: "absolute",
			    color: "#7FFF00",
			    opacity: '0.5',
			    width: "100%",
			    height: "100%",
			    "text-align":"right",
			    top: 0,
			    left: 0,
			    background: "#000",
			    "padding-bottom": "90px",
			}).appendTo(box.css("position", "relative"));
			grid.addClass('selected');
		}
		$('#print-btn').click(function(){
			var ids = "";
			$('.grid-boxes').each(function(){
				if($(this).hasClass('selected')){
					var tagid = $(this).attr('ref');
					ids += tagid+',';
					removeOverlay(tagid);
				}
			});
			var formData = "tagid="+ids;
			$.rPrint("sch_prints/bills?"+formData);
			$('#select-all-btn').html('<i class="fa fa-fw fa-check"></i> Select All');
			$('#select-all-btn').addClass('on-select');
			$('#select-all-btn').removeClass('un-select');
			$('#select-all-btn').addClass('btn-success');
			$('#select-all-btn').removeClass('btn-danger');
			return false;
		});
	<?php endif; ?>
});
</script>