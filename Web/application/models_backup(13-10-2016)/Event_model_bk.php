<?php

class Event_model extends CI_Model {
	
	public function __construct() 
	{           
	}	
        
	function get_allevent($data)
	{
		$where=array(
			'admin_id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_plan_event')->where($where)->order_by('id','desc');
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_event($data)
	{
		$where=array(
			'id'=>$data['id'],
			'admin_id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_plan_event')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	function events($data)
	{

	$where=array('admin_id'=>$data['admin_id']);

$this->db->select('ci_event.name,ci_plan_event.meetup_date');
$this->db->from('ci_event');
$this->db->join('ci_plan_event', 'ci_plan_event.event_id=ci_event.id');
// $this->db->where($where);
// $this->db->order_by('desc');

$query = $this->db->get();
return $query->result_array();


//	$where=array('admin_id'=>$data['admin_id']);
/*	$this->db->select()->from('ci_plan_event')->order_by('id','desc');
	$query=$this->db->get();
	return $query->result_array();*/	
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
	
	function get_calender_events($where,$tablename)
	{
		$this->db->select()->from($tablename)->where($where)->order_by('id','desc');
		$query=$this->db->get();
		return $query->result_array();
	}
}
?>