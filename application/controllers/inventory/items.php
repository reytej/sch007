<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Items extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('inventory/items_helper');
	}
	public function categories(){
		$data = $this->syter->spawn('category');
		$data['code'] = listPage(fa('fa-cube')." Item Categories",'item_categories','items/categories_form','list','list',false);
		$this->load->view('list',$data);
	}
	public function categories_form($id=null){
		$data = $this->syter->spawn('category');
		$data['page_title'] = fa('fa-cube')." Item Categories";
		$data['page_subtitle'] = "Add New Item Category";
		$det = array();
		$img = array();
		if($id != null){
			$details = $this->site_model->get_tbl('item_categories',array('id'=>$id));
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit Item Category ".ucwords(strtolower($det->name));
			}
		}
		$data['top_btns'][] = array('tag'=>'button','params'=>'id="save-btn" class="btn-flat btn-flat btn btn-success"','text'=>"<i class='fa fa-fw fa-save'></i> SAVE");
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'items/categories"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = itemCategoriesPage($det);
		$data['load_js'] = 'inventory/items';
		$data['use_js'] = 'itemCategoriesFormJs';
		$this->load->view('page',$data);
	}
	public function item_categories_db($id=null){
		$user = sess('user');
		$items = array(
		    "name"=>$this->input->post('name'),
		    "uom"=>$this->input->post('uom'),
		    "type"=>$this->input->post('type'),
		    "tax_type_id"=>$this->input->post('tax_type_id'),
		);
		$error = 0;
		$msg = "";
		if(!$this->input->post('id')){
			$id = $this->site_model->add_tbl('item_categories',$items);
			$msg = "Added New Item Category ".$items['name'];
		}
		else{
			$id = $this->input->post('id');
			$this->site_model->update_tbl('item_categories','id',$items,$id);
			$msg = "Updated Item Category ".$items['name'];
		}
		if($error == 0){
			site_alert($msg,'success');
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
	}
}
