<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Students extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('school/student_helper');
	}
	public function index(){
		$data = $this->syter->spawn('students');
		$data['code'] = listPage(fa('fa-mortar-board')." Students",'students','students/profile','grid','all',true);
		$this->load->view('list',$data);
	}
	public function profile($id=null){
		$data = $this->syter->spawn('students');
		$data['page_title'] = fa('fa-mortar-board')." Student Profile";
		$data['page_subtitle'] = "Add Student";
		$det = array();
		$img = array();
		if($id != null){
			$details = $this->site_model->get_tbl('students',array('id'=>$id));
			if($details){
				$det = $details[0];
				$student = $det->fname." ".$det->mname." ".$det->lname." ".$det->suffix;
				$data['page_subtitle'] = ucwords(strtolower($student));
				$resultIMG = $this->site_model->get_image(null,$det->id,'students');
				if(count($resultIMG) > 0){
				    $img = $resultIMG[0];
				}
			}
		}
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'students"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = studentsProfile($det,$img);
		$data['load_js'] = 'school/students';
		$data['use_js'] = 'studentProfileJs';
		$this->load->view('page',$data);
	}
	public function profile_general($id=null){
		$det = array();
		if($id != null){
			$details = $this->site_model->get_tbl('students',array('id'=>$id));
			if($details){
				$det = $details[0];
			}
		}
		$data['code'] = generalDetails($det);
		$data['load_js'] = 'school/students';
		$data['use_js'] = 'profileGeneralJs';
		$this->load->view('load',$data);
	}
}
