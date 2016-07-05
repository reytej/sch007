<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Enrollment extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('school/enrollment_helper');
	}
	public function index(){
		$data = $this->syter->spawn('enroll_list');
		$data['code'] = listPage(fa('fa-bookmark')." Enrollments",'enrolls','enrollment/form','list','list',true);
		$this->load->view('list',$data);
	}
	public function form($id=null){
		$data = $this->syter->spawn('enroll');
		$data['page_title'] = fa('fa-bookmark')." Enrollment";
		$now = $this->site_model->get_db_now();
		
		$enroll 	= array();
		$details 	= array();
		$subjects 	= array();
		$items 		= array();
		$payments 	= array();
		$img 		= array();
		
		$next_ref = $this->site_model->get_next_ref(ENROLLMENT);
		if($id != null){
			$result = $this->site_model->get_tbl('enrolls',array('id'=>$id));
			if($result)
				$enroll = $result[0];
			if(isset($enroll->id)){
				$details = $this->get_enroll_details($enroll->id,false);
				$next_ref = $enroll->trans_ref;
				
				$subjects 	= $details['subjects'];
				$items 		= $details['items'];
				$payments 	= $details['payments'];

				$resultIMG = $this->site_model->get_image(null,$enroll->student_id,'students');
				if(count($resultIMG) > 0){
				    $img = $resultIMG[0];
				}
			}
		}

		sess_initialize('subjects',$subjects);
		sess_initialize('items',$items);
		sess_initialize('payments',$payments);
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'enrollment"','text'=>"<i class='fa fa-fw fa-table'></i>");
		$data['code'] = enrollmentForm($now,$next_ref,$enroll,$details,$img);
		$data['load_js'] = 'school/enrollment';
		$data['use_js'] = 'enrollmentJs';
		$this->load->view('page',$data);
	}
	public function db(){
		$trans_type = ENROLLMENT;
		$reference = $this->input->post('trans_ref');
		$user = sess('user');

		$subjects 	= sess('subjects');
		$items 		= sess('items');
		$payments 	= sess('payments');

		$date_range = $this->input->post('date_range');
		$date = explode(' - ', $date_range);
		$total_amount = 0;
		foreach ($payments as $ctr => $pay) {
			$total_amount += $pay['amount'];
		}

		$details = array(
			"trans_ref"  => $reference,
			"student_id" => $this->input->post('student'),
			"course_id"  => $this->input->post('course'),
			"batch_id"   => $this->input->post('batch'),
			"section_id" => $this->input->post('section'),
			"pay_term_id" => $this->input->post('pay_term_id'),
			"no_months" => $this->input->post('no_months'),
			"day_of_month" => $this->input->post('day_of_month'),
			"total_amount" => $total_amount,
			"trans_date" => date2Sql($this->input->post('trans_date')),
			"start_date"  => date2Sql($date[0]),
			"end_date"    => date2Sql($date[1])
		);

		$error = 0;
		$msg = "";
		$id = 0;
		if(!$this->input->post('enroll_id')){
			$check = $this->site_model->ref_unused(ENROLLMENT,$reference);
			if($check){
				$id = $this->site_model->add_tbl('enrolls',$details,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
				$msg = "Student Enrolled. Reference #".$reference;	
				$this->site_model->save_ref(ENROLLMENT,$reference);			
			}
			else{
				$error = 1;
				$msg = "Reference number is already used.";
			}
		}
		else{
			$id = $this->input->post('enroll_id');
			$this->site_model->update_tbl('enrolls','id',$details,$id);
			$msg = "Student Updated Enrollment. Reference #".$reference;	
			$this->site_model->delete_tbl('enroll_subjects',array('enroll_id'=>$id));
			$this->site_model->delete_tbl('enroll_items',array('enroll_id'=>$id));
			$this->site_model->delete_tbl('enroll_payments',array('enroll_id'=>$id));
		}
		if($id != 0){
			$sub = array();
			foreach ($subjects as $ctr => $subj) {
				$sub[] = array(
					"enroll_id" => $id,
					"subject_id" => $subj['subj_id'],
				);
			}
			if(count($sub) > 0){
				$this->site_model->add_tbl_batch('enroll_subjects',$sub);
			}
			$ite = array();
			foreach ($items as $ctr => $item) {
				$ite[] = array(
					"enroll_id" => $id,
					"item_id" => $item['item_id'],
					"qty" => $item['qty'],
					"uom" => $item['uom'],
					"price" => $item['price'],
				);
			}
			if(count($ite) > 0){
				$this->site_model->add_tbl_batch('enroll_items',$ite);
			}
			$pay = array();
			foreach ($payments as $ctr => $paym) {
				$pay[] = array(
					"enroll_id" => $id,
					"student_id" => $this->input->post('student') ,
					"type" => $paym['type'],
					"amount" => $paym['amount'],
					"due_date" => $paym['due_date'],
				);
			}
			if(count($pay) > 0){
				$this->site_model->add_tbl_batch('enroll_payments',$pay);
			}
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg,"id"=>$id));
	}
	public function cart_months(){
		$post = $this->input->post();
		$payments = array();
		$json = array();
		$total = 0;
		$down_payment = 0;
		if($post['total_payment'] != "")
			$total = $post['total_payment'];
		$no_months = $post['no_months'];
		$day_of_month = $post['day_of_month'];
		$dp_use_1 = $post['dp_use_1'];
		$date_range = $post['date_range'];
		$date = explode(' - ', $date_range);

		$amt_due = 0;
		if($total > 0)
			$amt_due = $total;

		$row = "";
		$ctr = 1;
		$due_date = $date[0];		
		$dateY = date("Y", strtotime($due_date));
		// $dateM = date("m", strtotime($due_date . " +1 Months"));
		$dateM = date("m", strtotime($due_date));
		$due_date = $dateY."-".$dateM."-".$day_of_month;

		if($dp_use_1 == 1){
			$this->html->sRow(array('class'=>'pay-rows'));
				$this->html->td($ctr);
				$this->html->td('Down Payment');
				$this->html->td(sql2Date($due_date));
				$this->html->td(num($amt_due));
			$this->html->eRow();
			$payments[] = array(
				"type" 	   => "dp",
				"due_date" => $due_date,
				"amount"   => $amt_due,
			);
			$no_months -= 1;
			$due_date = date("Y-m-d", strtotime($due_date . " +1 Months"));
		}
		for ($i=0; $i < $no_months; $i++) { 
			$ctr += 1;
			$this->html->sRow(array('class'=>'pay-rows'));
				$this->html->td($ctr);
				$this->html->td('Monthly Payment');
				$this->html->td(sql2Date($due_date));
				$this->html->td(num($amt_due));
			$this->html->eRow();
			$payments[] = array(
				"type" 	   => "month",
				"due_date" => $due_date,
				"amount"   => $amt_due,
			);
			$due_date = date("Y-m-d", strtotime($due_date . " +1 Months"));
		}
		$total_payment = 0;
		foreach ($payments as $num => $pay) {
			$total_payment += $pay['amount'];
		}
		$this->html->sRow(array('class'=>'pay-rows'));
			$this->html->td('');
			$this->html->td('');
			$this->html->td('<b>Total Payment</b>');
			$this->html->td("<b>".num($total_payment)."</b>");
		$this->html->eRow();
		$json['html'] = $this->html->code();
		$json['payments'] = $payments;
		sess_initialize('payments',$payments);
		echo json_encode($json);
	}
	public function get_enroll_details($id=null,$asJson=true){
		$json = array();
		$subjects = array();
		$items = array();
		$payments = array();
		$select   = "enroll_subjects.*,subjects.code as subj_code,subjects.name as subj_name";
		$result = $this->site_model->get_tbl('enroll_subjects',array('enroll_id'=>$id),array(),array('subjects'=>'enroll_subjects.subject_id = subjects.id'),true,$select);
		foreach ($result as $res) {
			$subjects[] = array(
				"subj_id" => $res->subject_id,
				"subj_code" => $res->subj_code,
				"subj_name" => $res->subj_name,
			);
		}
		$json['subjects'] = $subjects;
		$select   = "enroll_items.*,items.code as item_code,items.name as item_name,items.uom as item_uom,items.price as item_price";
		$result   = $this->site_model->get_tbl('enroll_items',array('enroll_id'=>$id),array(),array('items'=>'enroll_items.item_id = items.id'),true,$select);
		foreach ($result as $res) {
			$items[] = array(
				'item_id' => $res->item_id,
				'qty' => $res->qty,
				'uom' => $res->item_uom,
				'price' => $res->item_price,
				'item_name' => "[".$res->item_code."]".$res->item_name
			);
		}
		$json['items'] = $items;
		$select   = "enroll_payments.*";
		$result   = $this->site_model->get_tbl('enroll_payments',array('enroll_id'=>$id),array(),array(),true,$select);
		foreach ($result as $res) {
			$payments[] = array(
				"type" 	   => $res->type,
				"due_date" => $res->due_date,
				"amount"   => $res->amount,
			);
		}
		$json['payments'] = $payments;
		if(!$asJson)
			return $json;
		else
			echo json_encode(array($json));
	}	
	public function get_course_details($id=null){
		$subjects = array();
		$items = array();
		$select   = "course_subjects.*,subjects.code as subj_code,subjects.name as subj_name";
		$result = $this->site_model->get_tbl('course_subjects',array('course_id'=>$id),array(),array('subjects'=>'course_subjects.subject_id = subjects.id'),true,$select);
		foreach ($result as $res) {
			$subjects[] = array(
				"subj_id" => $res->subject_id,
				"subj_code" => $res->subj_code,
				"subj_name" => $res->subj_name,
			);
		}
		sess_initialize('subjects',$subjects);
		$select   = "course_items.*,items.code as item_code,items.name as item_name,items.uom as item_uom,items.price as item_price";
		$result   = $this->site_model->get_tbl('course_items',array('course_id'=>$id),array(),array('items'=>'course_items.item_id = items.id'),true,$select);
		foreach ($result as $res) {
			$items[] = array(
				'item_id' => $res->item_id,
				'qty' => $res->qty,
				'uom' => $res->item_uom,
				'price' => $res->item_price,
				'item_name' => "[".$res->item_code."]".$res->item_name
			);
		}
		sess_initialize('items',$items);
		echo json_encode(array('subjects'=>$subjects,'items'=>$items));
	}	
}
