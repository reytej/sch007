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
	public function attendance_form($subj_id=null){
		$data = $this->syter->spawn('cr_attendance');
		$subj = $this->site_model->get_custom_val('subjects','id,name','id',$subj_id);
		$data['page_title'] = fa('fa-flag')." ".ucFix($subj->name);
		$now = $this->site_model->get_db_now();
		$data['code'] = attendanceForm($now);
		
		$data['load_js'] = 'school/class_record';
		$data['use_js'] = 'attendanceJs';
		// $data['no_padding'] = true;
		$this->load->view('page',$data);
	}
	// public function get_class($teacher_id=null,$)
}
