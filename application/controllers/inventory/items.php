<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Items extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('inventory/items_helper');
	}
	public function index(){
		$data = $this->syter->spawn('items');
		$data['code'] = listPage(fa('fa-cubes')." Items",'items','items/form','list','list',true);
		$this->load->view('list',$data);
	}
	public function form($id=null){
		$data = $this->syter->spawn('items');
		$data['page_title'] = fa('fa-cubes')." Items";
		$data['page_subtitle'] = "Add New Item";
		$det = array();
		$img = array();
		if($id != null){
			$details = $this->site_model->get_tbl('items',array('id'=>$id));
			// echo $this->site_model->db->last_query();
			if($details){
				$det = $details[0];
				$data['page_subtitle'] = "Edit Item ".ucwords(strtolower($det->name));
				$resultIMG = $this->site_model->get_image(null,$det->id,'items');
				if(count($resultIMG) > 0){
				    $img = $resultIMG[0];
				}
			}
		}
		$data['top_btns'][] = array('tag'=>'a','params'=>'class="btn btn-primary btn-flat" href="'.base_url().'items"','text'=>"<i class='fa fa-fw fa-reply'></i>");
		$data['code'] = itemsPage($det,$img);
		$data['load_js'] = 'inventory/items';
		$data['use_js'] = 'itemsFormJs';
		$this->load->view('page',$data);
	}
	public function general($id=null){
		$det = array();
		if($id != null){
			$details = $this->site_model->get_tbl('items',array('id'=>$id));
			if($details){
				$det = $details[0];
			}
		}
		$data['code'] = itemGeneralDetails($det);
		$data['load_js'] = 'inventory/items';
		$data['use_js'] = 'itemsGeneralFormJs';
		$this->load->view('load',$data);
	}
	public function general_db(){
		$user = sess('user');
		$items = array(
		    "code"=>$this->input->post('code'),
		    "name"=>$this->input->post('name'),
		    "description"=>$this->input->post('description'),
		    "cat_id"=>$this->input->post('cat_id'),
		    "type"=>$this->input->post('type'),
		    "uom"=>$this->input->post('uom'),
		    "price"=>$this->input->post('price'),
		    "tax_type_id"=>$this->input->post('tax_type_id'),
		);

		$error = 0;
		$msg = "";
		$id = 0;
		if(!$this->input->post('id')){
			$id = $this->site_model->add_tbl('items',$items,array('reg_date'=>'NOW()','reg_user'=>$user['id']));
			$msg = "Added New Item ".$items['name'];	
		}
		else{
			$id = $this->input->post('id');
			$this->site_model->update_tbl('items','id',$items,$id);
			$msg = "Updated Item ".$items['name'];
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

			        $this->site_model->delete_tbl('images',array('img_tbl'=>'items','img_ref_id'=>$id));
			        $info = pathinfo($_FILES['fileUpload']['name']);
			        if(isset($info['extension']))
			            $ext = $info['extension'];
			        $newname = $id.".png";            
			        $res_id = $id;
			        if (!file_exists("uploads/items/")) {
			            mkdir("uploads/items/", 0777, true);
			        }
			        $target = 'uploads/items/'.$newname;
			        if(!move_uploaded_file( $_FILES['fileUpload']['tmp_name'], $target)){
			            $msg = "Image Upload failed";
			            $error = 1;
			        }
			        else{
			            $new_image = $target;
			            $result = $this->site_model->get_image(null,$this->input->post('id'),'items');
			            $items = array(
			                "img_path" => $new_image,
			                "img_file_name" => $newname,
			                "img_ref_id" => $id,
			                "img_tbl" => 'items',
			            );
			            if(count($result) > 0){
			                $this->site_model->update_tbl('images','id',$items,$result[0]->img_id);
			            }
			            else{
			                $imgid = $this->site_model->add_tbl('images',$items,array('datetime'=>'NOW()'));
			            }
			            $msg = "Picture Uploaded Successfully.";
			        }
			        ####
			    }
			}
			###################################################
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg));
		###################################################
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
		if(!$this->input->post('rForm')){
			if($error == 0){
				site_alert($msg,'success');
			}
		}
		echo json_encode(array('error'=>$error,'msg'=>$msg,'items'=>$items,'id'=>$id));
	}
}
