<script>
$(document).ready(function(){
	<?php if($use_js == 'paymentFormJs'): ?>
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
	<?php endif; ?>
});
</script>