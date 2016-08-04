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
		$('#create-subj-pop').rForm(function(data){
			var items = data.items;
			var id = data.id;
			console.log(items);			
			$('#subject').append('<option value="'+id+'">'+items['name']+'</option>');
			$('#subject').selectpicker('refresh');
			$('#subject').selectpicker('val',id);
		});
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
					var td = $('<td style="text-align:right;padding-right:10px;"></td>');
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
    	$('#items-tbl').rTable({
    		cart 		: 	"items",
    		onAdd		: 	function(data){
	    						resetForm();
	    						grandTotal();
    						},
    		onRemove	: 	function(data){
	    						grandTotal();
    						}
    	});
    	$("#item_id").change(function(){
    		loadDetails();
    	});
    	$('#qty').blur(function(){
    		lineTotal();
    	});
    	function loadDetails(){
    		var id = $('#item_id').val();
    		$.fetch({
    			func		: 	'items',
    			key			: 	id,
    			onComplete 	: 	function(data){
    								$('#price-txt').number(data.price,2);
    								$('#price').val(data.price);
    								$('#qty').val(1);
    								$('#uom-txt').text(data.uom);
    								$('#uom').val(data.uom);
    								lineTotal();
    							} 	
    		});
    	}
    	function lineTotal(){
    		var qty = parseFloat($('#qty').val());
    		var price = parseFloat($('#price').val());
    		var total = qty * price;
    		$("#total-txt").number(total,2);
    	}
    	function grandTotal(){
			$.post(baseUrl+'cart/all/items',function(data){
				var grandTotal = 0;
				$.each(data,function(key,row){
					var qty = parseFloat(row['qty']);
		    		var price = parseFloat(row['price']);
		    		var total = qty * price;
		    		grandTotal += total;
				});
				$("#grand-total-txt").number(grandTotal,2);
			},'json').fail( function(xhr, textStatus, errorThrown) {
		       alert(xhr.responseText);
		    });
    	}
    	function resetForm(){
			$('#price-txt').number(0,2);
			$('#price').val(0);
			$('#qty').val("");
			$('#uom-txt').text("");
			$('#uom').val("");
			$('#item_id').selectpicker('val','');
			$('#total-txt').number(0,2);
    	}
    	function subj_remove(id){
    		$.post(baseUrl+'academic/courses_remove_subj/'+id,function(data){
    			$('#row-'+id).remove();
    		});
    	}
	<?php elseif($use_js == 'batchesFormJs'): ?>
		$('#create-sect-pop').rForm(function(data){
			var items = data.items;
			var id = data.id;
			console.log(items);			
			$('#section').append('<option value="'+id+'">'+items['name']+'</option>');
			$('#section').selectpicker('refresh');
			$('#section').selectpicker('val',id);
		});
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
    	$('#add-sec-btn').click(function(){
			var sec_id = $('#section').val();
			var teacher_id = $('#teacher').val();
			var tbl = $('#sections-tbl');
			$.post(baseUrl+'academic/batches_add_section/'+sec_id+'/'+teacher_id,function(data){
				if(data.status == "success"){
					var id = data.id;
					var val = data.row;
					var tr = $('<tr id="row-'+id+'"></tr>');
					tr.append('<td>'+val['sec_name']+'</td>');
					tr.append('<td>'+val['teacher_name']+'</td>');
					var link = $('<a class="remove" href="#" id="remove-'+id+'" ref="'+id+'"><i class="fa fa-remove fa-lg"></i></a>');
					var td = $('<td style="text-align:right;padding-right:10px;"></td>');
					link.click(function(){
						sec_remove(id);
						// alert('ere');
						// $("#subject").val('').trigger('change');
						return false;
					});
					td.append(link);
					tr.append(td);
					tr.appendTo(tbl);
				}
				$('#section').selectpicker('val','');
				$('#teacher').selectpicker('val','');
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
    			sec_remove(id);
    		});
    	});
		function sec_remove(id){
    		$.post(baseUrl+'academic/batch_remove_section/'+id,function(data){
    			$('#row-'+id).remove();
    		});
    	}
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
    <?php elseif($use_js == 'sectionsFormJs'): ?>
		$('#save-btn').click(function(){
			var btn = $(this);
			var noError = $('#general-form').rOkay({
    			btn_load		: 	btn,
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		: 	function(data){
										if(data.error == 0){
											window.location = baseUrl+'academic/sections';
										}
										else{
											$.alertMsg({msg:data.msg,type:'error'});
										}
									},
    		});
			return false;
    	});	
	<?php elseif($use_js == 'scheduleFormJs'): ?>
		$('#save-btn').click(function(){
			var btn = $(this);
			var noError = $('#general-form').rOkay({
    			btn_load		: 	btn,
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		: 	function(data){
										if(data.error == 0){
											window.location = baseUrl+'academic/schedule_form';
										}
										else{
											$.alertMsg({msg:data.msg,type:'error'});
										}
									},
    		});
			return false;
    	});	
		var docHeight = $(document).height();
		var lineID = 1; 
		var calendar = $('#time-tbl').fullCalendar({
			header: {
				left: '',
				// center: 'title',
				right: ''
			},
			allDaySlot:false,
			defaultDate: '2016-07-04',
			defaultView: 'agendaDay',
			editable: true,
			height: docHeight-200,
			minTime: '06:00:00', 
			maxTime: '10:00:00',
			selectable: true,
            selectHelper: true,
			eventStartEditable:false,
			eventOverlap:false,
			eventDurationEditable:false,
			timezone:false,
			select: function(start_ev,end_ev){
						console.log(lineID);
						calendar.fullCalendar('renderEvent', {
							id : lineID,
		                    start: start_ev,
		                    end: end_ev,
		                }, true);
		                calendar.fullCalendar('unselect');
		                var start =  moment(start_ev).format( "YYYY-MM-DD HH:mm:ss");
		                var end =  moment(end_ev).format( "YYYY-MM-DD HH:mm:ss");
						// console.log( moment(start_ev).format( "YYYY-MM-DD HH:mm:ss"));
						
						popForm(lineID,start,end);
						lineID++;
					},
			eventClick:function(event){
						// console.log(event.id);
						// $.post(baseUrl+'cart/all/schedules',function(data){
						// 	console.log(data);
						// },'json');
						popEditForm(event.id);
					}
		});
		$('.fc-toolbar').hide();
		function popEditForm(event_id){
			bootbox.dialog({
			  message: baseUrl+'academic/schedule_pop/'+event_id,
			  title: '<i class="fa fa-flag"></i> Edit Schedule',
			  className: 'bootbox-filter',
			  buttons: {
			    submit: {
			      label: "SUBMIT",
			      className: "btn btn-success btn-flat",
			      callback: function() {
			      	var form = $('.bootbox-filter').find('form');
			      	var formData = form.serialize();
			      	formData += '&update_event_id='+event_id;
			      	
			      	var subj = $('#subject');
			      	var teach = $('#teacher');
		      		var subject_name = subj.find("option:selected").text();
		      		var teacher_name = teach.find("option:selected").text();
		      		var eve = calendar.fullCalendar( 'clientEvents', event_id );
		      		// console.log(eve[0]);
		      		eve[0].title = 'Subject: '+subject_name+';'+' Teacher: '+teacher_name;
		      		eve[0].description = 'Subject: '+subject_name;
		      		calendar.fullCalendar('updateEvent', eve[0]);
			      	$.post(baseUrl+'academic/schedule_cart',formData,function(data){
			      		// console.log(data);
			      		$.post(baseUrl+'cart/all/schedules',function(data){
							console.log(data);
						},'json');
			      	}).fail( function(xhr, textStatus, errorThrown) {
			           alert(xhr.responseText);
			        });
			        return true;
			      }
			    },
			    delete: {
			      label: "DELETE",
			      className: "btn btn-danger btn-flat",
			      callback: function() {
			      	var formData = 'delete_event_id='+event_id;
			        $.post(baseUrl+'academic/schedule_cart',formData,function(data){
			      		calendar.fullCalendar('removeEvents',event_id);
			      	}).fail( function(xhr, textStatus, errorThrown) {
			           alert(xhr.responseText);
			        });
			      }
			    },
			    cancel: {
			      label: "CANCEL",
			      className: "btn btn-default btn-flat",
			      callback: function() {
			        // calendar.fullCalendar('removeEvents',event_id);
			      }
			    }
			  }
			});
		}	
		function popForm(event_id,start,end){
			bootbox.dialog({
			  message: baseUrl+'academic/schedule_pop',
			  title: '<i class="fa fa-flag"></i> Add To Schedule',
			  className: 'bootbox-filter',
			  buttons: {
			    submit: {
			      label: "SUBMIT",
			      className: "btn btn-success btn-flat",
			      callback: function() {
			      	var form = $('.bootbox-filter').find('form');
			      	var formData = form.serialize();
			      	formData += '&start='+start+'&end='+end+'&event_id='+event_id;
			      	var subj = $('#subject');
			      	var teach = $('#teacher');
		      		var subject_name = subj.find("option:selected").text();
		      		var teacher_name = teach.find("option:selected").text();
		      		var eve = calendar.fullCalendar( 'clientEvents', event_id );
		      		// console.log(eve[0]);
		      		eve[0].title = 'Subject: '+subject_name+';'+' Teacher: '+teacher_name;
		      		eve[0].description = 'Subject: '+subject_name;
		      		calendar.fullCalendar('updateEvent', eve[0]);
			      	$.post(baseUrl+'academic/schedule_cart',formData,function(data){
			      		console.log(data);
			      		$.post(baseUrl+'cart/all/schedules',function(data){
							console.log(data);
						},'json');
			      	}).fail( function(xhr, textStatus, errorThrown) {
			           alert(xhr.responseText);
			        });
			        return true;
			      }
			    },
			    cancel: {
			      label: "CANCEL",
			      className: "btn btn-default btn-flat",
			      callback: function() {
			        calendar.fullCalendar('removeEvents',event_id);
			      }
			    }
			  },
			  onEscape: function() {
			  	   calendar.fullCalendar('removeEvents',event_id);
			  }
			});
		}
		$('#day').change(function(){
			var day = $(this).val();
			if(day == 'monday')
				$('#time-tbl').fullCalendar( 'gotoDate','2016-07-04');
			else if (day == 'tuesday')
				$('#time-tbl').fullCalendar( 'gotoDate','2016-07-05');
			else if (day == 'wednesday')
				$('#time-tbl').fullCalendar( 'gotoDate','2016-07-06');
			else if (day == 'thursday')
				$('#time-tbl').fullCalendar( 'gotoDate','2016-07-07');
			else if (day == 'friday')
				$('#time-tbl').fullCalendar( 'gotoDate','2016-07-08');
			else if (day == 'saturday')
				$('#time-tbl').fullCalendar( 'gotoDate','2016-07-09');
			else if (day == 'sunday')
				$('#time-tbl').fullCalendar( 'gotoDate','2016-07-03');
		});
		$('#course').change(function(){
			var id = $('#course').val();
			$.fetch({
    			func		: 	'course_batches',
    			key			: 	id,
    			onComplete 	: 	function(data){
    								$('#batch').html('');
    								$('#batch').append('<option value="">Select Batch</option>');
    								$.each(data,function(ctr,row){
    									$('#batch').append('<option value="'+row['id']+'">'+row['name']+'</option>');
    								});
    								$('#batch').selectpicker('refresh');
    								loadSections();
    							} 	
    		});
		});
		$('#batch').change(function(){
			loadSections();
		});
		$('#section').change(function(){
			loadEvents();
		});
		function loadSections(){
			var id = $('#batch').val();
			$.fetch({
    			func		: 	'course_batch_sections',
    			key			: 	id,
    			onComplete 	: 	function(data){
    								$('#section').html('');
    								$('#section').append('<option value="">Select Section</option>');
    								$.each(data,function(ctr,row){
    									$('#section').append('<option value="'+row['id']+'">'+row['name']+'</option>');
    								});
    								$('#section').selectpicker('refresh');
    							} 	
    		});
		}
		function loadEvents(){
			var batch = $('#batch').val();
			var section = $('#section').val();
			calendar.fullCalendar('removeEvents');
			$.post(baseUrl+'academic/schedule_load/'+batch+'/'+section,function(data){

				$.each(data.details,function(ctr,row){
					calendar.fullCalendar('renderEvent', {
							id : row.event_id,
							title: 'Subject: '+row.subject_name+';'+' Teacher: '+row.teacher_name,
		                    // start: moment(row.start).format( "YYYY-MM-DDTHH:MM:SS"),
		                    start: row.start,
		                    // end: moment(row.end).format( "YYYY-MM-DDTHH:MM:SS"),
		                    end: row.end,
		                }, true);
					lineID = parseFloat(row.event_id);
				});
				lineID++;
				// console.log(lineID);
				// console.log(calendar.fullCalendar('clientEvents'));
				$.post(baseUrl+'cart/all/schedules',function(data){
					console.log(data);
				},'json');
			},'json').fail( function(xhr, textStatus, errorThrown) {
	           alert(xhr.responseText);
	        });
		}
	<?php endif; ?>
});
</script>