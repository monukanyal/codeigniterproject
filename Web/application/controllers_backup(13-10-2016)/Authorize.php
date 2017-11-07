<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authorize extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   
	    header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	    $this->load->model('auth_model');               
	    $this->load->model('user_model');
	    $this->load->helper('security'); 
	    // Load session library
		$this->load->library('session');	

		$auth_user_method = array('index', 'user_login_process'); 
		$current_method =$this->router->fetch_method();
		
		if(in_array($current_method,$auth_user_method))
		{
		    if (isset($this->session->userdata['logged_in']))
				redirect(site_url('dashboard'));				
		}	  
   	}
	public function index()
	{
		// echo site_url();
		$data["title"] = "Login";
		$data["message"] = "";
		$data["error"] = "";
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		$this->load->view('includes/partials/admin/header',$data);
		$this->load->view('authorize/index',$data);
		$this->load->view('includes/partials/admin/footer',$data);
	}

	// Check for user login process
	public function user_login_process() {

		$data["title"] = "Login";
		$data["message"] = "";
		$data["error"] = "";
		$data["assets_path"] = base_url().$this->config->item('assets_path');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			if(isset($this->session->userdata['logged_in'])){
				redirect(site_url('dashboard'));
				// $this->load->view('admin_page');
			}
		} else {
			$data_feed = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
			);
			$result = $this->auth_model->login($data_feed);
			if ($result) {
			
				$email = $this->input->post('email');
				$session_data = array(
						'admin_id' => $result['id'],
						'admin_email' => $result['email'],
						'user_type' => 'simpleuser',
					);
				// Add user data in session
				print_r($session_data);
				$this->session->set_userdata('logged_in', $session_data);
				redirect(site_url('dashboard'));
				// $this->load->view('admin_page');
			} else {
				$data['error'] = 'Invalid Username or Password';
				// $this->load->view('login_form', $data);
			}
		}
		$this->load->view('includes/partials/admin/header',$data);
		$this->load->view('authorize/index',$data);
		$this->load->view('includes/partials/admin/footer',$data);
	}

	// Check for user login process
	public function admin_login_process() {

		$data["title"] = "Login";
		$data["message"] = "";
		$data["error"] = "";
		$data["assets_path"] = base_url().$this->config->item('assets_path');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			if(isset($this->session->userdata['logged_in'])){
				redirect(site_url('super_dashboard'));
				// $this->load->view('admin_page');
			}
		} else {
			$data_feed = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
			);
			$result = $this->auth_model->super_login($data_feed);
			if ($result) {

				$email = $this->input->post('email');
				$session_data = array(
						'super_admin_id' => $result['id'],
						'super_admin_email' => $result['email'],
						'user_type' => 'superadmin',
					);
				// Add user data in session
				$this->session->set_userdata('logged_in', $session_data);
				redirect(site_url('super_dashboard'));
				// $this->load->view('admin_page');
			} else {
				$data['error'] = 'Invalid Username or Password';
				// $this->load->view('login_form', $data);
			}
		}
		$this->load->view('includes/partials/admin/header',$data);
		$this->load->view('authorize/index',$data);
		$this->load->view('includes/partials/admin/footer',$data);
	}

	// Ajax Login for landing page
	public function ajax_login() {

		// Retrieve session data
		$session_set_value = $this->session->all_userdata();
		// Check for remember_me data in retrieved session data
		if (isset($session_set_value['remember_me']) && $session_set_value['remember_me'] == "1") {
		$this->load->view('admin_page');
		} 
		else {
		$email = $this->input->post('email', true);	
		$password = $this->input->post('password', true);

		if($email !='' && $password !='' && $this->auth_model->validate_email($email) == false)
		{
			$ReturnData['error']['email']="Please enter valid Email-Id";
		}
		if($email !='' && $password !='' && $this->auth_model->validate() == false)
		{
			$ReturnData['error'] = "Invalid Username or Password Please try again";
		}

		if($email !='' && $this->auth_model->validate_email($email) == true)
		{
			
			$data_feed = array(
					'email' => $email,
					'password' => $password
				);
			$result = $this->auth_model->login($data_feed);


			if ($result) {

				$remember = $this->input->post('remember_me');
				if ($remember) 
				{
					// Set remember me value in session
					$this->session->set_userdata('remember_me', TRUE);
				}
				$session_data = array(
						'admin_id' => $result['id'],
						'admin_email' => $result['email'],
						'user_type' => 'simpleuser'
					);
				// Add user data in session
				$this->session->set_userdata('logged_in', $session_data);
					// print_r($session_data);
				$ReturnData['success']="Valid User";
			}
			else{
				$data['error'] = 'Invalid Username or Password';
			} 
		}
	}
		echo json_encode($ReturnData);
	}

	// Ajax Register for landing page
	function ajax_register() {

		$first_name = $this->input->post('first_name', true);	
		$address = $this->input->post('address', true);	
		$email = $this->input->post('email', true);	
		$password = $this->input->post('password', true);

		if($email !='' && $this->auth_model->validate_email($email) == false){
			$ReturnData['error']['email']="Please enter valid Email-Id";
		}

		// if($address !=''){
		// 	$data_feed = array(
		// 		'address' => $address
		// 	);
		// 	$result = $this->user_model->get_user_byaddress($data_feed);
		// 	if($result){
		// 		$ReturnData['error']['address']= "This Property Name is already exist";
		// 		// return false;
		// 	}
		// }


		if(($email !=''  && $this->auth_model->validate_email($email) == true) || $address !='')
		{
			$data_feed = array(
				'admin_email' => $email
			);
			$result = $this->user_model->get_user_byemail($data_feed);

			$result1 = $this->user_model->get_user_byaddress(array('address' => $address));

			if (empty($result) && empty($result1)) {
				$default_data = array("first_name" => $first_name,"address" => $address,"email" => $email,"password" => md5($password), "logtime"=>date('Y-m-d H:i:s'));
				$id_record=$this->user_model->insert_user($default_data, 'ci_admin');
			    if($id_record)
			    {
			    	$session_data = array(
						'admin_id' => $id_record,
						'admin_email' => $email,
						'user_type' => 'simpleuser',
					);
					$this->session->set_userdata('logged_in', $session_data);
					$ReturnData['success']="Valid User";
			    } 
			}
			else{
				if($result)
				{
					$ReturnData['user_exist']="User with this Email-Id already exists";
				}
				if($result1) {
					
					$ReturnData['error']['address'] = "This Property Name is already exist";				
				}
		   	}
		}
		echo json_encode($ReturnData);
	}

	// Ajax Login for landing page
	public function dashbaord_login() {

		$email = $this->input->post('email', true);	
		$userID = $this->input->post('userID', true);

		if($email !='' && $this->auth_model->validate_email($email) == false)
		{
			$ReturnData['error']['email']="Please enter valid Email-Id";
		}

		if($email !='' && $this->auth_model->validate_email($email) == true)
		{
			

				$session_data = array(
						'admin_id' => $userID,
						'admin_email' => $email ,
						'user_type' => 'simpleuser'
					);
				// Add user data in session
				$this->session->set_userdata('logged_in', $session_data);
				$ReturnData['success']="Valid User";

		redirect(base_url('index.php/dashboard'));
			 
		}
		echo json_encode($ReturnData);
	}
	public function forgot_password() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[5]|max_length[125]');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('authorize/forgot_password');
    } else {
      $email = $this->input->post('email');

      $this->db->where('email', $email);
      $this->db->from('ci_admin');
      $num_res = $this->db->count_all_results();
      // echo $email;
      
      if ($num_res == 1) {

        // Make a small string (code) to assign to the user // to indicate they've requested a change of // password
        $code = mt_rand('5000', '200000');
        $data = array(
          'forgot_password' => $code,
        );


        $this->db->where('email', $email);
        if ($this->db->update('ci_admin', $data)) {

          // Update okay, send email
          $url = site_url('authorize/new_password/')."/".$code;
          echo $url;
          $body = "\nPlease click the following link to reset your password:\n\n".$url."\n\n";
          if (mail($email, 'Password reset', $body, 'From: webexpert.esfera@gmail.com')) {
            $data['submit_success'] = true;
            // $this->load->view('authorize/authorize', $data);
            redirect(base_url('index.php'));
          }
        } else {
          // Some sort of error happened, redirect user // back to form
          redirect('authorize/forgot_password');
        }
      } else {
        // Some sort of error happened, redirect user back // to form
        redirect('authorize/forgot_password');
      }
    }
  }
  
  public function new_password() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('code', 'Code', 'required|min_length[4]|max_length[7]');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[5]|max_length[125]');
    $this->form_validation->set_rules('password1', 'Password', 'required|min_length[5]|max_length[15]');
    $this->form_validation->set_rules('password2', 'Confirmation Password', 'required|min_length[5]|max_length[15]|matches[password1]');
    
    // Get Code from URL or POST and clean up
    if ($this->input->post()) {
      $data['code'] = xss_clean($this->input->post('code'));
    } else {
      $data['code'] = xss_clean($this->uri->segment(3));
    }

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('authorize/new_password', $data);
    } else {
      // Does code from input match the code against the // email
      $this->load->model('Auth_model');
      $email = xss_clean($this->input->post('email'));
      if (!$this->Auth_model->does_code_match($data['code'], $email)) {
        // Code doesn't match
        redirect ('authorize/forgot_password');
      } else {// Code does match
        $this->load->model('Auth_model');
        $hash = $this->encrypt->sha1($this->input->post('password1'));

        $data = array(
          'user_hash' => $hash
        );

        if ($this->Register_model->update_user($data, $email)) {
          redirect ('authorize');
        }
      }
    }
  }




	// Logout from admin page
	public function logout() {

		// Removing session data
		$sess_array = array();
		$this->session->sess_destroy();
		$this->session->set_flashdata('flash_message', 'Successfully Logout');

		redirect(base_url());
	}

}

?>
