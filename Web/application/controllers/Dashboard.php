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
	    $this->load->library('session');	
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
		$admin_id=$this->session->userdata['logged_in']['admin_id'];
		//---28 march Bar graph graph@mk----------
		if(isset($_GET['range']))
		{
			$day=$_GET['range'];
			$this->session->set_userdata('range', $day);
		}
		else
		{
			if($this->session->has_userdata('range'))
			{
				$day= $this->session->userdata('range');
			}
			else
			{
				$day=30;  //by default 30 days
			}
		}
		if(isset($_GET['range2']))
		{
			$day2=$_GET['range2'];
			$this->session->set_userdata('range2', $day2);
		}
		else
		{
			if($this->session->has_userdata('range2'))
			{
				$day2= $this->session->userdata('range2');
			}
			else
			{
				$day2=30;  //by default 30 days
			}
		}
		if(isset($_GET['range3']))
		{
			$day3=$_GET['range3'];
			$this->session->set_userdata('range3', $day3);
		}
		else
		{
			if($this->session->has_userdata('range3'))
			{
				$day3= $this->session->userdata('range3');
			}
			else
			{
				$day3=30;  //by default 30 days
			}
		}
		 $data['getdata']=$this->dashboard_model->get_events_acctomonth($admin_id,$day);
		 $data['timeslot_avg']=$this->dashboard_model->get_avg_timeslotbyday($admin_id,$day2);
		 $data['busytime_avg']=$this->dashboard_model->get_avg_busytimebyday($admin_id,$day3);
		 $data['day']=$day;
		 $data['range2']=$day2;
		 $data['range3']=$day3;

		$num_data=$this->dashboard_model->get_no_of_msg_care_resident($admin_id);
		//echo "nor: ".$num_data['no_of_resident']."<br>";
		//echo "noc: ".$num_data['no_of_care']."<br>";
		//echo "nom: ".$num_data['no_of_msg']."<br>";
		$bill_data=$this->dashboard_model->get_billing_info($admin_id);
		$today = date("Y-m-d");
		$expire = $bill_data['paydate']; //from db
		$is_amount_calculated = $bill_data['amount']; //from db
		$start_date = $bill_data['start_date']; 
		$today_time = strtotime($today);
		$expire_time = strtotime($expire);
		if ($expire_time < $today_time) 
		{ 
			if(empty($is_amount_calculated))
			{
				$this->dashboard_model->calculate_bill($admin_id,$expire,$start_date);
			}
		}
		else if($expire_time==$today_time)
		{
			if(empty($is_amount_calculated))
			{
				$this->dashboard_model->calculate_bill($admin_id,$expire,$start_date);
			}

		}
		$data['bill_pay_data']=$this->dashboard_model->check_bill_paid($admin_id);
		
		//$this->dashboard_model->get_newcareadd_app($admin_id);
		//-----------------end code@mk------------------------------------
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('dashboard/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}
}
