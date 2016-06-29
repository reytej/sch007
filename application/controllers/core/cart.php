<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}	
    public function initial($name=null){
        sess_initialize($name,array());
    }    
    public function add($name=null){
        $post = $this->input->post();
        $sess = sess_add($name,$post);   
        echo json_encode($sess);
    }
}
