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
		
		$data['code'] = balanceDetails();
		// $data['load_js'] = 'school/students';
		// $data['use_js'] = 'profileGeneralJs';
		$this->load->view('load',$data);
	}
}
