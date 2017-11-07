<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   	    
	     $this->load->model('users_model');
	     $this->load->model('users_smodel');
	     header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	    if (!isset($this->session->userdata['logged_in'])) {
			$this->session->set_flashdata('flash_error', 'Please Login First!!');
			redirect(base_url());
		}	
		elseif($this->session->userdata['logged_in']['user_type'] != 'superadmin'){
			redirect(base_url('index.php/dashboard'));
		}	
   	}
   	// Only for super admin 
	public function index()
	{
		// echo site_url();
		$data["title"] = "Resident";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
	
		$data['arrUser'] = $this->users_model->get_alluser();

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/users/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}
	
	function show($userId) {		
		$data["title"] = "Show Resident";

	
		$data['user_info']=$this->users_model->get_user(array("id" => $userId));

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/users/show',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	function reset($userId)
	 {		
		$data["title"] = "Change Resident password";
		 $npass=  $this->input->post('npass');
//echo $userId; 
		$def_data = array('password'=>md5($npass));
//print_r($def_data);

		$data['user_info']=$this->users_smodel->update(array("id" => $userId),$def_data ,'ci_user');
//print_r($data);
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/users/reset',$data);
		$this->load->view('includes/partials/footer',$data);
		}

	/************************
	* To generate form
	*************************/
	function _generateform($default_data,$validate=0,$current_url)
	{
	
		$data['startform']=form_open_multipart($current_url,'data-parsley-validate class="form-horizontal form-label-left"');

		$data['form']['first_name']['label']=form_label('First Name:*','first_name');
		$data['form']['first_name']['field']=form_input(array('name'=>'first_name','type'=>'text','id'=>'first_name','value'=>$default_data['first_name'],'class'=>'form-control','required'=>'required','autofocus'=>'true'));
		
		$data['form']['last_name']['label']=form_label('Last Name','last_name');
		$data['form']['last_name']['field']=form_input(array('name'=>'last_name','type'=>'text','id'=>'last_name','value'=>$default_data['last_name'],'class'=>'form-control','required'=>'required','autofocus'=>'true'));

		$data['form']['mobile']['label']=form_label('Mobile','mobile');
		$data['form']['mobile']['field']=form_input(array('name'=>'mobile','type'=>'text','id'=>'mobile','value'=>$default_data['mobile'],'class'=>'form-control','autofocus'=>'true'));
			
		$required = 'false';
		$readonly = true;
		if($this->router->fetch_method()=='add')
		{
			$required = "required";
			$default_data['gender'] = "MALE";
			$readonly = false;
		}		
		$data['form']['email']['label']=form_label('Email','email');
		$data['form']['email']['field']=form_input(array('name'=>'email','type'=>'email','id'=>'email','value'=>$default_data['email'],'class'=>'form-control','required'=>'required','readonly'=>$readonly,'autofocus'=>'true'));

		$arrGender=array('MALE'=>'MALE','FEMALE'=>'FEMALE');
		$data['form']['gender']['label']=form_label('Gender:*','gender');	

		foreach ($arrGender as $key=>$value)
		{
			 if($default_data['gender']==$key)
				$data['form']['gender'][$key]['field']="<label class='btn btn-default active' data-toggle-class='btn-primary' data-toggle-passive-class='btn-default'><input type='radio' name='gender' value='".$key."' checked = 'true'>$key</label>";
			 else
				$data['form']['gender'][$key]['field']="<label class='btn btn-default' data-toggle-class='btn-primary' data-toggle-passive-class='btn-default'><input type='radio' name='gender' value='".$key."'>$key</label>";
		}
		$data['form']['room_no']['label']=form_label('Room Number','room_no');
		$data['form']['room_no']['field']=form_input(array('name'=>'room_no','type'=>'text','id'=>'room_no','value'=>$default_data['room_no'],'class'=>'form-control','autofocus'=>'true'));


		$data['form']['property_name']['label']=form_label('Property Name','property_name');
		$data['form']['property_name']['field']=form_input(array('name'=>'property_name','type'=>'text','id'=>'property_name','value'=>$default_data['property_name'],'class'=>'form-control','autofocus'=>'true'));

		
		$data['form']['city']['label']=form_label('City','city');
		$data['form']['city']['field']=form_input(array('name'=>'city','type'=>'text','id'=>'city','value'=>$default_data['city'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['state']['label']=form_label('State','state');
		$data['form']['state']['field']=form_input(array('name'=>'state','type'=>'text','id'=>'state','value'=>$default_data['state'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['pincode']['label']=form_label('Pincode','pincode');
		$data['form']['pincode']['field']=form_input(array('name'=>'pincode','type'=>'text','id'=>'pincode','value'=>$default_data['pincode'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['ad_days']['label']=form_label('Ad days','ad_days');
		$data['form']['ad_days']['field']=form_input(array('name'=>'ad_days','type'=>'text','placeholder'=>'0','id'=>'ad_days','value'=>$default_data['ad_days'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['is_active']['label']=form_label('Is Active?','is_active');
		$data['form']['is_active']['field']=form_checkbox('is_active',1,$default_data['is_active'],('class=flat id=is_active'));
		
		$data['form']['id']['field']=form_hidden('id',isset($default_data['id'])?$default_data['id']:'');

		$data['form']['submit']['field']=form_submit(array('name' =>'submit','class' =>'btn btn-success','value' => 'Submit'));
		$data['endform']=form_close();
		
		//VALIDATE DATA ON REQUESTAuthorised Roles
		if($validate == 1)
		{
			$data['form']['first_name']['errors']=form_error('first_name');
			$data['form']['middle_name']['errors']=form_error('middle_name');
			$data['form']['last_name']['errors']=form_error('last_name');
			$data['form']['email']['errors']=form_error('email');
		}
  		
  		return $data;
	}

	function add() {

		$this->load->library('plivo');
		$data["title"] = "Add Resident";
       
		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

		$default_data['first_name'] = $this->input->post('first_name');	
		// $default_data['middle_name'] = $this->input->post('middle_name');	
		$default_data['last_name'] = $this->input->post('last_name');	
		$default_data['email'] = $this->input->post('email');	
		$default_data['gender'] = $this->input->post('gender');	

		$default_data['property_name'] = $this->input->post('property_name');
		$default_data['room_no'] = $this->input->post('room_no');
		$default_data['city'] = $this->input->post('city');	
		$default_data['state'] = $this->input->post('state');	
		$default_data['pincode'] = $this->input->post('pincode');	
		$default_data['mobile'] = $this->input->post('mobile');	
		$default_data['ad_days'] = $this->input->post('ad_days');	
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;			

			// print($this->input->post());
			// die();
		if(isset($_POST['submit'])) 
		{
			$this->form_validation->set_rules('first_name', 'FirstName', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email');
					
			$default_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
			$default_data['logtime'] = date('Y-m-d H:i:s');

			if($this->form_validation->run() == TRUE)				
			{   		
				$default_data['is_active'] = ($this->input->post('is_active'))?(integer) $this->input->post('is_active'):0;	
       			// $default_data['is_deleted'] = 0;
       	
			    $id_record=$this->user_smodel->insert($default_data, 'ci_user');

			    if (!empty($default_data['mobile'])) {
			    	# code...
			    
			    	$sms_data = array(
					    'src' => '+918950766737', //The phone number to use as the caller id (with the country code). E.g. For USA 15671234567
					    'dst' => $default_data['mobile'], // The number to which the message needs to be send (regular phone numbers must be prefixed with country code but without the ‘+’ sign) E.g., For USA 15677654321.
					    'text' =>  'This is text message' , // The text to send
					    'type' => 'sms', //The type of message. Should be 'sms' for a text message. Defaults to 'sms'
					    'url' => base_url() . 'index.php/plivo_test/receive_sms', // The URL which will be called with the status of the message.
					    'method' => 'POST', // The method used to call the URL. Defaults to. POST
					);
					$response_array = $this->plivo->send_sms($sms_data);
					  if ($response_array[0] == '200')
				        {
				            //$data["response"] = json_decode($response_array[1], TRUE);
							$this->session->set_flashdata('flash_message', 'Record has been added successfully');
				        
				        }
				        else
				        {
				            /*
				             * the response wasn't good, show the error
				             */
							//$this->session->set_flashdata('flash_message', 'Message failed');
				           $this->api_error($response_array);

				        }
			 
			    redirect(site_url('users'));
		       }
			} 
			else 
			{ 	
				$form_data = $this->_generateform($default_data,1,$self_url);	
			}
		}
		else
		{
			$form_data = $this->_generateform($default_data,0,$self_url);

		}
  
		$data["js"] = array("js1" => "parsley/parsley.min.js");

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/user/add',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	function edit($userId,$start=0)
	{
		
		$data["title"] = "Edit Resident";

		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method."/".$userId;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

	
		$edit_data=$this->users_smodel->get_user(array("id" => $userId));

		//$default_data['id'] = $userId;
		// print_r($edit_data);
		// die();
					
		if($this->router->fetch_method()=='edit'  && !empty($edit_data))
		{
			$default_data['first_name'] = $edit_data['first_name'];
			// $default_data['middle_name'] = $edit_data['middle_name'];
			$default_data['last_name'] = $edit_data['last_name'];
			$default_data['email'] = $edit_data['email'];
			$default_data['gender'] = $edit_data['gender'];
		//	$dataq['admin_info']=$this->users_model->get_admindata(array("admin_id" => $admin_id));
			$default_data['property_name'] = $edit_data['property_name'];
			$default_data['room_no'] = $this->input->post('room_no');
			
			$default_data['city'] = $edit_data['city'];
			$default_data['state'] = $edit_data['state'];
			$default_data['pincode'] = $edit_data['pincode'];
			$default_data['mobile'] = $edit_data['mobile'];	
			$default_data['ad_days'] = $edit_data['ad_days'];
			$default_data['is_active'] = $edit_data['is_active'];
		}		
		if(isset($_POST['submit'])) 
		{
			// echo "submit";
			// print_r($this->input->post('ad_days'));
			// die();
			$default_data['first_name'] = $this->input->post('first_name');	
			// $default_data['middle_name'] = $this->input->post('middle_name');	
			$default_data['last_name'] = $this->input->post('last_name');	
			// $default_data['email'] = $this->input->post('email');	
			$default_data['gender'] = $this->input->post('gender');	

			$default_data['property_name'] =$this->input->post('property_name');
			$default_data['room_no'] = $this->input->post('room_no');

			$default_data['city'] = $this->input->post('city');	
			$default_data['state'] = $this->input->post('state');	
			$default_data['pincode'] = $this->input->post('pincode');	
			$default_data['mobile'] = $this->input->post('mobile');	
			$default_data['ad_days'] = $this->input->post('ad_days');	
			$default_data['is_active'] = ($this->input->post('is_active'))?((integer) $this->input->post('is_active')):0;		

			$this->form_validation->set_rules('first_name', 'FirstName', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('ad_days','Ad Days','trim|required|integer');
			
			if($this->form_validation->run() == TRUE)				
			{
				$default_data['id'] = $userId;
				$default_data['modified_at'] = date('Y-m-d H:i:s');
				$data_feed = array('id' => $userId);
			    $id_record=$this->users_smodel->update($data_feed, $default_data, 'ci_user');

			     // print_r($id_record);
			     // die();
			    $this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			    redirect(site_url('users'));
			} 
			else 
				$form_data = $this->_generateform($default_data,1,$self_url);
		}
		else
			$form_data = $this->_generateform($default_data,0,$self_url);
		      		
		$data["js"] = array("js1" => "parsley/parsley.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/users/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function delete($userId)
	{

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$default_data['id'] = $userId;
		$data['user_info']=$this->users_smodel->get_user(array("id" => $userId));
		$default_data['admin_id'] =$data['user_info']['admin_id'];
		
		$default_data['is_deleted'] = 1;
		$id_record=$this->users_smodel->delete($default_data, 'ci_user');
		
	    $this->session->set_flashdata('flash_message', 'Record has been deleted successfully');
	    redirect(site_url('users'));
	}
	  public function api_error($response)
    {
       // echo "<h2>Error</h2>\n";

       // print_r($response);
    }
}
