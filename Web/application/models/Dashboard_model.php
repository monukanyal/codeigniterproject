<?php

class Dashboard_model extends CI_Model {
	
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
		$sql="SELECT attend_users from ci_plan_event WHERE meetup_date >= ( CURDATE() - INTERVAL 240 DAY ) and meetup_date <= CURDATE() and admin_id = $admin_id and is_active = 1 order by meetup_date ASC"; 	
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
		$sql="SELECT c_e.name, count(p_e.id) as sum_rec from ci_plan_event as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.meetup_date >= ( CURDATE() - INTERVAL 30 DAY ) and p_e.meetup_date <= CURDATE() and p_e.admin_id = $admin_id and p_e.is_active = 1 group by p_e.event_id order by p_e.meetup_date ASC"; 	
		$query=$this->db->query($sql)->result_array();

		return $query;
	}
	//13 april
	function get_dayplanned_activity($data,$day)
	{
		$admin_id = $data['admin_id'];
		$sql="SELECT c_e.name, count(p_e.id) as sum_rec from ci_plan_event as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.meetup_date >= ( CURDATE() - INTERVAL $day DAY ) and p_e.meetup_date <= CURDATE() and p_e.admin_id = $admin_id and p_e.is_active = 1 group by p_e.event_id order by p_e.meetup_date ASC"; 	
		$query2=$this->db->query($sql)->result_array();

		return $query2;
	}

	function todayplanned_activity($send_data)
	{
		$admin_id = $send_data['admin_id'];
		$sql1="SELECT c_e.name, count(p_e.id) as sum_rec from ci_plan_event as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.meetup_date = CURDATE() and p_e.admin_id = $admin_id and p_e.is_active = 1 group by p_e.event_id order by p_e.meetup_date ASC"; 	
		//$sql1="SELECT c_e.name, count(p_e.id) as sum_rec from ci_plan_event as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.meetup_date ='2017-04-14' and p_e.admin_id = $admin_id and p_e.is_active = 1 group by p_e.event_id order by p_e.meetup_date ASC"; 	
		$query1=$this->db->query($sql1)->result_array();

		return $query1;
	}
	//28 march
	function get_events_acctomonth($admin_id,$day)
	{
		$data=array();
	$query = $this->db->query("SELECT * FROM `ci_plan_event` WHERE `admin_id`='$admin_id' and list_users!='' and `meetup_date` BETWEEN DATE_SUB(NOW(), INTERVAL $day DAY) AND NOW()");
		$num=$query->num_rows();
		//echo "<br>numrows: ".$num;
		if($num>0)
		{
			$result=$query->result_array();
			for($k=0;$k<count($result);$k++)
			{
				$event_id=$result[$k]['event_id'];
				$this->db->select('*');
				$this->db->from('ci_event');
				$this->db->where('id',$event_id);
				$query1=$this->db->get();
				$output=$query1->result_array();
				$name['event_name']=$output[0]['name'];
				$data[]=array_merge($result[$k],$name);
			}
			return $data;
		}
		else
		{
			return "";
		}

	}

	//13 april
	function get_avg_timeslotbyday($admin_id,$day)
	{

		$a=array();
		$arr=array();
	$query = $this->db->query("SELECT * FROM `ci_plan_event` WHERE admin_id='$admin_id' and list_users!='' and `meetup_date` and `end_date` BETWEEN DATE_SUB(NOW(), INTERVAL $day DAY) AND NOW()");
		$num=$query->num_rows();
		if($num>0)
		{
			$result=$query->result_array();
			for($k=0;$k<count($result);$k++)
			{	
				$meetup_time=$result[$k]['meetup_time'];
				$end_time=$result[$k]['end_time'];
				 $str=$result[$k]['list_users'];
				 $arr[]=$meetup_time.'-'.$end_time; //for counting 

				 if (array_key_exists($meetup_time.'-'.$end_time,$a))
				 {

				 		$c=explode(",",$str);
             	 		$value2=count($c);
				 		$value1=$a[$meetup_time.'-'.$end_time];
				 		$a[$meetup_time.'-'.$end_time]=$value1+$value2; 

				 }
				 else
				 {
				  	$b=explode(",",$str);
             	 	$attendies=count($b);
					$a[$meetup_time.'-'.$end_time]=$attendies;
				}
			}
			$vals = array_count_values($arr);
			 foreach($vals as $timeslot =>$x_value) 
			 {
				$x1=$a[$timeslot];
				$a[$timeslot]=$x1/$x_value;	    
			 }
			return $a;
			
		}
		else
		{
			return "";
		}

	}
	//13 april
	function get_avg_busytimebyday($admin_id,$day)
	{

		$a=array();
		$arr=array();
$query = $this->db->query("SELECT * FROM `ci_plan_event` WHERE admin_id='$admin_id' and list_users!='' and `meetup_date` and `end_date` BETWEEN DATE_SUB(NOW(), INTERVAL $day DAY) AND NOW()");
		$num=$query->num_rows();
		if($num>0)
		{
			$result=$query->result_array();
			for($k=0;$k<count($result);$k++)
			{	
				$meetup_time=$result[$k]['meetup_time'];
				$end_time=$result[$k]['end_time'];
				 $str=$result[$k]['list_users'];
				 $arr[]=$meetup_time; //for counting 

				 if (array_key_exists($meetup_time,$a))
				 {

				 		$c=explode(",",$str);
             	 		$value2=count($c);
				 		$value1=$a[$meetup_time];
				 		$a[$meetup_time]=$value1+$value2; 

				 }
				 else
				 {
				  	$b=explode(",",$str);
             	 	$attendies=count($b);
					$a[$meetup_time]=$attendies;
				}
			}
			$vals = array_count_values($arr);
			 foreach($vals as $timeslot =>$x_value) 
			 {
				$x1=$a[$timeslot];
				$a[$timeslot]=$x1/$x_value;	    
			 }
			 return $a;
			//return $a;
			
		}
		else
		{
			return "";
		}

	}

		//9 may @mkcode
		function get_no_of_msg_care_resident($admin_id)
		{
				$this->db->select('*');
				$this->db->from('ci_admin');
				$this->db->where('id',$admin_id);
				$query1=$this->db->get();
				$output=$query1->result_array();
				return $output[0];
				
		}

		function get_billing_info($admin_id)
		{
				$this->db->select('*');
				$this->db->from('admin_billing_pay_tbl');
				$this->db->where('admin_id',$admin_id);
				$query1=$this->db->get();
				$output=$query1->result_array();
				return $output[0];
		}

		function calculate_bill($admin_id,$expire,$start_date)
		{
				$this->db->select('*');
				$this->db->from('ci_admin');
				$this->db->where('id',$admin_id);
				$query1=$this->db->get();
				$output=$query1->result_array();
				$joined_date=$output[0]['logtime'];
				$nom=$output[0]['no_of_msg'];
				$joined_date=strtotime($joined_date);
				$jd=date('Y-m-d', $joined_date);   
				
				$date1=date('Y-m-d');
				$d1 = strtotime("$jd");
				$d2 = strtotime("$date1");
				$min_date = min($d1, $d2);
				$max_date = max($d1, $d2);
				$i = 0;

				while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
				    $i++;
				}
				//echo $i;  //number of month from joining date

				//if($i<=3)
				if($i>0)
				{
					//trial
					$this->db->select('*');
					$this->db->from('admin_billing_pay_tbl');
					$this->db->where('admin_id',$admin_id);
					$query_3=$this->db->get();
					$monthdata=$query_3->result_array();
					$stdate=$monthdata[0]['startdate'];
					$paydate=$monthdata[0]['paydate'];
					//$range=$stdate.' to '.$paydate;
					$fromrange=$stdate;
					$torange=$paydate;

					$this->db->select('*');
					$this->db->from('main_charge_tbl');
					$this->db->where('admin_id',$admin_id);
					$this->db->where('active',1);   //super admin will set
					//$this->db->where('type','trial');
					$query2=$this->db->get();
					$res=$query2->result_array();
					$facility_fee=$res[0]['facility_fee'];
					$resident_fee=$res[0]['resident_fee'];
					$care_account_fee=$res[0]['care_account_fee'];
					$msg_fee=$res[0]['msg_fee'];

					$feedata=$this->get_no_of_msg_care_resident($admin_id);
					$nor=$feedata['no_of_resident'];
					$noc=$feedata['no_of_care'];
					$nom=$feedata['no_of_msg'];
					$t1=$nor*$resident_fee;
					$t2=$noc*$care_account_fee;
					$t3=$nom*$msg_fee;
					$total=$facility_fee+$t1+$t2+$t3;
						if($total>0)
						{
								$billrec="$facility_fee,$resident_fee,$nor,$care_account_fee,$noc,$msg_fee,$nom";
								$newdata=array(
									"admin_id"=>$admin_id,
									"from_range"=>"$fromrange",
									"to_range"=>"$torange",
									"complete_bill_info"=>$billrec,
									"total_charge"=>$total
									);

								$this->db->select('*');
								$this->db->from('site_billing_record_tbl');
								$this->db->where('paid_on','0000-00-00');
								$query_chk=$this->db->get();
								//$chkres=$query_chk->result_array();
								if($query_chk->num_rows()==0)
								{
									$this->db->insert('site_billing_record_tbl',$newdata);
									$bill_id = $this->db->insert_id();
									if($total==0)
									{
										$tr_num='Trial Account';
										$this->update_bill_info($bill_id,$tr_num,$admin_id);
									}
								}

								$this->db->set('amount',$total);
								$this->db->where('admin_id',$admin_id);
								if($this->db->update('admin_billing_pay_tbl'))
								{
									

									return "calculated";
									// no refresh
									// $this->db->set('no_of_msg','0');
									// $this->db->set('no_of_care','0');
									// $this->db->set('no_of_resident','0');
									// $this->db->where('id',$admin_id);
									// $this->db->update('ci_admin');
								}
						}
						else
						{
							return "calculated";  //no bill record for trial
						}
				}
				// else
				// {
				// 	//prod
				// 	$this->db->select('*');
				// 	$this->db->from('admin_billing_pay_tbl');
				// 	$this->db->where('admin_id',$admin_id);
				// 	$query_3=$this->db->get();
				// 	$monthdata=$query_3->result_array();
				// 	$stdate=$monthdata[0]['startdate'];
				// 	$paydate=$monthdata[0]['paydate'];
				// 	//$range=$stdate.' to '.$paydate;

				// 	$fromrange=$stdate;
				// 	$torange=$paydate;

				// 	$this->db->select('*');
				// 	$this->db->from('main_charge_tbl');
				// 	$this->db->where('admin_id',$admin_id);
				// 	$this->db->where('type','prod');
				// 	$query2=$this->db->get();
				// 	$res=$query2->result_array();
				// 	$facility_fee=$res[0]['facility_fee'];
				// 	$resident_fee=$res[0]['resident_fee'];
				// 	$care_account_fee=$res[0]['care_account_fee'];
				// 	$msg_fee=$res[0]['msg_fee'];
				// 	$feedata=$this->get_no_of_msg_care_resident($admin_id);
				// 	$nor=$feedata['no_of_resident'];
				// 	$noc=$feedata['no_of_care'];
				// 	$nom=$feedata['no_of_msg'];
				// 	$t1=$nor*$resident_fee;
				// 	$t2=$noc*$care_account_fee;
				// 	$t3=$nom*$msg_fee;
				// 	$total=$facility_fee+$t1+$t2+$t3;
				// 	$billrec="$facility_fee,$resident_fee,$nor,$care_account_fee,$noc,$msg_fee,$nom";
				// 	$newdata=array(
				// 		"admin_id"=>$admin_id,
				// 		"from_range"=>"$fromrange",
				// 		"to_range"=>"$torange",
				// 		"complete_bill_info"=>$billrec,
				// 		"total_charge"=>$total
				// 		);
				// 	$this->db->insert('site_billing_record_tbl',$newdata);
				// 	$this->db->set('amount',$total);
				// 	$this->db->where('admin_id',$admin_id);
				// 	if($this->db->update('admin_billing_pay_tbl'))
				// 	{
				// 		return "calculated";
					
				// 	}
				// }

		}
		function check_bill_paid($admin_id)
		{
					$this->db->select('*');
					$this->db->from('site_billing_record_tbl');
					$this->db->where('paid_on','0000-00-00');
					$this->db->where('admin_id',$admin_id);
					$query2=$this->db->get();
					$res=$query2->result_array();
					if($query2->num_rows()>0)
					{
						return $res[0];	
					}
					else
					{
						return "";
					}
		}
		function update_bill_info($bill_id,$tr_num,$admin_id)
		{
			$cur_date=date('Y-m-d');
			$paydate=date('Y-m-d',strtotime('+30 days',strtotime("$cur_date")));
			$this->db->set('paid_on',$cur_date);
			$this->db->set('transaction_id',"$tr_num");
			$this->db->where('id',$bill_id);
			if($this->db->update('site_billing_record_tbl'))
			{
				$this->db->set('startdate',$cur_date);
				$this->db->set('paydate',$paydate);
				$this->db->set('amount','');
				$this->db->where('admin_id',$admin_id);
				$this->db->update('admin_billing_pay_tbl'); 
				
			}
		}
		
		//@mkcode end
}
?>