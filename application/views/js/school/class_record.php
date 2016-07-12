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
					$.loadPage(false);
				},'json').fail( function(xhr, textStatus, errorThrown) {
		           alert(xhr.responseText);
				});
			}	
		}
	<?php endif; ?>
});
</script>