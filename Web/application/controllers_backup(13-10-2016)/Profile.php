<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() 
    {
        parent::__construct();          
         $this->load->model('user_model');

        if (!isset($this->session->userdata['logged_in'])) {
            $this->session->set_flashdata('flash_error', 'Please Login First!!');
            redirect(base_url());
        }       
    }
    public function index($userId)
    {
        $data["title"] = "Resident";
        $data["message"] = "";
        $data["error"] = "";
        $userId = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
        $data['user_info']=$this->user_model->get_admindata($userId);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        //print_r($userId);

        $data["assets_path"] = base_url().$this->config->item('assets_path');
        $this->load->view('includes/partials/header',$data);
        $this->load->view('includes/partials/sidebar',$data);
        $this->load->view('includes/partials/topmenu',$data);
        $this->load->view('profile/index',$data);
        $this->load->view('includes/partials/footer',$data);
    }
  
}
?>