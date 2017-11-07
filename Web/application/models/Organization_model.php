<?php

class Organization_model extends CI_Model {
	
	public function __construct() 
	{           
	}	
        
	function get_allorganization()
	{
		
		$this->db->select()->from('ci_admin');
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_organization($data){
		$where=array(
			'id'=>$data['id']
			);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_organization_data($data)
	{
		$where=array(
			'id'=>$data['id']
		);
		$this->db->select()->from('ci_admin')->where($where);
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
			'id'=>$data['id']
			
		);
		$this->db->where($where);
		$this->db->update($tablename,$def_data);	
		//$this->salary_account($userid,$data);
	}
	//---@mkcode start
	function delete($data,$tablename)
	{
		$where=array(
			'id'=>$data['id'],
			//'admin_id'=>$data['admin_id']
		);
		$this->db->where($where);
		if($this->db->delete($tablename))
		{
			$this->db->where('admin_id',$data['id']);
			if($this->db->delete('admin_billing_pay_tbl'))
			{
				$this->db->where('admin_id',$data['id']);
				$this->db->delete('main_charge_tbl');
			}
		}
	}
	//@mkcode end
	
	function getTotalusers($data)
	{
			$where=array(
			'admin_id'=>$data
		);

		$this->db->select()->from('ci_user')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}
		function getTotalstaff($data)
	{
			$where=array(
			'admin_id'=>$data
		);

		$this->db->select()->from('ci_staff')->where($where);
		$query=$this->db->get();
		return $query->result_array();
	}

	//@mkcode start
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
	//@mkcode end
}
?>