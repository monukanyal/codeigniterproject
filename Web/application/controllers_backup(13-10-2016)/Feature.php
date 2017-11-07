<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feature extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 
	     $this->load->model('user_model');	   
	    if (!isset($this->session->userdata['logged_in'])) {
			$this->session->set_flashdata('flash_error', 'Please Login First!!');
			redirect(base_url());
		} 
   	}
	public function index()
	{
		// echo site_url();
		$data["title"] = "Feature";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('feature/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}

}

?>
