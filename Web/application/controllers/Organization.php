<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	
	     header('Access-Control-Allow-Origin: *');
         header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");   	    
	     $this->load->model('user_model');  //<--@mkcode
	     $this->load->model('users_smodel');
	     $this->load->model('organization_model');
	     $this->load->model('common_model');

	    if (!isset($this->session->userdata['logged_in'])) {
			$this->session->set_flashdata('flash_error', 'Please Login First!!');
			redirect(base_url());
		}

		elseif($this->session->userdata['logged_in']['user_type'] != 'superadmin'){
			redirect(base_url('index.php/dashboard'));
		}

   	}
	public function index()
	{
		// echo site_url();
		$data["title"] = "Organization";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		
		$data['organization'] = $this->organization_model->get_allorganization();
		$tablename = 'ci_user';
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/organization/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}
	
	function show($organizationId) {		
		$data["title"] = "Show Staff";

		$data['organization_info']=$this->organization_model->get_organization(array("id" => $organizationId));
		

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/organization/show',$data);
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
		
		$data['form']['middle_name']['label']=form_label('Middle Name','middle_name');
		$data['form']['middle_name']['field']=form_input(array('name'=>'middle_name','type'=>'text','id'=>'middle_name','value'=>$default_data['middle_name'],'class'=>'form-control','autofocus'=>'true'));
		
		$data['form']['last_name']['label']=form_label('Last Name','last_name');
		$data['form']['last_name']['field']=form_input(array('name'=>'last_name','type'=>'text','id'=>'last_name','value'=>$default_data['last_name'],'class'=>'form-control','required'=>'required','autofocus'=>'true'));

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


		$data['form']['password']['label']=form_label('Password','password');
		$data['form']['password']['field']=form_input(array('name'=>'password','type'=>'password','id'=>'password','value'=>'','class'=>'form-control',"required" => $required,'autofocus'=>'true'));
		
		$data['form']['cnpassword']['label']=form_label('Confirm Password','cnpassword');
		$data['form']['cnpassword']['field']=form_input(array('name'=>'cnpassword','type'=>'password','id'=>'cnpassword','value'=>'','class'=>'form-control',"required" => $required,'autofocus'=>'true'));
	
		$data['form']['address']['label']=form_label('Address','address');
		$data['form']['address']['field']=form_input(array('name'=>'address','type'=>'text','id'=>'address','value'=>$default_data['address'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['city']['label']=form_label('City','city');
		$data['form']['city']['field']=form_input(array('name'=>'city','type'=>'text','id'=>'city','value'=>$default_data['city'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['state']['label']=form_label('State','state');
		$data['form']['state']['field']=form_input(array('name'=>'state','type'=>'text','id'=>'state','value'=>$default_data['state'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['pincode']['label']=form_label('Pincode','pincode');
		$data['form']['pincode']['field']=form_input(array('name'=>'pincode','type'=>'text','id'=>'pincode','value'=>$default_data['pincode'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['mobile']['label']=form_label('Mobile','mobile');
		$data['form']['mobile']['field']=form_input(array('name'=>'mobile','type'=>'text','id'=>'mobile','value'=>$default_data['mobile'],'class'=>'form-control','autofocus'=>'true'));


		$data['form']['is_active']['label']=form_label('Is Active?','is_active');
		$data['form']['is_active']['field']=form_checkbox('is_active',1,$default_data['is_active'],('class=flat id=is_active'));
		
		$data['form']['id']['field']=form_hidden('id',isset($default_data['id'])?$default_data['id']:'');

		$data['form']['submit']['field']=form_submit(array('name' =>'submit','class' =>'btn btn-success','value' => 'Submit'));
		$data['endform']=form_close();
		
		//VALIDATE DATA ON REQUESTAuthorised Roles
		if($validate == 1)
		{
			$data['form']['first_name']['errors']=form_error('first_name');
			// $data['form']['middle_name']['errors']=form_error('middle_name');
			$data['form']['last_name']['errors']=form_error('last_name');
			$data['form']['email']['errors']=form_error('email');
			$data['form']['password']['errors']=form_error('password');
			$data['form']['cnpassword']['errors']=form_error('cnpassword');
		}
  		
  		return $data;
	}

	function add() {
		$data["title"] = "Add Admin";
       
		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

		$default_data['first_name'] = $this->input->post('first_name');	
		$default_data['middle_name'] = $this->input->post('middle_name');	
		$default_data['last_name'] = $this->input->post('last_name');	
		$default_data['email'] = $this->input->post('email');	
		$default_data['password'] = $this->input->post('password');	
		
		$default_data['address'] = $this->input->post('address');	
		$default_data['city'] = $this->input->post('city');	
		$default_data['state'] = $this->input->post('state');	
		$default_data['pincode'] = $this->input->post('pincode');	
		$default_data['mobile'] = $this->input->post('mobile');	
	
	
		
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;			

		
		if(isset($_POST['submit'])) 
		{
			// print_r($this->input->post());
			// die();
			$this->form_validation->set_rules('first_name', 'FirstName', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('cnpassword','Confirm Password','trim|required|min_length[4]|max_length[32]|matches[password]');
					
			$default_data['logtime'] = date('Y-m-d H:i:s');

			if($this->form_validation->run() == TRUE)				
			{ 

				if(isset($_FILES) && $_FILES!='')
				{ 
					foreach ($_FILES as $fieldname => $fileObject)  //fieldname is the form field name
					{
						if (!empty($fileObject['name']))
						{
							$config = array();
							$config['upload_path'] = $this->config->item('upload_staff_real').$default_data['admin_id']."/";
							$config['allowed_types'] = '*';
								
							$config['encrypt_name'] = false;
							$config['create_thumb'] = "TRUE";
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							$this->load->library('image_lib');	

							$this->common_model->check_make_dir($config['upload_path']);

							if ( ! $this->upload->do_upload($fieldname))
							{
								$error = array('error' => $this->upload->display_errors());
								 print_r($error);die('error');
							}	
							else
							{
								$data = array('upload_data' => $this->upload->data());
								
								$error = array('error' => $this->upload->display_errors());
								$img_name = $data['upload_data']['file_name'];
								
								if($data['upload_data']['image_width'] > 800 || $data['upload_data']['image_height'] > 800)
								{
									$img_resized = $this->common_model->resize_file($config['upload_path'],$img_name, 100);			
									unlink($config['upload_path'].$img_name);
									$img_name = $img_resized;
								}
							
								$default_data[$fieldname] = $img_name;		
						    }
						}
				 	} //End Foreach
				}  		
				$default_data['is_active'] = ($this->input->post('is_active'))?(integer) $this->input->post('is_active'):0;	
				$default_data['password'] = md5($this->input->post('password'));	
       			// $default_data['is_deleted'] = 0;
			    $id_record=$this->organization_model->insert($default_data, 'ci_admin');
			    //------------@mkcode 18 may-----------------------------
			    $this->organization_model->add_billing_entry($id_record);
			    //--------------@mkcode end------------------------------
			    $this->session->set_flashdata('flash_message', 'Record has been added successfully');

			    redirect(site_url('organization'));
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
		      		
		$data["css"] = array("css1" => "jquery.ui.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/organization/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	function edit($staffId,$start=0)
	{
		
		$data["title"] = "Edit Staff";

		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method."/".$staffId;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

	
		$edit_data=$this->organization_model->get_organization_data(array("id" => $staffId));
	
		//$default_data['id'] = $staffId;


		$default_data = array();
		if($this->router->fetch_method()=='edit'  && !empty($edit_data))
		{
			$default_data['first_name'] = $edit_data['first_name'];
			$default_data['middle_name'] = $edit_data['middle_name'];
			$default_data['last_name'] = $edit_data['last_name'];
			$default_data['email'] = $edit_data['email'];
			$default_data['password'] = $edit_data['password'];
		
			$default_data['address'] = $edit_data['address'];
			$default_data['city'] = $edit_data['city'];
			$default_data['state'] = $edit_data['state'];
			$default_data['pincode'] = $edit_data['pincode'];
			$default_data['mobile'] = $edit_data['mobile'];


			$default_data['is_active'] = $edit_data['is_active'];
		}		
		if(isset($_POST['submit'])) 
		{
			$default_data['first_name'] = $this->input->post('first_name');	
			$default_data['middle_name'] = $this->input->post('middle_name');	
			$default_data['last_name'] = $this->input->post('last_name');	
			// $default_data['email'] = $this->input->post('email');	
			$default_data['password'] = $this->input->post('password');	
		
			$default_data['address'] = $this->input->post('address');	
			$default_data['city'] = $this->input->post('city');	
			$default_data['state'] = $this->input->post('state');	
			$default_data['pincode'] = $this->input->post('pincode');	
			$default_data['mobile'] = $this->input->post('mobile');	
		
		
			$default_data['is_active'] = ($this->input->post('is_active'))?((integer) $this->input->post('is_active')):0;		
			// print_r($default_data);
			// die();

			$this->form_validation->set_rules('first_name', 'FirstName', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('password','Password','trim|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('cnpassword','Confirm Password','trim|min_length[4]|max_length[32]|matches[password]');
			if($this->form_validation->run() == TRUE)				
			{
				if(isset($_FILES) && $_FILES!='')
				{ 
					foreach ($_FILES as $fieldname => $fileObject)  //fieldname is the form field name
					{
						if (!empty($fileObject['name']))
						{
							$config = array();
							$config['upload_path'] = $this->config->item('upload_staff_real').$admin_id."/";
							$config['allowed_types'] = '*';
								
							$config['encrypt_name'] = false;
							$config['create_thumb'] = "TRUE";
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							$this->load->library('image_lib');	

							$this->common_model->check_make_dir($config['upload_path']);

							if ( ! $this->upload->do_upload($fieldname))
							{
								$error = array('error' => $this->upload->display_errors());
								 print_r($error);die('error');
							}	
							else
							{
								$data = array('upload_data' => $this->upload->data());
								
								$error = array('error' => $this->upload->display_errors());
								$img_name = $data['upload_data']['file_name'];
								
								if($data['upload_data']['image_width'] > 800 || $data['upload_data']['image_height'] > 800)
								{
									$img_resized = $this->common_model->resize_file($config['upload_path'],$img_name, 100);			
									unlink($config['upload_path'].$img_name);
									$img_name = $img_resized;
								}						
								
								$default_data[$fieldname] = $img_name;		
						    }
						}
				 	} //End Foreach
				}

				$default_data['id'] = $staffId;
				$default_data['password'] = ($this->input->post('password'))?(md5($default_data['password'])):$edit_data['password'];
				$default_data['modified_at'] = date('Y-m-d H:i:s');
				$data_feed = array('id' => $staffId);
			    $id_record=$this->organization_model->update($data_feed, $default_data, 'ci_admin');
			    $this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			     redirect(site_url('organization'));
			} 
			else 
				$form_data = $this->_generateform($default_data,1,$self_url);
		}
		else
			$form_data = $this->_generateform($default_data,0,$self_url);
		      		
		$data["css"] = array("css1" => "jquery.ui.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
			$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/organization/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function delete($staffId)
	{
		$admin_id = $this->session->userdata['logged_in']['id'];
		$default_data['id'] = $staffId;
		$data['organization_info']=$this->organization_model->get_organization_data(array("id" => $staffId));
		//$default_data['admin_id'] = $admin_id;
		$default_data['admin_id'] =$data['organization_info']['id'];
		//print_r($default_data);
		$default_data['is_deleted'] = 1;
		$id_record=$this->organization_model->delete($default_data, 'ci_admin');
		
	    $this->session->set_flashdata('flash_message', 'Record has been deleted successfully');
	    redirect(site_url('organization'));
	}

	//-------@mkcode 17 may start-------
	public function show_admin_info($admin_id)
	{
		$data["title"] = "admin";
		$data["message"] = "";
		$data["error"] = "";
		 $userId = array("admin_id" => $admin_id);
		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		 //-----set charge form data------
		 $data['maindata']=$this->user_model->get_fee_details($admin_id);
		 //-------------------------------
		$data['user_info']=$this->user_model->get_admindata($userId);
        $data['billdata']=$this->user_model->get_billing_info($admin_id);
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/admin_info',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function get_month_complete_data()
	{
		$admin_id=$_POST['admin_id'];
		$bill_id=$_POST['bill_id'];
		$bill_pay_data=$this->user_model->check_bill_paid($admin_id,$bill_id);
		?>
			 <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-body">
                                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                                   <table>
                                    <?php if(isset($bill_pay_data['complete_bill_info'])){
                                        $cb=$bill_pay_data['complete_bill_info'];
                                        $cb_arr=explode(",",$cb);
                                       // print_r($cb_arr);
                                     ?>
                                        <table class="table"> 
                                        <tr style="background-color: #1A82C3;">
                                            <th colspan="2" style="color: #fff;  border-right: none; font-family: 'arial'; font-size: 20px; ">Billing Information</th>
                                        </tr>
                                        <tr>
                                        <td style="width: 430px">Facility Fee :</td>
                                        <td><?php echo  '$'.$cb_arr[0]; ?></td>
                                        </tr>
                                        <tr>
                                        <td>Resident Fee : <span>[<?php echo  '$'.$cb_arr[1]; ?>]</span> x Number of Resident:<span>[<?php echo  $cb_arr[2]; ?>]</span> </td>
                                        <td><?php echo '$'.$cb_arr[1]*$cb_arr[2]; ?></td>
                                        </tr>
                                        <tr>
                                        <td>Care Account Fee :<span>[<?php echo  '$'.$cb_arr[3]; ?>]</span> x Number of Care a/c :<span>[<?php echo  $cb_arr[4]; ?>]</span></td>
                                        <td><?php echo '$'.$cb_arr[3]*$cb_arr[4]; ?></td>
                                        </tr>
                                        <tr>
                                        <td> Message Fee:<span>[<?php echo  '$'.$cb_arr[5]; ?>]</span> x Number of Message : <span>[<?php echo  '$'.$cb_arr[6]; ?>]</span></td>
                                        <td><?php echo '$'.$cb_arr[5]*$cb_arr[6]; ?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>

                                        </table>
                                      <button type="button" id="proceed_to_pay_btn" class="btn btn-success" data-dismiss="modal">Close</button>
                                 </div>
                                </div>
                                <?php
	}

	public function change_fee()
	{
		$fac=$_POST['fac'];
		$care=$_POST['care'];
		$res=$_POST['res'];
		$msg=$_POST['msg'];
		$type=$_POST['type'];
		$admin_id=$_POST['admin_id'];
		$data = array(
	        'facility_fee' => $fac,
	        'resident_fee' => $res,
	        'care_account_fee' => $care,
	        'msg_fee'=>$msg
		);
		$status=$this->user_model->update_new_fee($data,$type,$admin_id);
		if($status==200)
		{
			echo "done";
		}
		else
		{
			echo "";
		}
	}
	
	public function edit_admin_info($admin_id)
	{
		$data["title"] = "admin";
		$data["message"] = "";
		$data["error"] = "";
		 $userId = array("admin_id" => $admin_id);
		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data['user_info']=$this->user_model->get_admindata($userId);
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/admin_edit',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function update_admin_info()
	{
		$admin_id=$_POST['admin_id'];
		$data=array(
		'first_name'=>$_POST['fname'],
		'middle_name'=>$_POST['mname'],
		'last_name'=>$_POST['lname'],
		'email'=>$_POST['email'],
		'mobile'=>$_POST['mobile'],
		'city'=>$_POST['city'],
		'state'=>$_POST['state'],
		'pincode'=>$_POST['pincode'],
		'address'=>$_POST['address'],
		'is_active'=>$_POST['is_active']
		);
		$status=$this->user_model->update_admin_info($data,$admin_id);
		if($status==200)
		{
			echo "done";
		}
		else
		{
			echo "";
		}
	}

	public function quick_status_trial_prod()
	{
		$admin_id=$_POST['admin_id'];
		$type=$_POST['type'];
		$active=$_POST['active'];
		$status=$this->user_model->update_trial_prod_status($admin_id,$type,$active);
		if($status=='true')
		{
			echo "done";
		}
		else
		{
			echo "";
		}
	}

	public function update_status_care_pay()
	{
		$admin_id=$_POST['admin_id'];
		$onlycarepay=$_POST['onlycarepay'];
		$prod_care=$_POST['prod_care'];
		$trial_care=$_POST['trial_care'];
		$status=$this->user_model->update_status_care_pay($admin_id,$onlycarepay,$prod_care,$trial_care);
		if($status=='true')
		{
			echo "done";
		}
		else
		{
			echo "";
		}

	}
	//--------@mkcode 17 may end---------
}
?>