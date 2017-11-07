<?php

class User_model extends CI_Model {
	
	public function __construct() 
	{           
	}
	//-----------------------@mkcode----
	function update_myinfo($fn,$uuid)
	{
			$this->db->set('msg_recieved', $uuid);
			$this->db->where('mobile', $fn);
			if($this->db->update('ci_user'))
			{
				$this->db->select()->from('ci_user')->where('mobile',$fn);
				$query=$this->db->get();
				$res=$query->result_array();
				$admin_id=$res[0]['admin_id'];
				$this->db->select('*')->from('ci_admin')->where('id',$admin_id);
				$query_msg = $this->db->get();
				$res=$query_msg->result_array();
				$nom=$res[0]['no_of_msg'];
				$new_nom=$nom+1;
				$this->db->set('no_of_msg',$new_nom);
				$this->db->where('id',$admin_id);
				if($this->db->update('ci_admin'))
				{
					return true;
				}
				else
				{
					return false;
				}
				
			}
			else
			{
				return false;
			} 
	}

	//---------------------------------
	function get_alluser($data)
	{
		$where=array(
			'user_type'=> 'resident',
			'admin_id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_user')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}

	//@mkcode
	function childuser($data)
	{
		
		$resident_id=$data['parrent'];
		$query1 = $this->db->query("SELECT * FROM ci_user WHERE ((belongs_to='$resident_id' and user_type='child') or (belongs_another='$resident_id' and user_type='child'))");
		return $query1->result_array();
	}

