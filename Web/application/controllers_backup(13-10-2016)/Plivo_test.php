<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plivo_test extends CI_Controller
{

    public function index()
    {
        
    }

    /**
     * A function to show the account() function from the library
     * Used to retrieve a users account details 
     */
    public function account()
    {
        $this->load->library('plivo');

        /*
         * look up available number groups
         */
        $response_array = $this->plivo->account();

        if ($response_array[0] == '200')
        {
            $data["account"] = json_decode($response_array[1], TRUE);

            print_r($data["account"]);
        }
        else
        {
            /*
             * the response wasn't good, show the error
             */
            $this->api_error($response_array);
        }
    }

    /**
     * A function to show the available_number_group() from the library
     * Used to see what areas/groups have available numbers
     */
    public function available_number_groups()
    {
        $this->load->library('plivo');

        /*
         * look up available number groups
         */
        $response_array = $this->plivo->available_number_group();

        if ($response_array[0] == '200')
        {
            $data["available_number_groups"] = json_decode($response_array[1], TRUE);

            print_r($data["available_number_groups"]);
        }
        else
        {
            /*
             * the response wasn't good, show the error
             */
            $this->api_error($response_array);
        }
    }

    /**
     * A function to show the available_numbers() from the library
     * Used to list numbers available in an area
     */
    public function available_numbers()
    {
        $this->load->library('plivo');

        /*
         * look up available number groups
         */
        $response_array = $this->plivo->available_numbers('15928342876993'); // 021 area code

        if ($response_array[0] == '200')
        {
            $data["available_numbers"] = json_decode($response_array[1], TRUE);

            print_r($data["available_numbers"]);
        }
        else
        {
            /*
             * the response wasn't good, show the error
             */
            $this->api_error($response_array);
        }
    }

    /**
     * A function to show the send_sms() from the library
     * Used to send an SMS message 
     */
    public function send_sms()
    {
        $this->load->library('plivo');
        
        $this->load->model('user_model');

        $userids = $this->input->post('users',TRUE);
        $message = $this->input->post('msg',TRUE);
        $mobileNo ="" ;
        $result_count = count($userids);
        $count = 1;
      foreach($userids as  $userid) 
      {

            $data['user_info']=$this->user_model->get_userById(array("id" => $userid));
        
            $mobileNo .=  $data['user_info']['mobile'];
            if ($count <  $result_count ) {
                $mobileNo .= "<";
            }

        $count++;

      }
        $sms_data = array(
            'src' => '+15125663933', //The phone number to use as the caller id (with the country code). E.g. For USA 15671234567
            'dst' => "+1".$mobileNo, // The number to which the message needs to be send (regular phone numbers must be prefixed with country code but without the ‘+’ sign) E.g., For USA 15677654321.
            'text' =>  $message , // The text to send
            'type' => 'sms', //The type of message. Should be 'sms' for a text message. Defaults to 'sms'
            'url' => base_url() . 'index.php/plivo_test/receive_sms', // The URL which will be called with the status of the message.
            'method' => 'POST', // The method used to call the URL. Defaults to. POST
        );
 

        /*
         * look up available number groups
         */
        $response_array = $this->plivo->send_sms($sms_data);

        if ($response_array[0] == '200')
        {
            $data["response"] = json_decode($response_array[1], TRUE);

             return $data["response"];
        }
        else if($response_array[0] == '202'){
            $this->session->set_flashdata('flash_message', 'Message Send successfully');
            redirect(site_url('user'));
            $data["response"] = json_decode($response_array[1], TRUE);

            return $data["response"];
        }
        else
        {
            /*
             * the response wasn't good, show the error
             */
            $this->api_error($response_array);
        }

     
        
    }

    /**
     * A function to show the outbound_call() function
     * Used to make a voice call to a customer 
     */
    public function call()
    {
        $this->load->library('plivo');

        $call_data = array(
            'from' => '+123456789', // Required // The phone number to use as the caller id (with the country code). E.g. For USA 15671234567
            'to' => '+123456789', // Required // The number to call. Regular number must be prefixed with country code but without the ‘+’ sign) E.g., For USA 15677654321
            'answer_url' => base_url() . 'index.php/plivo_test/receive_call', // Required // The URL Plivo will fetch when the outbound call is answering.
//            'answer_method' => '',
//            'ring_url' => '',
//            'ring_method' => '',
//            'hangup_url' => '',
//            'hangup_method' => '',
//            'fallback_url' => '',
//            'fallback_method' => '',
//            'caller_name' => '',
//            'send_digits' => '',
//            'send_on_preanswer' => '',
//            'time_limit' => '',
//            'hangup_on_ring' => '',
//            'machine_detection' => '',
//            'machine_detection_time' => '',
//            'sip_headers' => ''
        );

        /*
         * look up available number groups
         */
        $response_array = $this->plivo->outbound_call($call_data);

        if ($response_array[0] == '200')
        {
            $data["response"] = json_decode($response_array[1], TRUE);

            print_r($data["response"]);
        }
        else
        {
            /*
             * the response wasn't good, show the error
             */
            $this->api_error($response_array);
        }
    }

    /**
     * This function is called when a user replies to an SMS message 
     */
    public function receive_sms()
    {
        
    }

    /**
     * This function is called when a user answers a voice call
     */
    public function receive_call()
    {
        
    }

     public function get_messages() {
        

            $this->load->library('plivo');
      
            $response = $_REQUEST;
    
            $from_number = $response['From'];
            $messageText = $response['Text'];
            $explode = explode('{', $messageText);
            $message = explode('}', $explode[1]);

            //$mobileNo ="" ;
           // $from_number = 17374441555;

            $this->load->model('user_model');


            //$userID = $data['user_info']['id'];
            
            $data = array();
            $data = array(
                'UUID' => $message[0],
                'appactive' => 1,
                'phoneNo' => substr($from_number, 1)
             );

            $data_result['user_info'] = $this->user_model->update_userByNo($data);

    }

    /**
     * A function to show the send_sms() from the library
     * Used to resend an SMS message 
     */
    public function resend_sms($userId)
    {
        $this->load->library('plivo');
        
        $this->load->model('user_model');

        $admin_id = $this->session->userdata['logged_in']['admin_id'];
        $data['user_info']=$this->user_model->get_user(array("id" => $userId, "admin_id" => $admin_id));

        $mobileNo = $this->input->post('Ph_number',TRUE);
        $site_url = base_url('index.php/applink');
        $resendsms_data = array(
            'src' => '+15125663933', //The phone number to use as the caller id (with the country code). E.g. For USA 15671234567
            'dst' => "+1".$data['user_info']['mobile'], // The number to which the message needs to be send (regular phone numbers must be prefixed with country code but without the ‘+’ sign) E.g., For USA 15677654321.
            'text' => 'Your App ready to install Please open this link "'.$site_url.'"', // The text to send
            'type' => 'sms', //The type of message. Should be 'sms' for a text message. Defaults to 'sms'
            'url' => base_url() . 'index.php/plivo_test/receive_sms', // The URL which will be called with the status of the message.
            'method' => 'POST', // The method used to call the URL. Defaults to. POST
        );
 
        /*
         * look up available number groups
         */
        $response_array = $this->plivo->resend_sms($resendsms_data);

        if ($response_array[0] == '200')
        {
            $data["response"] = json_decode($response_array[1], TRUE);

             //print_r($data["response"]);
            $this->session->set_flashdata('flash_message', 'Message Send successfully');
            redirect(site_url('user'));

        }
        else if($response_array[0] == '202'){
            $this->session->set_flashdata('flash_message', 'Message Send successfully');
            redirect(site_url('user'));
        }
        else
        {
            /*
             * the response wasn't good, show the error
             */
            $this->api_error($response_array);
        } 
    }

    /**
     * A function to show an error response
     * @param type $response
     */
    public function api_error($response)
    {
        print_r($response);
    }

}

/* End of file Plivo_test.php */
/* Location: ./application/controllers/Plivo_test.php */