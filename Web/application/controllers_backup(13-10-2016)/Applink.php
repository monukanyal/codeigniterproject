<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class APPLINK extends CI_Controller {	
	
	public function index() 
	{
	    $this->load->library('Mobile_Detect');
	    $detect = new Mobile_Detect();
	    $respose = array();

		if( $detect->isiOS() ){
		redirect('https://itunes.apple.com/us/app/my-day-community/id1108829046?ls=1&mt=8');
		}
		 
		if( $detect->isAndroidOS() ){
		 redirect('https://play.google.com/store/apps/details?id=com.community.myresidents');
		}
	}

}
