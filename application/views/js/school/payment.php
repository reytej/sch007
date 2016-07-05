<script>
$(document).ready(function(){
	<?php if($use_js == 'paymentFormJs'): ?>
		$('.amt-btns').each(function(){
			$(this).click(function(){
				var type = $(this).attr('ref');
				var formData = $('#'+type+'-pane').serializeAnything();
				formData += '&type='+type;
				return false;
			});
		});
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
			},'json').fail( function(xhr, textStatus, errorThrown) {
	           alert(xhr.responseText);
	        });
		}
	<?php endif; ?>
});
</script>