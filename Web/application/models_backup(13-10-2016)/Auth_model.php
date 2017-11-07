<?php

class Auth_model extends CI_Model {
	
	public function __construct() 
    {           
        $this->load->helper('string');
        // $this->load->model('app/user_model');
    }
	function login($data)
	{
		$where=array(
			'email'=>$data['email'],
			'password'=>md5($data['password'])
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	function super_login($data)
	{
		$where=array(
			'email'=>$data['email'],
			'password'=>md5($data['password'])
		);
		$this->db->select()->from('ci_super_admin')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	
	
	function validate()
	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('ci_admin');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	function validate1($password)
	{
		$this->db->where('password', $password);
		$query = $this->db->get('ci_admin');
		if($query->num_rows == 1)
		{
			return true;
		}
	}
	
	function validate_email($email)
	{		
	   //print_r($email);die();
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			return false;
		else
			return true;
	}
	
	// function validate_password($password)
	// {		
	//    print_r($password);die();
	// 	// if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	// 	// 	return false;
	// 	// else
	// 	// 	return true;
	// }

	function _email_panelcheck($email)
	{
		$parentid=$this->get_panelid();		
		
		$where="(parentid='$parentid' OR id='$parentid') AND email='$email' AND is_deleted='0'";
		$result=$this->db->select()->from('ci_users')->where($where)->get();

		if($result->num_rows() > 0)
			return FALSE;
		else
			return true;			
	}
	
	function clear_activity()
	{
		$id_user=$this->session->userdata('id_user');
		$today = date('Y-m-d');
		if($this->input->post('clearlog')=='Last day')
		{
			$newdate = date('Y-m-d', strtotime("-1 days"));
		}
		elseif($this->input->post('clearlog')=='Last 30 days')
			$newdate = date('Y-m-d', strtotime("-30 days"));
		elseif($this->input->post('clearlog')=='ALL CLEAR')
			$newdate = '';
		$query="select * from ci_activity where id_user='$id_user' and creationdate like '%$newdate%'";
		$result_query=$this->db->query($query)->result_array();
		if(isset($result_query) && !empty($result_query))
		{
			$sql="delete from ci_activity where id_user='$id_user' and creationdate like '%$newdate%'";
			$result=$this->db->query($sql);		
			return true;
		}
		else
			return false;
	}
	
	
		
	// function validate_email($email)
	// {		
	//    //print_r($email);die();
	//    $exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
	//    if(eregi($exp,$email))
	//    {
	// 	  if(checkdnsrr(array_pop(explode("@",$email)),"MX")){
	// 		return true;
	// 	  }else{
	// 		return false;
	// 	  }
	//    }
	//    else
	//    {
	// 	  return false;
	//    }   
	// }
			
	function reset_Password($userid,$data)
	{
		$this->db->where('id',$userid);
		$this->db->update('ci_users',$data);
	}

		
	
	function get_country()
	{	
		$inactive = "0";
		$this->db->where('inactive', $inactive);
		$query = $this->db->get('ci_country');
		foreach ($query->result() as $row){
			$countryresults[] = array(
				'id' => $row->id,
				'name' => $row->name
				);
		}
		return $countryresults;
	}
	
	function get_registermailparams($id)
	{		
	   // $this->load->library('parser');

		if($id!="")
		{			
			$users=$this->db->select('*')->from('ci_users')->where(array('id'=>$id))->get()->result_array();						
			$params=array();				
			if(is_array($users) && count($users)>0)
			{				
				$params['tempvalues']=$users[0];
				$params['tempvalues']['password']=$this->input->post('password');
				$params['tempvalues']['url']=base_url();
				
				//$path = $this->config->item('tpl_path')."mailtemplate/";
				//$params['tempvalues']['templates']=$this->parser->parse($path.'temp_register.tpl', $params['tempvalues'], true);
				
				$params['from']=$this->get_senderDetails($users[0]['parentid']);
				$params['to'][]=array('name'=>safe_decode($users[0]['name']),'email'=>$users[0]['email']);					
			}			
			return safe_decode($params);
		}
	}
	

	
	function get_logo($path)
	{
		$this->load->view($this->config->item('tpl_path').'widgets/logo.tpl',$path);
	}
	
	function get_timezone($country)
	{
		$this->db->where('id', $country);
		$query = $this->db->get('ci_country')->result_array();
		if(is_array($query) && count($query))
			{
				$results=$query[0]['id_timezone'];
			}
		return safe_decode($results);
	}
	function authentication()
	{				
		if($this->session->userdata('id_user')=='')
		{
			return true;
		}
		
	}
	
	
	function check_auth()
	{
		$author='';
		$sideresults='';
		$inactive = "0";
		$is_deleted = "0";
		$hidden = "0";
		$id_user=$this->session->userdata('id_user');
		$sessionmodule=$this->session->userdata('id_sessionmodule');
		//$mac_address = safe_decode($this->session->userdata('mac_address'));
		$this->db->where('id', $id_user);
			
		$query1 = $this->db->get('ci_users');
		//echo $this->db->last_query();  authorisedroles	
		if ($query1->num_rows() > 0)
		{
		   foreach ($query1->result() as $rowr)
		   {
			  $author=$rowr->authorisedroles;
		   }
		}
		//echo $mac_address;
		//if(empty($mac_address))
		//		{
			//		$this->session->sess_destroy();	
			//		redirect(base_url().'app/noaccess');

			//	}
/*
		if($author=='')
		{
			redirect(base_url().'app/noaccess');
		}
*/
		$permission_array=$query1->result_array();
		
		$id_user=$this->session->userdata('id_user');
		$patharray=$this->uri->segment(1)."/".$this->router->fetch_class();
		$checkpath=0;
		if($id_user == '')
		{
			redirect(base_url().'app/authorize');
		}
		else
		{
			if($author=='')
				redirect(base_url().'app/noaccess');

			$author_ids=explode(",",$author);
			$author_array='';
			$roldatv='';
			foreach($author_ids as $authors)						
				$author_array[]="FIND_IN_SET($authors,authorisedroles)";
				
			$role_data=implode(" OR ",$author_array);
			$Get_roles="SELECT * FROM ci_menu WHERE FIND_IN_SET('0',authorisedroles) AND `inactive` = '$inactive' AND `is_deleted` = '$is_deleted'";
			$query12=$this->db->query($Get_roles);
			$getorder=$query12->result_array();
			
			if(isset($getorder) && !empty($getorder))
			{
				foreach($getorder as $getorders)
					$roledat[]=$getorders['id'];
			}
			if(isset($permission_array) && !empty($permission_array) && $permission_array[0]['is_admin']=='1')
			{
				$sql = "SELECT * FROM (`ci_menu`) WHERE `inactive` = '$inactive' AND `is_deleted` = '$is_deleted'";						
			}
			else
			{
				if(isset($roledat) && !empty($roledat))
				{
					$roldatv=implode(",",$roledat);	
					$sql = "SELECT * FROM (`ci_menu`) WHERE (id in ($roldatv) OR ($role_data)) AND `inactive` = '$inactive' AND `is_deleted` = '$is_deleted'";			
				}
				else
					$sql = "SELECT * FROM (`ci_menu`) WHERE `inactive` = '$inactive' AND `is_deleted` = '$is_deleted' AND ($role_data)";			
				//die($sql);
			}
			$query=$this->db->query($sql);			
			foreach ($query->result() as $row){
			$sideresults[] = array(				
				'url_path' => $row->url_path
				);
			}
			$permission_array=$this->db->select()->from('ci_users')->where(array('id'=>$id_user,'is_deleted'=>0))->limit(1)->get()->result_array();
		
			if($sideresults!='')
			{
				foreach($sideresults as $key=>$val)
				{
					
						if(in_array($patharray,$val))
						{
							$checkpath=0;
							break;
						}
						else
						{
							$checkpath=1;
						}
					
				}
				
				if($checkpath==1)
				{
					if($this->session->userdata('id_user')!='')
						redirect(base_url().'app/noaccess');
					else
						redirect(base_url().'app/authorize');
				}

			}
		}		
	}
	function mac($mac_address)
	{
		$where=array(
			'mac_address'=>safe_encode($mac_address),
			'inactive'=>0
		);
		$this->db->select()->from('ci_allow_access')->where($where);
		$query = $this->db->get();
		return $query->first_row('array');
	}
	 public function update_user($data, $email) {
        $this->db->where('email', $email);
        $this->db->update('ci_admin', $data);
    }

    public function does_email_exist($email) {
      $this->db->where('email', $email);
      $this->db->from('ci_admin');
      $num_res = $this->db->count_all_results();
        if ($num_res == 1) {
          return TRUE;
      } else {
          return FALSE;
      }
    }

    public function does_code_match($code, $email) {
      $this->db->where('email', $email);
      $this->db->where('forgot_password', $code);
      $this->db->from('ci_admin');
        $num_res = $this->db->count_all_results();

        if ($num_res == 1) {
          return TRUE;
      } else {
          return FALSE;
      }
    }

}
