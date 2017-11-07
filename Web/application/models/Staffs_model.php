<?php

class Staffs_model extends CI_Model {
	
	public function __construct() 
	{           
	}
	
        
	function get_alluser()
	{
		
		$this->db->select('c.*,a.first_name as adminname')->from('ci_staff c');
		$this->db->join('ci_admin a',"a.id=c.admin_id");
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_admindata($data)
	{
		$where=array(
			'id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_user($data)
	{
		$where=array(
			'id'=>$data['id']

		);
		$this->db->select()->from('ci_staff')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	function get_user_byemail($data)
	{
		$where=array(
			'email'=>$data['admin_email']
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	function get_userinfo($data)
	{
		$where=array(
			'id'=>$data['admin_id'],
			'email'=>$data['admin_email']
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	
	 function getUsers($conditions=array(),$fields='')
	 {
	
		if(count($conditions)>0)		
	 		$this->db->where($conditions);
			
		$this->db->from('ci_staffs');

		$this->db->order_by("ci_staffs.id", "asc");

		
		if($fields!='')
				$this->db->select($fields);
		else 		
	 		$this->db->select('ci_staffs.id,ci_staffs.name,ci_staffs.email,ci_staffs.online');
		
		$result = $this->db->get()->result_array();
		
		return $result;
	}
	
	function insert_user($data,$tablename)
	{
		$insert = $this->db->insert($tablename,$data);
		$quer=$this->db->insert_id();		
		return $quer;
	}	
	function insert($data,$tablename)
	{
		$insert = $this->db->insert($tablename,$data);
		$quer=$this->db->insert_id();		
		return $quer;
	}	
	function update($data,$def_data,$tablename)
	{
		$where=array(
			'id'=>$data['id']
		);
		//print_r($def_data);		
		$this->db->where($where);
		$this->db->update($tablename,$def_data);
		// $this->db->last_query(); die;
		//$this->salary_account($userid,$data);
	}
	
	function delete($data,$tablename)
	{
		$where=array(
			'id'=>$data['id'],
			'admin_id'=>$data['admin_id']
		);
		$this->db->where($where);
		$this->db->delete($tablename);
	}
	function get_userById($data)
	{
		$where=array(
			'id'=>$data['id']
		);
		$this->db->select()->from('ci_staff')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	function get_alluserinfo($data)
	{
		
		$this->db->select()->from('ci_admin');
		$query=$this->db->get();
		return $query->first_row('array');
	}
}
?>
