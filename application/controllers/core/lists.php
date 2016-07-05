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
    public function courses($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/courses';
        $cols = array('ID','Code','Name','Description',' ');
        $table = 'courses';
        $select = 'courses.*';

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'academic/courses_form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>strtoupper($res->code),   
                    "name"=>ucFix($res->name),   
                    "description"=>$res->description,   
                    "link"=>$link
                );
            }
        }

        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function course_batches($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/course_batches';
        $cols = array('ID','Code','Name','Course','Start Date','End Date',' ');
        $table = 'course_batches';
        $select = 'course_batches.*,courses.name as course_name';
        $join['courses'] = "course_batches.id = courses.id";

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'academic/batches_form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>strtoupper($res->code),   
                    "name"=>ucFix($res->name),   
                    "course"=>ucFix($res->course_name),   
                    "start_date"=>sql2Date($res->start_date),   
                    "end_date"=>sql2Date($res->end_date),   
                    "link"=>$link
                );
            }
        }

        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function subjects($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/subjects';
        $cols = array('ID','Code','Name','Description',' ');
        $table = 'subjects';
        $select = 'subjects.*';

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'academic/subjects_form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>strtoupper($res->code),   
                    "name"=>ucFix($res->name),   
                    "description"=>$res->description,   
                    "link"=>$link
                );
            }
        }
        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function sections($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/sections';
        $cols = array('ID','Code','Name',' ');
        $table = 'sections';
        $select = 'sections.*';

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'academic/sections_form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>strtoupper($res->code),   
                    "name"=>ucFix($res->name),   
                    "link"=>$link
                );
            }
        }
        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function students($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
        
        $cols = array('ID','Code','Name','Gender','Age','Reg Date','Inactive','');
        $table  = 'students';
        $select = 'students.*';
        $join   = null;
        
        $post = array();
        $args = array();
        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        if($this->input->post('name')){
            $lk  =$this->input->post('name');
            $args["(students.fname like '%".$lk."%' OR students.mname like '%".$lk."%' OR students.lname like '%".$lk."%' OR students.suffix like '%".$lk."%')"] = array('use'=>'where','val'=>"",'third'=>false);
        }        
        $order = array('students.fname'=>'asc');
        
        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate('lists/students',$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);
        
        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg'),base_url().'students/profile/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $name = $res->fname." ".$res->mname." ".$res->lname." ".$res->suffix;
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "code"=>$res->code,   
                    "title"=>$name,   
                    "desc"=>strtoupper($res->sex),   
                    "subtitle"=>"Age ".age($res->bday),   
                    "reg_date"=>sql2Date($res->reg_date),
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes'),
                    "link"=>$link
                );
                $ids[] = $res->id;
            }
            $images = $this->site_model->get_image(null,null,'students',array('images.img_ref_id'=>$ids)); 
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
    public function students_filter(){
        $this->html->sForm();
            $this->html->inputPaper('Name:','name','');
        $this->html->eForm();
        $data['code'] = $this->html->code();
        $this->load->view('load',$data);   
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
    public function uom($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/uom';
        $cols = array('ID','Code','Name',' ');
        $table = 'uom';
        $select = 'uom.*';

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'inventory/uom_form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>strtoupper($res->abbrev),   
                    "name"=>ucFix($res->name),   
                    "link"=>$link
                );
            }
        }
        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function item_categories($id=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/item_categories';
        $cols = array('ID','Name','UOM','Type',' ');
        $table = 'item_categories';
        $select = 'item_categories.*';

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'items/categories_form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>ucFix($res->name),   
                    "uom"=>$res->uom,   
                    "name"=>ucFix($res->type),   
                    "link"=>$link
                );
            }
        }
        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function items($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/items';
        $cols = array('ID','Name','Category','UOM','Type','Price',' ');
        $table = 'items';
        $select = 'items.*,item_categories.name as cat_name';
        $join['item_categories'] = "items.cat_id = item_categories.id";

        if(count($this->input->post()) > 0){
            $post = $this->input->post();
        }
        if($this->input->post('code')){
            $lk  =$this->input->post('code');
            $args["(items.code like '%".$lk."%')"] = array('use'=>'where','val'=>"",'third'=>false);
        }
        if($this->input->post('name')){
            $lk  =$this->input->post('name');
            $args["(items.name like '%".$lk."%')"] = array('use'=>'where','val'=>"",'third'=>false);
        }
        if($this->input->post('cat_id')){
            $args['items.cat_id'] = array('use'=>'where','val'=>$this->input->post('cat_id'));
        }

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'items/form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $json[$res->id] = array(
                    "id"=>$res->id,   
                    "title"=>"[".$res->code."] ".ucFix($res->name),   
                    "desc"=>ucFix($res->cat_name),   
                    "uom"=>$res->uom,   
                    "name"=>ucFix($res->type),   
                    "subtitle"=>num($res->price),   
                    "link"=>$link
                );
            }
        }
        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function items_filter(){
        $this->html->sForm();
            $this->html->inputPaper('Code:','code','');
            $this->html->inputPaper('Name:','name','');
            $this->html->itemCategoriesDropPaper('Category:','cat_id','');
        $this->html->eForm();
        $data['code'] = $this->html->code();
        $this->load->view('load',$data);   
    }
    public function enrolls($tbl=null){
        $total_rows = 30;
        $pagi = null;
        if($this->input->post('pagi'))
            $pagi = $this->input->post('pagi');
       
        $post = array();
        $args = array();
        $join = array();
        $order = array();
        
        $page_link = 'lists/enrolls';
        $cols = array('Reference','Student','Course','Batch','Section','Start Date','End Date','Trans Date',' ');
        $table = 'enrolls';
        $select = 'enrolls.*,
                   students.fname as std_fname,students.mname as std_mname,students.lname as std_lname,students.suffix as std_suffix,
                   courses.name as course_name,
                   course_batches.name as batch_name,
                   sections.name as section_name';
        $join['students'] = "enrolls.student_id = students.id";
        $join['courses'] = "enrolls.course_id = courses.id";
        $join['course_batches'] = "enrolls.batch_id = course_batches.id";
        $join['sections'] = "enrolls.section_id = sections.id";

        if($this->input->post('student_name')){
            $lk  =$this->input->post('student_name');
            $args["(students.fname like '%".$lk."%' OR students.mname like '%".$lk."%' OR students.lname like '%".$lk."%' OR students.suffix like '%".$lk."%')"] = array('use'=>'where','val'=>"",'third'=>false);
        }
        if($this->input->post('trans_ref')){
            $lk  =$this->input->post('trans_ref');
            $args["(enrolls.trans_ref like '%".$lk."%')"] = array('use'=>'where','val'=>"",'third'=>false);
        }

        $count = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,null,true);
        $page = paginate($page_link,$count,$total_rows,$pagi);
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select,null,$page['limit']);

        $json = array();
        if(count($items) > 0){
            $ids = array();
            foreach ($items as $res) {
                $link = "";
                $link = $this->html->A(fa('fa-edit fa-lg fa-fw'),base_url().'enrollment/form/'.$res->id,array('class'=>'btn btn-sm btn-primary btn-flat','return'=>'true'));
                $name  = $res->std_fname." ".$res->std_mname." ".$res->std_lname." ".$res->std_suffix;
                $json[] = array(
                    "title"     =>  strtoupper($res->trans_ref),   
                    "name"      =>  ucFix($name),   
                    "course"    =>  ucFix($res->course_name),   
                    "batch"     =>  ucFix($res->batch_name),   
                    "section"   =>  ucFix($res->section_name),   
                    "trans_date"=>  sql2Date($res->trans_date),   
                    "start_date"=>  sql2Date($res->start_date),   
                    "end_date"  =>  sql2Date($res->end_date),   
                    "link"      =>  $link
                );
            }
        }
        echo json_encode(array('cols'=>$cols,'rows'=>$json,'pagi'=>$page['code'],'post'=>$post));
    }
    public function enrolls_filter(){
        $this->html->sForm();
            $this->html->inputPaper('Reference:','trans_ref','');
            $this->html->inputPaper('Student:','student_name','');
        $this->html->eForm();
        $data['code'] = $this->html->code();
        $this->load->view('load',$data);   
    }
}