	//@mkcode start
	function allchilduser($admin_id)
	{
		$where=array(
			'admin_id'=>$admin_id,
			'user_type'=>'child'
		);
		$this->db->select('*')->from('ci_user')->where($where);
		$query=$this->db->get();
		 $res=$query->result_array();
			for($i=0;$i<count($res);$i++)
			{
				$child_id=$res[$i]['id'];
				$this->db->select('*')->from('ci_care_subscription')->where('care_id',$child_id);
				$query_new=$this->db->get();
				if($query_new->num_rows()==1)
				{
					$res[$i]['subscription_started']='yes';
				}
				else
				{
					$res[$i]['subscription_started']='no';
				}
			}
			
			return $res;
		//return $query->result_array();
	}
	//@mkcode end
	function getparentuser($parentid)
	{

		$where=array(
			'user_type'=>'resident',
			'id'=>$parentid
		);
		$this->db->select()->from('ci_user')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
	function getparentuserfrmpage($data)
	{
		
		$where=array(
			'user_type'=>'resident',
			'id'=>$data
		);
		$this->db->select()->from('ci_user')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function get_admindata($data)
	{
		$where=array(
			'id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function get_super_admindata($data)
	{
		$where=array(
			'id'=>$data['super_admin_id']
		);
		$this->db->select()->from('ci_super_admin')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function get_user($data)
	{
		$where=array(
			'id'=>$data['id'],
			'admin_id'=>$data['admin_id']
		);
		$this->db->select()->from('ci_user')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	
	function get_user_byemail($data)
	{
		$where=array(
			'email'=> $data['admin_email']
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		$qry =  $query->first_row('array');
		return $qry;
	}
	
	function get_user_byaddress($data)
	{
		$where=array(
			'address'=> $data['address']
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		$qry =  $query->first_row('array');
		return $qry;
	}
	
	function get_userinfo($data)
	{
		$where=array(
			'id'=>$data['admin_id'],
			'email'=>$data['admin_email']
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	
	function getUsers($conditions=array(),$fields='')
	{
		if(count($conditions)>0)		
	 		$this->db->where($conditions);
			
		$this->db->from('ci_users');

		$this->db->order_by("ci_users.id", "asc");

		if($fields!='')
				$this->db->select($fields);
		else 		
	 		$this->db->select('ci_users.id,ci_users.name,ci_users.email,ci_users.online');
		
		$result = $this->db->get()->result_array();
		
		return $result;
	}
	
	function insert_user($data,$tablename)
	{
		$insert = $this->db->insert($tablename,$data);
		$quer=$this->db->insert_id();		
		return $quer;
	}	
	
	//@mkcode-modify
	function insert($data,$tablename)
	{
		if(isset($data['user_type']))
		{
			$insert = $this->db->insert($tablename,$data);
			$quer=$this->db->insert_id();	
			$this->db->select()->from($tablename)->where('id',$quer);
			$myquery=$this->db->get();
			$res=$myquery->result_array();
			$admin_id=$res[0]['admin_id'];
			$status=$this->care_counter_inc($admin_id);
			return $quer;
		}
		else
		{
		$insert = $this->db->insert($tablename,$data);
		$quer=$this->db->insert_id();	
		$this->db->select()->from($tablename)->where('id',$quer);
		$myquery=$this->db->get();
		$res=$myquery->result_array();
		$admin_id=$res[0]['admin_id'];
		$status=$this->resident_counter_inc($admin_id);
		return $quer;
		}
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
	

	//@mkcode modification start
	function delete($data,$tablename)
	{
		if(isset($data['user_type']))
		{
			$admin_id=$data['admin_id'];
			$where=array(
				'id'=>$data['id'],
				'admin_id'=>$data['admin_id']
			);
			$this->db->where($where);
			$this->db->delete($tablename);
			
				//$status=$this->care_counter_dec($admin_id);  // not decrease noc counter acc. to client
			
		}
		else
		{
			$admin_id=$data['admin_id'];
			$where=array(
				'id'=>$data['id'],
				'admin_id'=>$data['admin_id']
			);
			$this->db->where($where);
			if($this->db->delete($tablename))
			{
				$status=$this->resident_counter_dec($admin_id);   // decrease nor counter acc. to client
			}
		}
	}
	//--------@mkcode modification end

	function get_userById($data)
	{
		$where=array(
			'id'=>$data['id']
		);
		$this->db->select()->from('ci_user')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}
	
	function get_alluserinfo($data)
	{
		
		$this->db->select()->from('ci_admin');
		$query=$this->db->get();
		return $query->first_row('array');
	}
	
	function update_userByNo($data)
	{
		$where=array(
			'mobile'=>$data['phoneNo']
		);
		$user_data = array(
			'UUID'=>$data['UUID'],
			'appactive' => 1
			);

		$this->db->where($where);
		$this->db->update('ci_user',$user_data);
	}

	function get_mobileinfo($data,$tablename)
	{
		$where=array(
			'mobile'=>$data['phoneno']
		);
		 $this->db->select()->from($tablename)->where($where);
		$query=$this->db->get();
		return $query->first_row('array');
	}

	function update_sitecode($id, $sitecode){
		$where=array(
			'id'=>$id
		);
		$this->db->select('sitecode')->from('ci_admin')->where($where);
		$query=$this->db->get();

		if($query->result_array()[0]['sitecode'] == ''){
			 $value=array('sitecode'=>$sitecode);
			 $this->db->where('id',$id);
			 if( $this->db->update('ci_admin',$value))
		      {
		        $data['new_sitecode_add']="true";
		        $data['sitecode']=$sitecode;
		        return $data;
		      }
		      else
		      {
		        return $data['result']="false";
		      }
	  	}else{
	  		$data['sitecode']=$query->result_array()[0]['sitecode'];
	  		$data['already_exist']="true";
	  		return $data;
	  	}
	}

	function get_sitecode($id){
		$where=array(
			'id'=>$id
		);
		$this->db->select('sitecode')->from('ci_admin')->where($where);
		$query=$this->db->get();

		if($query->result_array()[0]['sitecode'] == ''){
			$data['sitecode_exist'] = "false";
			return $data;
		}else{
			$data['sitecode_exist'] = "true";
			$data['sitecode'] = $query->result_array()[0]['sitecode'];
			return $data;
		}
	}

	function get_admin_bysitecode($sitecode){
		$query = $this->db->get_where('ci_admin', array("sitecode"=>$sitecode));

		if(!empty($query->row_array()['id'])){
			$data['sitecode_exist'] = "true";
			$data['admin_id'] = $query->row_array()['id'];
			return $data;
		}else{
			$data['sitecode_exist'] = "false";
			return $data;
		}
	}
	//code for generating sitecode automatically.
	function get_all_admindata(){
		$this->db->select('id, address, sitecode');
		$query = $this->db->get('ci_admin');
		//echo "<pre>";print_r($query->result_array());
		$all_admin = $query->result_array();
		foreach($all_admin AS $admin){
			//echo "<pre>".$admin['address'];print_r($admin);die();
			if(!isset($admin['sitecode'])){
			//if(1){
				$sitecode = strtoupper(substr($admin['address'], 0, 2)).mt_rand(1000, 9999);
				//echo $sitecode;die();
				$data = array('sitecode' => $sitecode);
				$this->db->where('id',$admin['id']);
				$this->db->update('ci_admin', $data);
			}else{
				echo "site code already exists.";
			}
		}
		die();
	}
	//@mkcode
	function get_admin_info($admin_id)
	{
		$where=array(
			'id'=>$admin_id
		);
		$this->db->select('*')->from('ci_admin')->where($where);
		$query = $this->db->get();
		$data = $query->result_array();
		return $data[0];
	}
	//@mkcode
	function check_care_account_limit($resident_id)
	{
		$query1 = $this->db->query("SELECT * FROM ci_user WHERE ((belongs_to='$resident_id' and user_type='child') or (belongs_another='$resident_id' and user_type='child'))");
		$num = $query1->num_rows();
		return $num;

	}

	//@mkcode
	function all_care_list($residentid)
	{

		$where=array(
			'user_type'=>'child',
			'belongs_another'=>''
			);
		$this->db->select('*')->from('ci_user')->where($where)->where('belongs_to!=',$residentid);
		$query = $this->db->get();
		 return $query->result_array();
	}
	//@mkcode
	function update_belongs_ofcare($careid,$residentid)
	{
		 $query1 = $this->db->query("SELECT * FROM ci_user WHERE ((belongs_to='$residentid' and user_type='child') or (belongs_another='$residentid' and user_type='child'))");
		 $num = $query1->num_rows();
		// echo $num."<br>";
		 if($num<=3)
		 {
		 	$user_data = array(
			'belongs_another'=>$residentid
			);
		 	$this->db->set('belongs_another',$residentid);
			$this->db->where('id=',$careid);
			if($this->db->update('ci_user'))
			{
				//$this->db->select('*')->from('ci_user')->where('id=',$careid)->where('belongs_another=',$residentid); //show only updated care
				$this->db->select('*')->from('ci_user')->where('belongs_another=',$residentid);
				$query2= $this->db->get();
		 		$res=$query2->result_array();	
		 		for($j=0;$j<count($res);$j++)
		 		{
		 		echo "<strong style='color:green'>".$res[$j]['first_name']." ".$res[$j]['last_name']." (".$res[$j]['mobile'].")<strong>,";
				}
			}
			else
			{
				echo "";
			}
		 }
		 else
		 {
		 	echo "<p style='color:red'>Care Account Exceeds 4<p>";
		 }
	}
	
	//9 may @mkcode start
	function care_counter_inc($admin_id)
	{
		$this->db->select('*')->from('ci_admin')->where('id',$admin_id);
		$query_msg = $this->db->get();
		$res=$query_msg->result_array();
		$noc=$res[0]['no_of_care'];
		$new_noc=$noc+1;
		$this->db->set('no_of_care',$new_noc);
		$this->db->where('id',$admin_id);
		if($this->db->update('ci_admin'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
//-----------------not use according to client----------
	// function care_counter_dec($admin_id)
	// {
	// 	$this->db->select('*')->from('ci_admin')->where('id',$admin_id);
	// 	$query_msg = $this->db->get();
	// 	$res=$query_msg->result_array();
	// 	$noc=$res[0]['no_of_care'];
		
	// 	if($noc!='0')
	// 	{
	// 		$new_noc=$noc-1;
	// 	}
	// 	$this->db->set('no_of_care',$new_nor);
	// 	$this->db->where('id',$admin_id);
	// 	if($this->db->update('ci_admin'))
	// 	{
	// 		return 1;
	// 	}
	// 	else
	// 	{
	// 		return 0;
	// 	}
	// }
//-------------------------------------------


	function resident_counter_inc($admin_id)
	{
		$this->db->select('*')->from('ci_admin')->where('id',$admin_id);
		$query_msg = $this->db->get();
		$res=$query_msg->result_array();
		$nor=$res[0]['no_of_resident'];
		$new_nor=$nor+1;
		$this->db->set('no_of_resident',$new_nor);
		$this->db->where('id',$admin_id);
		if($this->db->update('ci_admin'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	function resident_counter_dec($admin_id)
	{
		$this->db->select('*')->from('ci_admin')->where('id',$admin_id);
		$query_msg = $this->db->get();
		$res=$query_msg->result_array();
		$nor=$res[0]['no_of_resident'];
		if($nor!='0')
		{
			$new_nor=$nor-1;
		}
		$this->db->set('no_of_resident',$new_nor);
		$this->db->where('id',$admin_id);
		if($this->db->update('ci_admin'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	function msg_counter_inc($admin_id)
	{
		$this->db->select('*')->from('ci_admin')->where('id',$admin_id);
		$query_msg = $this->db->get();
		$res=$query_msg->result_array();
		$nom=$res[0]['no_of_msg'];
		$new_nom=$nom+1;
		$this->db->set('no_of_msg',$new_nom);
		$this->db->where('id',$admin_id);
		if($this->db->update('ci_admin'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	function msg_counter_inc_bulk($admin_id,$inc)
	{
		$this->db->select('*')->from('ci_admin')->where('id',$admin_id);
		$query_msg = $this->db->get();
		$res=$query_msg->result_array();
		$nom=$res[0]['no_of_msg'];
		$new_nom=$nom+$inc;
		$this->db->set('no_of_msg',$new_nom);
		$this->db->where('id',$admin_id);
		if($this->db->update('ci_admin'))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	
	function add_billing_entry($admin_id)
	{
		$startdate=date('Y-m-d');
		$paydate=date('Y-m-d',strtotime('+30 days',strtotime("$startdate")));
		$data=array(
			"admin_id"=>$admin_id,
			"startdate"=>$startdate,
			"paydate"=>$paydate
			);
		//$insert = $this->db->insert('admin_billing_pay_tbl',$data);  //trial and prod charges same for all
		if($this->db->insert('admin_billing_pay_tbl',$data))        //trial and prod charges different for each
		{
			$first=array(
				'admin_id'=>$admin_id,
				'type'=>'trial',
				'facility_fee'=>'0',
				'resident_fee'=>'0',
				'care_account_fee'=>'3',
				'msg_fee'=>'0',
				'active'=>1		
				);

			$second=array(
				'admin_id'=>$admin_id,
				'type'=>'prod',
				'facility_fee'=>'50',
				'resident_fee'=>'2',
				'care_account_fee'=>'3',
				'msg_fee'=>'0.01',
				'active'=>0	
				);

			if($this->db->insert('main_charge_tbl',$first))
			{
				$this->db->insert('main_charge_tbl',$second);
			}
		}
	}
	
	function get_billing_info($admin_id)
	{
		$this->db->select('*')->from('site_billing_record_tbl')->where('admin_id',$admin_id)->order_by('id','desc');
		$query_msg = $this->db->get();
		$res=$query_msg->result_array();
		return $res;
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
	function add_care_subscription_info($data)
	{
		$start_on=date('Y-m-d');
		$subscription_id=$data['subc_id'];
		$amount=$data['amount'];
		$care_id=$data['care_id'];
		$maindata=array(
			"care_id"=>$care_id,
			"subscription_id"=>$subscription_id,
			"amount"=>$amount,
			"start_on"=>$start_on
			);
		if($this->db->insert('ci_care_subscription',$maindata))
		{
			return "true";

		}
		else
		{
			return "";
		}
	}
	function del_subscription_info($care_id,$subscription_id)
	{
			$this->db->where('care_id',$care_id);
			if($this->db->delete('ci_care_subscription'))
			{
				return "true";
			}
			else
			{
				return "";
			}
	}

		function del_subscription_care($care_id)
		{
				$this->db->where('care_id',$care_id);
				$this->db->delete('ci_care_subscription');
		}
	function confirm_account($code)
	{
			$this->db->set('active','1');
			$this->db->set('confirmation_code','');
			$this->db->where('confirmation_code',"$code");
			if($this->db->update('ci_admin'))
			{
				return "true";
			}
			else
			{
				return "";
			}
	}
	//9may  end 
	//17 may superadmin start
	function update_admin_info($data,$admin_id)
	{
		$this->db->where('id', $admin_id);
		if($this->db->update('ci_admin', $data))
		{
			echo 200;
		}
		else
		{
			echo 400;
		}
	}
	function get_fee_details($admin_id)
	{
			$this->db->select()->from('main_charge_tbl')->where('admin_id',$admin_id);
			$myquery=$this->db->get();
			$result=$myquery->result_array();
			return $result;
	}
	function get_care_charge($care_id)
	{
		$this->db->select()->from('ci_user')->where('id',$care_id);
		$firstquery=$this->db->get();
		$response=$firstquery->result_array();
		$admin_id=$response[0]['admin_id'];
		if(!empty($admin_id))
		{
			$this->db->select()->from('main_charge_tbl')->where('admin_id',$admin_id)->where('type','trial');
			$myquery=$this->db->get();
			$result=$myquery->result_array();
			return $result[0]['care_account_fee'];
		}
		else
		{
			return "";
		}
	}
	//-------@mkcode 17 may start
	function update_new_fee($data,$type,$admin_id)
	{
		$this->db->where('type', "$type");
		$this->db->where('admin_id', "$admin_id");
		if($this->db->update('main_charge_tbl', $data))
		{
			return 200;
		}
		else
		{
			return 400;
		}
	}

	function check_bill_paid($admin_id,$bill_id)
		{
					$this->db->select('*');
					$this->db->from('site_billing_record_tbl');
					$this->db->where('id',$bill_id);
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
		function get_approval_care($admin_id)
		{
					$this->db->select('*');
					$this->db->from('ci_user');
					$this->db->where('user_type','child');
					$this->db->where('approved','0');
					$this->db->where('added_via','app');
					$this->db->where('admin_id',$admin_id);
					$query2=$this->db->get();
					if($query2->num_rows()>0)
					{
						return $query2->result_array();
					}
					else
					{
						return "";
					}
		}

		function approve_care_now($care_id)
		{		
				
					$this->db->set('approved','1');
					$this->db->where('id',$care_id);
					if($this->db->update('ci_user'))
					{
						echo "done";
					
					}
					else
					{
						echo "";
					}
		}
		function get_newcareadd_app($admin_id)
		{
					$this->db->select('*');
					$this->db->from('ci_user');
					$this->db->where('user_type','child');
					$this->db->where('approved','0');
					$this->db->where('added_via','app');
					$this->db->where('admin_id',$admin_id);
					$query2=$this->db->get();
					if($query2->num_rows()>0)
					{
						return $query2->num_rows();	
					}
					else
					{
						return "";
					}
		}

		function get_care_belongs_resident($userId,$admin_id)
		{

					$this->db->select('*');
					$this->db->from('ci_user');
					$this->db->where('user_type','child');
					$this->db->where('id',$userId);
					$this->db->where('admin_id',$admin_id);
					$query2=$this->db->get();
					if($query2->num_rows()==1)
					{
						$res=$query2->result_array();
						$belong1=$res[0]['belongs_to'];
						$belong2=$res[0]['belongs_another'];
						if(!empty($belong2))
						{
							$arrParent1 = $this->getparentuserfrmpage($belong1);
							$arrParent2 = $this->getparentuserfrmpage($belong2);
							$mainarr[]=array('parent1'=>$arrParent1[0]['first_name'].' '.$arrParent1[0]['last_name'],'parent1_id'=>$belong1);
							$mainarr[]=array('parent2'=>$arrParent2[0]['first_name'].' '.$arrParent2[0]['last_name'],'parent2_id'=>$belong2);

							//print_r($mainarr);
							return $mainarr;
						}
						else
						{
							$arrParent1 = $this->getparentuserfrmpage($belong1);
							$mainarr[]=array('parent1'=>$arrParent1[0]['first_name'].' '.$arrParent1[0]['last_name'],'parent1_id'=>$belong1);
							return $mainarr;
							//print_r($mainarr);
						}
					}
					else
					{
						return "";
					}
		}

		function is_caresubscription_started($care_id)
		{
					$this->db->select('*');
					$this->db->from('ci_care_subscription');
					$this->db->where('care_id',$care_id);
					$query2=$this->db->get();
					$res=$query2->result_array();
					if($query2->num_rows()>0)
					{
						return 1;	
					}
					else
					{
						return 0;
					}
		}

		function get_care_subscription_info($care_id)
	    {
	         $this->db->select()->from('ci_care_subscription')->where('care_id',$care_id);
	        $query=$this->db->get();
	        if($query->num_rows()==1)
	        {
	            $res=$query->result_array();
	            $subscription_id=$res[0]['subscription_id'];
	            if(!empty($subscription_id))
	            {
	            return $subscription_id;
	            } 
	        }
	        else
	        {
	            return "";
	        }
	    }

	    function get_care_reg_info($care_id)
	    {

	         $this->db->select()->from('ci_user')->where('id',$care_id);
	        $query=$this->db->get();
	        if($query->num_rows()==1)
	        {
	            $res=$query->result_array();
	            return $res[0]['reg_status'];
	            
	        }
	        else
	        {
	            return "";
	        }
	    }

	    function update_care_subscription_info($care_id,$current_status)
	    {
			$this->db->set('status',"$current_status");
			$this->db->where('care_id',$care_id);
			$this->db->update('ci_care_subscription');
	    }

	    function update_trial_prod_status($admin_id,$type,$active)
	    {
	    	if($type=='trial')
	    	{
	    		//---------trial---------------
		    		if($active==1)
		    		{
		    			//trial
			    		$this->db->set('active',1);
						$this->db->where('admin_id',$admin_id);
						$this->db->where('type','trial');
						if($this->db->update('main_charge_tbl'))
						{
							$this->db->set('active',0);
							$this->db->where('admin_id',$admin_id);
							$this->db->where('type','prod');
							if($this->db->update('main_charge_tbl'))
							{
								return "true";
							}
							else
							{
								return "false";
							}
						}
		    		}
		    		

		    		//---------trial-end---------------
	    	}
	    	else
	    	{
	    		if($active==1)
	    		{
	    			//prod
	    			$this->db->set('active',1);
					$this->db->where('admin_id',$admin_id);
					$this->db->where('type','prod');
					if($this->db->update('main_charge_tbl'))
					{
						$this->db->set('active',0);
						$this->db->where('admin_id',$admin_id);
						$this->db->where('type','trial');
						if($this->db->update('main_charge_tbl'))
						{
							return "true";
						}
						else
						{
							return "false";
						}
					}
	    		}
	    	}
	    }
	    function update_status_care_pay($admin_id,$onlycarepay,$prod_care,$trial_care)
	    {
	    			$this->db->set('only_care_pay',$onlycarepay);
					$this->db->where('id',$admin_id);
					if($this->db->update('ci_admin'))
					{
							$this->db->set('care_account_fee',$prod_care);
							$this->db->where('admin_id',$admin_id);
							$this->db->where('type','prod');
							if($this->db->update('main_charge_tbl'))
							{
								$this->db->set('care_account_fee',$trial_care);
								$this->db->where('admin_id',$admin_id);
								$this->db->where('type','trial');
								if($this->db->update('main_charge_tbl'))
								{
									return "true";
								}
								else
								{
									return "false";
								}
							}
							else
							{
								return "false";
							}
					}
					else
					{
						return "false";
					}
	    }

	//     function work_do_quick()
	//     {
	//     	$firstquery=$this->db->query('select distinct id from ci_admin');
	//     	$res=$firstquery->result_array();
	//     	$len=count($res);
	//     	$a=array();
	//     	for($i=0;$i<count($res);$i++)
	//     	{
	// 		    		$admin_id=$res[$i]['id'];
	// 			    	$startdate=date('Y-m-d');
	// 					$paydate=date('Y-m-d',strtotime('+30 days',strtotime("$startdate")));
	// 					$data=array(
	// 					"admin_id"=>$admin_id,
	// 					"startdate"=>$startdate,
	// 					"paydate"=>$paydate
	// 					);
	// 			//$insert = $this->db->insert('admin_billing_pay_tbl',$data);  //trial and prod charges same for all
	// 				if($this->db->insert('admin_billing_pay_tbl',$data))        //trial and prod charges different for each
	// 				{
	// 					$first=array(
	// 						'admin_id'=>$admin_id,
	// 						'type'=>'trial',
	// 						'facility_fee'=>'0',
	// 						'resident_fee'=>'0',
	// 						'care_account_fee'=>'3',
	// 						'msg_fee'=>'0',
	// 						'active'=>1		
	// 						);

	// 					$second=array(
	// 						'admin_id'=>$admin_id,
	// 						'type'=>'prod',
	// 						'facility_fee'=>'50',
	// 						'resident_fee'=>'2',
	// 						'care_account_fee'=>'3',
	// 						'msg_fee'=>'0.01',
	// 						'active'=>0	
	// 						);

	// 					if($this->db->insert('main_charge_tbl',$first))
	// 					{
	// 						$this->db->insert('main_charge_tbl',$second);
	// 						$a[]='add';
	// 					}
	// 				}
	//     }
	//     if($len==count($a))
	//     {
	//     	echo "done";
	//     }
	//     else
	//     {
	//     	echo "undone";
	//     }
	   
	// }
	//@mkcode end
}
?>
