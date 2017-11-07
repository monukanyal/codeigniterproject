<?php

class Meal_model extends CI_Model {
	
	public function __construct() 
	{           
	}	
      
      function get_locationlist($data)
	{
		$where=array(
			'admin_id'=>$data['admin_id'],
			
		);
		$this->db->select()->from('ci_location')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
    function get_mealbreakfast($data)
	{
		$where=array(
			'admin_id'=>$data['admin_id'],
			'no_end_date !='=>1,  //1--for old meal
			'meal_type'=>'breakfast'
		);
		$this->db->select()->from('ci_plan_meal')->where($where)->order_by('id','desc');
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_recurring_meal_id($mealid)
	{
		$this->db->select('*')->from('ci_plan_meal')->where('id',$mealid);
		$query=$this->db->get();
		$res=$query->result_array();
		return $res[0]['recurring'];
	}
	  function get_meallunch($data)
		{
			$where=array(
				'admin_id'=>$data['admin_id'],
				'no_end_date !='=>1,  //1--for old meal
				'meal_type'=>'lunch'
			);
			$this->db->select()->from('ci_plan_meal')->where($where)->order_by('id','desc');
			$query=$this->db->get();
			return $query->result_array();
		}
		function get_mealdinner($data)
		{
			$where=array(
				'admin_id'=>$data['admin_id'],
				'no_end_date !='=>1,  //1--for old meal
				'meal_type'=>'dinner'
			);
			$this->db->select()->from('ci_plan_meal')->where($where)->order_by('id','desc');
			$query=$this->db->get();
			return $query->result_array();
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

	//@mkcode start
	function get_calender_meals($where,$tablename)
	{
		
		$where=array(
			'admin_id'=>$where['admin_id'],
			'no_end_date'=>1    //no end date
		);
		$this->db->select()->from('ci_plan_meal')->where($where)->order_by('id','desc');

		//$sql="SELECT c_e.name, p_e.* from $tablename as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.admin_id = $admin_id  order by p_e.meetup_date DESC"; 	
		$query=$this->db->get();
		$res=$query->result_array();
		for($k=0;$k<count($res);$k++)
			{
				$location_id=$res[$k]['location_id'];	
				$this->db->select('*');
				$this->db->from('ci_location');
				$this->db->where('id',$location_id);
				$query=$this->db->get();
				$output=$query->result_array();
				$name['location_name']=$output[0]['name'];
				$data[]=array_merge($res[$k],$name);
			}
			
			return $data;
		
	}
	function get_calender_meals_withdate($where,$tablename)
	{
		
		$where=array(
			'admin_id'=>$where['admin_id'],
			'no_end_date'=>0    //no end date
		);
		$this->db->select()->from('ci_plan_meal')->where($where)->order_by('id','desc');	
		$query=$this->db->get();
		$res=$query->result_array();
		for($k=0;$k<count($res);$k++)
			{
				$location_id=$res[$k]['location_id'];	
				$this->db->select('*');
				$this->db->from('ci_location');
				$this->db->where('id',$location_id);
				$query=$this->db->get();
				$output=$query->result_array();
				$name['location_name']=$output[0]['name'];
				$data[]=array_merge($res[$k],$name);
			}
			
			return $data;
		
	}
	//28 march

	function get_planmeal_old($userid,$admin_id)
	{
		$data=array();
		$d=date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from('ci_plan_meal');
		$this->db->like('list_users',$userid);  //%userid%
		$this->db->where('logtime <',$d);  // data above current date
		$this->db->where('admin_id',$admin_id);
		$this->db->order_by("id", "desc");
		$query=$this->db->get();
		//echo "<br>numrows: ".$query->num_rows();
		$p=0;
		foreach ($query->result_array() as $row)
		{	$a=array();
			$str=$row['list_users'];
       		$a=explode(",",$str);
       		//print_r($a);
       		// true means found
			$name=$row['name'];
			$logtime=$row['logtime'];
			$id=$row['id'];
			if(in_array($userid, $a)==true)
			{
				//echo "<br>yes";
				$data[$p]['id']=$id; 
				$data[$p]['name']=$name;
				$data[$p]['logtime']=$logtime;
				// print_r($meals)."<br>";
				$p++;
			}
			
			
		}
		if(count($data)>0)
			{
				return $data;
			}
			else
			{
				return "";
			}
		//print_r($data);
	}

	
	function get_planmeal_up($userid,$admin_id)
	{	
		$data=array();
		$d=date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from('ci_plan_meal');
		$this->db->like('list_users',$userid);  //%userid%
		$this->db->where('logtime >',$d);  // data above current date
		$this->db->where('admin_id',$admin_id);
		$this->db->order_by("id", "desc");
		$query=$this->db->get();
		//echo "<br>numrows: ".$query->num_rows();
		$p=0;
		foreach ($query->result_array() as $row)
		{	$a=array();
			$str=$row['list_users'];
       		$a=explode(",",$str);
       		//print_r($a);
       		// true means found
			$name=$row['name'];
			$logtime=$row['logtime'];
			$id=$row['id'];
			if(in_array($userid, $a)==true)
			{
				//echo "<br>yes";
				$data[$p]['id']=$id; 
				$data[$p]['name']=$name;
				$data[$p]['logtime']=$logtime;
				// print_r($meals)."<br>";
				$p++;
			}
			
			
		}
		if(count($data)>0)
			{
				return $data;
			}else
			{
				return "";
			}
		//print_r($data);
	}
	
	function get_address_admin($admin_id)
	{
			$this->db->select('*');
			$this->db->from('ci_admin');
			$this->db->where('id',$admin_id);
			$query=$this->db->get();
			$output=$query->result_array();
			return $output[0]['address'];
	}

	function clear_glance_meal_admin($monthyear,$admin_id)
	{
				$where=array(
						'monthyear'=>$monthyear,
						'admin_id'=>$admin_id
					);
					$this->db->where($where);
					if($this->db->delete('storage_mealglance'))
					{
							$where2=array(
							'monthyear'=>$monthyear,
							'admin_id'=>$admin_id
						);
						$this->db->where($where2);
						$this->db->delete('storage_mealglance_subtitles');
						return true;
					}
					else
					{
						return false;
					}
	}
	function store_glance_meal_subtitles($monthyear,$admin_id,$subtitle1,$subtitle2,$footer)
	{

				$array2 = array(
				        'admin_id' =>$admin_id,
				        'subtitle1' =>$subtitle1,
				        'subtitle2'=>$subtitle2,
				        'footer'=>$footer,
				        'monthyear' =>$monthyear
					);
					$this->db->set($array2);
					$this->db->insert('storage_mealglance_subtitles');
	}
	function save_glance_meal($weekday,$position,$data,$admin_id,$monthyear)
	{
				$array = array(
				        'admin_id' =>$admin_id,
				        'weekday' =>$weekday,
				        'position'=>$position,
				        'monthyear' =>$monthyear,
				        'data' =>$data
					);
					$this->db->set($array);
					if($this->db->insert('storage_mealglance'))
					{
						return "true";
					}
					else
					{
						return "";	
					}
	}

	function get_glance_meal($admin_id,$monthyear)
	{
			$this->db->select('*');
			$this->db->from('storage_mealglance');
			$this->db->where('admin_id',$admin_id);
			$this->db->where('monthyear',$monthyear);
			$query=$this->db->get();
			if($query->num_rows()>0)
			{
				return $query->result_array();
			}
			else
			{
				return "";
			}
	}

	function get_glance_meal_subtitles($admin_id,$monthyear)
	{
			$this->db->select('*');
			$this->db->from('storage_mealglance_subtitles');
			$this->db->where('admin_id',$admin_id);
			$this->db->where('monthyear',$monthyear);
			$query=$this->db->get();
			if($query->num_rows()==1)
			{
				$res=$query->result_array();
				return $res[0];
			}
			else
			{
				return "";
			}
	}

	function get_glance_meal_week($admin_id,$weekdays,$monthyears)
	{
			$this->db->select('*');
			$this->db->from('storage_mealglance');
			$this->db->where('admin_id',$admin_id);
			$this->db->where_in('monthyear', $monthyears);
			$this->db->where_in('weekday', $weekdays);	
			$query=$this->db->get();
			if($query->num_rows()>0)
			{
				return $query->result_array();
			}
			else
			{
				return "";
			}
	}

	function update_glance_meal_id($default_data,$admin_id,$mealid)
	{
				
				//echo "<pre>";
			//print_r($default_data);

					$this->db->where('id', $mealid);
					$this->db->where('admin_id', $admin_id);
					if($this->db->update('ci_plan_meal', $default_data))
					{
						echo "true";
					}
					else
					{
						echo "false";	
					}
	}
}

?>