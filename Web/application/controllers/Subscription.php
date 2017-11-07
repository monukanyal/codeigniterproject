<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

	function __construct() 
   	{
	    parent::__construct(); 	   
		
		$this->load->library('session');
	    $this->load->model('auth_model');               
	    $this->load->model('user_model');
	   
	   	// Load helpers
		$this->load->helper('url');
		// Load PayPal library
		$this->config->load('paypal');
		$config = array(
			'Sandbox' => $this->config->item('Sandbox'),
			'APIUsername' => $this->config->item('PayFlowUsername'),
			'APIPassword' => $this->config->item('PayFlowPassword'),
			'APIVendor' => $this->config->item('PayFlowVendor'),
			'APIPartner' => $this->config->item('PayFlowPartner')
		);
		if($config['Sandbox'])
		{
			// Show Errors
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}
		$this->load->library('paypal/Paypal_payflow', $config);

   	}
	public function index()
	{
	
		// echo site_url();
		$data["title"] = "Home";
		$data["assets_path"] = base_url().$this->config->item('assets_path');
		// $this->load->view('includes/partials/admin/header',$data);
		$this->load->view('home/subscription',$data);

		if (isset($_POST['subscription']) && ($_POST['subscription'] == 'Add')) {
			$account_no=$this->input->post('credit_card');
			$month=$this->input->post('month');
			$year=$this->input->post('year');
			$description=$this->input->post('description');
			$authcode=$this->input->post('authcode');
			$cvv2=$this->input->post('cvv2');
			$amount=$this->input->post('amount');
			$cardlevel=$this->input->post('VISACARDLEVEL');
			$email=$this->input->post('email');
			$phonenum=$this->input->post('phonenum');
			$firstname=$this->input->post('firstname');
			$middlename=$this->input->post('middlename');
			$lastname=$this->input->post('lastname');
			$street=$this->input->post('street');
			$city=$this->input->post('city');
			$state=$this->input->post('state');
			$zip=$this->input->post('zip');
			$country=$this->input->post('country');
			//$trxtype=$this->input->post('trxtype');

			// Prepare request arrays
			$PayPalRequestData = array(
				'tender'=>'C', 				// Required.  The method of payment.  Values are: A = ACH, C = Credit Card, D = Pinless Debit, K = Telecheck, P = PayPal
				'trxtype'=>'S', 			// Required.  Indicates the type of transaction to perform.  Values are:  A = Authorization, B = Balance Inquiry, C = Credit, D = Delayed Capture, F = Voice Authorization, I = Inquiry, L = Data Upload, N = Duplicate Transaction, S = Sale, V = Void
				'acct'=>$account_no, // Required for credit card transaction.  Credit card or purchase card number.
				'expdate'=>$month.$year, 	//	0622	// Required for credit card transaction.  Expiration date of the credit card.  Format:  MMYY
				'amt'=>$amount,				// Required.  Amount of the transaction.  Must have 2 decimal places.
				'dutyamt'=>'', 				//
				//'freightamt'=>'5.00', 	//
				//'taxamt'=>'2.50', 		//
				'taxexempt'=>'', 			//
				'comment1'=>$description, 	// Merchant-defined value for reporting and auditing purposes.  128 char max
				'comment2'=>$description, 	// Merchant-defined value for reporting and auditing purposes.  128 char max
				'cvv2'=>$cvv2, 				// A code printed on the back of the card (or front for Amex)
				'recurring'=>'Y',
				 			// Identifies the transaction as recurring.  One of the following values:  Y = transaction is recurring, N = transaction is not recurring.
				'frequency' =>'1',
				'swipe'=>'', 				// Required for card-present transactions.  Used to pass either Track 1 or Track 2, but not both.
				'orderid'=>'', 				// Checks for duplicate order.  If you pass orderid in a request and pass it again in the future the response returns DUPLICATE=2 along with the orderid
				'billtoemail'=>$email, // Account holder's email address.
				'billtophonenum'=>$phonenum, 	// Account holder's phone number.
				'billtofirstname'=>$firstname, 		// Account holder's first name.
				'billtomiddlename'=>$middlename, 	// Account holder's middle name.
				'billtolastname'=>$lastname, 		// Account holder's last name.
				'billtostreet'=>$street, 	// The cardholder's street address (number and street name).  150 char max
				'billtocity'=>$city, 	// Bill to city.  45 char max
				'billtostate'=>$state, 	// Bill to state.
				'billtozip'=>$zip, 	// Account holder's 5 to 9 digit postal code.  9 char max.  No dashes, spaces, or non-numeric characters
				'billtocountry'=>$country, 	// Bill to Country.  3 letter country code.
				'shiptofirstname'=>'', 	// Ship to first name.  30 char max
				'shiptomiddlename'=>'', // Ship to middle name. 30 char max
				'shiptolastname'=>'', 	// Ship to last name.  30 char max
				'shiptostreet'=>'', 	// Ship to street address.  150 char max
				'shiptostate'=>'', 		// Ship to state.
				'shiptozip'=>'', 		// Ship to postal code.  10 char max
				'shiptocountry'=>'', 	// Ship to country code.  3 char code.
				'origid'=>'', 			// Required by some transaction types.  ID of the original transaction referenced.  The PNREF parameter returns this ID, and it appears as the Transaction ID in PayPal Manager reports.
				'custref'=>'', 			//
				'custcode'=>'', 		//
				'custip'=>'', 			//
				'invnum'=>'', 			//
				'ponum'=>'', 			//
				'starttime'=>'', 		// For inquiry transaction when using CUSTREF to specify the transaction.
				'endtime'=>'', 			// For inquiry transaction when using CUSTREF to specify the transaction.
				'securetoken'=>'', 		// Required if using secure tokens.  A value the Payflow server created upon your request for storing transaction data.  32 char
				'partialauth'=>'', 		// Required for partial authorizations.  Set to Y to submit a partial auth.
				'authcode'=>$authcode 			// Rrequired for voice authorizations.  Returned only for approved voice authorization transactions.  AUTHCODE is the approval code received over the phone from the processing network.  6 char max
			);
	//print_r($PayPalRequestData);die();
			$PayPalResult = $this->paypal_payflow->ProcessTransaction($PayPalRequestData);
			if(!$this->paypal_payflow->APICallSuccessful($PayPalResult['RESULT']))
			{
				// Error
				echo "error";
				echo '<pre />';
				print_r($PayPalResult);
			}
			else
			{
				echo "successful";
				// Successful call.  Load view or whatever you need to do here.
				echo '<pre />';
				print_r($PayPalResult);
			}
		}
		//print_r($remember);
		// if($remember){
		// $this->session->set_userdata('remember_me', true);
		// }

		// $this->load->view('includes/partials/admin/footer',$data);
	}
	
}

?>
