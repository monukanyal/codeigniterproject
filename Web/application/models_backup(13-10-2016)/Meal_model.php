<?php

class Meal_model extends CI_Model {
	
	public function __construct() 
	{           
	}	
        
	function get_allmeal($data)
	{
		$where=array(
			'admin_id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_plan_meal')->where($where)->order_by('id','desc');
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_meal($data)
	{
		$where=array(
			'id'=>$data['id'],
			'admin_id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_plan_meal')->where($where);
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
	function get_calender_meals($where,$tablename)
	{
		
		$where=array(
			'admin_id'=>$where['admin_id']
		);
		$this->db->select()->from('ci_plan_meal')->where($where)->order_by('id','desc');

		//$sql="SELECT c_e.name, p_e.* from $tablename as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.admin_id = $admin_id  order by p_e.meetup_date DESC"; 	
		$query=$this->db->get();
		return $query->result_array();

		// return $query;
	}

}
?>