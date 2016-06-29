<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fetch extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}	
    public function item_categories($id=null){
        $args = array();
        $join = array();
        $order = array();
        $table = 'item_categories';
        $select = 'item_categories.*';
        $args['item_categories.id'] = $id;
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select);
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json = array(
                    "id"=>$res->id,   
                    "type"=>$res->type,   
                    "uom"=>$res->uom,   
                    "tax_type_id"=>$res->tax_type_id,   
                );
            }
        }
        echo json_encode(array('details'=>$json));
    }
    public function items($id=null){
        $args = array();
        $join = array();
        $order = array();
        $table = 'items';
        $select = 'items.*';
        $args['items.id'] = $id;
        $items = $this->site_model->get_tbl($table,$args,$order,$join,true,$select);
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json = array(
                    "id"=>$res->id,   
                    "type"=>$res->type,   
                    "uom"=>$res->uom,   
                    "price"=>$res->price,   
                    "tax_type_id"=>$res->tax_type_id,   
                );
            }
        }
        echo json_encode(array('details'=>$json));
    }

}
