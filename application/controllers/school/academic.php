<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Academic extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('school/academic_helper');
	}
	public function years(){
		$data = $this->syter->spawn('aca_years');
		$data['code'] = listPage(fa('fa-calendar')." Academic Years",'years','academic/years_form','list','list',false);
		$this->load->view('list',$data);
	}
	public function years_form($id=null){
		$data = $this->syter->spawn('aca_years');
		$data['page_title'] = fa('fa-calendar')." Academic Years";
		$data['page_subtitle'] = "Add Academic Year";
		$det = array();
		$img = array();
		if($id != null){
			$details = $this->site_model->get_tbl('academic_years',array('id'=>$id));
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit Academic Year ".ucwords(strtolower($det->name));
			}
		}
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'academic/years"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = yearsPage($det);
		$data['load_js'] = 'school/academic';
		$data['use_js'] = 'yearsFormJs';
		$this->load->view('page',$data);
	}
	public function years_db($id=null){
		$user = sess('user');
		$items = array(
		    "name"=>$this->input->post('name'),
		    "start_date"=>date2Sql($this->input->post('start_date')),
		    "end_date"=>date2Sql($this->input->post('end_date')),
		);
		$error = 0;
		$msg = "";
		if(!$this->input->post('id')){
			$id = $this->site_model->add_tbl('academic_years',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
			$msg = "Added New Academic Year ".$items['name'];
		}
		else{
			$id = $this->input->post('id');
			$this->site_model->update_tbl('academic_years','id',$items,$id);
			$msg = "Updated Academic Year ".$items['name'];
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
	}
	public function courses(){
		$data = $this->syter->spawn('courses');
		$data['code'] = listPage(fa('fa-map')." Courses",'courses','academic/courses_form','list','list',false);
		$this->load->view('list',$data);
	}
	public function courses_form($id=null){
		$data = $this->syter->spawn('courses');
		$data['page_title'] = fa('fa-map')." Courses";
		$data['page_subtitle'] = "Add Course";
		$det = array();
		$img = array();
		$subjects = array();
		$items = array();
		if($id != null){
			$details = $this->site_model->get_tbl('courses',array('id'=>$id));
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit Course ".ucwords(strtolower($det->name));
				$select   = "course_subjects.*,subjects.code as subj_code,subjects.name as subj_name";
				$result = $this->site_model->get_tbl('course_subjects',array('course_id'=>$id),array(),array('subjects'=>'course_subjects.subject_id = subjects.id'),true,$select);
				foreach ($result as $res) {
					$subjects[] = array(
						"subj_id" => $res->subject_id,
						"subj_code" => $res->subj_code,
						"subj_name" => $res->subj_name,
					);
				}
				$select   = "course_items.*,items.code as item_code,items.name as item_name,items.uom as item_uom,items.price as item_price";
				$result   = $this->site_model->get_tbl('course_items',array('course_id'=>$id),array(),array('items'=>'course_items.item_id = items.id'),true,$select);
				foreach ($result as $res) {
					$items[] = array(
						'item_id' => $res->item_id,
						'qty' => $res->qty,
						'uom' => $res->item_uom,
						'price' => $res->item_price,
						'item_name' => "[".$res->item_code."]".$res->item_name
					);
				}	
			}
		}
		sess_initialize("subjects",$subjects);
		sess_initialize("items",$items);
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'academic/courses"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = coursesPage($det,$subjects,$items);
		$data['load_js'] = 'school/academic';
		$data['use_js'] = 'coursesFormJs';
		$this->load->view('page',$data);
	}
	public function courses_add_subj($subj_id=null){
		$subjects = sess('subjects');
		$status = "success";
		$msg    = "";
		$check  = true;
		$row    = array();
		$id 	= null;
		foreach ($subjects as $ctr => $row) {
			if($row['subj_id'] == $subj_id){
				$check = false;
				$status = "error";
				$msg    = "Subject is already added.";
				break;
			}	
		}
		if($check){
			$details = $this->site_model->get_tbl('subjects',array('id'=>$subj_id));
			if(count($details) > 0){
				$det = $details[0];
				$row = array('subj_id'=>$det->id,'subj_code'=>$det->code,'subj_name'=>$det->name); 
				$cart = sess_add('subjects',$row);
				$id = $cart['id'];
				$msg   = "Subject Added.";
			}
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg,'row'=>$row,'id'=>$id));
	}
	public function courses_remove_subj($id=null){
		sess_delete('subjects',$id);
	}
	public function courses_db($id=null){
		$user = sess('user');
		
		$items = array(
		    "name"=>$this->input->post('name'),
		    "code"=>$this->input->post('code'),
		    "description"=>$this->input->post('description'),
		);
		$error = 0;
		$msg = "";
		if(!$this->input->post('id')){
			$id = $this->site_model->add_tbl('courses',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
			$msg = "Added New Course ".$items['name'];
		}
		else{
			$id = $this->input->post('id');
			$this->site_model->update_tbl('courses','id',$items,$id);
			$msg = "Updated Course ".$items['name'];
			$this->site_model->delete_tbl('course_subjects',array('course_id'=>$id));
			$this->site_model->delete_tbl('course_items',array('course_id'=>$id));
		}
		$subjects = sess('subjects');
		if(count($subjects) > 0){
			$details = array();
			foreach ($subjects as $ctr => $row) {
				$details[] = array(
					"course_id" => $id,
					"subject_id" => $row['subj_id'],
				);
			}
			$this->site_model->add_tbl_batch('course_subjects',$details);
		}
		$items = sess('items');
		if(count($items) > 0){
			$details = array();
			foreach ($items as $ctr => $row) {
				$details[] = array(
					"course_id" => $id,
					"item_id" => $row['item_id'],
					"qty" => $row['qty'],
				);
			}
			$this->site_model->add_tbl_batch('course_items',$details);
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
	}
	public function batches(){
		$data = $this->syter->spawn('batches');
		$data['code'] = listPage(fa('fa-map-o')." Batches",'course_batches','academic/batches_form','list','list',false);
		$this->load->view('list',$data);
	}
	public function batches_form($id=null){
		$data = $this->syter->spawn('batches');
		$data['page_title'] = fa('fa-map-o')." Course Batch";
		$data['page_subtitle'] = "Add Batch";
		$det = array();
		$sections = array();
		if($id != null){
			$details = $this->site_model->get_tbl('course_batches',array('id'=>$id));
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit Batch ".ucwords(strtolower($det->name));

				$select   = "course_batch_sections.*,sections.code as sec_code,sections.name as sec_name,
						     users.fname,users.lname,users.mname,users.suffix";
				$join['sections']='course_batch_sections.section_id = sections.id';
				$join['users']='course_batch_sections.teacher_id = users.id';
				$result = $this->site_model->get_tbl('course_batch_sections',array('batch_id'=>$id),array(),$join,true,$select);
				foreach ($result as $res) {
					$name = ucFix($res->fname." ".$res->mname." ".$res->lname." ".$res->suffix);
					$sections[] = array(
						"sec_id" => $res->section_id,
						"sec_name" => $res->sec_name,
						"teacher_id" => $res->teacher_id,
						"teacher_name" => $name,
					);
				}
			}
		}
		sess_initialize("sections",$sections);
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'academic/batches"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = batchesPage($det,$sections);
		$data['load_js'] = 'school/academic';
		$data['use_js'] = 'batchesFormJs';
		$this->load->view('page',$data);
	}
	public function batches_add_section($sec_id=null,$teacher_id=null){
		$sections = sess('sections');
		$status = "success";
		$msg    = "";
		$check  = true;
		$row    = array();
		$id 	= null;
		if(count($sections) > 0){
			foreach ($sections as $ctr => $row) {
				if($row['sec_id'] == $sec_id){
					$check = false;
					$status = "error";
					$msg    = "Section is already added.";
					break;
				}	
			}
			foreach ($sections as $ctr => $row) {
				if($row['teacher_id'] == $teacher_id){
					$check = false;
					$status = "error";
					$msg    = "Teacher is already added.";
					break;
				}	
			}
		}
		if($check){
			$sec_details = $this->site_model->get_tbl('sections',array('id'=>$sec_id));
			if(count($sec_details) > 0){
				$det = $sec_details[0];
				$row = array('sec_id'=>$det->id,'sec_name'=>$det->name); 
			}
			$tea_details = $this->site_model->get_tbl('users',array('id'=>$teacher_id),array(),null,true,'id,fname,mname,lname,suffix');
			if(count($tea_details) > 0){
				$det = $tea_details[0];
				$name = ucFix($det->fname." ".$det->mname." ".$det->lname." ".$det->suffix);
				$row['teacher_id']=$det->id;
				$row['teacher_name']=$name; 
			}
			if(count($sec_details) > 0 && count($tea_details) > 0){
				$cart = sess_add('sections',$row);
				$id = $cart['id'];
				$msg   = "Section Added.";				
			}
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg,'row'=>$row,'id'=>$id));
	}
	public function batch_remove_section($id=null){
		sess_delete('sections',$id);
	}
	public function batches_db($id=null){
		$user = sess('user');
		$items = array(
		    "name"=>$this->input->post('name'),
		    "code"=>$this->input->post('code'),
		    "course_id"=>$this->input->post('course_id'),
		    "start_date"=>date2Sql($this->input->post('start_date')),
		    "end_date"=>date2Sql($this->input->post('end_date')),
		);
		$error = 0;
		$msg = "";
		if(!$this->input->post('id')){
			$id = $this->site_model->add_tbl('course_batches',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
			$msg = "Added New Batch ".$items['name'];
		}
		else{
			$id = $this->input->post('id');
			$this->site_model->update_tbl('course_batches','id',$items,$id);
			$msg = "Updated Batch ".$items['name'];
			$this->site_model->delete_tbl('course_batch_sections',array('batch_id'=>$id));
		}
		$sections = sess('sections');
		if(count($sections) > 0){
			$details = array();
			foreach ($sections as $ctr => $row) {
				$details[] = array(
					"batch_id" => $id,
					"section_id" => $row['sec_id'],
					"teacher_id" => $row['teacher_id'],
				);
			}
			$this->site_model->add_tbl_batch('course_batch_sections',$details);
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
	}
	public function subjects(){
		$data = $this->syter->spawn('subjects');
		$data['code'] = listPage(fa('fa-book')." Subjects",'subjects','academic/subjects_form','list','list',false);
		$this->load->view('list',$data);
	}
	public function subjects_form($id=null){
		$data = $this->syter->spawn('subjects');
		$data['page_title'] = fa('fa-book')." Subjects";
		$data['page_subtitle'] = "Add Subject";
		$det = array();
		$img = array();
		if($id != null){
			$details = $this->site_model->get_tbl('subjects',array('id'=>$id));
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit Sunject ".ucwords(strtolower($det->name));
			}
		}
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-new-btn" class="btn-flat btn-flat btn btn-info"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE AS NEW");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'academic/subjects"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = subjectsPage($det);
		$data['load_js'] = 'school/academic';
		$data['use_js'] = 'subjectsFormJs';
		$this->load->view('page',$data);
	}
	public function subjects_db($id=null){
		$user = sess('user');
		$items = array(
		    "name"=>$this->input->post('name'),
		    "code"=>$this->input->post('code'),
		    "description"=>$this->input->post('description'),
		);
		$error = 0;
		$msg = "";
		if($this->input->post('new')){
			$id = $this->site_model->add_tbl('subjects',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
			$msg = "Added New Subject ".$items['name'];
		}
		else{
			if(!$this->input->post('id')){
				$id = $this->site_model->add_tbl('subjects',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
				$msg = "Added New Subject ".$items['name'];
			}
			else{
				$id = $this->input->post('id');
				$this->site_model->update_tbl('subjects','id',$items,$id);
				$msg = "Updated Subject ".$items['name'];
			}
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
	}
	public function sections(){
		$data = $this->syter->spawn('sections');
		$data['code'] = listPage(fa('fa-flag')." Sections",'sections','academic/sections_form','list','list',false);
		$this->load->view('list',$data);
	}
	public function sections_form($id=null){
		$data = $this->syter->spawn('sections');
		$data['page_title'] = fa('fa-flag')." Sections";
		$data['page_subtitle'] = "Add New Section";
		$det = array();
		$img = array();
		if($id != null){
			$details = $this->site_model->get_tbl('sections',array('id'=>$id));
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit Section ".ucwords(strtolower($det->name));
			}
		}
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'academic/sections"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = sectionsPage($det);
		$data['load_js'] = 'school/academic';
		$data['use_js'] = 'sectionsFormJs';
		$this->load->view('page',$data);
	}
	public function sections_db($id=null){
		$user = sess('user');
		$items = array(
		    "name"=>$this->input->post('name'),
		    "code"=>$this->input->post('code'),
		);
		$error = 0;
		$msg = "";
		if($this->input->post('new')){
			$id = $this->site_model->add_tbl('sections',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
			$msg = "Added New Section ".$items['name'];
		}
		else{
			if(!$this->input->post('id')){
				$id = $this->site_model->add_tbl('sections',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
				$msg = "Added New Section ".$items['name'];
			}
			else{
				$id = $this->input->post('id');
				$this->site_model->update_tbl('sections','id',$items,$id);
				$msg = "Updated Section ".$items['name'];
			}
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
	}	
	public function schedule_form($id=null){
		$data = $this->syter->spawn('schedule');
		$schedules = array();
		sess_initialize('schedules',$schedules);
		$data['page_title'] = fa('fa-clock-o')." Schedule";
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['code'] = schedulePage();
		$data['add_css'] = 'plugins/fullcalendar/fullcalendar.min.css';
		$data['add_js'] = 'plugins/fullcalendar/fullcalendar.min.js';
		$data['load_js'] = 'school/academic';
		$data['use_js'] = 'scheduleFormJs';
		$this->load->view('page',$data);
	}
	public function schedule_pop($id=null){
		$schedules = sess('schedules');
		
		$det = array();
		if($id != null){
			if(isset($schedules[$id]))
				$det = $schedules[$id];
		}
		$this->html->sForm();
		    $this->html->subjectsDropPaper('Subject','subject',iSet($det,'subject'));
		    $this->html->teachersDropPaper('Teacher','teacher',iSet($det,'teacher'));
		$this->html->eForm();
		$data['code'] = $this->html->code();
		$this->load->view('load',$data); 
	}
	public function schedule_cart(){
		$schedules = sess('schedules');
		$event_id = $this->input->post('event_id');

		if($this->input->post('update_event_id')){
			$event_id = $this->input->post('update_event_id');
			if(isset($schedules[$event_id])){
				$sched = $schedules[$event_id];
				$sched['subject'] = $this->input->post('subject');
				$sched['teacher'] = $this->input->post('teacher');
				$schedules[$event_id] = $sched;
				sess_update('schedules',$event_id,$sched);
				
			}
		}
		else if($this->input->post('delete_event_id')){
			$event_id = $this->input->post('delete_event_id');
			sess_delete('schedules',$event_id);
		}
		else{
			$sched = array(
	        	'event_id' 	=> $event_id,
				'start' 	=> $this->input->post('start'),
				'end' 		=> $this->input->post('end'),
				'subject' 	=> $this->input->post('subject'),
				'teacher' 	=> $this->input->post('teacher'),
			);		
			sess_add('schedules',$sched,$event_id);
		}
		// echo var_dump(sess('schedules'));
	}
	public function schedule_db(){
		$schedules = sess('schedules');
		$error = 0;
		$msg = "";
		if(count($schedules) > 0){
			$sched = array();
			foreach ($schedules as $ctr => $row) {
				$day = date('D',strtotime($row['start']));
				$start = time2Sql($row['start']);
				$end = time2Sql($row['end']);
				$sched[] = array(
					'course_id'  => $this->input->post('course'),
					'batch_id'   => $this->input->post('batch'),
					'section_id' => $this->input->post('section'),
					'teacher_id' => $row['teacher'],
					'subject_id' => $row['subject'],
					'start_time' => $start,
					'end_time' 	 => $end,
					'day' 	 	 => $day,
				);
			}
			$args['batch_id'] = $this->input->post('batch');
			$args['section_id'] = $this->input->post('section');
			$this->site_model->delete_tbl('course_batch_schedules',$args);
			$this->site_model->add_tbl_batch('course_batch_schedules',$sched);
			$msg = "Updated Time Schedule";
		}
		else{
			$msg = "No Schedule found.";
			$error = 1;
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
	}
	public function schedule_load($batch_id,$section_id){
        $args = array();
        $join = array();
        $order = array();
        $table = 'course_batch_schedules';
        $select = 'course_batch_schedules.*,
        		   subjects.name as subject_name,
        		   users.fname,users.lname,users.mname,users.suffix,
        		  ';
        $join['subjects'] = "course_batch_schedules.subject_id = subjects.id";
        $join['users'] = "course_batch_schedules.teacher_id = users.id";
        $args['course_batch_schedules.batch_id'] = $batch_id;
        $args['course_batch_schedules.section_id'] = $section_id;
        $order['course_batch_schedules.day'] = 'desc';
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select);
        $json = array();
        sess_initialize('schedules',array());
        if(count($items) > 0){
        	$ctr = 1;
            foreach ($items as $res) {
            	$name = $res->fname." ".$res->mname." ".$res->lname." ".$res->suffix;
                $start = null;
                $end = null;
                switch (strtolower($res->day)){
                	case 'mon':
                		$start = '2016-07-04T'.$res->start_time;
                		$end = '2016-07-04T'.$res->end_time;
                		break;
                	case 'tue':
                		$start = '2016-07-05T'.$res->start_time;
                		$end = '2016-07-05T'.$res->end_time;
                		break;
                	case 'wed':
                		$start = '2016-07-06T'.$res->start_time;
                		$end = '2016-07-06T'.$res->end_time;
                		break;
                	case 'thu':
                		$start = '2016-07-07T'.$res->start_time;
                		$end = '2016-07-07T'.$res->end_time;
                		break;
                	case 'fri':
                		$start = '2016-07-08T'.$res->start_time;
                		$end = '2016-07-08T'.$res->end_time;
                		break;
                	case 'sat':
                		$start = '2016-07-09T'.$res->start_time;
                		$end = '2016-07-09T'.$res->end_time;
                		break;
                	case 'sun':
                		$start = '2016-07-03T'.$res->start_time;
                		$end = '2016-07-03T'.$res->end_time;
                		break;
                }
                $json[$ctr] = array(
                    "event_id"=>$ctr,   
                    "subject"=>$res->subject_id,   
                    "subject_name"=>ucFix($res->subject_name),   
                    "teacher"=>$res->teacher_id,   
                    "teacher_name"=>ucFix($name),   
                    "start"=>$start,
                    "end"=>$end
                );
                sess_add('schedules',$json[$ctr],$ctr);
                $ctr++;
            }
        }
        echo json_encode(array('details'=>$json));
    }
}
