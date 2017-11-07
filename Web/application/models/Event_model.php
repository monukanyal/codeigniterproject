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
			'is_active'=>1,
			'admin_id'=>$data['admin_id'],

		);
		$this->db->select()->from('ci_plan_event')->where($where);
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
	

	//@mkcode start modified
	function get_calender_events($where,$tablename)
	{
		$admin_id = $where['admin_id'];
		$sql="SELECT c_e.name, p_e.* from $tablename as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.admin_id = $admin_id  order by p_e.meetup_date DESC"; 	
		$res=$this->db->query($sql)->result_array();
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

	
	// 27 march
	function get_event_id($userid,$admin_id)
	{
		$e=array();
		$this->db->select('*');
		$this->db->from('ci_plan_event');
		$this->db->like('list_users',$userid);
		$this->db->where('admin_id',$admin_id);
		$this->db->order_by("id", "desc");
		$query=$this->db->get();
		foreach ($query->result_array() as $row)
		{	$a=array();
			$str=$row['list_users'];
			$event_id=$row['event_id'];
			$id=$row['id'];
       		$a=explode(",",$str);
       		//print_r($a);
       		// true means found
			if(in_array($userid, $a)==true)
			{

				//--no same event id again
				if(in_array($event_id, $events)==false)
				{
					$events[$event_id]=$id;
				}
			}
			
		}
		if(count($events)>0)
			{
				return $events;
			}else
			{
				return "";
			}
		//print_r($events);
	}

	function get_events_old($assoc_arr,$admin_id)
	{	
		$data=array();
		//2016-01-20 12:13:18
		//$d=date('Y-m-d H:i:s');
		$d=date('Y-m-d');
		if(count($assoc_arr)>0)
		{
			$j=0;
			foreach ($assoc_arr as $key => $value) 
			{
				$eid=$key;  //event id
				//echo $eid."<br>";
				$id=$value;
				$this->db->select('*');
				$this->db->from('ci_event');
				$this->db->where('id',$eid);
				$this->db->where('logtime <',$d);  // data below current date
				$this->db->where('admin_id',$admin_id);
				$query1=$this->db->get();
				$num = $query1->num_rows();
				//echo "nor".$num;
				if($num==1)
				{
					$result=$query1->result_array();
					
					$name=$result[0]['name'];
					$logtime=$result[0]['logtime'];
					$data[$j]['linkid']=$id; 
					$data[$j]['name']=$name;
					$data[$j]['logtime']=$logtime;
				}
				$j++;
			}
			//print_r($data);
			if(count($data)>0)
			{
				return $data;
			}else
			{
				return "";
			}
		}
		else
		{
			return "";
		}
	}
	function get_events_up($assoc_arr,$admin_id)
	{	
		$data=array();
		//2016-01-20 12:13:18
		//$d=date('Y-m-d H:i:s');
		$d=date('Y-m-d');
		if(count($assoc_arr)>0)
		{	$j=0;
			foreach ($assoc_arr as $key => $value) 
			{
				$eid=$key;  //event id
				//echo $eid."<br>";
				$id=$value;
				$this->db->select('*');
				$this->db->from('ci_event');
				$this->db->where('id',$eid);
				$this->db->where('logtime >=',$d);  // data above current date
				$this->db->where('admin_id',$admin_id);
				$query1=$this->db->get();
				$num = $query1->num_rows();
				//echo "nor".$num;
				if($num==1)
				{
					$result=$query1->result_array();
					$name=$result[0]['name'];
					$logtime=$result[0]['logtime'];
					$data[$j]['linkid']=$id;
					$data[$j]['name']=$name;
					$data[$j]['logtime']=$logtime;
				}
				$j++;

			}
			//print_r($data);
			if(count($data)>0)
			{
				return $data;
			}else
			{
				return "";
			}

		}
		else
		{
			return "";
		}
	}

	//@mk code start
	function get_event_datewise_data($eid,$day,$admin_id)
	{
		$data=array();
	$query = $this->db->query("SELECT * FROM `ci_plan_event` WHERE `admin_id`='$admin_id' and list_users!='' and event_id='$eid' and `meetup_date` BETWEEN DATE_SUB(NOW(), INTERVAL $day DAY) AND NOW()");
		$num=$query->num_rows();
		//echo "<br>numrows: ".$num;
		if($num>0)
		{
			$result=$query->result_array();
			for($k=0;$k<count($result);$k++)
			{
				
				$this->db->select('*');
				$this->db->from('ci_event');
				$this->db->where('id',$eid);
				$query1=$this->db->get();
				$output=$query1->result_array();
				$name['event_name']=$output[0]['name'];
				$data[]=array_merge($result[$k],$name);
			}
			//print_r($data);
			return $data;
		}
		else
		{
			return "";
		}
	}

	function get_event_datewise_ajax($eid,$day,$admin_id)
	{
		$data=array();
	$query = $this->db->query("SELECT * FROM `ci_plan_event` WHERE `admin_id`='$admin_id' and list_users!='' and event_id='$eid' and `meetup_date` BETWEEN DATE_SUB(NOW(), INTERVAL $day DAY) AND NOW()");
		$num=$query->num_rows();
		//echo "<br>numrows: ".$num;
		if($num>0)
		{
			$result=$query->result_array();
			for($k=0;$k<count($result);$k++)
			{
				
				$this->db->select('*');
				$this->db->from('ci_event');
				$this->db->where('id',$eid);
				$query1=$this->db->get();
				$output=$query1->result_array();
				$name['event_name']=$output[0]['name'];
				$data[]=array_merge($result[$k],$name);
			}
			//print_r($data);
			$res=array();
		   for($m=0;$m<count($data);$m++)
		   {
		        $a=array();
		        $str=$data[$m]['list_users'];
		        $aid=$data[$m]['event_id'];
		        $e=str_replace(' ', '', $data[$m]['event_name']);
		        $meetup_date=$data[$m]['meetup_date'];
		           
		            $a=explode(",",$str);
		              $attendies=count($a);
		             if(count($a)>0)
		             {
		                $res[]="{ y: '$meetup_date',a: $attendies,c:'$e (max. attendies: $attendies)' }";
		              
		             }

		   }

     	$graph_bar_data=implode(", ",$res);
  	 	$complete_graph_bar="[ $graph_bar_data ]";  
  	 	print_r($complete_graph_bar);
		}
		else
		{
			echo "";
		}
	}
	function check_status_onlycarepay($admin_id)
	{
		$this->db->select('*');
		$this->db->from('ci_admin');
		$this->db->where('id',$admin_id);
		$this->db->where('only_care_pay',1);
		$query1=$this->db->get();
		if($query1->num_rows()==1)
		{
			return "enable";  // care will pay only
		}
		else
		{
			return "disable";  
		}
	}
	function check_care_subscription($id)
	{
		$this->db->select('*');
		$this->db->from('ci_care_subscription');
		$this->db->where('care_id',$id);
		$query1=$this->db->get();
		if($query1->num_rows()==1)
		{
			$output=$query1->result_array();
			//return $output;
			if(!empty($output[0]['subscription_id']))
			{
					return $output[0];
			}
			else
			{
				return "unpaid";
			}
		}
		else
		{
			return "unpaid";
		}
	}
	//@mkcode end
}
?>