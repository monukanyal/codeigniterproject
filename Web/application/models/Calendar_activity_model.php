<?php

class Calendar_activity_model extends CI_Model {
	
	public function __construct() 
	{           
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
	function get_calender_events($where,$tablename)
	{
		
		$where=array(
			'admin_id'=>$where['admin_id']
		);
		$this->db->select()->from('ci_plan_event')->where($where)->order_by('id','desc');

		//$sql="SELECT c_e.name, p_e.* from $tablename as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.admin_id = $admin_id  order by p_e.meetup_date DESC"; 	
		$query=$this->db->get();
		return $query->result_array();

		// return $query;
	}

}
?>