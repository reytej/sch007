<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Students extends CI_Controller {
	public function __construct(){
		parent::__construct();
		// $this->load->helper('school/academic_helper');
	}
	public function index(){
		$data = $this->syter->spawn('students');
		$data['code'] = listPage(fa('fa-mortar-board')." Students",'students','students/form','grid','all',true);
		$this->load->view('list',$data);
	}
}
