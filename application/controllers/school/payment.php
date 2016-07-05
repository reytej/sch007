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
		$data['load_js'] = 'school/payment';
		$data['use_js'] = 'paymentFormJs';
		$this->load->view('page',$data);
	}
	public function get_student_dues($id=null){
		$json = array();
		$select   = "enroll_payments.*,enrolls.trans_ref";
		$join['enrolls'] = 'enroll_payments.enroll_id = enrolls.id';
		$args['enroll_payments.student_id'] = $id;
		$args['enroll_payments.amount > enroll_payments.pay '] = array('use'=>'where','val'=>"",'third'=>false);
		$order['enroll_payments.due_date'] = 'asc';
		$result = $this->site_model->get_tbl('enroll_payments',$args,$order,$join,true,$select);
		if($result){
			foreach ($result as $res) {
				$this->html->sRow(array('class'=>'dues-rows'));
					$this->html->td($res->trans_ref);
					$particular = "Monthly Payment";
					if($res->type == 'dp')
						$particular = "Down Payment";
					$this->html->td($particular);
					$this->html->td(sql2Date($res->due_date));
					$this->html->td(num($res->amount));
					$this->html->td(num($res->pay));
					$balance = $res->amount - $res->pay;
					$this->html->td(num($balance) ) ;
					$this->html->sTd(array('style'=>'width:120px;'));
						$this->html->input("","tender[".$res->id."]",null,null,array('class'=>'paper-input'));
					$this->html->eTd();
					$link = "";
					$link .= $this->html->A(fa('fa-check-circle fa-fw fa-lg'),'#',array('return'=>'true'));
					$link .= $this->html->A(fa('fa-times-circle fa-fw fa-lg'),'#',array('return'=>'true'));
					$this->html->td($link,array('style'=>'width:80px;'));
				$this->html->eRow();	
			}
		}
		else{
			$this->html->sRow(array('class'=>'dues-rows'));
				$this->html->td('<center>No On Due Payment found.</center>',array('colspan'=>'100%'));
			$this->html->eRow();
		}
		$json['html'] = $this->html->code();
		echo json_encode($json);
	}
}
