<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class Paynow extends CI_Controller 
{
    public function index()
    {
    
        echo phpinfo();
        //$this->load->view('welcome_message');
       
    }


    public function curl_test()
    {
        $ch = curl_init('https://www.howsmyssl.com/a/check');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $data = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($data);
        echo $json->tls_version ."\n";

    }
 
    public function pay_test_old()
    {
        // Authorize.net lib
        $this->load->library('authorize_net');

        $auth_net = array(
            'x_card_num'            => '4111111111111111', // Visa
            'x_exp_date'            => '12/18',
            'x_card_code'           => '123',
            'x_description'         => 'A test transaction',
            'x_amount'              => '2',
            'x_first_name'          => 'Animesh',
            'x_last_name'           => 'Doe',
            'x_address'             => '123 Green St.',
            'x_city'                => 'Lexington',
            'x_state'               => 'KY',
            'x_zip'                 => '40502',
            'x_country'             => 'US',
            'x_phone'               => '555-123-4567',
            'x_email'               => 'test@example.com',
            'x_customer_ip'         => $this->input->ip_address(),
            );
        $this->authorize_net->setData($auth_net);

        // Try to AUTH_CAPTURE
        if( $this->authorize_net->authorizeAndCapture() )
        {
            echo '<h2>Success!</h2>';
            echo '<p>Transaction ID: ' . $this->authorize_net->getTransactionId() . '</p>';
            echo '<p>Approval Code: ' . $this->authorize_net->getApprovalCode() . '</p>';
        }
        else
        {
            echo '<h2>Fail!</h2>';
            // Get error
            echo '<p>' . $this->authorize_net->getError() . '</p>';
            // Show debug data
            $this->authorize_net->debug();
        }
    }

 public function pay_instant()
    {

        /*  The customer’s card code.The three- or four-digit number on the back of a credit card (on the front for American Express). */ 
        
        /*       $_POST['x_card_num']="4111111111111111";
                $_POST['x_exp_date']="2018-04";
                $_POST['x_card_code']="123";
                $_POST['x_first_name']="Himanshu";
                $_POST['x_last_name']="Gurung";
                $_POST['x_address']="xyz";
                $_POST['x_city']="dehradun";
                $_POST['x_state']="uttarakhand";
                $_POST['x_zip']="248001";
                $_POST['x_phone']="9878787878";
                $_POST['x_email']='test@gmail.com';
                $_POST['amount']='1';  */

                $auth_amount=$_POST['amount'];
                $x_card_num=$_POST['x_card_num'];
                $x_exp_date=$_POST['x_exp_date'];  //MM/YY
                $x_card_code=$_POST['x_card_code'];

                $x_first_name=$_POST['x_first_name'];
                $x_last_name=$_POST['x_last_name'];
                $x_address=$_POST['x_address'];
                //$x_country=$_POST['x_country'];<---
                $x_state=$_POST['x_state'];
                $x_city=$_POST['x_city'];

                $x_zip=$_POST['x_zip'];
                $x_phone=$_POST['x_phone'];
                $x_email=$_POST['x_email'];  

            //define("AUTHORIZENET_LOG_FILE", "phplog");
             $merchant_id= $this->config->item('auth_merchant_id');
            $merchant_trans_key= $this->config->item('auth_transaction_key');
            // Common setup for API credentials
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName("$merchant_id");
            $merchantAuthentication->setTransactionKey("$merchant_trans_key");

            // Create the payment data for a credit card
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber("$x_card_num");
            $creditCard->setExpirationDate("$x_exp_date");
            $creditCard->setCardCode("$x_card_code");
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);

            // Set the customer's Bill To address
            $customerAddress = new AnetAPI\CustomerAddressType();
            $customerAddress->setFirstName("$x_first_name");
            $customerAddress->setLastName("$x_last_name");
            //$customerAddress->setCompany("Souveniropolis");
            $customerAddress->setAddress("$x_address");
            $customerAddress->setCity("$x_city");
            $customerAddress->setState("$x_state");
            $customerAddress->setZip("$x_zip");
            //$customerAddress->setCountry("$x_country");
                
             // Set the customer's identifying information
            $customerData = new AnetAPI\CustomerDataType();
            $customerData->setType("individual");
            $customerData->setId("$x_phone");
            $customerData->setEmail("$x_email");
            
            // Create a transaction
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction"); 
            $transactionRequestType->setAmount($auth_amount);
            $transactionRequestType->setPayment($paymentOne);
            $transactionRequestType->setBillTo($customerAddress);
            $transactionRequestType->setCustomer($customerData);

            $request = new AnetAPI\CreateTransactionRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setTransactionRequest( $transactionRequestType);

            $controller = new AnetController\CreateTransactionController($request);
            //$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
             $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            
            if ($response != null)
            {
                $tresponse = $response->getTransactionResponse();

                if (($tresponse != null) && ($tresponse->getResponseCode()=="1") )   
                {
                    echo '<h2>Success!</h2>';
                    echo '<p style="color:green">Transaction ID: ' . $tresponse->getTransId() . '</p>';
                      // $this->load->modal('');
                }
                else
                {
                    echo '<h2>Fail!</h2>';
                    echo  "<p status='color:crimson'>Charge Credit Card ERROR :".$response->getMessages()->getMessage()[0]->getText()." </p>";
                }
            }
            else
            {
                echo  "<p status='color:crimson'>Charge Credit card Null response returned</p>";
            }

    }
    //---start payment
    public function pay_monthly_bill()
    {

        /*  The customer’s card code.The three- or four-digit number on the back of a credit card (on the front for American Express). */ 
                $auth_amount=$_POST['amount'];
                $x_card_num=$_POST['x_card_num'];
                $x_exp_date=$_POST['x_exp_date'];  //MM/YY
                $x_card_code=$_POST['x_card_code'];

                $x_first_name=$_POST['x_first_name'];
                $x_last_name=$_POST['x_last_name'];
                $x_address=$_POST['x_address'];
                //$x_country=$_POST['x_country'];
                $x_state=$_POST['x_state'];
                $x_city=$_POST['x_city'];

                $x_zip=$_POST['x_zip'];
                $x_phone=$_POST['x_phone'];
                $x_email=$_POST['x_email'];
                $bill_id=$_POST['bill_id'];
                $admin_id=$_POST['admin_id'];

    
            //define("AUTHORIZENET_LOG_FILE", "phplog");
             $merchant_id= $this->config->item('auth_merchant_id');
            $merchant_trans_key= $this->config->item('auth_transaction_key');
            // Common setup for API credentials
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName("$merchant_id");
            $merchantAuthentication->setTransactionKey("$merchant_trans_key");

            // Create the payment data for a credit card
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber("$x_card_num");
            $creditCard->setExpirationDate("$x_exp_date");
            $creditCard->setCardCode("$x_card_code");
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);

            // Set the customer's Bill To address
            $customerAddress = new AnetAPI\CustomerAddressType();
            $customerAddress->setFirstName("$x_first_name");
            $customerAddress->setLastName("$x_last_name");
            //$customerAddress->setCompany("Souveniropolis");
            $customerAddress->setAddress("$x_address");
            $customerAddress->setCity("$x_city");
            $customerAddress->setState("$x_state");
            $customerAddress->setZip("$x_zip");
           // $customerAddress->setCountry("$x_country");
                
             // Set the customer's identifying information
            $customerData = new AnetAPI\CustomerDataType();
            $customerData->setType("individual");
            $customerData->setId("$x_phone");
            $customerData->setEmail("$x_email");
            
            // Create a transaction
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction"); 
            $transactionRequestType->setAmount($auth_amount);
            $transactionRequestType->setPayment($paymentOne);
            $transactionRequestType->setBillTo($customerAddress);
            $transactionRequestType->setCustomer($customerData);

            $request = new AnetAPI\CreateTransactionRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setTransactionRequest( $transactionRequestType);

            $controller = new AnetController\CreateTransactionController($request);
            //$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            if ($response != null)
            {
                $tresponse = $response->getTransactionResponse();

                if (($tresponse != null) && ($tresponse->getResponseCode()=="1") )   
                {
                    $tr_num=$tresponse->getTransId();
                    $this->load->model("user_model");
                    $this->user_model->update_bill_info($bill_id,$tr_num,$admin_id);
                    echo '<h2>Success!</h2>';
                    echo '<p style="color:green">Transaction ID: ' . $tresponse->getTransId() . '</p>';
                }
                else
                {
                    echo '<h2>Failed!</h2>';
                    echo  "<p status='color:crimson'>Charge Credit Card ERROR :".$response->getMessages()->getMessage()[0]->getText()." </p>";
                }
            }
            else
            {
                echo  "<p status='color:crimson'>Charge Credit card Null response returned</p>";
            }

    }
 public function create_subscription()
        {
    
             date_default_timezone_set('America/Los_Angeles');
              
              // $_POST['cardnum']="4111111111111111";
              //   $_POST['exp_date']="2019-04";
              //   $_POST['firstname']="mk";
              //   $_POST['lastname']="singh";
              //   $_POST['address']="xyz";
              //   $_POST['city']="dehradun";
              //   $_POST['state']="uttarakhand";
              //   $_POST['zipcode']="248001";
              //   $_POST['care_id']="380"; 
          
            //  $x=array('status'=>'success','text'=>$_POST);
            // echo json_encode($x);
            //  die;
            if(!empty($_POST['cardnum'])&&!empty($_POST['exp_date'])&&!empty($_POST['care_id'])&&!empty($_POST['firstname'])&&!empty($_POST['lastname'])&&!empty($_POST['address'])&&!empty($_POST['city'])&&!empty($_POST['state'])&&!empty($_POST['zipcode']))
            {
                    $card_num= $_POST['cardnum'];
                    $exp_date=$_POST['exp_date'];
                    $firstname=$_POST['firstname'];
                    $lastname=$_POST['lastname'];
                    $care_id=$_POST['care_id']; 
                    $address=$_POST['address'];
                    $city=$_POST['city'];
                    $state=$_POST['state'];
                   // $country=$_POST['country'];
                    $zipcode=$_POST['zipcode'];
                     // $email=$_POST['email'];  //not mandatory
                    
                    $merchant_id= $this->config->item('auth_merchant_id');
                    $merchant_trans_key= $this->config->item('auth_transaction_key');
                     $this->load->model("user_model");
                     $this->user_model->del_subscription_care($care_id);
                     $is_started=$this->user_model->is_caresubscription_started($care_id);
                     if($is_started==0)
                     {
                     //-----getting admin price rule-------
                   /* $this->load->model("user_model");
                    $care_charge=$this->user_model->get_care_charge($care_id);
                    if(!empty($care_charge))
                    { */
                        //------------------------------------
                        $intervalLength=1;
                        
                        // Common Set Up for API Credentials
                        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                        $merchantAuthentication->setName("$merchant_id");
                        $merchantAuthentication->setTransactionKey("$merchant_trans_key");
                        $start=date('Y-m-d');
                        $refId = 'ref'.time();
                        
                        // Subscription Type Info
                        $subscription = new AnetAPI\ARBSubscriptionType();
                        $subscription->setName("CARE $care_id Subscription");
                        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
                        $interval->setLength($intervalLength);
                        $interval->setUnit("months");  //days months
                        $paymentSchedule = new AnetAPI\PaymentScheduleType();
                        $paymentSchedule->setInterval($interval);
                        $paymentSchedule->setStartDate(new DateTime("$start"));
                        $paymentSchedule->setTotalOccurrences("9999");
                        // $paymentSchedule->setTrialOccurrences("1");
                        $subscription->setPaymentSchedule($paymentSchedule);
                        $subscription->setAmount("0.5");   // it should be dynamic -set by admin 
                      

                         //$subscription->setAmount("$care_charge"); 
                        // $subscription->setTrialAmount("0.00");
                        
                        $creditCard = new AnetAPI\CreditCardType();
                        $creditCard->setCardNumber("$card_num");
                        $creditCard->setExpirationDate("$exp_date");  //YYYY-MM
                        $payment = new AnetAPI\PaymentType();
                        $payment->setCreditCard($creditCard);
                        
                        $subscription->setPayment($payment);
                        $order = new AnetAPI\OrderType();
                        $inv_num=uniqid();
                        $order->setInvoiceNumber("$inv_num");        
                        $order->setDescription("Description of the subscription"); 
                        $subscription->setOrder($order); 
                        
                        $billTo = new AnetAPI\NameAndAddressType();
                        $billTo->setFirstName("$firstname");
                        $billTo->setLastName("$lastname");
                        $billTo->setaddress("$address");
                        $billTo->setcity("$city");
                        $billTo->setstate("$state");   //2 character
                        //$billTo->setcountry("$country");
                        $billTo->setzip("$zipcode");
                       // $billTo->setemail("$email");  //not mandatory
                        $subscription->setBillTo($billTo);
                        $request = new AnetAPI\ARBCreateSubscriptionRequest();
                        $request->setmerchantAuthentication($merchantAuthentication);
                        $request->setRefId($refId);
                        $request->setSubscription($subscription);
                        $controller = new AnetController\ARBCreateSubscriptionController($request);
                        //$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
                        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                        // print_r($response);
                        // echo "<br>".$subscription_id=$response->getSubscriptionId();
                        // die;
                        
                        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
                        {

                            $subscription_id=$response->getSubscriptionId();
                            $subscription_status=$this->get_subscription_status($subscription_id);
                                 $data=array(
                                "care_id"=>$care_id,
                                "amount"=>'0.5',
                                "subc_id"=>$subscription_id,
                                'status'=>$subscription_status
                                );
                                $care_status=$this->user_model->add_care_subscription_info($data);
                                if(!empty($care_status))
                                {
                                  $b=array('status'=>'success','result'=>$response->getSubscriptionId(),'text'=>'Your Subscription has been Created.');
                                    echo json_encode($b);

                                }

                        }   
                        else
                        {
                           
                                 $errorMessages = $response->getMessages()->getMessage();
                                 $b=array('status'=>'error','text'=>$errorMessages[0]->getText());
                                 echo json_encode($b);
                        }
                    }
                    else
                    {
                        $b=array('status'=>'success','text'=>'Subscription has already started for this care.');
                                    echo json_encode($b);
                    }
              /*  }
                else
                {
                    $a=array('status'=>'error','text'=>'Care charge has not set by admin!!');
                    echo json_encode($a);
                }
                */

            }
            else
            {
                
               $a=array('status'=>'error','text'=>'please provide required data*');
                echo json_encode($a);
              
            }
            
    }  

  // temporary solution
    /* public function create_subscription_dummy()
        {
        
                 date_default_timezone_set('America/Los_Angeles');
                  
                if(!empty($_POST['cardnum'])&&!empty($_POST['exp_date'])&&!empty($_POST['care_id'])&&!empty($_POST['firstname'])&&!empty($_POST['lastname'])&&!empty($_POST['address'])&&!empty($_POST['city'])&&!empty($_POST['state'])&&!empty($_POST['zipcode']))
                {
                        $card_num= $_POST['cardnum'];
                        $exp_date=$_POST['exp_date'];
                        $firstname=$_POST['firstname'];
                        $lastname=$_POST['lastname'];
                        $care_id=$_POST['care_id']; 
                        $address=$_POST['address'];
                        $city=$_POST['city'];
                        $state=$_POST['state'];
                       // $country=$_POST['country'];
                        $zipcode=$_POST['zipcode'];
                         // $email=$_POST['email'];  //not mandatory
                        
                        $merchant_id= $this->config->item('auth_merchant_id');
                        $merchant_trans_key= $this->config->item('auth_transaction_key');
                         $this->load->model("user_model");
                         $this->user_model->del_subscription_care($care_id);
                         $is_started=$this->user_model->is_caresubscription_started($care_id);
                         if($is_started==0)
                         {
                   

                                $subscription_id=uniqid();
                                $subscription_status='active';
                                
                                 $data=array(
                                    "care_id"=>$care_id,
                                    "amount"=>'1',
                                    "subc_id"=>$subscription_id,
                                    'status'=>$subscription_status
                                    );
                      
                                    $care_status=$this->user_model->add_care_subscription_info($data);
                                    if(!empty($care_status))
                                    {
                                      $b=array('status'=>'success','result'=>$response->getSubscriptionId(),'text'=>'Your Subscription has been Created.');
                                        echo json_encode($b);

                                    }

                           
                        }
                        else
                        {
                            $b=array('status'=>'success','text'=>'Subscription has already started for this care.');
                                        echo json_encode($b);
                        }
                 

                }
                else
                {
                    
                   $a=array('status'=>'error','text'=>'please provide required data*');
                    echo json_encode($a);
                  
                }
                
        }
    
     */

    public function cancel_subscription()
    {
            //define("AUTHORIZENET_LOG_FILE", "phplog");
            // $_POST['subscriptionId']="35321729";
            // $_POST['care_id']="380";
        
            if(!empty($_POST['subscriptionId'])&& !empty($_POST['care_id']))
            {
                $subscriptionId=$_POST['subscriptionId'];
                $care_id=$_POST['care_id'];
                $merchant_id= $this->config->item('auth_merchant_id');
                $merchant_trans_key= $this->config->item('auth_transaction_key');

                $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                $merchantAuthentication->setName("$merchant_id");
                $merchantAuthentication->setTransactionKey("$merchant_trans_key");

                $refId = 'ref' . time();
                $request = new AnetAPI\ARBCancelSubscriptionRequest();
                $request->setMerchantAuthentication($merchantAuthentication);
                $request->setRefId($refId);
                $request->setSubscriptionId($subscriptionId);
                $controller = new AnetController\ARBCancelSubscriptionController($request);
                $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
               // $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
                if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
                {
                    $successMessages = $response->getMessages()->getMessage();
                   // print_r($successMessages);
                     $this->load->model("user_model");
          
                        $care_status=$this->user_model->del_subscription_info($care_id,$subscriptionId);

                        if(!empty($care_status))
                        {
                            //$successMessages[0]->getText();
                            $b=array('status'=>'success','text'=>"Your subscription has been canceled successfully.");
                            echo json_encode($b);
                            
                       }else
                       {

                           
                           echo json_encode(array('status'=>"success",'text'=>"Your subscription has been canceled."));
                      }
                 }
                else
                {
                    
                    $errorMessages = $response->getMessages()->getMessage();
                    //echo $errorMessages;
                    $b=array('status'=>'error','text'=>$errorMessages[0]->getText());
                       echo  json_encode($b);
                    
                }
            }
            else
            {
                  
                
                       echo  json_encode(array('status'=>'error','text'=>'Please provide required data'));
            }

    }

    public function update_subscription()
    {
            // $_POST['cardnum']="4111111111111111";
            //     $_POST['exp_date']="2018-04";  //yyyy-mm
            //     $_POST['subscriptionId']="4642015";
             
         if(!empty($_POST['subscriptionId'])&&!empty($_POST['cardnum'])&&!empty($_POST['exp_date']))
            {
                $subscriptionId=$_POST['subscriptionId'];
                $card_num= $_POST['cardnum'];
                $exp_date=$_POST['exp_date'];
                
                $merchant_id= $this->config->item('auth_merchant_id');
                $merchant_trans_key= $this->config->item('auth_transaction_key');
                
                $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                $merchantAuthentication->setName("$merchant_id");
                $merchantAuthentication->setTransactionKey("$merchant_trans_key");
                
                $refId = 'ref'.time();
                $subscription = new AnetAPI\ARBSubscriptionType();
                $creditCard = new AnetAPI\CreditCardType();
                $creditCard->setCardNumber("$card_num");
                $creditCard->setExpirationDate("$exp_date");
                $payment = new AnetAPI\PaymentType();
                $payment->setCreditCard($creditCard);
                $subscription->setPayment($payment);
                $request = new AnetAPI\ARBUpdateSubscriptionRequest();
                $request->setMerchantAuthentication($merchantAuthentication);
                $request->setRefId($refId);
                $request->setSubscriptionId("$subscriptionId");
                $request->setSubscription($subscription);
                $controller = new AnetController\ARBUpdateSubscriptionController($request);
               // $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
             $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
                {

                    $msg=$response->getMessages()->getMessage()[0]->getText();
                        //echo $msg;
                    $b=array('status'=>"success",'text'=>"Your Subscription details has been updated.");
                           echo json_encode($b);
                }
                else
                {
                   $msg=$response->getMessages()->getMessage()[0]->getText();
                    $b=array('status'=>"success",'text'=>$msg);
                           echo json_encode($b);

               }
            }
            else
            {
                echo  json_encode(array('status'=>'error','text'=>'Please provide required data'));
            }
    }

    function get_subscription_status($subc_id)
    {
                // Common Set Up for API Credentials
                $merchant_id= $this->config->item('auth_merchant_id');
                $merchant_trans_key= $this->config->item('auth_transaction_key');

                $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                $merchantAuthentication->setName("$merchant_id");
                $merchantAuthentication->setTransactionKey("$merchant_trans_key");
               // $refId = 'ref' . time();
                $request = new AnetAPI\ARBGetSubscriptionStatusRequest();
                $request->setMerchantAuthentication($merchantAuthentication);
               // $request->setRefId($refId);
                $request->setSubscriptionId("$subc_id");
                $controller = new AnetController\ARBGetSubscriptionStatusController($request);
                //$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
                  $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
                {
                    return $response->getStatus();
                    
                }
                else
                {

                    return "";

                }
    }

        /*-----------------------------------------------------------------------
        It checks subscription in table and also get status of that subscription
        -------------------------------------------------------------------------*/
     public function care_subscription_check()
    {   
               // $_POST['care_id']='482';
                $this->load->model("user_model");
                if(!empty($_POST['care_id']))
                {
                $care_id=$_POST['care_id'];
                $reg_status=$this->user_model->get_care_reg_info($care_id);
                $subscription_id=$this->user_model->get_care_subscription_info($care_id);
                if(!empty($subscription_id))
                {

                     // Common Set Up for API Credentials
                    $merchant_id= $this->config->item('auth_merchant_id');
                    $merchant_trans_key= $this->config->item('auth_transaction_key');

                    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                    $merchantAuthentication->setName("$merchant_id");
                    $merchantAuthentication->setTransactionKey("$merchant_trans_key");
                    // $refId = 'ref' . time();
                    $request = new AnetAPI\ARBGetSubscriptionStatusRequest();
                    $request->setMerchantAuthentication($merchantAuthentication);
                    // $request->setRefId($refId);
                    $request->setSubscriptionId("$subscription_id");
                    $controller = new AnetController\ARBGetSubscriptionStatusController($request);
                    //$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
                    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                    if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
                    {
                
                        $current_status=$response->getStatus();
                        $this->user_model->update_care_subscription_info($care_id,$current_status);
                       
                        if($current_status=='active')
                        {
                             $b = array(
                                'query_status'=>'success',
                                'subscription_status'=>$current_status,
                                'registration_status'=>$reg_status,
                                'text'=>'Subscription Started!!',
                                'result'=>$subscription_id
                            );
                               echo json_encode($b);
                        }
                        else
                        {
                             $b = array(
                                'query_status'=>'success',
                                'subscription_status'=>$current_status,
                                'registration_status'=>$reg_status,
                                'text'=>"Subscription $current_status,Please update your Subscription.",
                                'result'=>$subscription_id
                            );
                               echo json_encode($b);
                        }
                    }
                    else
                    {
                        $b=array('query_status'=>"error",'subscription_status'=> $response->getMessages()->getMessage()[0]->getText(),'registration_status'=>$reg_status,'text'=>$response->getMessages()->getMessage()[0]->getText(),'result'=>$subscription_id);
                           echo json_encode($b);
                    
                    //echo "Response : " . $response->getMessages()->getMessage()[0]->getCode(). "\n";

                    }
                }
                else
                {
                    $a  = array(
                            'query_status'=>'success',
                            'text'=>'Subscription Did Not Start Yet.',
                            'subscription_status'=>'no_subscription',
                            'registration_status'=>$reg_status
                        );
                     echo json_encode($a);
                }
                
               
           }
 
    }


    function newmailtest()
    {
                      $code='dsfsdhf';
                   // $url="site_url().'/Home/confirm_account/$code'";
             
                     $to = "monu_kanyal@esferasoft.com, himanshu_gurung@esferasoft.com";
                    $subject = "HTML email";

                    $message = "
                    <html>
                    <head>
                    <title>HTML email</title>
                    </head>
                    <body>
                    <p>This email contains HTML Tags!</p>
                    <table>
                    <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    </tr>
                    <tr>
                    <td>John</td>
                    <td>Doe</td>
                    </tr>
                    </table>
                    </body>
                    </html>
                    ";

                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                     $headers .= 'From: admin <admin@gmail.com>' . "\r\n";
                     if(mail($to,$subject,$message,$headers))
                     {
                      echo "Mail Successfully Sent..";
                      
                     }
    }

   

}

?>