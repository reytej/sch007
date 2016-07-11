<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Class_record extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function attendance(){
		$user = sess('user');
		$data = $this->syter->spawn('cr_attendance');
		$data['code'] = listPage(fa('fa-calendar')." Attendance",'classes/'.$user['id'],'class_record/attendance_form','list','list',false);
		$this->load->view('list',$data);
	}
	public function attendance_form($subj_id=null){
		
	}
}
