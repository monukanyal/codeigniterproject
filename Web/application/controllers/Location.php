<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   	    
	     $this->load->model('system_model');
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
		$data["title"] = "Location";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$data['arrLocation'] = $this->system_model->get_all($data_feed, 'ci_location');

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('location/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}
	
	function show($locationId) {		
		$data["title"] = "Show Location";

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$data['location_info']=$this->system_model->get_single(array("id" => $locationId, "admin_id" => $admin_id), 'ci_location');

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('location/show',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	/************************
	* To generate form
	*************************/
	function _generateform($default_data,$validate=0,$current_url)
	{
		$data['startform']=form_open_multipart($current_url,'data-parsley-validate class="form-horizontal form-label-left"');

		$data['form']['name']['label']=form_label('Name:*','name');
		$data['form']['name']['field']=form_input(array('name'=>'name','type'=>'text','id'=>'name','value'=>$default_data['name'],'class'=>'form-control','required'=>'required','autofocus'=>'true'));
		
		$data['form']['is_active']['label']=form_label('Is Active?','is_active');
		$data['form']['is_active']['field']=form_checkbox('is_active',1,$default_data['is_active'],('class=flat id=is_active'));
		
		$data['form']['id']['field']=form_hidden('id',isset($default_data['id'])?$default_data['id']:'');

		$data['form']['submit']['field']=form_submit(array('name' =>'submit','class' =>'btn btn-success','value' => 'Submit'));
		$data['endform']=form_close();
		
		//VALIDATE DATA ON REQUESTAuthorised Roles
		if($validate == 1)
		{
			$data['form']['name']['errors']=form_error('name');
		}
  		
  		return $data;
	}

	function add() {
		$data["title"] = "Add Location";
       
		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

		$default_data['name'] = $this->input->post('name');	
		
	
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;			

		if(isset($_POST['submit'])) 
		{
			$namelocation = $this->input->post('name');	
			$locationRecord=$this->system_model->get_single_by_name(trim($namelocation), 'ci_location');
			if (empty($locationRecord[0])) {
				# code...
				
				$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
						
				$default_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
				$default_data['logtime'] = date('Y-m-d H:i:s');

				if($this->form_validation->run() == TRUE)				
				{   	
					$default_data['is_active'] = ($this->input->post('is_active'))?(integer) $this->input->post('is_active'):0;	
	       			// $default_data['is_deleted'] = 0;
				    $id_record=$this->system_model->insert($default_data, 'ci_location');
				    $this->session->set_flashdata('flash_message', 'Record has been added successfully');

				    redirect(site_url('location'));
				} 
				else 
				{ 	
					$form_data = $this->_generateform($default_data,1,$self_url);	
				}
			}else{
			 	$this->session->set_flashdata('flash_error', 'Location Already exists');

			    redirect(site_url('location/add'));
			}
		}
		else
		{
			$form_data = $this->_generateform($default_data,0,$self_url);

		}
  
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('location/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	function edit($locationId,$start=0)
	{
		
		$data["title"] = "Edit Location";

		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method."/".$locationId;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$edit_data=$this->system_model->get_single(array("id" => $locationId, "admin_id" => $admin_id), 'ci_location');
	
		//$default_data['id'] = $userId;
					
		if($this->router->fetch_method()=='edit'  && !empty($edit_data))
		{
			$default_data['name'] = $edit_data['name'];
			$default_data['is_active'] = $edit_data['is_active'];
		}		
		if(isset($_POST['submit'])) 
		{
			$default_data['name'] = $this->input->post('name');	
			$default_data['is_active'] = ($this->input->post('is_active'))?((integer) $this->input->post('is_active')):0;		

			$this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
			if($this->form_validation->run() == TRUE)				
			{
				$default_data['id'] = $locationId;
				$default_data['modified_at'] = date('Y-m-d H:i:s');
				$data_feed = array('id' => $locationId, 'admin_id' => $admin_id);
			    $id_record=$this->system_model->update($data_feed, $default_data, 'ci_location');
			    $this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			    redirect(site_url('location'));
			} 
			else 
				$form_data = $this->_generateform($default_data,1,$self_url);
		}
		else
			$form_data = $this->_generateform($default_data,0,$self_url);
		      		
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('location/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function delete($locationId)
	{
		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$default_data['id'] = $locationId;
		$default_data['admin_id'] = $admin_id;
		$default_data['is_deleted'] = 1;
		$id_record=$this->system_model->delete($default_data, 'ci_location');
		
	    $this->session->set_flashdata('flash_message', 'Record has been deleted successfully');
	    redirect(site_url('location'));
	}
}
?>