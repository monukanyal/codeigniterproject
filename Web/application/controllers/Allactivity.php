<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allactivity extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   	    
	     $this->load->model('event_model');
	     $this->load->model('meal_model');
	     $this->load->model('users_model');
	     $this->load->model('users_smodel');
	     $this->load->model('allactivity_model');
	     $this->load->model('system_model');
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
	public function index()
	{
		$data["title"] = "Calender Events";
		$data["message"] = "";
		$data["error"] = "";

		// $data['css'] = array("css1"=>"datatables/tools/css/dataTables.tableTools.css");
		//$data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
		$data['arrEvent'] = $this->allactivity_model->get_allevent();

		// print_r($data);
		// die();

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
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

	// $data_feed = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
	// $data=$this->event_model->events($data_feed);
	// echo json_encode($data);
	}
	
	function calendar() {
		
		$data["title"] = "Event";
		$data["message"] = "";
		$data["error"] = "";

		$data['cur_controller']=$this->router->fetch_class(); //currnet controller
		$data['cur_controller_method']=$this->router->fetch_method(); //current controller method	
		
		$data['css_other'] = array("css1"=>"fullcalendar/fullcalendar.css", "css2"=>"fullcalendar/fullcalendar.print.css");

		$data["js_header"] = array("js1" => "fullcalendar/lib/moment.min.js","js2" => "fullcalendar/lib/jquery.min.js","js3" => "fullcalendar/fullcalendar.min.js");


		$data['arrEvent'] = $this->allactivity_model->get_allevent();
		// print_r($data['arrEvent']);
		// die();

		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method;
		$default_data11='';

		$default_data['event_id'] = $this->input->post('event_id');	
		// $default_data['name'] = $this->input->post('name');	
		$default_data['name'] = $this->input->post('name');	
		$default_data['start_date'] = $this->input->post('start_date');	
		$default_data['start_time'] = $this->input->post('start_time');
		$default_data['description'] = $this->input->post('description');	
		$default_data['location_id'] = $this->input->post('location_id');	
		$default_data['max_attendies'] = $this->input->post('max_attendies');
		$default_data['meetup_date'] = $this->input->post('meetup_date');	
		$default_data['meetup_time'] = $this->input->post('meetup_time');	
		$default_data['end_date'] = $this->input->post('end_date');	
		$default_data['no_end_date'] = $this->input->post('no_end_date');	
		$default_data['end_time'] = $this->input->post('end_time');	
		$default_data['meal_type'] = $this->input->post('meal_type');
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;
		$default_data['recurring'] = $this->input->post('recurring');
		$form_data = $this->_generateform($default_data,0,$self_url,$default_data11);

		// print_r($form_data);
		
		$data["css"] = array("css1" => "jquery.ui.css", "css2" => "jquery.timepicker.css");
		$data["js"] = array("js1" => "parsley/parsley.min.js","js2" => "datepicker/datepicker.js","js3" => "datepicker/jquery.timepicker.min.js");
		

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('super_dashboard/calendar/calendar',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	function show($eventId) {		
		$data["title"] = "Show Event";

		// echo $eventId;

		//$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$data['event_info']=$this->allactivity_model->get_event(array("id" => $eventId));

		// print_r($data);
		// die();

        if($data['event_info']['event_id'] != '')
            $data['arrEvent'] = $this->system_model->get_single(array("id" => $data['event_info']['event_id'], "admin_id" => $admin_id),'ci_event');

        if($data['event_info']['location_id'] != '')
            $data['arrLocation'] = $this->system_model->get_single(array("id" => $data['event_info']['location_id'], "admin_id" => $admin_id),'ci_location');

		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('event/show',$data);
		$this->load->view('includes/partials/footer',$data);
	}

	/************************
	* To generate form
	*************************/
	function _generateform($default_data,$validate=0,$current_url,$default_data11)
	{
		$data['startform']=form_open_multipart($current_url,'data-parsley-validate class="form-horizontal form-label-left"');
		
		
		$event_arrays=$this->allactivity_model->get_all('ci_event');	   	
		$location_arrays=$this->allactivity_model->get_all('ci_location');	

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
		
		// meal form field
		$data['form']['name']['label']=form_label('Name:*','name');
		$data['form']['name']['field']=form_input(array('name'=>'name','type'=>'text','id'=>'name','value'=>$default_data['name'],'class'=>'form-control','required'=>'required','autofocus'=>'true'));
		
		$data['form']['description']['label']=form_label('Description','description');
		$data['form']['description']['field']=form_textarea(array('name'=>'description','type'=>'textarea','id'=>'description','rows'=>1,'value'=>$default_data['description'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['location_id']['label']=form_label('Location:','location_id');
		$data['form']['location_id']['field']=form_dropdown('location_id',$result_location,$default_data['location_id'],('class="form-control" id="location_id" required'));

		$data['form']['max_attendies']['label']=form_label('Maximum Attendies','max_attendies');
		$data['form']['max_attendies']['field']=form_input(array('name'=>'max_attendies','type'=>'text','id'=>'max_attendies','value'=>$default_data['max_attendies'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['meetup_date']['label']=form_label('Meetup Date','meetup_date');
		$data['form']['meetup_date']['field']=form_input(array('name'=>'meetup_date','type'=>'text','id'=>'meetup_date','value'=>$default_data['meetup_date'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['meetup_time']['label']=form_label('Meetup Time','meetup_time');
		$data['form']['meetup_time']['field']=form_input(array('name'=>'meetup_time','type'=>'text','id'=>'meetup_time','value'=>$default_data['meetup_time'],'class'=>'form-control','autofocus'=>'true'));

		// meal fields
		$data['form']['start_date']['label']=form_label('Meal Date','start_date');
		$data['form']['start_date']['field']=form_input(array('name'=>'start_date','type'=>'text','id'=>'start_date','value'=>$default_data['start_date'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['start_time']['label']=form_label('Meal Time','start_time');
		$data['form']['start_time']['field']=form_input(array('name'=>'start_time','type'=>'text','id'=>'start_time','value'=>$default_data['start_time'],'class'=>'form-control','autofocus'=>'true'));

		// event 
		$data['form']['end_time']['label']=form_label('End Time','end_time');
		$data['form']['end_time']['field']=form_input(array('name'=>'end_time','type'=>'text','id'=>'end_time','value'=>$default_data['end_time'],'class'=>'form-control','autofocus'=>'true'));
			
		$data['form']['end_date']['label']=form_label('End Date','end_date');
		$data['form']['end_date']['field']=form_input(array('name'=>'end_date','type'=>'text','id'=>'end_date','value'=>$default_data['end_date'],'class'=>'form-control','autofocus'=>'true'));

		$data['form']['no_end_date']['label']=form_label('No end Date','no_end_date');
		// $data['form']['no_end_date']['field']=form_checkbox(array('name'=>'no_end_date','type'=>'checkbox','id'=>'no_end_date','value'=>$default_data['no_end_date'],'class'=>'form-control'));
		$data['form']['no_end_date']['field']=form_checkbox('no_end_date',1,$default_data['no_end_date'],('id=no_end_date'));
		
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

		$role_arrays=array("S"=>"S","M"=>"M","T"=>"T","W"=>"W","Th"=>"Th","F"=>"F","St"=>"St");
		$data['form']['recurring']['label']=form_label('Recurring Meal','recurring');
		
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
		$default_data['name'] = $this->input->post('meal_type');
		$default_data['meal_type'] = $this->input->post('meal_type');
		$default_data['no_end_date'] = 0;

		$default_data['meetup_time'] = $this->input->post('meetup_time');	
		$default_data['end_date'] = $this->input->post('end_date');	
		$default_data['end_time'] = $this->input->post('end_time');	
		$default_data['is_active'] = ($this->input->post('is_active')) ? $this->input->post('is_active') : 1;
		$default_data['recurring'] = $this->input->post('recurring');


			// print($this->input->post());
			// die();
		if(isset($_POST['submit'])) 
		{
			// print_r($this->input->post());
			// die();
			$this->form_validation->set_rules('event_id', 'Event', 'trim|required');
					
			$default_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
			$default_data['logtime'] = date('Y-m-d H:i:s');

			if($this->form_validation->run() == TRUE)				
			{   	
				$default_data['no_end_date'] = $this->input->post('no_end_date');
				$default_data['recurring'] = ($this->input->post('recurring'))?implode(",",$this->input->post('recurring')):'';
				$default_data['name'] = $this->input->post('meal_type');
				$default_data['meetup_time'] = ($this->input->post('meetup_time'))?mdate('%H:%i', strtotime($this->input->post('meetup_time'))):'';			
				$default_data['end_time'] = ($this->input->post('end_time'))?mdate('%H:%i', strtotime($this->input->post('end_time'))):'';			
				$default_data['is_active'] = ($this->input->post('is_active'))?(integer) $this->input->post('is_active'):0;	
       			// $default_data['is_deleted'] = 0;
			    $id_record=$this->allactivity_model->insert($default_data, 'ci_plan_event');
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
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('event/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	function edit($eventId,$start=0)
	{
		// echo $eventId;
		$data["title"] = "Edit Event";

		$cur_controller=$this->router->fetch_class(); //currnet controller
		$cur_controller_method=$this->router->fetch_method(); //current controller method	
		$self_url=site_url()."/".$cur_controller."/".$cur_controller_method."/".$eventId;
		
		$data['message']=$this->input->get('message');
		$data['error']=$this->input->get('error');	
		$default_data['name'] = $edit_data['meal_type'];
   		$default_data['meal_type'] = $edit_data['meal_type'];

		// $admin_id = $this->session->userdata['logged_in']['admin_id'];
		$edit_data=$this->allactivity_model->get_event(array("id" => $eventId));
	
		$default_data['recurring']='';
		$default_data12['recurring[]']='';
		//$default_data['id'] = $userId;
					
		if($this->router->fetch_method()=='edit'  && !empty($edit_data))
		{
			$default_data['event_id'] = $edit_data['event_id'];
			$default_data['name'] = $edit_data['name'];
			$default_data['description'] = $edit_data['description'];
			$default_data['location_id'] = $edit_data['location_id'];
			$default_data['max_attendies'] = $edit_data['max_attendies'];
			$default_data['meetup_date'] = $edit_data['meetup_date'];
			$default_data['meetup_time'] = $edit_data['meetup_time'];
			$default_data['no_end_date'] = $edit_data['no_end_date'];
			$default_data['end_date'] = $edit_data['end_date'];
			$default_data['end_time'] = $edit_data['end_time'];
			$default_data['is_active'] = $edit_data['is_active'];
			$default_data['meal_type'] = $edit_data['meal_type'];
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
			$default_data['name'] = $this->input->post('meal_type');
			$default_data['description'] = $this->input->post('description');	
			$default_data['location_id'] = $this->input->post('location_id');	
			$default_data['max_attendies'] = $this->input->post('max_attendies');		
			$default_data['meetup_date'] = $this->input->post('meetup_date');
			$default_data['no_end_date'] = $this->input->post('no_end_date');		
			$default_data['meetup_time'] = ($this->input->post('meetup_time'))?mdate('%H:%i', strtotime($this->input->post('meetup_time'))):'';			
			$default_data['end_date'] = $this->input->post('end_date');	
			$default_data['meal_type'] = $this->input->post('meal_type');
			$default_data['end_time'] = ($this->input->post('end_time'))?mdate('%H:%i', strtotime($this->input->post('end_time'))):'';	
			$default_data['is_active'] = ($this->input->post('is_active'))?((integer) $this->input->post('is_active')):0;		
			$default_data['recurring'] = ($this->input->post('recurring'))?implode(",",$this->input->post('recurring')):'';

			$this->form_validation->set_rules('event_id', 'Event', 'trim|required');
			if($this->form_validation->run() == TRUE)				
			{
				$default_data['id'] = $eventId;
				$default_data['modified_at'] = date('Y-m-d H:i:s');
				$data_feed = array('id' => $eventId);
			    $id_record=$this->allactivity_model->update($data_feed, $default_data, 'ci_plan_event');
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
		$this->load->view('includes/partials/super_admin/header',$data);
		$this->load->view('includes/partials/super_admin/sidebar',$data);
		$this->load->view('includes/partials/super_admin/topmenu',$data);
		$this->load->view('event/add',$form_data);
		$this->load->view('includes/partials/footer',$data);
	}

	public function delete($eventId)
	{
		$red_url = $this->agent->referrer();
		$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$default_data['id'] = $eventId;
		// $default_data['admin_id'] = $admin_id;
		$default_data['is_deleted'] = 1;
		$id_record=$this->allactivity_model->delete($default_data, 'ci_plan_event');
		
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
			$default_data['name'] = $this->input->post('meal_type',TRUE);
			$default_data['meal_type'] = $this->input->post('meal_type',TRUE);
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
}
?>