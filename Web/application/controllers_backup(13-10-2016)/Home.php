<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   
		
		$this->load->library('session');
	    $this->load->model('auth_model');               
	    $this->load->model('user_model');
	  
   	}
	public function index()
	{
		
		$userdata = $this->session->userdata['logged_in'];
//		die('echo here');
		$data["title"] = "Home";
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		// $this->load->view('includes/partials/admin/header',$data);
		$this->load->view('home/index',$data);
		$remember = $this->input->post('remember_me');
		
		if($remember){
		$this->session->set_userdata('remember_me', true);
		}

		// $this->load->view('includes/partials/admin/footer',$data);
	}
	
}

?>
