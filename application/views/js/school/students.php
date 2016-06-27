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
		function readURL(input) {
        	if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            reader.onload = function (ev) {
	                // alert($('#pic-form').exists());	
		            $('#pic-form').submit(function(e){
					    var formObj = $(this);
					    var formURL = formObj.attr("action");
					    var formData = new FormData(this);
					    $.ajax({
					        url: baseUrl+formURL,
					        type: 'POST',
					        data:  formData,
					        dataType:  'json',
					        mimeType:"multipart/form-data",
					        contentType: false,
					        cache: false,
					        processData:false,
					        success: function(data, textStatus, jqXHR){
								if(data.error == 0){
					                $('#profile-pic').attr('src', ev.target.result);
									$.alertMsg({msg:data.msg,type:'success'});
								}
								else{
									$.alertMsg({msg:data.msg,type:'error'});
								}
					        },
					        error: function(jqXHR, textStatus, errorThrown){
					        }         
					    });
					    e.preventDefault();
					//     e.unbind();
					});
					$('#pic-form').submit();
	            }
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
    	$("#fileUpload").change(function(){
	        readURL(this);        			
	    });
	    $('#target').click(function(e){
	    	$('#fileUpload').trigger('click');
	    }).css('cursor', 'pointer');

	<?php elseif($use_js == 'profileGeneralJs'): ?>
		$('.pick-date').datepicker();
		$('.paper-select').selectpicker();
		$('#save-btn').click(function(){
			var btn = $(this);
			var noError = $('#general-form').rOkay({
    			btn_load		: 	btn,
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		: 	function(data){
										// alert(data.error);
										if(data.error == 0){
											window.location = baseUrl+'students/profile/'+data.id;
										}
										else{
											$.alertMsg({msg:data.msg,type:'error'});
										}
									},
    		});
			return false;
    	});
	<?php endif; ?>
});
</script>