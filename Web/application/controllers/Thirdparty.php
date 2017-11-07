<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thirdparty extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   

	    $this->load->model('Thirdparty_model');
	    $this->load->library('session');	
	  
   	}
   	public function show_event_form()
   	{
   		$data["assets_path"] = base_url().$this->config->item('assets_path');
   		$this->load->view('user/thirdparty_add_event',$data);
   	}
	public function add()
	{
				// $_POST['resident_phone']="9878787878";
				// $_POST['event_name']='EVENT NAME';
				// $_POST['description']='description HERE';
				// $_POST['location']="HALL";
				// $_POST['meetup_date']=date('Y-m-d');
				// $_POST['meetup_time']=date('H:i:s');
				// $_POST['end_date']=date('Y-m-d');
				// $_POST['end_time']=date('H:i:s');
				// $_POST['api_key']='';

		//----adding planned activity and event-------------------------------------
		if(isset($_POST['resident_phone'])&&isset($_POST['event_name'])&&isset($_POST['description'])&&isset($_POST['location'])&&isset($_POST['meetup_date'])&&isset($_POST['meetup_time'])&&isset($_POST['end_date'])&&isset($_POST['end_time'])&&isset($_POST['api_key']))
		{
			$api_key=$_POST['api_key'];

			$data=array(
				"Resident_phone"=>$_POST['resident_phone'],
				"event_name"=>$_POST['event_name'],
				"description"=>$_POST['description'],
				"location"=>$_POST['location'],
				"meetup_date"=>$_POST['meetup_date'],
				"meetup_time"=>$_POST['meetup_time'],
				"end_date"=>$_POST['meetup_date'],
				"end_time"=>$_POST['end_time'],
				);
			
			//----------------------------------------------------------------------
		 	$valid=$this->Thirdparty_model->key_varification($api_key,'thirdparty_token_tbl');
		 	if($valid==true)
		 	{
				 	$status=$this->Thirdparty_model->insert($data,'resident_thirdparty_tbl');
					if($status)
					{
						$response =array(
						"status"=>"success",
						"text"=>"Event successfully added",
						);
					}
					else
					{
						$response =array(
						"status"=>"error",
						"text"=>"Something is wrong,please try again later"
						);
					}
			}
			else
			{
				$response =array(
						"status"=>"error",
						"text"=>"Please provide valid api key",
						);
			}
		}
		else
		{
			$response =array(
				"status"=>"error",
				"text"=>"Please provide all required field values"
				);
			
		}
		echo json_encode($response);
	}

	public function get_via_phonenumber()
	{
			//  $_GET['resident_phone']="8767767777";
			// $_GET['api_key']='10cf93697d7155ac0d368bbafbc842a4';
		//----adding planned activity and event-------------------------------------
		if(isset($_GET['resident_phone'])&&isset($_GET['api_key']))
		{
			$data=array(
				"Resident_phone"=>$_GET['resident_phone']
				
				);
			$api_key=$_GET['api_key'];
			//----------------------------------------------------------------------
			$valid=$this->Thirdparty_model->key_varification($api_key,'thirdparty_token_tbl');
		 	if($valid==true)
		 	{
				 	$result=$this->Thirdparty_model->get_via_phone($data,'resident_thirdparty_tbl');
					if(!empty($result))
					{
						$response =array(
						"status"=>"success",
						"result"=>$result
						);
					}
					else
					{
						$response =array(
						"status"=>"success",
						"text"=>"No Event exist"
						);
					}
			}
			else
			{
				$response =array(
						"status"=>"error",
						"text"=>"Please provide valid api key",
						);
			}
		}
		else
		{
			$response =array(
				"status"=>"error",
				"text"=>"Please provide required field"
				);
			
		}
		echo json_encode($response);
	}

	
}
