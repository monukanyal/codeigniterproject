<?php

class System_model extends CI_Model {
	
	public function __construct() 
	{           
	}	
        
	function get_all($where, $tablename)
	{
		 $wheres=array(
		 	'admin_id'=>$where['admin_id'],
		 	 'is_active'=>1
		 );
		//echo "<pre>";print_r($where);die("sdfa");
		$this->db->select()->from($tablename)->where($wheres)->order_by('id','desc');
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_single($where, $tablename)
	{
		// $where=array(
		// 	'id'=>$data['id'],
		// 	'admin_id'=>$data['admin_id']
		// );
		$this->db->select()->from($tablename)->where($where);
		$query=$this->db->get();
		return $query->first_row('array');

	}

	function get_single_by_name($lname, $tablename)
	{
		 $where=array(
			'name'=>$lname,
		
		);
		$this->db->select()->from($tablename)->where($where);
		$query=$this->db->get();
		return $query->result_array();

	}

	function get_super_single_event($where, $tablename1, $tablename2, $tablename3)
	{
		// $where=array(
		// 	'id'=>$data['id'],
		// 	'admin_id'=>$data['admin_id']
		// );
		$this->db->where(array("t1.id" => $where['id']));
		$this->db->select("t1.*,t2.name as event_name, t3.name as location_name")->from("$tablename1 as t1");
		$this->db->join("$tablename2 as t2", 't1.event_id = t2.id', 'inner');
		$this->db->join("$tablename3 as t3", 't1.location_id = t3.id', 'inner');
		$query=$this->db->get();
		$result = $query->first_row('array');
		return $result;
	}
	function get_super_single_meal($where, $tablename1, $tablename2)
	{
		// $where=array(
		// 	'id'=>$data['id'],
		// 	'admin_id'=>$data['admin_id']
		// );
		$this->db->where(array("t1.id" => $where['id']));
		$this->db->select("t1.*,t1.name as event_name,t1.id as event_id,t2.name as location_name")->from("$tablename1 as t1");
		// $this->db->join("$tablename2 as t2", 't1.meal_id = t2.id', 'inner');
		$this->db->join("$tablename2 as t2", 't1.location_id = t2.id', 'inner');
		$query=$this->db->get();
		$result = $query->first_row('array');
		return $result;
	}

	function get_single_event_join($where, $tablename1, $tablename2, $tablename3)
	{
		$response = array();
		$this->db->where(array("t1.id" => $where['id'], "t1.admin_id" => $where['admin_id']));
		$this->db->select("t1.*,t2.name as event_name, t3.name as location_name")->from("$tablename1 as t1");
		$this->db->join("$tablename2 as t2", 't1.event_id = t2.id', 'inner');
		$this->db->join("$tablename3 as t3", 't1.location_id = t3.id', 'inner');
		$query=$this->db->get();
		$result = $query->first_row('array');
		if(!empty($result))
		{
			$response['event_name'] = $result['event_name'];
			$response['location_name'] = $result['location_name'];
			$response['meetup_time'] = mdate('%h:%i %A',strtotime($result['meetup_time']));
			$response['end_time'] = mdate('%h:%i %A',strtotime($result['end_time']));
		}
		return $response;
	}
	function get_single_sevent_join($where, $tablename1, $tablename2, $tablename3)
	{
		$response = array();
		$this->db->where(array("t1.id" => $where['id']));
		$this->db->select("t1.*,t2.name as event_name, t3.name as location_name")->from("$tablename1 as t1");
		$this->db->join("$tablename2 as t2", 't1.event_id = t2.id', 'inner');
		$this->db->join("$tablename3 as t3", 't1.location_id = t3.id', 'inner');
		$query=$this->db->get();
		$result = $query->first_row('array');
		if(!empty($result))
		{
			$response['event_name'] = $result['event_name'];
			$response['location_name'] = $result['location_name'];
			$response['meetup_time'] = mdate('%h:%i %A',strtotime($result['meetup_time']));
			$response['end_time'] = mdate('%h:%i %A',strtotime($result['end_time']));
		}
		return $response;
	}


	function get_single_eventAct_join($where, $tablename1, $tablename2, $tablename3)
	{ // Super admin event activity
		$response = array();
		$this->db->where(array("t1.id" => $where['id']));
		$this->db->select("t1.*,t2.name as event_name, t3.name as location_name")->from("$tablename1 as t1");
		$this->db->join("$tablename2 as t2", 't1.event_id = t2.id', 'inner');
		$this->db->join("$tablename3 as t3", 't1.location_id = t3.id', 'inner');
		$query=$this->db->get();
		$result = $query->first_row('array');
		if(!empty($result))
		{
			$response['event_name'] = $result['event_name'];
			$response['location_name'] = $result['location_name'];
			$response['meetup_time'] = mdate('%h:%i %A',strtotime($result['meetup_time']));
			$response['end_time'] = mdate('%h:%i %A',strtotime($result['end_time']));
		}
		return $response;
	}
	
	function getsingle_mealActData($where)
	{
		# code...
		$where=array(
			'id'=>$where['id']
		);
		$this->db->select()->from('ci_plan_meal')->where($where);

		//$sql="SELECT c_e.name, p_e.* from $tablename as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.admin_id = $admin_id  order by p_e.meetup_date DESC"; 	
		$query=$this->db->get();
		$result = $query->first_row('array');
		if(!empty($result))
		{
			$response['meal_name'] = $result['name'];
			$response['location_name'] = $result['location'];
			$response['start_date'] = mdate('%h:%i %A',strtotime($result['start_date']));
			$response['end_time'] = mdate('%h:%i %A',strtotime($result['end_time']));
		}
		return $response;
	}

	function getsingle_mealData($where)
	{ // super admin meal activity 
		# code...
		// $where=array(
		// 	'id'=>$where['id']
		// );
		$this->db->where(array("l.id" => $where['id']));

		$this->db->select('l.*,p.name as location_name')->from('ci_plan_meal as l');
		$this->db->join('ci_location as p', 'p.id=l.location_id');

		//$sql="SELECT c_e.name, p_e.* from $tablename as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.admin_id = $admin_id  order by p_e.meetup_date DESC"; 	
		$query=$this->db->get();
		$result = $query->first_row('array');
		
		if(!empty($result))
		{
			$response['meal_name'] = $result['name'];
			$response['location_name'] = $result['location_name'];
			$response['start_date'] = mdate('%h:%i %A',strtotime($result['start_date']));
			$response['end_time'] = mdate('%h:%i %A',strtotime($result['end_time']));
		}
		return $response;
	}
	function insert($data,$tablename)
	{
		$insert = $this->db->insert($tablename,$data);
		$quer=$this->db->insert_id();		
		return $quer;
	}	
	function update($where,$def_data,$tablename)
	{
		// $where=array(
		// 	'id'=>$data['id'],
		// 	'admin_id'=>$data['admin_id']
		// );
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