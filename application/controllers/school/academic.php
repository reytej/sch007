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
			}
		}
		sess_initialize("subjects",$subjects);
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'academic/courses"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = coursesPage($det,$subjects);
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
		$img = array();
		if($id != null){
			$details = $this->site_model->get_tbl('course_batches',array('id'=>$id));
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit Batch ".ucwords(strtolower($det->name));
			}
		}
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'academic/batches"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = batchesPage($det);
		$data['load_js'] = 'school/academic';
		$data['use_js'] = 'batchesFormJs';
		$this->load->view('page',$data);
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
}
