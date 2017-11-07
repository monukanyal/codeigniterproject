<?php

class Staff_model extends CI_Model {
	
	public function __construct() 
	{           
	}	
        
	function get_allstaff($data)
	{
		$where=array(
			'admin_id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_staff')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_staff($data)
	{
		$where=array(
			'id'=>$data['id'],
			'admin_id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_staff')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
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
			'id'=>$data['id'],
			'admin_id'=>$data['admin_id']
		);
		$this->db->where($where);
		$this->db->update($tablename,$def_data);	
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
}
?>