<script>
$(document).ready(function(){
	<?php if($use_js == 'rolesFormJs'): ?>
		$('#save-btn').click(function(){
			var btn = $(this);
			var noError = $('#roles-form').rOkay({
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
		$(".check").click(function(){
			var id = $(this).attr('id');
			var ch = false
			if($(this).is(':checked'))
				var ch = true;
			$('.'+id).prop('checked',ch);

			var parent = $(this).attr('parent');
			if (typeof parent !== 'undefined' && parent !== false) {
			   parentCheck(ch,parent); 
			}
		});
		function parentCheck(ch,parent){
			if(parent != "check"){
				var par = $('#'+parent);
				if(!ch){
					var ctr = 0;
					$('.'+parent).each(function(){
						if($(this).is(':checked'))
							ctr ++;
					});
					if(ctr == 0)
						par.prop('checked',ch)
				}
				else
					par.prop('checked',ch);
				
				var parentParent = par.attr('parent');
				if (typeof parentParent !== 'undefined' && parentParent !== false) {
					parentCheck(ch,parentParent);	
				}

			}
		}
	<?php endif; ?>
});
</script>