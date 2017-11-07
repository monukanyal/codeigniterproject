<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin_profile extends CI_Controller {

    function __construct() 
    {
        parent::__construct();          
         $this->load->model('users_model');
         $this->load->model('users_smodel');

        if (!isset($this->session->userdata['logged_in'])) {
            $this->session->set_flashdata('flash_error', 'Please Login First!!');
            redirect(base_url());
        }   
        elseif($this->session->userdata['logged_in']['user_type'] != 'superadmin'){
            redirect(base_url('index.php/dashboard'));
        }      
    }
    public function index($userId)
    {
        $data["title"] = "User Information";
        $data["message"] = "";
        $data["error"] = "";
        $userId= $this->session->userdata['logged_in']['super_admin_id'];
        $data['super_admin_id'] = $userId;
        $data['superadmin_info'] = $this->users_smodel->get_admindata($data);
     
        $data["assets_path"] = base_url().$this->config->item('assets_path');
        $this->load->view('includes/partials/super_admin/header',$data);
        $this->load->view('includes/partials/super_admin/sidebar',$data);
        $this->load->view('includes/partials/super_admin/topmenu',$data);
        $this->load->view('super_dashboard/profile/index',$data);
        $this->load->view('includes/partials/footer',$data);
    }
  
}
?>