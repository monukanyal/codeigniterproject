<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meal extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   	    
	     $this->load->model('meal_model');
	     $this->load->model('user_model');
	     $this->load->model('system_model');
	     $this->load->model('allactivity_model');
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
		$data["title"] = "Meal";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$data['arrMeal'] = $this->meal_model->get_allmeal($data_feed);

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('meal/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}
	
	function show($mealId) {		
		$data["title"] = "Show Meal";

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$data['meal_info']=$this->meal_model->get_meal(array("id" => $mealId, "admin_id" => $admin_id));

        if($data['meal_info']['location_id'] != '')
            $data['arrLocation'] = $this->system_model->get_single(array("id" => $data['meal_info']['location_id'], "admin_id" => $admin_id),'ci_location');

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('meal/show',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	function calendar() {
		
	
		$data["title"] = "Event";
		$data["message"] = "";
		$data["error"] = "";

		$data['cur_controller']=$this->router->fetch_class(); //currnet controller
		$data['cur_controller_method']=$this->router->fetch_method(); //current controller method	
		
		 $data['css_other'] = array("css1"=>"fullcalendar/fullcalendar.css", "css2"=>"fullcalendar/fullcalendar.print.css");

		$data["js_header"] = array("js1" => "fullcalendar/lib/moment.min.js","js2" => "fullcalendar/lib/jquery.min.js","js3" => "fullcalendar/fullcalendar.min.js");

		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$data['arrmeal'] = $this->meal_model->get_allmeal($data_feed);

		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		$default_data111='';

		$default_data['name'] = $this->input->post('name');	
		$default_data['description'] = $this->input->post('description');	
		$default_data['location_id'] = $this->input->post('location_id');	
		$default_data['start_date'] = $this->input->post('start_date');	
		$default_data['start_time'] = $this->input->post('start_time');	
		$default_data['end_date'] = $this->input->post('end_date');	
		$default_data['no_end_date'] = 1;
		$default_data['end_time'] = $this->input->post('end_time');	
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;
		$default_data['recurring'] = $this->input->post('recurring');
		$default_data['meal_type'] = $this->input->post('meal_type');


		$form_data = $this->_generateform($default_data,0,$self_url,$default_data111);
		
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('meal/calendar',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	/************************
	* To generate form
	*************************/
	function _generateform($default_data,$validate=0,$current_url,$default_data11)
	{
		$data['startform']=form_open_multipart($current_url,'data-parsley-validate class="form-horizontal form-label-left"');
		
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$location_arrays=$this->system_model->get_all($data_feed,'ci_location');

		// $data['form']['name']['label']=form_label('Name:*','name');
		// $data['form']['name']['field']=form_input(array('name'=>'name','type'=>'text','id'=>'name','value'=>$default_data['name'],'class'=>'form-control','required'=>'required','autofocus'=>'true'));
		
		$data['form']['description']['label']=form_label('Description','description');
		$data['form']['description']['field']=form_textarea(array('name'=>'description','type'=>'textarea','id'=>'description','rows'=>1,'value'=>$default_data['description'],'class'=>'form-control','autofocus'=>'true'));

  		$result_location['']="Select Location...";
	   	if(isset($location_arrays) && $location_arrays!='')
		{ 
			 foreach ($location_arrays as $location_array)
				 $result_location[$location_array['id']]=$location_array['name'];
  		}

		$data['form']['location_id']['label']=form_label('Location:','location_id');
		$data['form']['location_id']['field']=form_dropdown('location_id',$result_location,$default_data['location_id'],('class="form-control" id="location_id" required'));

		$meal_type_option = array(
				'breakfast' => 'Breakfast',
				'brunch' => 'Brunch',
				'lunch' => 'Lunch',
				'snack' => 'Snack',
				'dinner' => 'Dinner',
				'late-snack' => 'Late Snack'
			);
		$data['form']['meal_type']['label']=form_label('Meal Type:','meal_type');
		$data['form']['meal_type']['field']=form_dropdown('meal_type',$meal_type_option,$default_data['meal_type'],('class="form-control" id="meal_type" required'));


		// $data['form']['start_date']['label']=form_label('Meal Date','start_date');
		// $data['form']['start_date']['field']=form_input(array('name'=>'start_date','type'=>'text','id'=>'start_date','value'=>$default_data['start_date'],'class'=>'form-control','autofocus'=>'true','readonly'=>'true'));

		$data['form']['start_time']['label']=form_label('Meal Time','start_time');
		$data['form']['start_time']['field']=form_input(array('name'=>'start_time','type'=>'text','id'=>'start_time','value'=>$default_data['start_time'],'class'=>'form-control','autofocus'=>'true','onkeydown'=>'return false'));

		// $data['form']['no_end_date']['label']=form_label('No end Date','no_end_date');
		// // $data['form']['no_end_date']['field']=form_checkbox(array('name'=>'no_end_date','type'=>'checkbox','id'=>'no_end_date','value'=>$default_data['no_end_date'],'class'=>'form-control'));
		// $data['form']['no_end_date']['field']=form_checkbox('no_end_date',1,$default_data['no_end_date'],('id=no_end_date'));
		
		// $data['form']['end_date']['label']=form_label('End Date','end_date');
		// $data['form']['end_date']['field']=form_input(array('name'=>'end_date','type'=>'text','id'=>'end_date','value'=>$default_data['end_date'],'class'=>'form-control','autofocus'=>'true','readonly'=>'true'));

		$data['form']['end_time']['label']=form_label('End Time','end_time');
		$data['form']['end_time']['field']=form_input(array('name'=>'end_time','type'=>'text','id'=>'end_time','value'=>$default_data['end_time'],'class'=>'form-control','autofocus'=>'true','onkeydown'=>'return false'));
			
		$role_arrays=array("S"=>"S","M"=>"M","T"=>"T","W"=>"W","Th"=>"Th","F"=>"F","St"=>"St");
		$data['form']['recurring']['label']=form_label('Recurring Meal','recurring');
		
		if(isset($role_arrays) && $role_arrays!='')
		{ 
			 foreach ($role_arrays as $k=>$role_array)
			 {
				// $resultrole_array[$k]=$role_array['name'];
				$resultrole_arr['form']['recurring'][$k]['field']=$role_array;
				
				if($this->router->fetch_method()=='add')
				{
					if($default_data['recurring']!='')
					{
						if(in_array($role_array,$default_data['recurring']))
						{
							$data['form']['recurring'][$k]['field']=form_checkbox('recurring[]',$role_array,TRUE,('id=recurring['.$k.']'));
						}
						else
						{
							$data['form']['recurring'][$k]['field']=form_checkbox('recurring[]',$role_array,'',('id=recurring['.$k.']'));
						}
					}
					else
					{
						$data['form']['recurring'][$k]['field']=form_checkbox('recurring[]',$role_array,'',('id=recurring['.$k.']'));
					}
				}
				else
				{
					if(isset($default_data11['recurring[]']) && $default_data11['recurring[]']!='')
					{
						if (in_array($role_array,$default_data11['recurring[]'])) 
						{
							$data['form']['recurring'][$k]['field']=form_checkbox('recurring[]',$role_array,$default_data11['recurring[]'],('id=recurring['.$k.']'));
						}
						else
						{
							$data['form']['recurring'][$k]['field']=form_checkbox('recurring[]',$role_array,'',('id=recurring['.$k.']'));
						}
					}
					else
						$data['form']['recurring'][$k]['field']=form_checkbox('recurring[]',$role_array,'',('id=recurring['.$k.']'));
				}
				$data['form']['recurring'][$k]['role_label']=$role_array;
			 }		 
			  
  		}

		$data['form']['is_active']['label']=form_label('Is Active?','is_active');
		$data['form']['is_active']['field']=form_checkbox('is_active',1,$default_data['is_active'],('class=flat id=is_active'));
		
		$data['form']['id']['field']=form_hidden('id',isset($default_data['id'])?$default_data['id']:'');

		$data['form']['submit']['field']=form_submit(array('name' =>'submit','class' =>'btn btn-success','value' => 'Submit'));
		$data['endform']=form_close();
		
		//VALIDATE DATA ON REQUESTAuthorised Roles
		if($validate == 1)
		{
			$data['form']['name']['errors']=form_error('name');
			$data['form']['description']['errors']=form_error('description');
			$data['form']['location_id']['errors']=form_error('location_id');
			
			$data['form']['start_date']['errors']=form_error('start_date');
			$data['form']['start_time']['errors']=form_error('start_time');
		}
  		
  		return $data;
	}

	function add() {
		$data["title"] = "Add Meal";
       
		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	
		$default_data11='';

		$default_data['name'] = $this->input->post('meal_type');	
		$default_data['description'] = $this->input->post('description');	
		$default_data['location_id'] = $this->input->post('location_id');

		// $default_data['start_date'] = $this->input->post('start_date');	
		$default_data['start_time'] = ($this->input->post('start_time')) ? $this->input->post('start_time') : '08:00 AM';
		// $default_data['end_date'] = $this->input->post('end_date');	
		// $default_data['no_end_date'] = 1;
		$default_data['end_time'] = ($this->input->post('end_time')) ? $this->input->post('end_time') : '08:30 AM';
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;
		$default_data['recurring'] = $this->input->post('recurring');
		$default_data['meal_type'] = $this->input->post('meal_type');	
			// print($this->input->post());
			// die();
		if(isset($_POST['submit'])) 
		{

			// print_r($_POST);
			// die();
			// $this->form_validation->set_rules('recurring[]', 'Authorised Role', 'trim|required');
			// $default_data['start_time'] = ($this->input->post('start_time'))?mdate('%H:%i', strtotime($this->input->post('start_time'))):'';		
			// $default_data['end_time'] = ($this->input->post('end_time'))?mdate('%H:%i', strtotime($this->input->post('end_time'))):'';
			// $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
			$default_data['start_time'] = $this->input->post('start_time');
			$default_data['end_time'] = $this->input->post('end_time');
			$default_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
			$default_data['logtime'] = date('Y-m-d H:i:s');
			$default_data['name'] = $this->input->post('meal_type');

			$this->form_validation->set_rules('start_time', 'Meal Time', 'required');
			$this->form_validation->set_rules('end_time', 'End Time', 'required');

			if($this->form_validation->run() == TRUE)				
			{   	
				//$default_data['no_end_date'] = $this->input->post('no_end_date');
				$default_data['no_end_date'] =1;
				$default_data['recurring'] = ($this->input->post('recurring'))?implode(",",$this->input->post('recurring')):'';
	
				$meet_time_value = $this->input->post('start_time');	
				$default_data['start_time'] = date("H:i:s", strtotime($meet_time_value));

				$end_time_value = $this->input->post('end_time');	
				$default_data['end_time'] = date("H:i:s", strtotime($end_time_value));

				// print_r($default_data);
				// die;

				$default_data['is_active'] = ($this->input->post('is_active'))?(integer) $this->input->post('is_active'):0;	
       			// $default_data['is_deleted'] = 0;
			    $id_record=$this->meal_model->insert($default_data, 'ci_plan_meal');
			    $this->session->set_flashdata('flash_message', 'Record has been added successfully');

			    redirect(site_url('meal'));
			} 
			else 
			{ 	
				$form_data = $this->_generateform($default_data,1,$self_url,$default_data11);	
			}
		}
		else
		{
			// $default_data['no_end_date']=1;
			$form_data = $this->_generateform($default_data,0,$self_url,$default_data11);

		}
  
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('meal/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	function edit($mealId,$start=0)
	{
		
		$data["title"] = "Edit Meal";

		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method."/".$mealId;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$edit_data=$this->meal_model->get_meal(array("id" => $mealId, "admin_id" => $admin_id));
	
		$default_data['recurring']='';
		$default_data12['recurring[]']='';
				
		if($this->router->fetch_method()=='edit'  && !empty($edit_data))
		{		
			$default_data['name'] = $edit_data['meal_type'];
			$default_data['description'] = $edit_data['description'];
			$default_data['location_id'] = $edit_data['location_id'];
			$default_data['start_date'] = $edit_data['start_date'];
			$default_data['start_time'] = $edit_data['start_time'];
			$default_data['no_end_date'] = $edit_data['no_end_date'];
			$default_data['end_date'] = $edit_data['end_date'];
			$default_data['end_time'] = $edit_data['end_time'];
			$default_data['is_active'] = $edit_data['is_active'];
			$default_data12['recurring[]'] = explode(",",$edit_data['recurring']);
			$default_data['meal_type'] = $edit_data['meal_type'];
			
		}	
		$default_data['recurring']='';
		$default_data11['recurring[]']='';
		if($default_data['recurring']!='')
		{
			$default_data11['recurring[]']=explode(",",$default_data['recurring']);
		}
		else
		{
			$default_data11['recurring[]']=$default_data12['recurring[]'];
		}	
		if(isset($_POST['submit'])) 
		{

			//$default_data['meal_id'] = $mealId;
			$default_data['name'] = $this->input->post('meal_type');	
			$default_data['description'] = $this->input->post('description');	
			$default_data['location_id'] = $this->input->post('location_id');	
			//$default_data['start_date'] = $this->input->post('start_date');
			//$default_data['no_end_date'] = $this->input->post('no_end_date');		
			$default_data['start_time'] = $this->input->post('start_time');		
			//$default_data['end_date'] = $this->input->post('end_date');	
			$default_data['end_time'] = $this->input->post('end_time');	
					
			$meet_time_value = $this->input->post('start_time');	
			$default_data['start_time'] = date("H:i:s", strtotime($meet_time_value));
			$end_time_value = $this->input->post('end_time');	
			$default_data['end_time'] = date("H:i:s", strtotime($end_time_value));

			$default_data['is_active'] = ($this->input->post('is_active'))?((integer) $this->input->post('is_active')):0;		
			$default_data['recurring'] = ($this->input->post('recurring'))?implode(",",$this->input->post('recurring')):'';
			//$default_data['meal_type'] = $this->input->post('meal_type');
			$default_data['modified_at'] = date('Y-m-d H:i:s');
			$data_feed = array('id' => $mealId, 'admin_id' => $admin_id);
			$id_record=$this->meal_model->update($data_feed, $default_data, 'ci_plan_meal');
			$this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			redirect(site_url('meal'));
			
		}
		else
			$form_data = $this->_generateform($default_data,0,$self_url,$default_data11);
		      		
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('meal/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function delete($mealId)
	{
		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$default_data['id'] = $mealId;
		$default_data['admin_id'] = $admin_id;
		$default_data['is_deleted'] = 1;
		$id_record=$this->meal_model->delete($default_data, 'ci_plan_meal');
		
	    $this->session->set_flashdata('flash_message', 'Record has been deleted successfully');
	    redirect(site_url('meal'));
	}
	public function ajax_update($mealId)
	{
		if($this->input->is_ajax_request())
		{	
			$response = array();
			$admin_id = $this->session->userdata['logged_in']['admin_id'];
			$mealId = $this->input->post('id',TRUE);

			// $default_data['event_id'] = $this->input->post('event_id',TRUE);
			$default_data['name'] = $this->input->post('meal_type',TRUE);
			$default_data['description'] = $this->input->post('description',TRUE);
			$default_data['location_id'] = $this->input->post('location_id',TRUE);

			//$default_data['start_date'] = $this->input->post('start_date',TRUE);
			$default_data['start_time'] = $this->input->post('start_time',TRUE);
			//$default_data['end_date'] = $this->input->post('end_date',TRUE);
			$default_data['end_time'] = $this->input->post('end_time',TRUE);
			$default_data['is_active'] = $this->input->post('is_active',TRUE);
			$default_data['recurring'] = $this->input->post('recurring',TRUE);
			//$default_data['no_end_date'] = $this->input->post('meal_type',TRUE);
			//$default_data['meal_type'] = $this->input->post('no_end_date',TRUE);
			$default_data['modified_at'] = date('Y-m-d H:i:s');

			$data_feed = array('id' => $mealId, 'admin_id' => $admin_id);
			//print_r($data_feed);
		    $id_record=$this->meal_model->update($data_feed, $default_data, 'ci_plan_meal');
			$this->session->set_flashdata('flash_message', '*Record has been updated successfully');
			    
			echo json_encode($response);
		}
		else
			die("Sorry, NOT AN AJAX REQUEST");
		
	}

	public function superadmin_ajax_update($mealId)
	{
		if($this->input->is_ajax_request())
		{	
			$response = array();
			// $admin_id = $this->session->userdata['logged_in']['admin_id'];
			$mealId = $this->input->post('id',TRUE);

			// $default_data['event_id'] = $this->input->post('event_id',TRUE);
			$default_data['name'] = $this->input->post('meal_type',TRUE);
			$default_data['description'] = $this->input->post('description',TRUE);
			$default_data['location_id'] = $this->input->post('location_id',TRUE);

			$default_data['start_date'] = $this->input->post('start_date',TRUE);
			$default_data['start_time'] = $this->input->post('start_time',TRUE);
			$default_data['end_date'] = $this->input->post('end_date',TRUE);
			$default_data['end_time'] = $this->input->post('end_time',TRUE);
			$default_data['is_active'] = $this->input->post('is_active',TRUE);
			$default_data['recurring'] = $this->input->post('recurring',TRUE);
			//$default_data['no_end_date'] = $this->input->post('meal_type',TRUE);
			$default_data['meal_type'] = $this->input->post('no_end_date',TRUE);
			$default_data['modified_at'] = date('Y-m-d H:i:s');

			$data_feed = array('id' => $mealId);
			//print_r($data_feed);
		    $id_record=$this->allactivity_model->update($data_feed, $default_data, 'ci_plan_meal');
			$this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			    
			echo json_encode($response);
		}
		else
			die("Sorry, NOT AN AJAX REQUEST");
		
	}

	// 4 sep
	public function meals_at_a_glance()
	{
		$data["title"] = "Meals at a Glance";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		//$data['arrMeal'] = $this->meal_model->get_allmeal($data_feed);
		$data['arrbreakfast'] = $this->meal_model->get_mealbreakfast($data_feed);
		$data['arrlunch'] = $this->meal_model->get_meallunch($data_feed);
		$data['arrdinner'] = $this->meal_model->get_mealdinner($data_feed);
		$data['address'] = $this->meal_model->get_address_admin($data_feed['admin_id']);
		$data['location']=$this->meal_model->get_locationlist($data_feed['admin_id']);
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('meal/glance',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function add_meal_glance()
	{

		if(isset($_POST))
		{

			    //echo "<pre>";
			    //print_r($_POST);
			$default_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
			$default_data['logtime'] = date('Y-m-d H:i:s');
			$a_date=$this->input->post('start_date');
			//$default_data['start_date'] =date('Y-m-d',strtotime($a_date));//not using
			//$default_data['end_date'] = date("Y-m-t", strtotime($a_date));//not using
			$default_data['no_end_date'] =2;  // startdate and enddate  available	
			//print_r($default_data);
			$default_data['name'] = $this->input->post('meal_type');	
			$default_data['description'] = $this->input->post('description');	
			$default_data['location_id'] = $this->input->post('location_id');	
	
			$stime = $this->input->post('start_time');	
			$etime = $this->input->post('end_time');	
			$a=explode(' ',$stime);
			$b=explode(' ',$etime);
			$meet_time_value=$a[0];
			$end_time_value =$b[0];
			$default_data['start_time'] = date("H:i:s", strtotime($meet_time_value));
			$default_data['end_time'] = date("H:i:s", strtotime($end_time_value));
			$default_data['is_active'] = ($this->input->post('is_active'))?((integer) $this->input->post('is_active')):0;		
			//$default_data['recurring'] = ($this->input->post('recurring'))?implode(",",$this->input->post('recurring')):'';  //not using
			$default_data['meal_type'] = $this->input->post('meal_type');

			$default_data['modified_at'] = date('Y-m-d H:i:s');
			
			$id_record=$this->meal_model->insert($default_data, 'ci_plan_meal');
			$this->session->set_flashdata('flash_msg', 'Record has been created successfully');
			redirect(site_url('meal/meals_at_a_glance'));

			//print_r($default_data);
		}
	}

	  public function update_meal_glance()
	  {
	  	if(isset($_POST))
		{
			$recurring_org=array();
			$admin_id=$this->session->userdata['logged_in']['admin_id'];
			$a_date=$this->input->post('start_date');
			$mealid=$this->input->post('mealid');
			//$default_data['mealid']=$mealid;
			$default_data['start_date'] =date('Y-m-d',strtotime($a_date));//not using
			$default_data['end_date'] = date("Y-m-t", strtotime($a_date));//not using
			$default_data['no_end_date'] =0;  // startdate and enddate  available
			$rec_org=$this->meal_model->get_recurring_meal_id($mealid);	
			$recurring= $this->input->post('recurring');
			if(!empty($rec_org))
			{
				$recurring_org= explode(",",$rec_org);
				if(in_array($recurring,$recurring_org))
				{
					//echo "<br>Got $recurring";
					$default_data['recurring'] =implode(",",$recurring_org );
					$response=$this->meal_model->update_glance_meal_id($default_data,$admin_id,$mealid);
				}
				else
				{
					//echo "<br>Not found $recurring";
					$recurring_org[]=$recurring;
					$default_data['recurring'] =implode(",",$recurring_org );
					$response=$this->meal_model->update_glance_meal_id($default_data,$admin_id,$mealid);
				}
			} 
			else
			{
					//echo "<br>Empty recurring_org";
					$default_data['recurring'] =$recurring;
					$response=$this->meal_model->update_glance_meal_id($default_data,$admin_id,$mealid);

			}
			
		}
	  }
	public function save_glance()
	{
		if(isset($_POST))
		{
			//echo count($_POST['mainarr']);
			//print_r($_POST);
			$admin_id=$this->session->userdata['logged_in']['admin_id'];
			$monthyear=$_POST['monthyear'];
			$subtitle1=$_POST['subtitle1'];
			$subtitle2=$_POST['subtitle2'];
			$footer=$_POST['footer'];
			$response=$this->meal_model->clear_glance_meal_admin($monthyear,$admin_id);
			if($response)
			{
					$this->meal_model->store_glance_meal_subtitles($monthyear,$admin_id,$subtitle1,$subtitle2,$footer);
					$status=array();
					for($i=0;$i<count($_POST['mainarr']);$i++)
					{
						$data=$_POST['mainarr'][$i];
						$marr=explode('<>', $data);
						//print_r($marr);
						$position= trim($marr[0],'{');
						$newdata=trim($marr[1],'}');
						if($position[0]==1)
						{
							$weekday='Sun';
						}
						else if($position[0]==2)
						{
							$weekday='Mon';
						}
						else if($position[0]==3)
						{
							$weekday='Tue';
						}
						else if($position[0]==4)
						{
							$weekday='Wed';
						}
						else if($position[0]==5)
						{
							$weekday='Thu';
						}
						else if($position[0]==6)
						{
							$weekday='Fri';
						}
						else
						{
							$weekday='Sat';
						}
						
					$status[]=$this->meal_model->save_glance_meal($weekday,$position,$newdata,$admin_id,$monthyear);
					}
					if(count($status)==count($_POST['mainarr']))
					{
						echo "success";
					}
					else
					{
						echo "failed";
					}
			}
			else
			{
				echo "failed";
			}	
		}
	}

	public function get_glance_month()
	{
		if(isset($_POST))
		{
				$admin_id=$this->session->userdata['logged_in']['admin_id'];
				$monthyear=$_POST['monthyear'];
				$result=$this->meal_model->get_glance_meal($admin_id,$monthyear);
				if(!empty($result))
				{
					$titleres=$this->meal_model->get_glance_meal_subtitles($admin_id,$monthyear);
					if(!empty($titleres))
					{
						$result[0]['subtitle1']=$titleres['subtitle1'];
						$result[0]['subtitle2']=$titleres['subtitle2'];
						$result[0]['footer']=$titleres['footer'];
					}
					else
					{
						$result[0]['subtitle1']='';
						$result[0]['subtitle2']='';
						$result[0]['footer']='';
					}
				}
					echo json_encode($result);
		}
	}

	public function get_glance_week()
	{
		if(isset($_POST))
		{
				date_default_timezone_set('Asia/Kolkata');
				$admin_id=$this->session->userdata['logged_in']['admin_id'];
				$from_date = $_POST['startdate'];
				$to_date= date( "d-m-Y", strtotime( "$from_date +6 day" ) );
				$from_date = new \DateTime($from_date);
				$to_date = new \DateTime($to_date);
				for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) 
				{

					$weekdays=$date->format('D');
				 	$monthyears=$date->format('m').'_'.$date->format('Y');
				 	$tempresult[]=$this->meal_model->get_glance_meal_week($admin_id,$weekdays,$monthyears);
				}

				if(count($tempresult)>0)
				{
					for($j=0;$j<count($tempresult);$j++)
					{
						for($k=0;$k<count($tempresult[$j]);$k++)
						{
							$result[]=$tempresult[$j][$k];
						}
					}
					echo (json_encode($result));
				}
				else
				{
					echo "";
				}
		}
	}

	public function delete_meal_from_glance()
	{
		if(isset($_POST))
		{
			$recurring_org=array();
			$admin_id=$this->session->userdata['logged_in']['admin_id'];
			$mealid=$this->input->post('mealid');
			$default_data['start_date'] ='';
			$default_data['end_date'] = '';
			
			$rec_org=$this->meal_model->get_recurring_meal_id($mealid);	
			$recurring= $this->input->post('recurring_current');
			if(!empty($rec_org))
			{
				$recurring_org= explode(",",$rec_org);
				if (($key = array_search($recurring, $recurring_org)) !== false) 
				{
				    unset($recurring_org[$key]);
				    if(!empty($recurring_org))
				    {
				    	 $default_data['recurring'] =implode(",",$recurring_org );
					    $default_data['no_end_date'] =0;  //because recurring day left
					   $this->meal_model->update_glance_meal_id($default_data,$admin_id,$mealid);
				    }
				    else
				    {
				    	$default_data['recurring'] ='';
					    $default_data['no_end_date'] =2;  //because recurring day left
					   $this->meal_model->update_glance_meal_id($default_data,$admin_id,$mealid);
				    }
				   
				}
				else
				{
					//very rare case
					$default_data['recurring'] =implode(",",$recurring_org );
					$default_data['no_end_date'] =0; //because recurring day left
					$this->meal_model->update_glance_meal_id($default_data,$admin_id,$mealid);
				}
				
			} 
			else
			{
					//echo "<br>Empty recurring_org";
					$default_data['recurring'] ='';
					$default_data['no_end_date'] =2;  // because no  recurring day left
					$this->meal_model->update_glance_meal_id($default_data,$admin_id,$mealid);

			}
			//echo "<pre>";
			//print_r($default_data);
		}
	}
	
}
?>