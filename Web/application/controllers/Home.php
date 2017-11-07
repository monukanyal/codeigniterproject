<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{
	function __construct() 
   	{
	    parent::__construct(); 	   
	    $this->load->model('event_model');
		$this->load->library('session');
	    $this->load->model('auth_model');               
	    $this->load->model('meal_model');               
	    $this->load->model('event_model');               
	    $this->load->model('user_model');
	    header('Access-Control-Allow-Origin: *');
       header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");	  
   	}
	public function index()
	{
		$data["title"] = "Home";
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		
		//Getting calender event data using the admin id.
		if(isset($_GET['admin_id'])){
			$admin_id = $_GET['admin_id']; 
			$send_data['admin_id'] = $admin_id;
			$data['get_calender_events']=$this->event_model->get_calender_events($send_data, 'ci_plan_event');
		}elseif(isset($_GET['sitecode'])){//Getting calendar event data using the sitecode.
 			$sitecode = $_GET['sitecode'];
 			$data['result'] = $this->user_model->get_admin_bysitecode($sitecode);
			//echo "<pre>";print_r($data);die();
			
			if($data['result']['sitecode_exist'] == "true"){
		 		$send_data['admin_id'] = $data['result']['admin_id'];
				$data['get_calender_events']=$this->event_model->get_calender_events($send_data, 'ci_plan_event');
				//echo "<pre>";print_r($data);die();
			}else{
				$data['sitecode_notexisterr'] = "Sitecode not exists.";
			}
 		}else{
			//$admin_id=1; //admin id bydefault
			//$send_data['admin_id'] = $admin_id;
 			//$data['get_calender_events']=$this->event_model->get_calender_events($send_data, 'ci_plan_event');
 		}

 		$this->load->view('home/index',$data);
		$remember = $this->input->post('remember_me');
		//print_r($remember);
		if($remember){
			$this->session->set_userdata('remember_me', true);
		}
	}
	public function get_adminid_bysitecode(){
		$sitecode = $_POST['scode'];
		$data['result'] = $this->user_model->get_admin_bysitecode($sitecode);
		//print_r($data);die();
		
		if($data['result']['sitecode_exist'] == "true"){
			$data['admin_id'] = $data['result']['admin_id'];
	 		echo json_encode($data);
		}else{
			$data['errmsg'] = "sitecode does not exists.";
			echo json_encode($data);
		}
	}
	public function auto_gen_sitecode()
	{
		//get all admin_id, address and sitecode from ci_admin table.
		$all_admin = $this->user_model->get_all_admindata();
		print_r($all_admin);
		//die();
	}
	public function confirm_account($code)
	{
		$status=$this->user_model->confirm_account($code);
		if(!empty($status))
		{
			?>
			<script type="text/javascript">
				window.open('<?php echo site_url('Home'); ?>','_self');
			</script>
			<?php

		}
	}
	public function test()
	{
		 if (!is_writable(session_save_path())) {
    echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
}else
{
	echo "writable".session_save_path();
}  
		//phpinfo();
	}

	
	
}
?>
