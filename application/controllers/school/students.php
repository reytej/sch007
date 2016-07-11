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
		$next_ref = $this->site_model->get_next_ref(STUDENT_CODE);
		$det = array();
		if($id != null){
			$details = $this->site_model->get_tbl('students',array('id'=>$id));
			if($details){
				$det = $details[0];
			}
		}
		$data['code'] = generalDetails($next_ref,$det);
		$data['load_js'] = 'school/students';
		$data['use_js'] = 'profileGeneralJs';
		$this->load->view('load',$data);
	}
	public function profile_general_db(){
		$trans_type = STUDENT_CODE;
		$student_code = $this->input->post('Code');
		$user = sess('user');
		$items = array(
		    "Code"=>$student_code,
		    "fname"=>$this->input->post('fname'),
		    "mname"=>$this->input->post('mname'),
		    "lname"=>$this->input->post('lname'),
		    "suffix"=>$this->input->post('suffix'),
		    "bday"=>date2Sql($this->input->post('bday')),
		    "blood_type"=>$this->input->post('blood_type'),
		    "sex"=>$this->input->post('sex'),
		    "nationality"=>$this->input->post('nationality'),
		    "language"=>$this->input->post('language'),
		    "religion"=>$this->input->post('religion'),
		    "pres_address"=>$this->input->post('pres_address'),
		    "phone"=>$this->input->post('phone'),
		    "mobile"=>$this->input->post('mobile'),
		    "perm_address"=>$this->input->post('perm_address'),
		    "email"=>$this->input->post('email'),
		);

		$error = 0;
		$msg = "";
		$id = 0;
		if(!$this->input->post('id')){
			$check = $this->site_model->ref_unused(STUDENT_CODE,$student_code);
			if($check){
				$id = $this->site_model->add_tbl('students',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
				$msg = "Added New Student ".$items['fname']." ".$items['mname']." ".$items['lname']." ".$items['suffix'];	
				$this->site_model->save_ref(STUDENT_CODE,$student_code);			
			}
			else{
				$error = 1;
				$msg = "Student Code is already taken.";
			}
		}
		else{
			$id = $this->input->post('id');
			$this->site_model->update_tbl('students','id',$items,$id);
			$msg = "Updated Student ".$items['fname']." ".$items['mname']." ".$items['lname']." ".$items['suffix'];
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg,"id"=>$id));
	}
	public function pic_upload(){
		$error = 0;
		$msg = "";
		$id = $this->input->post('id');
		if($id){
			if(isset($_FILES['fileUpload'])){
			    if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){

			        $this->site_model->delete_tbl('images',array('img_tbl'=>'students','img_ref_id'=>$id));
			        $info = pathinfo($_FILES['fileUpload']['name']);
			        if(isset($info['extension']))
			            $ext = $info['extension'];
			        $newname = $id.".png";            
			        $res_id = $id;
			        if (!file_exists("uploads/students/")) {
			            mkdir("uploads/students/", 0777, true);
			        }
			        $target = 'uploads/students/'.$newname;
			        if(!move_uploaded_file( $_FILES['fileUpload']['tmp_name'], $target)){
			            $msg = "Image Upload failed";
			            $error = 1;
			        }
			        else{
			            $new_image = $target;
			            $result = $this->site_model->get_image(null,$this->input->post('id'),'students');
			            $items = array(
			                "img_path" => $new_image,
			                "img_file_name" => $newname,
			                "img_ref_id" => $id,
			                "img_tbl" => 'students',
			            );
			            if(count($result) > 0){
			                $this->site_model->update_tbl('images','id',$items,$result[0]->img_id);
			            }
			            else{
			                $imgid = $this->site_model->add_tbl('images',$items,array('datetime'=>'NOW()'));
			            }
			            $msg = "Profile Picture Uploaded Successfully.";
			        }
			        ####
			    }
			}
			###################################################
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
		###################################################
	}
	public function profile_balance($id=null){
		$select   = "enroll_payments.*,enrolls.trans_ref";
		$join['enrolls'] = 'enroll_payments.enroll_id = enrolls.id';
		$args['enroll_payments.student_id'] = $id;
		$order['enroll_payments.due_date'] = 'asc';
		$result = $this->site_model->get_tbl('enroll_payments',$args,$order,$join,true,$select);
		$data['code'] = balanceDetails($result);
		// $data['load_js'] = 'school/students';
		// $data['use_js'] = 'profileGeneralJs';
		$this->load->view('load',$data);
	}
	public function profile_academic($id=null){
		$now = $this->site_model->get_db_now('sql',true);
		$details = array();
		$subjects = array();
		$order = array();
		$table  = 'students';
		$select = 'students.*,
		           enrolls.batch_id,enrolls.section_id,enrolls.start_date,enrolls.end_date,
		           courses.name as course_name,
		           course_batches.name as batch_name,
		           sections.name as section_name,
		           course_batch_sections.teacher_id,
		           users.fname as tc_fname,users.mname as tc_mname,users.lname as tc_lname,users.suffix as tc_suffix
		          ';
		$join['enrolls'] = array("content"=>"students.enroll_id = enrolls.id","mode"=>"left");
		$join['courses'] = array("content"=>"enrolls.course_id = courses.id","mode"=>"left");
		$join['course_batches'] = array("content"=>"enrolls.batch_id = course_batches.id","mode"=>"left");
		$join['sections'] = array("content"=>"enrolls.section_id = sections.id","mode"=>"left");
		$join['course_batch_sections'] = array("content"=>"course_batches.id = course_batch_sections.batch_id AND sections.id = course_batch_sections.section_id","mode"=>"left");
		$join['users'] = array("content"=>"course_batch_sections.teacher_id = users.id","mode"=>"left");
		$args['students.id'] = $id;
		$items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select);
		if(count($items) > 0){
			$details = $items[0];
			$table  = 'enroll_subjects';
			$select = 'enroll_subjects.*,
					   subjects.code subj_code,subjects.name as subj_name,
					   course_batch_schedules.day,course_batch_schedules.start_time,course_batch_schedules.end_time,
					   users.fname as tc_fname,users.mname as tc_mname,users.lname as tc_lname,users.suffix as tc_suffix
					  ';
			$join2['subjects'] = array("content"=>"enroll_subjects.subject_id = subjects.id","mode"=>"left");
			$join2['course_batch_schedules'] = array("content"=>"enroll_subjects.subject_id = course_batch_schedules.subject_id","mode"=>"left");
			$join2['users'] = array("content"=>"course_batch_schedules.teacher_id = users.id","mode"=>"left");
			$args2['enroll_subjects.enroll_id'] = $details->enroll_id;
			$args2['course_batch_schedules.batch_id'] = $details->batch_id;
			$args2['course_batch_schedules.section_id'] = $details->section_id;
			$order = array('subjects.name'=>'asc');
			$subjects_result = $this->site_model->get_tbl($table,$args2,$order,$join2,true,$select);

			foreach ($subjects_result as $sres) {
				$days = array('mon'=>'','tue'=>'','wed'=>'','thu'=>'','fri'=>'','sat'=>'','sun'=>'');
				$teacher = ucFix($sres->tc_fname." ".$sres->tc_mname." ".$sres->tc_lname." ".$sres->tc_suffix);
				$time = sql2Time($sres->start_time)." - ".sql2Time($sres->end_time)."<br>".$teacher;
				$days[strtolower($sres->day)] = $time;
				if(!isset($subjects[$sres->subject_id])){
					$subjects[$sres->subject_id] = array(
						"name" => "[".$sres->subj_code."] ".$sres->subj_name,
						"mon"  => $days['mon'],
						"tue"  => $days['tue'],
						"wed"  => $days['wed'],
						"thu"  => $days['thu'],
						"fri"  => $days['fri'],
						"sat"  => $days['sat'],
						"sun"  => $days['sun'],
					);
				}
				else{
					$subj = $subjects[$sres->subject_id];
					$subj[strtolower($sres->day)] = $days[strtolower($sres->day)];
					$subjects[$sres->subject_id] = $subj;
				}
			}
		}
		$data['code'] = academicDetails($details,$now,$subjects);
		$data['load_js'] = 'school/students';
		$data['use_js'] = 'profileGeneralJs';
		$this->load->view('load',$data);
	}
}
