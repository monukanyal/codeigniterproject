<?php

class Super_dashboard_model extends CI_Model {
	
	public function __construct() 
	{           
	}	
        
	function get_activities($data)
	{
		$admin_id = $data['admin_id'];
		$sql="SELECT meetup_date, count(*) as sum_rec from ci_plan_event WHERE meetup_date >= ( CURDATE() - INTERVAL 7 DAY ) and meetup_date <= CURDATE() and admin_id = $admin_id and is_active = 1 group by meetup_date order by meetup_date ASC"; 	
		$query=$this->db->query($sql)->result_array();
		return $query;
	}
	function get_attendActivities($data)
	{
		$admin_id = $data['admin_id'];
		$sql="SELECT meetup_date from ci_plan_event WHERE meetup_date >= ( CURDATE() - INTERVAL 7 DAY ) and meetup_date <= CURDATE() and admin_id = $admin_id and is_active = 1 group by meetup_date order by meetup_date ASC"; 	
		$query=$this->db->query($sql)->result_array();

		$response = '';
		if(!empty($query))
		{
			foreach($query as $key=>$value)
			{
				$mt_date = $value['meetup_date'];
				$sql1="SELECT * from ci_plan_event WHERE meetup_date = '$mt_date' and admin_id = $admin_id and is_active = 1 order by meetup_date ASC";
				$query1=$this->db->query($sql1)->result_array();

				$totalAttend = 0;
				foreach($query1 as $key1=>$value1)
				{
					$arrAttend = 0;
					$countAttend = 0;
					if($value1['attend_users'] !='')
					{
						$arrAttend = explode(", ",$value1['attend_users']);
						$countAttend = count($arrAttend);
					}					
					$totalAttend = $totalAttend+$countAttend;
				}
				$response[$key] = array('meetup_date' => $value['meetup_date'], 'sum_rec' => $totalAttend);
			}
		}
		return $response;
	}
	function get_most_active($data)
	{
		$admin_id = $data['admin_id'];
		$sql="SELECT attend_users from ci_plan_event WHERE meetup_date >= ( CURDATE() - INTERVAL 90 DAY ) and meetup_date <= CURDATE() and admin_id = $admin_id and is_active = 1 order by meetup_date ASC"; 	
		$query=$this->db->query($sql)->result_array();

		$arrFinal = array();
		if(!empty($query))
		{
			foreach($query as $key => $value)
			{
				if($value['attend_users'] != '')
				{
					$arrAttend = explode(", ",$value['attend_users']);
					// $countAttend = count($arrAttend);
					$arrFinal = array_merge($arrAttend, $arrFinal);
				}
			}
		}
		$arrTotalAttend = array_count_values($arrFinal);
		arsort($arrTotalAttend);
		$response = '';
		if(!empty($arrTotalAttend))
		{
			$i = 0;
			foreach ($arrTotalAttend as $key1 => $value1) {

				$where=array(
					'id'=>$key1,
					'admin_id'=>$admin_id
				);
				$this->db->select()->from('ci_user')->where($where);
				$arrUser=$this->db->get()->first_row('array');
				if(!empty($arrUser))
				{
					if($i < 10)
					{
						$user_name = ucfirst(substr($arrUser['first_name'], 0, 1)).'.'.$arrUser['last_name'];
						
						$response[$i] = array('user_name' => $user_name, 'sum_rec' => $value1);
					}
					$i++;
				}
			}
		}
		return $response;
	}
	function get_least_active($data)
	{
		$admin_id = $data['admin_id'];
		$sql="SELECT attend_users from ci_plan_event WHERE meetup_date >= ( CURDATE() - INTERVAL 90 DAY ) and meetup_date <= CURDATE() and admin_id = $admin_id and is_active = 1 order by meetup_date ASC"; 	
		$query=$this->db->query($sql)->result_array();

		$arrFinal = array();
		if(!empty($query))
		{
			foreach($query as $key => $value)
			{
				if($value['attend_users'] != '')
				{
					$arrAttend = explode(", ",$value['attend_users']);
					// $countAttend = count($arrAttend);
					$arrFinal = array_merge($arrAttend, $arrFinal);
				}
			}
		}
		$arrTotalAttend = array_count_values($arrFinal);
		asort($arrTotalAttend);
		$response = '';
		if(!empty($arrTotalAttend))
		{
			$i = 0;
			foreach ($arrTotalAttend as $key1 => $value1) {

				$where=array(
					'id'=>$key1,
					'admin_id'=>$admin_id
				);
				$this->db->select()->from('ci_user')->where($where);
				$arrUser=$this->db->get()->first_row('array');
				if(!empty($arrUser))
				{
					if($i < 10)
					{
						$user_name = ucfirst(substr($arrUser['first_name'], 0, 1)).'.'.$arrUser['last_name'];
						
						$response[$i] = array('user_name' => $user_name, 'sum_rec' => $value1);
					}
					$i++;
				}
			}
		}
		return $response;
	}
	function get_least_residents($data)
	{
		$admin_id = $data['admin_id'];
		$sql="SELECT attend_users from ci_plan_event WHERE meetup_date >= ( CURDATE() - INTERVAL 7 DAY ) and meetup_date <= CURDATE() and admin_id = $admin_id and is_active = 1 order by meetup_date ASC"; 	
		$query=$this->db->query($sql)->result_array();

		$arrFinal = array();
		if(!empty($query))
		{
			foreach($query as $key => $value)
			{
				if($value['attend_users'] != '')
				{
					$arrAttend = explode(", ",$value['attend_users']);
					// $countAttend = count($arrAttend);
					$arrFinal = array_merge($arrAttend, $arrFinal);
				}
			}
		}
		$arrTotalAttend = $this->array_avg($arrFinal);
		// arsort($arrTotalAttend);
		$response = '';
		if(!empty($arrTotalAttend))
		{
			$i = 0;
			foreach ($arrTotalAttend as $key1 => $value1) {

				$where=array(
					'id'=>$key1,
					'admin_id'=>$admin_id
				);
				$this->db->select()->from('ci_user')->where($where);
				$arrUser=$this->db->get()->first_row('array');
				if(!empty($arrUser))
				{
					if($i < 10)
					{
						$user_name = ucfirst(substr($arrUser['first_name'], 0, 1)).'.'.$arrUser['last_name'];
						
						$response[$i] = array('user_name' => $user_name, 'sum_rec' => $value1['avg']);
					}
					$i++;
				}
			}
		}
		return $response;
	}

	function array_avg($array, $round=1){
	    $num = count($array);
	    return array_map(
	        function($val) use ($num,$round){
	            return array('count'=>$val,'avg'=>round($val/$num*100, $round));
	        },
	        array_count_values($array));
	}
	function get_planned_activity($data)
	{
		$admin_id = $data['admin_id'];
		$sql="SELECT c_e.name, count(p_e.id) as sum_rec from ci_plan_event as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.meetup_date >= ( CURDATE() - INTERVAL 30 DAY ) and p_e.meetup_date <= CURDATE() and p_e.is_active = 1 group by p_e.event_id order by p_e.meetup_date ASC"; 	
		$query=$this->db->query($sql)->result_array();

		return $query;
	}


}
?>