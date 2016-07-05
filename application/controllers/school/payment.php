<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('school/payment_helper');
	}
	// public function index(){
	// 	$data = $this->syter->spawn('students');
	// 	$data['code'] = listPage(fa('fa-mortar-board')." Students",'students','students/profile','grid','all',true);
	// 	$this->load->view('list',$data);
	// }
	public function form($id=null){
		$data = $this->syter->spawn('enroll_pay');
		$data['page_title'] = fa('fa-money')." Student Payment";
		$now = $this->site_model->get_db_now();

		$next_ref = $this->site_model->get_next_ref(PAYMENT);

		$data['code'] = paymentForm($now,$next_ref);
		// $data['load_js'] = 'school/students';
		// $data['use_js'] = 'studentProfileJs';
		$this->load->view('page',$data);
	}
}
