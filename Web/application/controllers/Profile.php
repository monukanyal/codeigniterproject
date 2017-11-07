<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
    public function index($userId)
    {
        $data["title"] = "Admin";
        $data["message"] = "";
        $data["error"] = "";
        $admin_id=$this->session->userdata['logged_in']['admin_id'];
        $userId = array("admin_id" => $this->session->userdata['logged_in']['admin_id']);
        $data['user_info']=$this->user_model->get_admindata($userId);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        //print_r($userId);
        $data['billdata']=$this->user_model->get_billing_info($admin_id);

        $data["assets_path"] = base_url().$this->config->item('assets_path');
        $this->load->view('includes/partials/header',$data);
        $this->load->view('includes/partials/sidebar',$data);
        $this->load->view('includes/partials/topmenu',$data);
        $this->load->view('profile/index',$data);
        $this->load->view('includes/partials/footer',$data);
    }

    public function update_sitecode(){
        $id = $_POST['id'];
        $sitecode = $_POST['sitecode'];
        $data['result'] = $this->user_model->update_sitecode($id, $sitecode);
        echo json_encode($data);
    }

    public function get_sitecode(){
        $id = $_POST['id'];
        $data['result'] = $this->user_model->get_sitecode($id);
        echo json_encode($data);
    }

    //@mkcode start
    public function get_month_complete_data()
    {
        $admin_id=$this->session->userdata['logged_in']['admin_id'];
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
    //@mkcode end   
  
}
?>