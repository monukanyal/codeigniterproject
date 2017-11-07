<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   	    
	    $this->load->model('user_model');
	    header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	    if (!isset($this->session->userdata['logged_in'])) {
			$this->session->set_flashdata('flash_error', 'Please Login First!!');
			redirect(base_url());
		}		
   	}
	public function index()
	{
		// echo site_url();
		$data["title"] = "Resident";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$data['arrUser'] = $this->user_model->get_alluser($data_feed);

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('user/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}
	public function childindex($parrentId)
	{
	
		$data["title"] = "Resident";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$pID =  array("parrent" => $parrentId);
		$data['arrUser'] = $this->user_model->childuser($pID);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('user/childindex',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function child_listing()
	{
	
		$data["title"] = "Care Listing";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		//$pID =  array("parrent" => $parrentId);
		$data['arrUser'] = $this->user_model->allchilduser();
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('user/child_listing');
		$this->load->view('includes/partials/footer',$data);
	}
	
	function show($userId) {		
		$data["title"] = "Show Resident";

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$data['user_info']=$this->user_model->get_user(array("id" => $userId, "admin_id" => $admin_id));
		
		 $mobile_num = $data['user_info']['mobile'];

			if(  preg_match( '/(\d{3})(\d{3})(\d{4})$/', $mobile_num,  $matches ) )
			{
			   $result = '('.$matches[1] . ') ' .$matches[2] . '-' . $matches[3];
			  
			}
		$data['user_info']['mobile']= $result;
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('user/show',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	/************************
	* To generate form
	*************************/
	function _generateform($default_data,$validate=0,$current_url)
	{
	
		$data['startform']=form_open_multipart($current_url,'data-parsley-validate class="form-horizontal form-label-left"');

		$data['form']['first_name']['label']=form_label('First Name:*','first_name');
		$data['form']['first_name']['field']=form_input(array('name'=>'first_name','type'=>'text','id'=>'first_name','value'=>$default_data['first_name'],'class'=>'form-control','required'=>'required','autofocus'=>'true','pattern'=>'^[A-z]+$','minlength'=>'3'));
		
		$data['form']['last_name']['label']=form_label('Last Name:*','last_name');
		$data['form']['last_name']['field']=form_input(array('name'=>'last_name','type'=>'text','id'=>'last_name','value'=>$default_data['last_name'],'class'=>'form-control','required'=>'required','autofocus'=>'true','pattern'=>'^[A-z]+$','minlength'=>'3'));

		$data['form']['mobile']['label']=form_label('Mobile:*','mobile');
		$data['form']['mobile']['field']=form_input(array('name'=>'mobile','type'=>'text','id'=>'mobile','value'=>$default_data['mobile'],'class'=>'form-control','autofocus'=>'true','required'=>'required','maxlength'=>'14','placeholder'=>'xxx-xxx-xxxx' ));
		
		// $data['form']['child_mobile']['label']=form_label('Child Mobile:*','child_mobile');
		// $data['form']['child_mobile']['field']=form_input(array('name'=>'child_mobile','type'=>'text','id'=>'child_mobile','value'=>$default_data['child_mobile'],'class'=>'form-control','autofocus'=>'true','required'=>'required','maxlength'=>'14','placeholder'=>'xxx-xxx-xxxx' ));
			
		$required = 'false';
		$readonly = true;
		if($this->router->fetch_method()=='add')
		{
			$required = "required";
			$default_data['gender'] = "MALE";
			$readonly = false;
		}		
		$data['form']['email']['label']=form_label('Email','email');
		$data['form']['email']['field']=form_input(array('name'=>'email','type'=>'email','id'=>'email','value'=>$default_data['email'],'class'=>'form-control','readonly'=>$readonly,'autofocus'=>'true'));

		$arrGender=array('MALE'=>'MALE','FEMALE'=>'FEMALE');
		$data['form']['gender']['label']=form_label('Gender:*','gender');	

		foreach ($arrGender as $key=>$value)
		{
			 if($default_data['gender']==$key)
				$data['form']['gender'][$key]['field']="<label class='btn btn-default active' data-toggle-class='btn-primary' data-toggle-passive-class='btn-default'><input type='radio' name='gender' value='".$key."' checked='true'/>$key</label>";
			 else
				$data['form']['gender'][$key]['field']="<label class='btn btn-default' data-toggle-class='btn-primary' data-toggle-passive-class='btn-default'><input type='radio' name='gender' value='".$key."'/>$key</label>";
		}
		$data['form']['room_no']['label']=form_label('Room Number','room_no');
		$data['form']['room_no']['field']=form_input(array('name'=>'room_no','type'=>'text','id'=>'room_no','value'=>$default_data['room_no'],'class'=>'form-control','autofocus'=>'true','data-parsley-type'=>'integer','title'=>'Enter Only Number..!!','pattern'=>'^[0-9]+$'));


		$data['form']['property_name']['label']=form_label('Property Name','property_name');
		$data['form']['property_name']['field']=form_input(array('name'=>'property_name','type'=>'text','id'=>'property_name','value'=>$default_data['property_name'],'class'=>'form-control','autofocus'=>'true'));

		
		$data['form']['city']['label']=form_label('City','city');
		$data['form']['city']['field']=form_input(array('name'=>'city','type'=>'text','id'=>'city','value'=>$default_data['city'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['state']['label']=form_label('State','state');
		$data['form']['state']['field']=form_input(array('name'=>'state','type'=>'text','id'=>'state','value'=>$default_data['state'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['pincode']['label']=form_label('Zipcode','pincode');
		$data['form']['pincode']['field']=form_input(array('name'=>'pincode','type'=>'text','id'=>'pincode','value'=>$default_data['pincode'],'class'=>'form-control','autofocus'=>'true'));

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

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$dataq['admin_info']=$this->user_model->get_admindata(array("admin_id" => $admin_id));

		$default_data['property_name'] = $dataq['admin_info'][0]['address'];
		$default_data['room_no'] = $this->input->post('room_no');
		$default_data['city'] = $this->input->post('city');	
		$default_data['state'] = $this->input->post('state');	
		$default_data['pincode'] = $this->input->post('pincode');
		$phone_number = $this->input->post('mobile');
		$child_phone_number = $this->input->post('child_mobile');

		$default_data['mobile'] = $phone_number;
		$default_data['child_mobile'] = $child_phone_number;	
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;
		
		$rand_start1 = mt_rand(000,999);
		$rand_start2 = mt_rand(000,999);
		$rand_res = $rand_start1 . $rand_start2;
		
		$default_data['appcode'] = 	$rand_res;		
		$default_data['appactive'] = 0;		

		// print_r($default_data);
		// die();
		if(isset($_POST['submit'])) 
		{
			$phone_number  = "";
			$phone_number .= $this->input->post('mobile');
			$phone_number = str_replace("(","",$phone_number);	
			$phone_number = str_replace(")","",$phone_number);	
			$phone_number = str_replace(" ","",$phone_number);	
			$phone_number = str_replace("-","",$phone_number);
			
			$child_phone_number  = "";
			// $child_phone_number .= $this->input->post('child_mobile');
			$child_phone_number = str_replace("(","",$child_phone_number);	
			$child_phone_number = str_replace(")","",$child_phone_number);	
			$child_phone_number = str_replace(" ","",$child_phone_number);	
			$child_phone_number = str_replace("-","",$child_phone_number);

			$default_data['mobile'] = $phone_number;
			// $default_data['child_mobile'] = $child_phone_number;
			//echo $phone_number;
			$data_feed['phoneno'] = $phone_number;

			$mobiledata['ci_user'] = $this->user_model->get_mobileinfo($data_feed,'ci_user');
		
			$mobiledata['ci_admin'] = $this->user_model->get_mobileinfo($data_feed,'ci_admin');
			$mobiledata['ci_staff'] = $this->user_model->get_mobileinfo($data_feed,'ci_staff');
	
 			if ((!empty($mobiledata['ci_user'])) && (!empty($mobiledata['ci_user'])) && (!empty($mobiledata['ci_user']))) 
 			{
 				$this->session->set_flashdata('flash_message', 'Record alredy exists');
 				$form_data = $this->_generateform($default_data,0,$self_url);
 			}
 			else
 			{
				$this->form_validation->set_rules('first_name', 'FirstName', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('email','Email','trim|valid_email');
					
				$default_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
				$default_data['logtime'] = date('Y-m-d H:i:s');
			
			//if($this->form_validation->run() == TRUE)				
			//{   		
				$default_data['is_active'] = ($this->input->post('is_active'))?(integer) $this->input->post('is_active'):0;	
       			
	
			    $id_record=$this->user_model->insert($default_data, 'ci_user');
			  	$user_idmd5 = md5($id_record);
			    if (!empty($default_data['mobile'])) {
			    	# code...
			        $site_url = base_url('index.php/applink');
			    	$sms_data = array(
					    'src' => '+15125663933', //The phone number to use as the caller id (with the country code). E.g. For USA 15671234567
					    'dst' => "+1".$default_data['mobile'], // The number to which the message needs to be send (regular phone numbers must be prefixed with country code but without the ‘+’ sign) E.g., For USA 15677654321.
					    //'text' =>  'This is your app installation link : https://play.google.com/store/apps/details?id=com.community.resident&referrer='.$user_idmd5.'', // The text to send
					    'text' =>  'Your App ready to install Please open this link "'.$site_url.'"', // The text to send
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
			 
			    redirect(site_url('user'));
		       }
			//} 
			// else 
			// { 	
			// 	$form_data = $this->_generateform($default_data,1,$self_url);	
			// }
				// }
 			// else
 			// {
 			// 		$this->session->set_flashdata('flash_message', 'Record alredy exists');
 			// 		  redirect(site_url('user'));
 			// }
		   }
		}
		else
		{
			$form_data = $this->_generateform($default_data,0,$self_url);

		}
  
		$data["js"] = array("js1" => "parsley/parsley.min.js");

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('user/add',$form_data);
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

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$edit_data =$this->user_model->get_user(array("id" => $userId, "admin_id" => $admin_id));
		$parentId  = array("parentid" => $edit_data['belongs_to']);
		$parendata['arrUser'] = $this->user_model->getparentuser($parentId);
		$userdata = array();

		//print_r($parendata['arrUser']);
		
		if($this->router->fetch_method()=='edit'  && !empty($edit_data))
		{
			$default_data['first_name'] = $edit_data['first_name'];
			// $default_data['middle_name'] = $edit_data['middle_name'];
			$default_data['last_name'] = $edit_data['last_name'];
			$default_data['email'] = $edit_data['email'];
			$default_data['gender'] = $edit_data['gender'];
			$dataq['admin_info']=$this->user_model->get_admindata(array("admin_id" => $admin_id));
			$default_data['property_name'] = $dataq['admin_info'][0]['address'];
			$default_data['room_no'] = $this->input->post('room_no');
			
			$default_data['city'] = $edit_data['city'];
			$default_data['state'] = $edit_data['state'];
			$default_data['pincode'] = $edit_data['pincode'];
			
			 $mobile_num = $edit_data['mobile'];

			if(  preg_match( '/(\d{3})(\d{3})(\d{4})$/', $mobile_num,  $matches ) )
			{
			   $result = '('.$matches[1] . ') ' .$matches[2] . '-' . $matches[3];
			  
			}

			$default_data['mobile']= $result;
			$default_data['is_active'] = $edit_data['is_active'];
		}		
		if(isset($_POST['submit'])) 
		{
			$default_data['first_name'] = $this->input->post('first_name');	
			// $default_data['middle_name'] = $this->input->post('middle_name');	
			$default_data['last_name'] = $this->input->post('last_name');	
			// $default_data['email'] = $this->input->post('email');	
			$default_data['gender'] = $this->input->post('gender');	

			$default_data['property_name'] = $dataq['admin_info'][0]['address'];
			$default_data['room_no'] = $this->input->post('room_no');

			$default_data['city'] = $this->input->post('city');	
			$default_data['state'] = $this->input->post('state');	
			$default_data['pincode'] = $this->input->post('pincode');	
			$phone_number= $this->input->post('mobile');	
						$mobile1=str_replace(' ','', $phone_number);
						$mobile2= str_replace('(','', $mobile1);
						$mobile3= str_replace(')','', $mobile2);
						$mobile4= str_replace('-','', $mobile3);
						//print_r($mobile);

						$default_data['mobile'] =$mobile4;
						//print_r($default_data);
			$default_data['is_active'] = ($this->input->post('is_active'))?((integer) $this->input->post('is_active')):0;		

			$this->form_validation->set_rules('first_name', 'FirstName', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email');
			if($this->form_validation->run() == TRUE)				
			{
				$default_data['id'] = $userId;
				$default_data['modified_at'] = date('Y-m-d H:i:s');
				$data_feed = array('id' => $userId, 'admin_id' => $admin_id);
			    $id_record=$this->user_model->update($data_feed, $default_data, 'ci_user');
			    $this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			    redirect(site_url('user'));
			} 
			else 
				$form_data = $this->_generateform($default_data,1,$self_url);
		}
		else
			$form_data = $this->_generateform($default_data,0,$self_url);
		      		
		$data["js"] = array("js1" => "parsley/parsley.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
	
		$form_data['parrentId'] = $userId;
		$this->load->view('user/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	// 21 Oct 2016 Create child controller 

	function child($parentId) {

		$this->load->library('plivo');
		$data["title"] = "Add Resident";
       
		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

		$default_data['first_name'] = $this->input->post('first_name');	
		$default_data['last_name'] = $this->input->post('last_name');	
		$default_data['email'] = $this->input->post('email');	
		$default_data['gender'] = $this->input->post('gender');	

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$dataq['admin_info']=$this->user_model->get_admindata(array("admin_id" => $admin_id));

		$default_data['property_name'] = $dataq['admin_info'][0]['address'];
		$default_data['room_no'] = $this->input->post('room_no');
		$default_data['city'] = $this->input->post('city');	
		$default_data['state'] = $this->input->post('state');	
		$default_data['pincode'] = $this->input->post('pincode');
		$phone_number = $this->input->post('mobile');
		// $child_phone_number = $this->input->post('child_mobile');

		$default_data['mobile'] = $phone_number;
		// $default_data['child_mobile'] = $child_phone_number;	
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;
		
		$rand_start1 = mt_rand(000,999);
		$rand_start2 = mt_rand(000,999);
		$rand_res = $rand_start1 . $rand_start2;
		
		$default_data['appcode'] = 	$rand_res;		
		$default_data['appactive'] = 0;		
	
		// print_r($default_data);
		// die();
		if(isset($_POST['submit'])) 
		{
			$phone_number  = "";
			$phone_number .= $this->input->post('mobile');
			$phone_number = str_replace("(","",$phone_number);	
			$phone_number = str_replace(")","",$phone_number);	
			$phone_number = str_replace(" ","",$phone_number);	
			$phone_number = str_replace("-","",$phone_number);
			
			$child_phone_number  = "";
			$child_phone_number .= $this->input->post('child_mobile');
			$child_phone_number = str_replace("(","",$child_phone_number);	
			$child_phone_number = str_replace(")","",$child_phone_number);	
			$child_phone_number = str_replace(" ","",$child_phone_number);	
			$child_phone_number = str_replace("-","",$child_phone_number);

			$default_data['mobile'] = $phone_number;
			$default_data['child_mobile'] = $child_phone_number;
			//echo $phone_number;
			$data_feed['phoneno'] = $phone_number;

			$mobiledata['ci_user'] = $this->user_model->get_mobileinfo($data_feed,'ci_user');
		
			$mobiledata['ci_admin'] = $this->user_model->get_mobileinfo($data_feed,'ci_admin');
			$mobiledata['ci_staff'] = $this->user_model->get_mobileinfo($data_feed,'ci_staff');
	
 			if ((!empty($mobiledata['ci_user'])) && (!empty($mobiledata['ci_user'])) && (!empty($mobiledata['ci_user']))) 
 			{
 				$this->session->set_flashdata('flash_message', 'Record alredy exists');
 				$form_data = $this->_generateform($default_data,0,$self_url);
 			}
 			else
 			{
				$this->form_validation->set_rules('first_name', 'FirstName', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('email','Email','trim|valid_email');
					
				$default_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
				$default_data['logtime'] = date('Y-m-d H:i:s');
			
			//if($this->form_validation->run() == TRUE)				
			//{   		
				$default_data['is_active'] = ($this->input->post('is_active'))?(integer) $this->input->post('is_active'):0;	
       			$default_data['user_type'] = 'child';
       			$default_data['belongs_to'] = $this->input->post('parentID');
	
			    $id_record=$this->user_model->insert($default_data, 'ci_user');
			  	$user_idmd5 = md5($id_record);
			    if (!empty($default_data['mobile'])) {
			    	# code...
			        $site_url = base_url('index.php/applink');
			    	$sms_data = array(
					    'src' => '+15125663933', //The phone number to use as the caller id (with the country code). E.g. For USA 15671234567
					    'dst' => "+1".$default_data['mobile'], // The number to which the message needs to be send (regular phone numbers must be prefixed with country code but without the ‘+’ sign) E.g., For USA 15677654321.
					    //'text' =>  'This is your app installation link : https://play.google.com/store/apps/details?id=com.community.resident&referrer='.$user_idmd5.'', // The text to send
					    'text' =>  'Your App ready to install Please open this link "'.$site_url.'"', // The text to send
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
			 
			    redirect(site_url('user'));
		       }
			//} 
			// else 
			// { 	
			// 	$form_data = $this->_generateform($default_data,1,$self_url);	
			// }
				// }
 			// else
 			// {
 			// 		$this->session->set_flashdata('flash_message', 'Record alredy exists');
 			// 		  redirect(site_url('user'));
 			// }
		   }
		}
		else
		{
			$form_data = $this->_generateform($default_data,0,$self_url);

		}
  
		$data["js"] = array("js1" => "parsley/parsley.min.js");

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$form_data['parentIds'] = $parentId;
		$this->load->view('user/childadd',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}



	public function delete($userId)
	{
		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$default_data['id'] = $userId;
		$default_data['admin_id'] = $admin_id;
		$default_data['is_deleted'] = 1;
		$id_record=$this->user_model->delete($default_data, 'ci_user');
		
	    $this->session->set_flashdata('flash_message', 'Record has been deleted successfully');
	    redirect(site_url('user'));
	}
	  public function api_error($response)
    {
       // echo "<h2>Error</h2>\n";

       // print_r($response);
    }
}