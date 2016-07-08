<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('school/payment_helper');
	}
	public function index(){
		$data = $this->syter->spawn('enroll_pay');
		$data['code'] = listPageCustom('payments-list',fa('fa-money')." Student Payments",'payments','payment/form','list','list',true);
		$data['load_js'] = 'school/payment';
		$data['use_js']  = 'paymentListJs';
		$this->load->view('list',$data);
	}
	public function form($id=null){
		$data = $this->syter->spawn('enroll_pay');
		$data['page_title'] = fa('fa-money')." Payment Entry";
		$now = $this->site_model->get_db_now();

		$next_ref = $this->site_model->get_next_ref(PAYMENT);
		$payments = array();
		
		sess_initialize('payments',$payments);
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'payment"','text'=>"<i class='fa fa-fw fa-table'></i>");
		$data['code'] = paymentForm($now,$next_ref);
		$data['load_js'] = 'school/payment';
		$data['use_js'] = 'paymentFormJs';
		$this->load->view('page',$data);
	}
	public function db(){
		$trans_type = PAYMENT;
		$reference = $this->input->post('trans_ref');
		$user = sess('user');

		$payments 	= sess('payments');
		$total_amount = $this->input->post('total-allocate');
		$tenders = $this->input->post('tender');
		$enrolls = $this->input->post('enrolls');

		$details = array(
			"trans_ref"  => $reference,
			"student_id" => $this->input->post('student'),
			"trans_date" => date2Sql($this->input->post('trans_date')),
			"total_amount" => $total_amount,
			"remarks"  => $this->input->post('remarks'),
		);

		$error = 0;
		$msg = "";
		$id = 0;
		$check = $this->site_model->ref_unused(PAYMENT,$reference);
		if($check){
			$id = $this->site_model->add_tbl('payments',$details,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
			$msg = "Payment Successfull. Reference #".$reference;	
			$this->site_model->save_ref(PAYMENT,$reference);			
		}
		else{
			$error = 1;
			$msg = "Reference number ".$reference." is already used.";
		}
		if($id != 0){
			$pay = array();
			foreach ($payments as $ctr => $pyt) {
				$branch = "";
				if($pyt['branch']){
					$branch = $pyt['branch'];
				}
				$app_code = "";
				if($pyt['approval_code']){
					$app_code = $pyt['approval_code'];
				}
				$check_date = null;
				if($pyt['check_date']){
					$check_date = date2Sql($pyt['check_date']);
				}
				$pay[] = array(
					"pay_id" 		=> $id,
					"type" 			=> $pyt['type'],
					"amount" 		=> $pyt['amount'],
					"bank"			=> $pyt['bank'],
					"branch"		=> $branch,
					"ref_no" 		=> $pyt['ref_no'],
					"check_date"	=> $check_date,
					"approval_code"	=> $app_code,
				);
			}
			if(count($pay) > 0){
				$this->site_model->add_tbl_batch('payment_details',$pay);
			}
			$ten = array();
			foreach ($tenders as $en_py_id => $tnd) {
				if($tnd > 0){
					$enroll_id = null;
					if(isset($enrolls[$en_py_id]))
						$enroll_id = $enrolls[$en_py_id];
					$ten[] = array(
						"pay_id" 		=> $id,
						"src_type" 		=> ENROLLMENT,
						"src_id" 		=> $enroll_id,
						"src_det_id"	=> $en_py_id,
						"amount"		=> $tnd,
					);
				}
			}
			if(count($ten) > 0){
				$this->site_model->add_tbl_batch('payment_for',$ten);
				foreach ($tenders as $en_py_id => $tnd) {
					if($tnd > 0){
						$args = array('pay_date'=>date2Sql($this->input->post('trans_date')));
						$set = array('pay'=>'pay+'.$tnd);
						$this->site_model->update_tbl('enroll_payments','id',$args,$en_py_id,$set);
					}
				}	
			}
		}	
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg,"id"=>$id));
	}
	public function add_payment_cart(){
		$post = $this->input->post();
		$payments = sess('payments');
		$type = $post['type'];
		$amount = 0;
		if(isset($post[$type.'_amt']))
			$amount = $post[$type.'_amt'];
		$bank = "";
		if(isset($post[$type.'_bank']))
			$bank = $post[$type.'_bank'];
		$ref_no = "";
		if(isset($post['credit_card_no']))
			$ref_no = $post['credit_card_no'];
		if(isset($post['check_no']))
			$ref_no = $post['check_no'];
		$pay = array(
					"type" 			=> $type,
					"amount" 		=> $amount,
					"bank"			=> $bank,
					"branch"		=> $this->input->post('check_branch'),
					"ref_no" 		=> $ref_no,
					"check_date"	=> $this->input->post('check_date'),
					"approval_code"	=> $this->input->post('credit_approval'),
				);
		$sess = sess_add('payments',$pay);
		$json['sess'] = $sess;

		$this->html->sRow(array('id'=>'payments-row-'.$sess['id'],'class'=>'payments-rows'));
			$this->html->td($sess['id'] + 1);
			$this->html->td(strtoupper($type));
			$this->html->td(num($amount));
			$link = $this->html->A(fa('fa-times fa-lg'),'#',array('id'=>'del-pay-'.$sess['id'],'ref'=>$sess['id'],'return'=>true));
			$this->html->td($link);
		$this->html->eRow();
		$json['html'] = $this->html->code();
		echo json_encode($json);
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
						$this->html->input("","tender[".$res->id."]",null,null,array('class'=>'paper-input tenders','id'=>'tender-'.$res->id));
						$this->html->hidden("enrolls[".$res->id."]",$res->enroll_id);
					$this->html->eTd();
					$link = "";
					$link .= $this->html->A(fa('fa-check-circle fa-fw fa-lg'),'#',array('class'=>'all-ins','id'=>'all-in-'.$res->id,'ref'=>$res->id,'return'=>'true'));
					$link .= $this->html->A(fa('fa-times-circle fa-fw fa-lg'),'#',array('class'=>'all-dels','id'=>'all-del-'.$res->id,'ref'=>$res->id,'return'=>'true'));
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
	public function balances(){
		$data = $this->syter->spawn('balance_list');
		$data['code'] = listPageCustom("balance-list",fa('fa-balance-scale')." Balances",'balances',null,'list','list',true);
		$data['load_js'] = 'school/payment';
		$data['use_js']  = 'balancesJs';
		$this->load->view('list',$data);
	}
	public function billings(){
		$data = $this->syter->spawn('billing');
		$data['code'] = billingPage("billing-list",fa('fa-inbox')." Billings",'billings',null,'grid','grid',true);
		$data['load_js'] = 'school/payment';
		$data['use_js']  = 'billingJs';
		$this->load->view('list',$data);
	}
}
