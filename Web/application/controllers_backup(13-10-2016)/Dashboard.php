<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   
	    header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	    $this->load->model('auth_model');               
	    $this->load->model('user_model');
	    $this->load->model('common_model');
	    $this->load->model('dashboard_model');
	    $this->load->helper('security'); 	
	    if (!isset($this->session->userdata['logged_in'])) {
			$this->session->set_flashdata('flash_error', 'Please Login First!!');
			redirect(base_url());
		}
				  
   	}
	public function index()
	{
		// print_r($this->session->all_userdata());
		$css = array("css2"=>"maps/jquery-jvectormap-2.0.1.css","css1"=>"floatexamples.css");
		$data['js'] = array("js1"=>"chartjs/chart.min.js","js3"=>"moris/raphael-min.js", "js4"=>"moris/morris.js");

		$data["title"] = "Home";
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('dashboard/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}
}
