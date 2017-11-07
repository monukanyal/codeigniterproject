<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   	    
	     $this->load->model('user_model');
	     $this->load->model('system_model');
	    header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	    if (!isset($this->session->userdata['logged_in'])) {
			$this->session->set_flashdata('flash_error', 'Please Login First!!');
			redirect(base_url());
		}		
   	}
	function get_record_byId()
	{
		if($this->input->is_ajax_request())
		{		
			$id = $this->input->post('id',TRUE);
			$tablename = $this->input->post('tablename',TRUE);

			$admin_id = $this->session->userdata['logged_in']['admin_id'];
		
			$response = $this->system_model->get_single(array("id" => $id, "admin_id" => $admin_id), $tablename);
			
			echo json_encode($response);
			//$this->output->set_output(json_encode($path));
		}
		else
		{
			die("Sorry, NOT AN AJAX REQUEST");
		}
	}
	function get_superevent_record_byId()
	{
		if($this->input->is_ajax_request())
		{		
			$id = $this->input->post('id',TRUE);
			$tablename = $this->input->post('tablename',TRUE);

			// $admin_id = $this->session->userdata['logged_in']['admin_id'];
		
			$response = $this->system_model->get_super_single_event(array("id" => $id), $tablename, 'ci_event', 'ci_location');
			
			echo json_encode($response);
			//$this->output->set_output(json_encode($path));
		}
		else
		{
			die("Sorry, NOT AN AJAX REQUEST");
		}
	}
	function get_supermeal_record_byId()
	{
		if($this->input->is_ajax_request())
		{		
			$id = $this->input->post('id',TRUE);
			$tablename = $this->input->post('tablename',TRUE);

			// $admin_id = $this->session->userdata['logged_in']['admin_id'];
		
			$response = $this->system_model->get_super_single_meal(array("id" => $id), $tablename, 'ci_location');
			
			echo json_encode($response);
			//$this->output->set_output(json_encode($path));
		}
		else
		{
			die("Sorry, NOT AN AJAX REQUEST");
		}
	}

	function get_record_byId_tables()
	{
		if($this->input->is_ajax_request())
		{		
			$id = $this->input->post('id',TRUE);
			$tablename = $this->input->post('tablename',TRUE);

			$admin_id = $this->session->userdata['logged_in']['admin_id'];
		
			$response = $this->system_model->get_single_event_join(array("id" => $id, "admin_id" => $admin_id), $tablename, 'ci_event', 'ci_location');
			
			echo json_encode($response);
			//$this->output->set_output(json_encode($path));
		}
		else
		{
			die("Sorry, NOT AN AJAX REQUEST");
		}
	}
	function getevent_srecord_byId_tables()
	{
		if($this->input->is_ajax_request())
		{		
			$id = $this->input->post('id',TRUE);
			$tablename = $this->input->post('tablename',TRUE);

			// $admin_id = $this->session->userdata['logged_in']['admin_id'];
		
			$response = $this->system_model->get_single_sevent_join(array("id" => $id), $tablename, 'ci_event', 'ci_location');
			
			echo json_encode($response);
			//$this->output->set_output(json_encode($path));
		}
		else
		{
			die("Sorry, NOT AN AJAX REQUEST");
		}
	}


	function getmeal_record_byId_tables()
	{
		if($this->input->is_ajax_request())
		{		
			$id = $this->input->post('id',TRUE);
			$tablename = $this->input->post('tablename',TRUE);

			$admin_id = $this->session->userdata['logged_in']['admin_id'];
		
			$response = $this->system_model->getsingle_mealData(array("id" => $id), $tablename);
			//print_r($response);
			echo json_encode($response);
			//$this->output->set_output(json_encode($path));
		}
		else
		{
			die("Sorry, NOT AN AJAX REQUEST");
		}
	}
	function get_EventActivity_ById()
	{
		if($this->input->is_ajax_request())
		{		
			$id = $this->input->post('id',TRUE);
			$tablename = $this->input->post('tablename',TRUE);

			$response = $this->system_model->get_single_eventAct_join(array("id" => $id), $tablename, 'ci_event', 'ci_location');
			
			echo json_encode($response);
			//$this->output->set_output(json_encode($path));
		}
		else
		{
			die("Sorry, NOT AN AJAX REQUEST");
		}
	}

	function get_MealActivity_ById()
	{
		if($this->input->is_ajax_request())
		{		
			$id = $this->input->post('id',TRUE);
			$tablename = $this->input->post('tablename',TRUE);

			$response = $this->system_model->getsingle_mealActData(array("id" => $id), $tablename,'ci_event', 'ci_location');
			//print_r($response);
			echo json_encode($response);
			//print_r(json_decode($response));
			//$this->output->set_output(json_encode($path));
		}
		else
		{
			die("Sorry, NOT AN AJAX REQUEST");
		}
	}
	
}
?>