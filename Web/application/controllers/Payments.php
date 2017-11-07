<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payments_billing extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		// Load helpers
		$this->load->helper('url');
		
		// Load PayPal library
		$this->load->library('payments');
	}
	
	function index()
	{
	 	$payment = $this->payments->make_payment(array('visa', '4032030392586047', '062021', 'Calvin', 'Froedge', gmdate("c"), 'month', '1', '30.00', '3'), false); 
		$response = $payment->response;
			
	}
	
	
}
/* End of file Payflow.php */
/* Location: ./system/application/controllers/paypal/templates/Payflow.php */