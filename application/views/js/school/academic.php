<script>
$(document).ready(function(){
	<?php if($use_js == 'yearsFormJs'): ?>
		$('#save-btn').click(function(){
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
			return false;
    	});	
	<?php elseif($use_js == 'coursesFormJs'): ?>
		$('#save-btn').click(function(){
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
			return false;
    	});
		$('#add-subj-btn').click(function(){
			var subj_id = $('#subject').val();
			var tbl = $('#main-tbl');
			$.post(baseUrl+'academic/courses_add_subj/'+subj_id,function(data){
				if(data.status == "success"){
					var id = data.id;
					var val = data.row;
					var tr = $('<tr id="row-'+id+'"></tr>');
					tr.append('<td>'+val['subj_code']+'</td>');
					tr.append('<td>'+val['subj_name']+'</td>');
					var link = $('<a class="remove" href="#" id="remove-'+id+'" ref="'+id+'"><i class="fa fa-remove fa-lg"></i></a>');
					var td = $('<td style="text-align:right;padding-right:12px;"></td>');
					link.click(function(){
						subj_remove(id);
						// $("#subject").val('').trigger('change');
						return false;
					});
					td.append(link);
					tr.append(td);
					tr.appendTo(tbl);
				}
				$('#subject').selectpicker('val','');
				$.alertMsg({msg:data.msg,type:data.status});
			},'json').fail( function(xhr, textStatus, errorThrown) {
	           alert(xhr.responseText);
	        });
			return false;
    	});
    	$('.remove').each(function(){
    		$(this).click(function(){
    			var id = $(this).attr('ref');
    			if(id == "")
    				id = 0;
    			subj_remove(id);
    		});
    	});
    	function subj_remove(id){
    		$.post(baseUrl+'academic/courses_remove_subj/'+id,function(data){
    			$('#row-'+id).remove();
    		});
    	}
	<?php elseif($use_js == 'batchesFormJs'): ?>
		$('#save-btn').click(function(){
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
			return false;
    	});
    <?php elseif($use_js == 'subjectsFormJs'): ?>
		$('#save-btn').click(function(){
			var btn = $(this);
			var noError = $('#general-form').rOkay({
    			btn_load		: 	btn,
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		: 	function(data){
										if(data.error == 0){
											window.location = baseUrl+'academic/subjects';
										}
										else{
											$.alertMsg({msg:data.msg,type:'error'});
										}
									},
    		});
			return false;
    	});	
		$('#save-new-btn').click(function(){
			var btn = $(this);
			var noError = $('#general-form').rOkay({
				addData 		: 	"new=1",
    			btn_load		: 	btn,
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		: 	function(data){
										if(data.error == 0){
											// location.reload();
											window.location = baseUrl+'academic/subjects';
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