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
	//--29 march
	function get_secondary_admin_staff($admin_id)
	{
		$where=array(
			'admin_id'=>$admin_id
		);
		$this->db->select('*')->from('ci_staff')->where($where);
		$query=$this->db->get();
		if($query->num_rows()>0)
		{
		return $query->result_array();
		}else
		{
			return "";
		}
	}
	function update_secondary_admin_staff($admin_id,$staff_id)
	{	
		$where=array(
			'admin_id'=>$admin_id,
			''=>1
		);
		$this->db->select('*');
		$this->db->from('ci_staff');
		$this->db->where('is_secondary_admin',1);
		$this->db->where('admin_id', $admin_id);
		$query=$this->db->get();
		
		if($query->num_rows()==1)
		{
			$row=$query->result_array();

			$id=$row[0]['id'];
			$this->db->set('is_secondary_admin',0);
			$this->db->where('id', $id);
			$this->db->where('admin_id', $admin_id);
			$this->db->update('ci_staff');
		}

		$this->db->set('is_secondary_admin',1);
		$this->db->where('id', $staff_id);
		$this->db->where('admin_id', $admin_id);
		$this->db->update('ci_staff');
	}
}
?>