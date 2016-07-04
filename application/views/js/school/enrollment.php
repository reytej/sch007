<script>
$(document).ready(function(){
	<?php if($use_js == 'enrollmentJs'): ?>
		$('#save-btn').click(function(){
			var btn = $(this);
			var noError = $('#enrollment-form').rOkay({
    			btn_load		: 	btn,
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		: 	function(data){
										// alert(data.error);
										if(data.error == 0){
											window.location.reload();
										}
										else{
											$.alertMsg({msg:data.msg,type:'error'});
										}
									},
    		});
			return false;
    	});
		$('#course').change(function(){
			loadCourseDetails();
		});
		function loadCourseDetails(){
			var course_id = $('#course').val();
			var subj_tbl = $("#subjects-tbl tbody");
			var item_tbl = $("#items-tbl > tbody > tr:first-child");
			$.post(baseUrl+'enrollment/get_course_details/'+course_id,function(data){
				var subjects = data.subjects;
				$.each(subjects,function(ctr,row){
					var tr = $('<tr></tr>');
					tr.append('<td>'+row['subj_code']+'</td>');
					tr.append('<td>'+row['subj_name']+'</td>');
					subj_tbl.append(tr);
				});
				var items = data.items;
				$.each(items,function(id,row){
					var tr = $('<tr id="items-row-'+id+'"></tr>');
					tr.append('<td>'+row['item_name']+'</td>');
					tr.append('<td>'+row['qty']+'</td>');
					tr.append('<td>'+row['uom']+'</td>');
					tr.append('<td>'+$.number(row['price'],2)+'</td>');
					var lineTOtal = parseFloat(row['qty']) * parseFloat(row['price']);
					tr.append('<td>'+$.number(lineTOtal,2)+'</td>');
					var td = $('<td style="text-align:right"></td>');
					var link = $('<a href="#"><i class="fa fa-trash fa-lg"></i></a>');
					link.click(function(){
						$.post(baseUrl+'cart/remove/items/'+id,function(){
						  $('#items-tbl > tbody').find('tr#items-row-'+id).remove();
						  grandTotalItems();
						});
						return false;
					});
					link.appendTo(td);
					tr.append(td);
					item_tbl.before(tr);
				});
				grandTotalItems();
			},'json').fail( function(xhr, textStatus, errorThrown) {
	          alert(xhr.responseText);
	        });
		}
		function grandTotalItems(){
			$.post(baseUrl+'cart/all/items',function(data){
				var grandTotal = 0;
				$.each(data,function(key,row){
					var qty = parseFloat(row['qty']);
		    		var price = parseFloat(row['price']);
		    		var total = qty * price;
		    		grandTotal += total;
				});
				$("#grand-total-txt").number(grandTotal,2).css('font-weight','bold');
				$("#payment-total-txt").number(grandTotal,2).css('font-weight','bold');
				$('#total_payment').val(grandTotal);
			},'json').fail( function(xhr, textStatus, errorThrown) {
		       alert(xhr.responseText);
		    });
    	}	
		$('#student').change(function(){
			loadStudentDetails();
		});
		$('#date_range').daterangepicker({}, 
		function(start, end, label) {
		    totalMonths();
		});
		function loadStudentDetails(){
    		var id = $('#student').val();
    		$.fetch({
    			func		: 	'students',
    			key			: 	id,
    			onComplete 	: 	function(data){
    								$('#std-img').attr('src',baseUrl+data.image);
    							} 	
    		});
    	}
    	function totalMonths(){
    		var months = 0;
    		var dateRange = $('#date_range').val();
    		var dt = dateRange.split(' - ');
    		// console.log(dt);
    		
    		var d1 = new Date(dt[0]);
			var d2 = new Date(dt[1]);

    		if(d1 != "" && d2 != ""){
				months = monthDiff(d1, d2);
				months += 1;
				$('#total-months-txt').number(months,0);
				$('#no_months').val(months);
				calculateMonths();
    		}
    	}
    	function monthDiff(d1, d2) {
    	    var months;
    	    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    	    months -= d1.getMonth() + 1;
    	    months += d2.getMonth();
    	    
    	    return months <= 0 ? 0 : months;
    	}
    	function calculateMonths(){
    		var pay_tbl = $("#payments-tbl tbody");
    		var formData = $('#payments-pane').serializeAnything();
    		$.post(baseUrl+'enrollment/cart_months',formData,function(data){
	    		pay_tbl.find('.pay-rows').remove();
	    		var html = data.html;
	    		pay_tbl.append(html);
    		},'json').fail( function(xhr, textStatus, errorThrown) {
		       alert(xhr.responseText);
		    });
    	}
	<?php endif; ?>
});
</script>