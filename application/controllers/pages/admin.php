<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('pages/admin_helper');
	}
	public function roles(){
		$data = $this->syter->spawn('roles');
		$data['code'] = listPage(fa('fa-black-tie')." Roles",'roles','admin/roles_form','list',false);
		$this->load->view('list',$data);
	}
	public function roles_form($id=null){
		$data = $this->syter->spawn('roles');
		$data['page_title'] = fa('fa-black-tie')." User Roles";
		$data['page_subtitle'] = "Add New User Role";
		$det = array();
		$img = array();
		if($id != null){
			$details = $this->site_model->get_tbl('user_roles',array('id'=>$id));
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit User Role ".$det->role;
			}
		}
		$navs = $this->syter->get_navs();
		$data['code'] = rolesForm($det,$navs);
		$data['load_js'] = 'pages/admin';
		$data['use_js'] = 'rolesFormJs';
		$this->load->view('page',$data);
	}
	public function roles_db(){
		$error = 0;
		$msg = "";

		$items = array(
			"role"		  => $this->input->post('role_name'),
			"description" => $this->input->post('description'),
		);
		$roles = $this->input->post('roles');
		$access = "";
		if(is_array($roles)){		
			foreach ($roles as $li) {
			    $access .= $li.",";
			}
			$access = substr($access,0,-1);
		}
		$items['access'] = $access;

		if(!$this->input->post('id')){
			$id = $this->site_model->add_tbl('user_roles',$items);
			$msg = "Added New Role ".$items['role'];
		}
		else{
			$id = $this->input->post('id');
			$this->site_model->update_tbl('user_roles','id',$items,$id);
			$msg = "Updated Role ".$items['role'];
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
	}
}
