<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enrollment extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('school/enrollment_helper');
	}
	public function form(){
		$data = $this->syter->spawn('enroll');
		$data['page_title'] = fa('fa-pencil')." Enrollment";
		$data['code'] = enrollmentForm();
		// $data['load_js'] = 'school/students';
		// $data['use_js'] = 'studentProfileJs';
		$this->load->view('page',$data);
	}
}
