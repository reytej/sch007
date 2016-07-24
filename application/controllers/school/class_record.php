<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Class_record extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('school/Class_record_helper');
	}
	public function attendance(){
		$user = sess('user');
		$data = $this->syter->spawn('cr_attendance');
		$data['code'] = listPage(fa('fa-calendar')." Attendance",'classes/'.$user['id'],'','list','list',false);
		$this->load->view('list',$data);
	}
	public function attendance_form($batch_id=null,$sect_id=null,$subj_id=null){
		$data = $this->syter->spawn('cr_attendance');
		$user = sess('user');
		$subj = $this->site_model->get_custom_val('subjects','id,name','id',$subj_id);
		$sect = $this->site_model->get_custom_val('sections','id,name','id',$sect_id);
		$data['page_title'] = fa('fa-flag')." ".ucFix($subj->name);
		$data['page_subtitle'] = "Section ".ucFix($sect->name);
		$now = $this->site_model->get_db_now();
		
		// $class = $this->get_class($user['id'],$batch_id,$sect_id,$subj_id);
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'class_record/attendance"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = attendanceForm($now,$user['id'],$batch_id,$sect_id,$subj_id);
		$data['add_js'] = 'plugins/bootstrap-toggle/bootstrap-toggle.min.js';
		$data['add_css'] = 'plugins/bootstrap-toggle/bootstrap-toggle.min.css';
		$data['load_js'] = 'school/class_record';
		$data['use_js'] = 'attendanceJs';
		// $data['no_padding'] = true;
		$this->load->view('page',$data);
	}
	public function attendance_load(){
		$json = array();
		$now = $this->site_model->get_db_now();

		$teacher = $this->input->post('teacher');
		$batch_id = $this->input->post('batch_id');
		$sect_id = $this->input->post('sect_id');
		$subj_id = $this->input->post('subj_id');
		$class = $this->get_class($teacher,$batch_id,$sect_id,$subj_id);
		$attendance = $this->get_attendance($teacher,$batch_id,$sect_id,$subj_id,date2Sql($this->input->post('from_date')),date2Sql($this->input->post('to_date')));
		$json['thead'] = "";
			// $months = getDatesOfMonths();
			$dates = createDateRangeArray(date2Sql($this->input->post('from_date')),date2Sql($this->input->post('to_date')) );
			$this->html->sRow();
				$this->html->th('',array('class'=>'headcol'));
				foreach ($dates as $val) {
					$this->html->th(strtoupper(date('D',strtotime($val))),array('style'=>'width:150px;text-align:center;font-weight:bold;background-color:#72AFD2;color:#fff'));
				}
			$this->html->eRow();
			$this->html->sRow();
				$this->html->th('STUDENT',array('class'=>'headcol','style'=>'background-color:#72AFD2;color:#fff'));
				foreach ($dates as $val) {
					$this->html->th(date('d',strtotime($val)),array('style'=>'width:150px;text-align:center;border-top:2px solid #f4f4f4;font-weight:normal;background-color:#fff;'));
				}
			$this->html->eRow();
			$json['thead'] = $this->html->code();
		$json['tbody'] = "";
			foreach ($class as $std_id => $std) {
				$this->html->sRow();
					$this->html->td($std['name'],array('class'=>'headcol','style'=>'height:40px;padding-top:10px;'));
					foreach ($dates as $val) {
						$today = sql2Date($now);
						$date = sql2Date($val);
						$this->html->sTd(array('style'=>'width:150px;text-align:center;'));
							if(strtotime($now) > strtotime($date)){
								$day = strtolower(date('D',strtotime($val)));
								if($std[$day]){
									$params = array('student'=>$std_id,'date'=>sql2Date($val),'class'=>'dates','data-on'=>'Present','data-off'=>'Absent','data-style'=>'ios','data-onstyle'=>'success','data-offstyle'=>'danger','data-size'=>'small');
									foreach ($attendance as $ctr => $row) {
										if($row['student_id'] == $std_id && sql2Date($row['trans_date']) == sql2Date($val)){
											// echo $std_id." - ".sql2Date($row['trans_date']).' - '.$row['status'];
											if($row['status'] == 'present'){
												$params['checked'] = '';
											}
										}
									}
									$this->html->checkbox(null,'date-'.$std_id.'-'.date('mdy',strtotime($val)),1,$params);

								}
							}
							else $this->html->span('&nbsp;');
						$this->html->eTd();
					}
				$this->html->eRow();
			}
			$json['tbody'] = $this->html->code();
		echo json_encode($json);
	}
	public function attendance_db(){
		$user = sess('user');
		$items = array(
			"student_id" 	=> $this->input->post('student'),
			"batch_id" 		=> $this->input->post('batch_id'),
			"section_id" 	=> $this->input->post('sect_id'),
			"subject_id"	=> $this->input->post('subj_id'),
			"teacher_id"	=> $this->input->post('teacher'),
			"trans_date"	=> date2Sql($this->input->post('date')),
			"status" 		=> $this->input->post('status'),
		);
		$args['trans_date'] = date2Sql($this->input->post('date'));
		$args['batch_id'] = $this->input->post('batch_id');
		$args['student_id'] = $this->input->post('student');
		$args['subject_id'] = $this->input->post('subj_id');
		$args['section_id'] = $this->input->post('sect_id');
		$args['teacher_id'] = $this->input->post('teacher');
		$this->site_model->delete_tbl('student_attendance',$args);
		$id = $this->site_model->add_tbl('student_attendance',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
	}
	public function get_class($teacher,$batch,$section,$subject){
		$class  = array();
		$args   = array();
		$join   = array();
		$order  = array();
		$group  = null;
		$table  = 'enrolls';
		$select = 'enrolls.student_id,
				   students.fname as std_fname,students.mname as std_mname,students.lname as std_lname,students.suffix as std_suffix,
				   course_batch_schedules.day,course_batch_schedules.start_time,course_batch_schedules.end_time,
		          ';
		$join['students'] = array("content"=>"enrolls.student_id = students.id","mode"=>"left");
		$join['course_batch_schedules'] = array("content"=>"enrolls.batch_id = course_batch_schedules.batch_id AND enrolls.section_id = course_batch_schedules.section_id",
														   "mode"=>"left");
	    $args['course_batch_schedules.teacher_id'] = $teacher;
	    $args['course_batch_schedules.batch_id'] = $batch;
	    $args['course_batch_schedules.section_id'] = $section;
	    $args['course_batch_schedules.subject_id'] = $subject;
	    $args['enrolls.inactive'] = 0; 
	   	$order = array('students.fname'=>'asc');
		$items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,$group);
		if(count($items) > 0){
		    foreach ($items as $res) {
				$name  = $res->std_fname." ".$res->std_mname." ".$res->std_lname." ".$res->std_suffix;
		    	$days = array('mon'=>false,'tue'=>false,'wed'=>false,'thu'=>false,'fri'=>false,'sat'=>false,'sun'=>false);
		    	$days[strtolower($res->day)] = true;
		    	if(!isset($class[$res->student_id])){
		    		$class[$res->student_id] = array(
		    			"name" => ucFix($name),
		    			"mon"  => $days['mon'],
		    			"tue"  => $days['tue'],
		    			"wed"  => $days['wed'],
		    			"thu"  => $days['thu'],
		    			"fri"  => $days['fri'],
		    			"sat"  => $days['sat'],
		    			"sun"  => $days['sun'],
		    		);
		    	}
		    	else{
		    		$cl = $class[$res->student_id];
		    		$cl[strtolower($res->day)] = $days[strtolower($res->day)];
		    		$class[$res->student_id] = $cl;
		    	}
		    }
		}
		return $class;
	}
	public function get_attendance($teacher,$batch,$section,$subject,$start_date,$to_date){
			$json  = array();
			$args   = array();
			$join   = array();
			$order  = array();
			$group  = null;
			$table  = 'student_attendance';
			$select = 'student_attendance.student_id,trans_date,status';
			
		    $args['student_attendance.teacher_id'] = $teacher;
		    $args['student_attendance.batch_id']   = $batch;
		    $args['student_attendance.section_id'] = $section;
		    $args['student_attendance.subject_id'] = $subject;
		    $args["DATE(trans_date) >= '".date2Sql($start_date)."'"] = array('use'=>'where','val'=>"",'third'=>false);
		    $args["DATE(trans_date) <= '".date2Sql($to_date)."'"] = array('use'=>'where','val'=>"",'third'=>false);
			$items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,$group);

			if(count($items) > 0){
			    foreach ($items as $res) {
					$json[] = array(
						'student_id'=>$res->student_id,
						'trans_date'=>$res->trans_date,
						'status'=>$res->status,
					);
			    }
			}
			return $json;
	}
	public function activities(){
		$user = sess('user');
		$data = $this->syter->spawn('cr_activities');
		$data['code'] = listPage(fa('fa-star')." Activities",'classes/'.$user['id'].'/activites','','list','list',false);
		$this->load->view('list',$data);
	}
	public function activities_list($batch_id=null,$sect_id=null,$subj_id=null){
		$data = $this->syter->spawn('cr_attendance');
		$user = sess('user');
		$subj = $this->site_model->get_custom_val('subjects','id,name','id',$subj_id);
		$sect = $this->site_model->get_custom_val('sections','id,name','id',$sect_id);
		$data['code'] = listPage(fa('fa-star')." ".ucFix($subj->name)." Activities <small>".ucFix($sect->name)."</small>",'classes/'.$user['id'].'/activites','class_record/activities_form/'.$batch_id.'/'.$sect_id.'/'.$subj_id,'list','list',false);
		$this->load->view('list',$data);
	}
	public function activities_form($batch_id=null,$sect_id=null,$subj_id=null){
		$data = $this->syter->spawn('cr_attendance');
		$user = sess('user');
		$subj = $this->site_model->get_custom_val('subjects','id,name','id',$subj_id);
		$sect = $this->site_model->get_custom_val('sections','id,name','id',$sect_id);
		$data['page_title'] = fa('fa-flag')." ".ucFix($subj->name);
		$data['page_subtitle'] = "Section ".ucFix($sect->name);
		$now = $this->site_model->get_db_now();
		
		// $class = $this->get_class($user['id'],$batch_id,$sect_id,$subj_id);
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'class_record/activities_list/'.$batch_id.'/'.$sect_id.'/'.$subj_id.'"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = "";
		$data['add_js'] = 'plugins/bootstrap-toggle/bootstrap-toggle.min.js';
		$data['add_css'] = 'plugins/bootstrap-toggle/bootstrap-toggle.min.css';
		$data['load_js'] = 'school/class_record';
		$data['use_js'] = 'attendanceJs';
		// $data['no_padding'] = true;
		$this->load->view('page',$data);
	}
}
