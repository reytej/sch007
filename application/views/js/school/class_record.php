<script>
$(document).ready(function(){
	<?php if($use_js == 'attendanceJs'): ?>
		loadAttendance();
		$('#search-btn').click(function(){
			loadAttendance();
			return false;
		});	
		function loadAttendance(){
			var noError = $('#search-form').rOkay({
				"goSubmit" : false,
			});
			if(noError){
				var formData = $('#search-form').serialize();
				$.loadPage();
				$('#attendance-tbl').find('thead tr').remove();
				$('#attendance-tbl').find('tbody tr').remove();
				$.post(baseUrl+'class_record/attendance_load',formData,function(data){

					$('#attendance-tbl').find('thead').append(data.thead);
					$('#attendance-tbl').find('tbody').append(data.tbody);
					$('.dates').bootstrapToggle();
					$('.dates').each(function(){
						$(this).change(function(){
							var checked = $(this).prop('checked');
							var status = 'present';
							if(!checked)
								status = 'absent';
							var sendData = formData+'&student='+$(this).attr('student')+
										   '&date='+$(this).attr('date')+'&status='+status; 
							attendance(sendData);
						});
					});				
					$.loadPage(false);
				},'json').fail( function(xhr, textStatus, errorThrown) {
		           alert(xhr.responseText);
				});
			}	
		}
		function attendance(sendData){
			$.ajax({
		        url: 	baseUrl+'class_record/attendance_db',
		        type: 	'POST',
		        data:  	sendData,
				beforeSend: function(){
				    timeout = setTimeout(function(){
				        $.loadPage();
			    	}, 3000);
			   	},
			    success: function(data){
			       clearTimeout(timeout);
			       $.loadPage(false);
			    }
			});	

		}
	<?php endif; ?>
});
</script>