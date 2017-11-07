<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   	    
	     $this->load->model('event_model');
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
		$data["title"] = "Event";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$data['arrEvent'] = $this->event_model->get_allevent($data_feed);
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('event/index',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	
	public function event()
	{


		$year = date('Y'); 
		$month = date('m');
		echo json_encode(array( 
		array( 
			 'id' => 1, 
			 'title' => "Event1", 
			 'start' => "$year-$month-10", 
			 'url' => "http://yahoo.com/" 
			), 
		array( 
			 'id' => 2, 
			 'title' => "Event2", 
			 'start' => "$year-$month-20", 
			 'end' => "$year-$month-22", 
			 'url' => "http://yahoo.com/" 
			) 
		));

   die();


	}
	
	function calendar() 
	{
		
		$data["title"] = "Event";
		$data["message"] = "";
		$data["error"] = "";

		$data['cur_controller']=$this->router->fetch_class(); //currnet controller
		$data['cur_controller_method']=$this->router->fetch_method(); //current controller method	
		
		$data['css_other'] = array("css1"=>"fullcalendar/fullcalendar.css", "css2"=>"fullcalendar/fullcalendar.print.css");

	$data["js_header"] = array("js1" => "fullcalendar/lib/moment.min.js","js2" => "fullcalendar/lib/jquery.min.js","js3" => "fullcalendar/fullcalendar.min.js");

		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$data['arrEvent'] = $this->event_model->get_allevent($data_feed);  
		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		$default_data11='';
		//print_r($data);

		$default_data['event_id'] = $this->input->post('event_id');	
		// $default_data['name'] = $this->input->post('name');	
		$default_data['description'] = $this->input->post('description');	
		$default_data['location_id'] = $this->input->post('location_id');	
		$default_data['max_attendies'] = $this->input->post('max_attendies');
		$default_data['meetup_date'] = $this->input->post('meetup_date');	
		$default_data['meetup_time'] = $this->input->post('meetup_time');	
		$default_data['end_date'] = $this->input->post('end_date');	
		$default_data['no_end_date'] = $this->input->post('no_end_date');	
		$default_data['end_time'] = $this->input->post('end_time');	
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;
		$default_data['recurring'] = $this->input->post('recurring');
		$form_data = $this->_generateform($default_data,0,$self_url,$default_data11);
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('event/calendar',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	function show($eventId) {		
		$data["title"] = "Show Event";

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$data['event_info']=$this->event_model->get_event(array("id" => $eventId, "admin_id" => $admin_id));

        if($data['event_info']['event_id'] != '')
            $data['arrEvent'] = $this->system_model->get_single(array("id" => $data['event_info']['event_id'], "admin_id" => $admin_id),'ci_event');

        if($data['event_info']['location_id'] != '')
            $data['arrLocation'] = $this->system_model->get_single(array("id" => $data['event_info']['location_id'], "admin_id" => $admin_id),'ci_location');

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('event/show',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	/************************
	* To generate form
	*************************/
	function _generateform($default_data,$validate=0,$current_url,$default_data11)
	{
		$data['startform']=form_open_multipart($current_url,'data-parsley-validate class="form-horizontal form-label-left"');
		
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);		
		$event_arrays=$this->system_model->get_all($data_feed,'ci_event');	   	
		$location_arrays=$this->system_model->get_all($data_feed,'ci_location');	   	
	   	$result_event['']="Select Event...";
	   	if(isset($event_arrays) && $event_arrays!='')
		{ 
			 foreach ($event_arrays as $event_array)
				 $result_event[$event_array['id']]=$event_array['name'];
  		}
  		$result_location['']="Select Location...";
	   	if(isset($location_arrays) && $location_arrays!='')
		{ 
			 foreach ($location_arrays as $location_array)
				 $result_location[$location_array['id']]=$location_array['name'];
  		}

		$data['form']['event_id']['label']=form_label('Event:','event_id');
		$data['form']['event_id']['field']=form_dropdown('event_id',$result_event,$default_data['event_id'],('class="form-control" id="event_id" required'));

		// $data['form']['name']['label']=form_label('Name:*','name');
		// $data['form']['name']['field']=form_input(array('name'=>'name','type'=>'text','id'=>'name','value'=>$default_data['name'],'class'=>'form-control','required'=>'required','autofocus'=>'true'));
		
		$data['form']['description']['label']=form_label('Description','description');
		$data['form']['description']['field']=form_textarea(array('name'=>'description','type'=>'textarea','id'=>'description','rows'=>1,'value'=>$default_data['description'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['location_id']['label']=form_label('Location:','location_id');
		$data['form']['location_id']['field']=form_dropdown('location_id',$result_location,$default_data['location_id'],('class="form-control" id="location_id" required'));

		$data['form']['max_attendies']['label']=form_label('Maximum Attendies','max_attendies');
		$data['form']['max_attendies']['field']=form_input(array('name'=>'max_attendies','type'=>'text','id'=>'max_attendies','value'=>$default_data['max_attendies'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['meetup_date']['label']=form_label('Meetup Date','meetup_date');
		$data['form']['meetup_date']['field']=form_input(array('name'=>'meetup_date','type'=>'text','id'=>'meetup_date','value'=>$default_data['meetup_date'],'class'=>'form-control','autofocus'=>'true','readonly'=>'readonly'));

		$data['form']['meetup_time']['label']=form_label('Meetup Time','meetup_time');
		$data['form']['meetup_time']['field']=form_input(array('name'=>'meetup_time','type'=>'text','id'=>'meetup_time','value'=>$default_data['meetup_time'],'class'=>'form-control','autofocus'=>'true','onkeydown'=>'return false'));

		$data['form']['end_time']['label']=form_label('End Time','end_time');
		$data['form']['end_time']['field']=form_input(array('name'=>'end_time','type'=>'text','id'=>'end_time','value'=>$default_data['end_time'],'class'=>'form-control','autofocus'=>'true','onkeydown'=>'return false'));
			
		$data['form']['end_date']['label']=form_label('End Date','end_date');
		$data['form']['end_date']['field']=form_input(array('name'=>'end_date','type'=>'text','id'=>'end_date','value'=>$default_data['end_date'],'class'=>'form-control','autofocus'=>'true','readonly'=>'true'));

		$data['form']['no_end_date']['label']=form_label('No end Date','no_end_date');
		// $data['form']['no_end_date']['field']=form_checkbox(array('name'=>'no_end_date','type'=>'checkbox','id'=>'no_end_date','value'=>$default_data['no_end_date'],'class'=>'form-control'));
		$data['form']['no_end_date']['field']=form_checkbox('no_end_date',1,$default_data['no_end_date'],('id=no_end_date'));
		

		$role_arrays=array("S"=>"S","M"=>"M","T"=>"T","W"=>"W","Th"=>"Th","F"=>"F","St"=>"St");
		$data['form']['recurring']['label']=form_label('Recurring Event','recurring');
		
		if(isset($role_arrays) && $role_arrays!='')
		{ 
			 foreach ($role_arrays as $k=>$role_array)
			 {
				// $resultrole_array[$k]=$role_array['name'];
				$resultrole_arr['form']['recurring'][$k]['field']=$role_array;
				
				if($this->router->fetch_method()=='add' || $this->router->fetch_method()=='calendar')
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
					if($default_data11['recurring[]']!='')
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
			$data['form']['event_id']['errors']=form_error('event_id');
			// $data['form']['name']['errors']=form_error('name');
			$data['form']['description']['errors']=form_error('description');
			$data['form']['location_id']['errors']=form_error('location_id');
			$data['form']['max_attendies']['errors']=form_error('max_attendies');
			$data['form']['meetup_date']['errors']=form_error('meetup_date');
			$data['form']['meetup_time']['errors']=form_error('meetup_time');
		}
  		
  		return $data;
	}

	function add() {
		$data["title"] = "Add Event";
       
		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	
		$default_data11='';

		$default_data['event_id'] = $this->input->post('event_id');	
		// $default_data['name'] = $this->input->post('name');	
		$default_data['description'] = $this->input->post('description');	
		$default_data['location_id'] = $this->input->post('location_id');	
		$default_data['max_attendies'] = $this->input->post('max_attendies');
		$default_data['meetup_date'] = $this->input->post('meetup_date');

		$default_data['no_end_date'] = 0;

		$default_data['meetup_time'] = ($this->input->post('meetup_time')) ? $this->input->post('meetup_time') : '08:00 AM';	
		$default_data['end_date'] = $this->input->post('end_date');	
		$default_data['end_time'] = ($this->input->post('end_time')) ? $this->input->post('end_time') : '08:30 AM';	
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;
		$default_data['recurring'] = $this->input->post('recurring');


			//echo"<pre>";print_r($this->input->post());die();
		if(isset($_POST['submit'])) 
		{
			$this->form_validation->set_rules('event_id', 'Event', 'trim|required');
			$this->form_validation->set_rules('meetup_time', 'Meetup Time', 'required');
			$this->form_validation->set_rules('end_time', 'End Time', 'required');
					
			$default_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
			$default_data['logtime'] = date('Y-m-d H:i:s');

			if($this->form_validation->run() == TRUE)				
			{   	
				$default_data['no_end_date'] = ($this->input->post('no_end_date'))?(integer) $this->input->post('no_end_date'):0;
				$default_data['recurring'] = ($this->input->post('recurring'))?implode(",",$this->input->post('recurring')):'';
	
				$default_data['meetup_time'] = $this->input->post('meetup_time');
				$default_data['end_time'] = $this->input->post('end_time');

				// if ($default_data['end_time'] < $default_data['meetup_time'])
				// {
				//     $this->form_validation->set_message('validate_time', 'Invalid time');
				//     return FALSE;
				// }

				$meet_time_value = $this->input->post('meetup_time');	
				$default_data['meetup_time'] = date("H:i:s", strtotime($meet_time_value));
		
				$end_time_value = $this->input->post('end_time');	
				$default_data['end_time'] = date("H:i:s", strtotime($end_time_value));

				$default_data['is_active'] = ($this->input->post('is_active'))?(integer) $this->input->post('is_active'):0;	
       			// $default_data['is_deleted'] = 0;

			    $id_record=$this->event_model->insert($default_data, 'ci_plan_event');
			    $this->session->set_flashdata('flash_message', 'Record has been added successfully');

			    redirect(site_url('event'));
			} 
			else 
			{ 	
				$form_data = $this->_generateform($default_data,1,$self_url,$default_data11);	
			}
		}
		else
		{
			$form_data = $this->_generateform($default_data,0,$self_url,$default_data11);

		}
  
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('event/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}
	/*function check_equal_less($second_field,$first_field)
	{
	    if ($second_field < $first_field)
	      {
	        $this->form_validation->set_message('check_equal_less', 'End time should be greater than start time');
	        return false;       
	      }
	      else
	      {
	        return true;
	      }
	 }*/

	function edit($eventId,$start=0)
	{
		
		$data["title"] = "Edit Event";

		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method."/".$eventId;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	

		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$edit_data=$this->event_model->get_event(array("id" => $eventId, "admin_id" => $admin_id));
	
		//print_r($edit_data);

		$default_data['recurring']='';
		$default_data12['recurring[]']='';
		//$default_data['id'] = $userId;
					
		if($this->router->fetch_method()=='edit'  && !empty($edit_data))
		{
			$default_data['event_id'] = $edit_data['event_id'];
			// $default_data['name'] = $edit_data['name'];
			$default_data['description'] = $edit_data['description'];
			$default_data['location_id'] = $edit_data['location_id'];
			$default_data['max_attendies'] = $edit_data['max_attendies'];
			$default_data['meetup_date'] = $edit_data['meetup_date'];
			$default_data['meetup_time'] = $edit_data['meetup_time'];
			$default_data['no_end_date'] = $edit_data['no_end_date'];
			$default_data['end_date'] = $edit_data['end_date'];
			$default_data['end_time'] = $edit_data['end_time'];
			$default_data['is_active'] = $edit_data['is_active'];
			$default_data12['recurring[]'] = explode(",",$edit_data['recurring']);
			
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
			$default_data['event_id'] = $this->input->post('event_id');	
			// $default_data['name'] = $this->input->post('name');	
			$default_data['description'] = $this->input->post('description');	
			$default_data['location_id'] = $this->input->post('location_id');	
			$default_data['max_attendies'] = $this->input->post('max_attendies');		
			$default_data['meetup_date'] = $this->input->post('meetup_date');
			$default_data['no_end_date'] = $this->input->post('no_end_date');		
			$default_data['meetup_time'] = ($this->input->post('meetup_time'));			
			$default_data['end_date'] = $this->input->post('end_date');	
			$default_data['end_time'] = ($this->input->post('end_time'));	
			$meet_time_value = $this->input->post('meetup_time');	
			$default_data['meetup_time'] = date("H:i:s", strtotime($meet_time_value));
			$end_time_value = $this->input->post('end_time');	
			$default_data['end_time'] = date("H:i:s", strtotime($end_time_value));
			$default_data['is_active'] = ($this->input->post('is_active'))?((integer) $this->input->post('is_active')):0;		
			$default_data['recurring'] = ($this->input->post('recurring'))?implode(",",$this->input->post('recurring')):'';

			$this->form_validation->set_rules('event_id', 'Event', 'trim|required');
			if($this->form_validation->run() == TRUE)				
			{
				$default_data['id'] = $eventId;
				$default_data['modified_at'] = date('Y-m-d H:i:s');
				$data_feed = array('id' => $eventId, 'admin_id' => $admin_id);
			    $id_record=$this->event_model->update($data_feed, $default_data, 'ci_plan_event');
			    $this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			    redirect(site_url('event'));
			} 
			else 
				$form_data = $this->_generateform($default_data,1,$self_url,$default_data11);
		}
		else
			$form_data = $this->_generateform($default_data,0,$self_url,$default_data11);
		      		
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('event/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function delete($eventId)
	{
		$red_url = $this->agent->referrer();
		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$default_data['id'] = $eventId;
		$default_data['admin_id'] = $admin_id;
		$default_data['is_deleted'] = 1;
		$id_record=$this->event_model->delete($default_data, 'ci_plan_event');
		
	    $this->session->set_flashdata('flash_message', 'Record has been deleted successfully');
	    redirect($red_url);
	}
	public function ajax_update()
	{
		if($this->input->is_ajax_request())
		{	
			$response = array();
			$admin_id = $this->session->userdata['logged_in']['admin_id'];
			$eventId = $this->input->post('id',TRUE);

			$default_data['event_id'] = $this->input->post('event_id',TRUE);
			$default_data['description'] = $this->input->post('description',TRUE);
			$default_data['location_id'] = $this->input->post('location_id',TRUE);
			$default_data['max_attendies'] = $this->input->post('max_attendies',TRUE);
			$default_data['meetup_date'] = $this->input->post('meetup_date',TRUE);
			$default_data['meetup_time'] = $this->input->post('meetup_time',TRUE);
			$default_data['end_date'] = $this->input->post('end_date',TRUE);
			$default_data['end_time'] = $this->input->post('end_time',TRUE);
			$default_data['is_active'] = $this->input->post('is_active',TRUE);
			$default_data['recurring'] = $this->input->post('recurring',TRUE);
			$default_data['no_end_date'] = $this->input->post('no_end_date',TRUE);
			$default_data['modified_at'] = date('Y-m-d H:i:s');

			$data_feed = array('id' => $eventId, 'admin_id' => $admin_id);
		    $id_record=$this->event_model->update($data_feed, $default_data, 'ci_plan_event');
			$this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			    
			echo json_encode($response);
		}
		else
			die("Sorry, NOT AN AJAX REQUEST");
		
	}
	public function superadmin_ajax_update()
	{
		if($this->input->is_ajax_request())
		{	
			$response = array();
			// $admin_id = $this->session->userdata['logged_in']['admin_id'];
			$eventId = $this->input->post('id',TRUE);

			$default_data['event_id'] = $this->input->post('event_id',TRUE);
			$default_data['description'] = $this->input->post('description',TRUE);
			$default_data['location_id'] = $this->input->post('location_id',TRUE);
			$default_data['max_attendies'] = $this->input->post('max_attendies',TRUE);
			$default_data['meetup_date'] = $this->input->post('meetup_date',TRUE);
			$default_data['meetup_time'] = $this->input->post('meetup_time',TRUE);
			$default_data['end_date'] = $this->input->post('end_date',TRUE);
			$default_data['end_time'] = $this->input->post('end_time',TRUE);
			$default_data['is_active'] = $this->input->post('is_active',TRUE);
			$default_data['recurring'] = $this->input->post('recurring',TRUE);
			$default_data['no_end_date'] = $this->input->post('no_end_date',TRUE);
			$default_data['modified_at'] = date('Y-m-d H:i:s');

			$data_feed = array('id' => $eventId);
		    $id_record=$this->allactivity_model->update($data_feed, $default_data, 'ci_plan_event');
			$this->session->set_flashdata('flash_message', 'Record has been updated successfully');
			    
			echo json_encode($response);
		}
		else
			die("Sorry, NOT AN AJAX REQUEST");
		
	}

	//@mkcode start

	public function add_multiple_event()
	{
		$data["title"] = "Event";
		$data["message"] = "";
		$data["error"] = "";
		if(isset($_POST['submit_multiple']))
		{
			//echo "<pre>";

			$mycounter=array();
			$response=array();
			$logtime=date('Y-m-d H:i:s');
			$admin_id=$this->session->userdata['logged_in']['admin_id'];

		
			if($_POST['form1'])
			{
				$mycounter[]='form1';
				//echo "form1 ready to submit<br>";

				$location_id1=$this->input->post('location_id1');
				$max_attendies1=$this->input->post('max_attendies1');
				$event_ids1=$this->input->post('event_ids1');
				$meetup_dates1=$this->input->post('meetup_dates1');
				$descriptions1=$this->input->post('descriptions1');
				$meet_time1=$this->input->post('meetup_times1');
				$meetuptime1=date("H:i:s", strtotime($meet_time1));
				$duration1=$this->input->post('duration1');
				$endtime1=date("H:i:s", strtotime($meet_time1." +$duration1  minutes"));
				$no_end1=($this->input->post('noend1'))?(integer) $this->input->post('noend1'):0;
				$recur1=($this->input->post('recurring1'))?implode(",",$this->input->post('recurring1')):'';
				$end_date1=$_POST['end_dates1'];


				$data1=array(
				'event_id'=>$event_ids1,
				'description'=>$descriptions1,
				'location_id'=>$location_id1,
				'max_attendies'=>$max_attendies1,
				'meetup_date'=>$meetup_dates1,
				'no_end_date'=>$no_end1,
				'meetup_time'=>$meetuptime1,
				'end_date'=>$end_date1,
				'end_time'=>$endtime1,
				'is_active'=>1,
				'recurring'=>$recur1,
				'admin_id'=>$admin_id,
				'logtime'=>$logtime
			);
				//print_r($data1);
				$response[]=$this->event_model->insert($data1, 'ci_plan_event');
					
			}
			if($_POST['form2'])
			{
				$mycounter[]='form2';
				//echo "form2 ready to submit<br>";

				 $location_id2=$this->input->post('location_id2');
				$max_attendies2=$this->input->post('max_attendies2');
				$event_ids2=$this->input->post('event_ids2');
				$meetup_dates2=$this->input->post('meetup_dates2');
				$descriptions2=$this->input->post('descriptions2');
				$meet_time2=$this->input->post('meetup_times2');
				$meetuptime2=date("H:i:s", strtotime($meet_time2));
				$duration2=$this->input->post('duration2');
				$endtime2=date("H:i:s", strtotime($meet_time2." +$duration2  minutes"));
				$no_end2=($this->input->post('noend2'))?(integer) $this->input->post('noend2'):0;
				$recur2=($this->input->post('recurring2'))?implode(",",$this->input->post('recurring2')):'';
				$end_date2=$_POST['end_dates2'];

				   $data2=array(
				'event_id'=>$event_ids2,
				'description'=>$descriptions2,
				'location_id'=>$location_id2,
				'max_attendies'=>$max_attendies2,
				'meetup_date'=>$meetup_dates2,
				'no_end_date'=>$no_end2,
				'meetup_time'=>$meetuptime2,
				'end_date'=>$end_date2,
				'end_time'=>$endtime2,
				'is_active'=>1,
				'recurring'=>$recur2,
				'admin_id'=>$admin_id,
				'logtime'=>$logtime
			);

				   //print_r($data2);
				    $response[]=$this->event_model->insert($data2, 'ci_plan_event');
					

			}
			if($_POST['form3'])
			{
				$mycounter[]='form3';
				//echo "form3 ready to submit<br>";

				 $location_id3=$this->input->post('location_id3');
				$max_attendies3=$this->input->post('max_attendies3');
				$event_ids3=$this->input->post('event_ids3');
				$meetup_dates3=$this->input->post('meetup_dates3');
				$descriptions3=$this->input->post('descriptions3');
				$meet_time3=$this->input->post('meetup_times3');
				$meetuptime3=date("H:i:s", strtotime($meet_time3));
				$duration3=$this->input->post('duration3');
				$endtime3=date("H:i:s", strtotime($meet_time3." +$duration3  minutes"));
				$no_end3=($this->input->post('noend3'))?(integer) $this->input->post('noend3'):0;
				$recur3=($this->input->post('recurring3'))?implode(",",$this->input->post('recurring3')):'';
				$end_date3=$_POST['end_dates3'];

				 $data3=array(
				'event_id'=>$event_ids3,
				'description'=>$descriptions3,
				'location_id'=>$location_id3,
				'max_attendies'=>$max_attendies3,
				'meetup_date'=>$meetup_dates3,
				'no_end_date'=>$no_end3,
				'meetup_time'=>$meetuptime3,
				'end_date'=>$end_date3,
				'end_time'=>$endtime3,
				'is_active'=>1,
				'recurring'=>$recur3,
				'admin_id'=>$admin_id,
				'logtime'=>$logtime
				);

				// print_r($data3);
				 $response[]=$this->event_model->insert($data3, 'ci_plan_event');
					

			}

				if($_POST['form4'])
				{
					$mycounter[]='form4';
					//echo "form4 ready to submit<br>";

					 $location_id4=$this->input->post('location_id4');
						$max_attendies4=$this->input->post('max_attendies4');
						$event_ids4=$this->input->post('event_ids4');
						$meetup_dates4=$this->input->post('meetup_dates4');
						$descriptions4=$this->input->post('descriptions4');
						$meet_time4=$this->input->post('meetup_times4');
						$meetuptime4=date("H:i:s", strtotime($meet_time4));
						$duration4=$this->input->post('duration4');
						$endtime4=date("H:i:s", strtotime($meet_time4." +$duration4  minutes"));
						$no_end4=($this->input->post('noend4'))?(integer) $this->input->post('noend4'):0;
						$recur4=($this->input->post('recurring4'))?implode(",",$this->input->post('recurring4')):'';
						$end_date4=$_POST['end_dates4'];


						 $data4=array(
							'event_id'=>$event_ids4,
							'description'=>$descriptions4,
							'location_id'=>$location_id4,
							'max_attendies'=>$max_attendies4,
							'meetup_date'=>$meetup_dates4,
							'no_end_date'=>$no_end4,
							'meetup_time'=>$meetuptime4,
							'end_date'=>$end_date4,
							'end_time'=>$endtime4,
							'is_active'=>1,
							'recurring'=>$recur4,
							'admin_id'=>$admin_id,
							'logtime'=>$logtime
						);
						// print_r($data4);
						$response[]=$this->event_model->insert($data4, 'ci_plan_event');
					
				}
				if($_POST['form5'])
				{
					$mycounter[]='form5';
					//echo "form5 ready to submit<br>";

						$location_id5=$this->input->post('location_id5');
						$max_attendies5=$this->input->post('max_attendies5');
						$event_ids5=$this->input->post('event_ids5');
						$meetup_dates5=$this->input->post('meetup_dates5');
						$descriptions5=$this->input->post('descriptions5');
						$meet_time5=$this->input->post('meetup_times5');
						$meetuptime5=date("H:i:s", strtotime($meet_time5));
						$duration5=$this->input->post('duration5');
						$endtime5=date("H:i:s", strtotime($meet_time5." +$duration5  minutes"));
						$no_end5=($this->input->post('noend5'))?(integer) $this->input->post('noend5'):0;
						$recur5=($this->input->post('recurring5'))?implode(",",$this->input->post('recurring5')):'';
						$end_date5=$_POST['end_dates5'];


								 $data5=array(
							'event_id'=>$event_ids5,
							'description'=>$descriptions5,
							'location_id'=>$location_id5,
							'max_attendies'=>$max_attendies5,
							'meetup_date'=>$meetup_dates5,
							'no_end_date'=>$no_end5,
							'meetup_time'=>$meetuptime5,
							'end_date'=>$end_date5,
							'end_time'=>$endtime5,
							'is_active'=>1,
							'recurring'=>$recur5,
							'admin_id'=>$admin_id,
							'logtime'=>$logtime
						);

								 //print_r($data5);

					 $response[]=$this->event_model->insert($data5, 'ci_plan_event');
					
				}
				if($_POST['form6'])
				{
					$mycounter[]='form6';
					//echo "form6 ready to submit<br>";

					$location_id6=$this->input->post('location_id6');
					$max_attendies6=$this->input->post('max_attendies6');
					$event_ids6=$this->input->post('event_ids6');
					$meetup_dates6=$this->input->post('meetup_dates6');
					$descriptions6=$this->input->post('descriptions6');
					$meet_time6=$this->input->post('meetup_times6');
					$meetuptime6=date("H:i:s", strtotime($meet_time6));
					$duration6=$this->input->post('duration6');
					$endtime6=date("H:i:s", strtotime($meet_time6." +$duration6  minutes"));
					$no_end6=($this->input->post('noend6'))?(integer) $this->input->post('noend6'):0;
					$recur6=($this->input->post('recurring6'))?implode(",",$this->input->post('recurring6')):'';
					$end_date6=$_POST['end_dates6'];

					 $data6=array(
						'event_id'=>$event_ids6,
						'description'=>$descriptions6,
						'location_id'=>$location_id6,
						'max_attendies'=>$max_attendies6,
						'meetup_date'=>$meetup_dates6,
						'no_end_date'=>$no_end6,
						'meetup_time'=>$meetuptime6,
						'end_date'=>$end_date6,
						'end_time'=>$endtime6,
						'is_active'=>1,
						'recurring'=>$recur6,
						'admin_id'=>$admin_id,
						'logtime'=>$logtime
					);

					// print_r($data6);
				 $response[]=$this->event_model->insert($data6, 'ci_plan_event');
					

				}
				if($_POST['form7'])
				{
					$mycounter[]='form7';
					//echo "form7 ready to submit<br>";


					 $location_id7=$this->input->post('location_id7');
						$max_attendies7=$this->input->post('max_attendies7');
						$event_ids7=$this->input->post('event_ids7');
						$meetup_dates7=$this->input->post('meetup_dates7');
						$descriptions7=$this->input->post('descriptions7');
						$meet_time7=$this->input->post('meetup_times7');
						$meetuptime7=date("H:i:s", strtotime($meet_time7));
						$duration7=$this->input->post('duration7');
						$endtime7=date("H:i:s", strtotime($meet_time7." +$duration7  minutes"));
						$no_end7=($this->input->post('noend7'))?(integer) $this->input->post('noend7'):0;
						$recur7=($this->input->post('recurring7'))?implode(",",$this->input->post('recurring7')):'';
						$end_date7=$_POST['end_dates7'];

					

						 $data7=array(
							'event_id'=>$event_ids7,
							'description'=>$descriptions7,
							'location_id'=>$location_id7,
							'max_attendies'=>$max_attendies7,
							'meetup_date'=>$meetup_dates7,
							'no_end_date'=>$no_end7,
							'meetup_time'=>$meetuptime7,
							'end_date'=>$end_date7,
							'end_time'=>$endtime7,
							'is_active'=>1,
							'recurring'=>$recur7,
							'admin_id'=>$admin_id,
							'logtime'=>$logtime
						);
						 	// print_r($data7);

					$response[]=$this->event_model->insert($data7, 'ci_plan_event');
					

				}
				if($_POST['form8'])
				{
					$mycounter[]='form8';
					//echo "form8 ready to submit<br>";


					  $location_id8=$this->input->post('location_id8');
						$max_attendies8=$this->input->post('max_attendies8');
						$event_ids8=$this->input->post('event_ids8');
						$meetup_dates8=$this->input->post('meetup_dates8');
						$descriptions8=$this->input->post('descriptions8');
						$meet_time8=$this->input->post('meetup_times8');
						$meetuptime8=date("H:i:s", strtotime($meet_time8));
						$duration8=$this->input->post('duration8');
						$endtime8=date("H:i:s", strtotime($meet_time8." +$duration8  minutes"));
						$no_end8=($this->input->post('noend8'))?(integer) $this->input->post('noend8'):0;
						$recur8=($this->input->post('recurring8'))?implode(",",$this->input->post('recurring8')):'';
						$end_date8=$_POST['end_dates8'];

					
						 $data8=array(
							'event_id'=>$event_ids8,
							'description'=>$descriptions8,
							'location_id'=>$location_id8,
							'max_attendies'=>$max_attendies8,
							'meetup_date'=>$meetup_dates8,
							'no_end_date'=>$no_end8,
							'meetup_time'=>$meetuptime8,
							'end_date'=>$end_date8,
							'end_time'=>$endtime8,
							'is_active'=>1,
							'recurring'=>$recur8,
							'admin_id'=>$admin_id,
							'logtime'=>$logtime
						);
						 	//  print_r($data8);
					$response[]=$this->event_model->insert($data8, 'ci_plan_event');
					

				}
				if($_POST['form9'])
				{
					$mycounter[]='form9';
					//echo "form9 ready to submit<br>";

					 $location_id9=$this->input->post('location_id9');
					$max_attendies9=$this->input->post('max_attendies9');
					$event_ids9=$this->input->post('event_ids9');
					$meetup_dates9=$this->input->post('meetup_dates9');
					$descriptions9=$this->input->post('descriptions9');
					$meet_time9=$this->input->post('meetup_times9');
					$meetuptime9=date("H:i:s", strtotime($meet_time9));
					$duration9=$this->input->post('duration9');
					$endtime9=date("H:i:s", strtotime($meet_time9." +$duration9  minutes"));
					$no_end9=($this->input->post('noend9'))?(integer) $this->input->post('noend9'):0;
					$recur9=($this->input->post('recurring9'))?implode(",",$this->input->post('recurring9')):'';
					$end_date9=$_POST['end_dates9'];

						 $data9=array(
						'event_id'=>$event_ids9,
						'description'=>$descriptions9,
						'location_id'=>$location_id9,
						'max_attendies'=>$max_attendies9,
						'meetup_date'=>$meetup_dates9,
						'no_end_date'=>$no_end9,
						'meetup_time'=>$meetuptime9,
						'end_date'=>$end_date9,
						'end_time'=>$endtime9,
						'is_active'=>1,
						'recurring'=>$recur9,
						'admin_id'=>$admin_id,
						'logtime'=>$logtime
					);

				// print_r($data9);

			       $response[]=$this->event_model->insert($data9, 'ci_plan_event');
					
				}
				if($_POST['form10'])
				{
					$mycounter[]='form10';
					  //echo "form10 ready to submit<br>";

						$location_id10=$this->input->post('location_id10');
						$max_attendies10=$this->input->post('max_attendies10');
						$event_ids10=$this->input->post('event_ids10');
						$meetup_dates10=$this->input->post('meetup_dates10');
						$descriptions10=$this->input->post('descriptions10');
						$meet_time10=$this->input->post('meetup_times10');
						$meetuptime10=date("H:i:s", strtotime($meet_time10));
						$duration10=$this->input->post('duration10');
						$endtime10=date("H:i:s", strtotime($meet_time10." +$duration10  minutes"));
						$no_end10=($this->input->post('noend10'))?(integer) $this->input->post('noend10'):0;
						$recur10=($this->input->post('recurring10'))?implode(",",$this->input->post('recurring10')):'';
						$end_date10=$_POST['end_dates10'];


						 $data10=array(
							'event_id'=>$event_ids10,
							'description'=>$descriptions10,
							'location_id'=>$location_id10,
							'max_attendies'=>$max_attendies10,
							'meetup_date'=>$meetup_dates10,
							'no_end_date'=>$no_end10,
							'meetup_time'=>$meetuptime10,
							'end_date'=>$end_date10,
							'end_time'=>$endtime10,
							'is_active'=>1,
							'recurring'=>$recur10,
							'admin_id'=>$admin_id,
							'logtime'=>$logtime
						);

						 	//  print_r($data10);

					$response[]=$this->event_model->insert($data10, 'ci_plan_event');
				}

	
					if(count($response)==count($mycounter))
					{
						$this->session->set_flashdata('flash_message', 'Record has been added successfully');

					}
					else
					{
							$this->session->set_flashdata('flash_error', 'Something is Wrong While Adding Record.');	
					}
			    redirect(site_url('event'));
		}
		
		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$data['event_arrays']=$this->system_model->get_all($data_feed,'ci_event');	   
		//echo "<pre>";
		//print_r($data['event_arrays']);	
		$data['location_arrays']=$this->system_model->get_all($data_feed,'ci_location');	
		//echo "<pre>";
		//print_r($data['location_arrays']);	   	
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		$this->load->view('includes/partials/header',$data);
		$this->load->view('includes/partials/sidebar',$data);
		$this->load->view('includes/partials/topmenu',$data);
		$this->load->view('event/add_multiple',$data);
		$this->load->view('includes/partials/footer',$data);


	}


	//@mkcode end
}
?>