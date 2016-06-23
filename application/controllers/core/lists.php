<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lists extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('pagination_helper');
	}
	public function users($tbl=null){
		$total_rows = 30;
		$pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
		$post = array();
		$args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        if($this->input->post('name')){
            $lk  =$this->input->post('name');
            $args["(users.fname like '%".$lk."%' OR users.mname like '%".$lk."%' OR users.lname like '%".$lk."%' OR users.suffix like '%".$lk."%')"] = array('use'=>'where','val'=>"",'third'=>false);
        }
        if($this->input->post('role')){
            $args['users.role'] = array('use'=>'where','val'=>$this->input->post('role'));
        }
		$order = array();
        $cols = array('ID','Name','Role','Email','Reg Date','Inactive','');
		$join["user_roles"] = array('content'=>"users.role = user_roles.id");
		$count = $this->site_model->get_tbl('users',$args,$order,$join,true,'users.*,user_roles.role as role_name',null,null,true);
		$page = paginate('lists/users',$count,$total_rows,$pagi);
		$items = $this->site_model->get_tbl('users',$args,$order,$join,true,'users.*,user_roles.role as role_name',null,$page['limit']);
		$json = array();
		if(count($items) > 0){
			$ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg'),base_url().'users/form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $name = $res->fname." ".$res->mname." ".$res->lname." ".$res->suffix;
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>ucwords(strtolower($name)),   
                    "desc"=>ucwords(strtolower($res->role_name)),   
                    "subtitle"=>$res->email,   
                    "reg_date"=>sql2Date($res->reg_date),
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes'),
                    "link"=>$link
                );
                $ids[] = $res->id;
            }
            $images = $this->site_model->get_image(null,null,'users',array('images.img_ref_id'=>$ids)); 
            foreach ($images as $res) {
                if(isset($json[$res->img_ref_id])){
                    $js = $json[$res->img_ref_id];
                    $js['grid-image'] = $res->img_path;
                    $json[$res->img_ref_id] = $js;
                }
            }
        }
        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function users_filter(){
        $this->html->sForm();
            $this->html->inputPaper('Name:','name','');
            $this->html->roleDropPaper('Role:','role','',null,array('class'=>'paper-select'));
        $this->html->eForm();
        $data['code'] = $this->html->code();
        $this->load->view('load',$data);   
	}	
    public function roles($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/users';
        $cols = array('ID','Name','Description',' ');
        $table = 'user_roles';
        $select = 'user_roles.*';
        $args['user_roles.id != '] = 1; 

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'admin/roles_form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>ucwords(strtolower($res->role)),   
                    "desc"=>ucwords(strtolower($res->description)),   
                    "link"=>$link
                );
            }
        }

        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function years($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/roles';
        $cols = array('ID','Name','Start Date','End Date',' ');
        $table = 'academic_years';
        $select = 'academic_years.*';

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'academic/years_form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>ucwords(strtolower($res->name)),   
                    "start_date"=>sql2Date($res->start_date),   
                    "end_date"=>sql2Date($res->end_date),   
                    "link"=>$link
                );
            }
        }

        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
	public function get_menus($id=null,$asJson=true){
        $this->load->helper('site/pagination_helper');
        $pagi = null;
        $args = array();
        $total_rows = 30;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        $post = array();
        
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        if($this->input->post('menu_name')){
            $lk  =$this->input->post('menu_name');
            $args["(menus.menu_name like '%".$lk."%' OR menus.menu_short_desc like '%".$lk."%')"] = array('use'=>'where','val'=>"",'third'=>false);
        }
        // if($this->input->post('email')){
             // $args['users.email'] = array('use'=>'or_like','val'=>$this->input->post('email'));
        // }
        // if($this->input->post('email')){
            // $args['DATE(users.reg_date) = date('.date2Sql($this->input->post('reg_date')).')'] = array('use'=>'where','val'=>"",'third'=>false);
        // }
        if($this->input->post('inactive')){
            $args['menus.inactive'] = array('use'=>'where','val'=>$this->input->post('inactive'));
        }
        if($this->input->post('menu_cat_id')){
            $args['menus.menu_cat_id'] = array('use'=>'where','val'=>$this->input->post('menu_cat_id'));
        }
        $join["menu_categories"] = array('content'=>"menus.menu_cat_id = menu_categories.menu_cat_id");
        $count = $this->site_model->get_tbl('menus',$args,array(),$join,true,'menus.*,menu_categories.menu_cat_name',null,null,true);
        $page = paginate('menu/get_menus',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl('menus',$args,array(),$join,true,'menus.*,menu_categories.menu_cat_name',null,$page['limit']);
        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->make->A(fa('fa-edit fa-lg'),base_url().'menu/form/'.$res->menu_id,array('return'=>'true'));
                $json[$res->menu_id] = array(
                    "id"=>$res->menu_id,   
                    "title"=>"[".$res->menu_code."] ".ucwords(strtolower($res->menu_name)),   
                    "desc"=>ucwords(strtolower($res->menu_short_desc)),   
                    "subtitle"=>ucwords(strtolower($res->menu_cat_name)),   
                    "caption"=>"PHP ".num($res->cost),
                    "date_reg"=>sql2Date($res->reg_date),
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes'),
                    "link"=>$link
                );
                $ids[] = $res->menu_id;
            }
            $images = $this->site_model->get_image(null,null,'menus',array('images.img_ref_id'=>$ids)); 
            foreach ($images as $res) {
                if(isset($json[$res->img_ref_id])){
                    $js = $json[$res->img_ref_id];
                    $js['image'] = $res->img_path;
                    $json[$res->img_ref_id] = $js;
                }
            }
        }
        echo json_encode(array('rows'=>$json,'page'=>$page['code'],'post'=>$post));
    }
}
