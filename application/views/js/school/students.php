<script>
$(document).ready(function(){
	<?php if($use_js == 'studentProfileJs'): ?>
		load_div('students/profile_general');
		$('.load-btns').each(function(){
			$(this).click(function(){
				var ur = $(this).attr('load');
				load_div(ur);
				return false;
			});
		});
		function load_div(loadUrl){
			var div = $('#load-div');
			var std_id = div.attr('student');
			div.rLoad({url:loadUrl+'/'+std_id});
		}
	<?php elseif($use_js == 'profileGeneralJs'): ?>
		$('.pick-date').datepicker();
		$('.paper-select').selectpicker();
	<?php endif; ?>
});
</script>