<?php

Class Password_rest extends CI_Controller {

public function __construct() {
	parent::__construct();
	    header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		$this->load->helper('url');
			    $this->load->model('auth_model');    
		// Load form helper library
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->model('Password_change_model');
	}
				function index(){	
					$this->load->view('home/password_again');



				}

				function Update_password(){	

						$email = $this->input->post('email');
						$password = $this->input->post('password', true);
						$new_password = $this->input->post('new_password', true);

						$data = array(
						'email'=> $email
						);
						$userdata =	$this->Password_change_model->get_user_byemail($data);

						if (empty($userdata)) {
						    echo 'Not Found';
						}
						else{

							$data = array(
								'email' => $email,
								'password' => md5($new_password)
								);
								print_r($data);
							 $this->Password_change_model->Change_password(	$data );
							 $this->load->view('home/password_again');
							}

							}
						
				
				}
	
?>