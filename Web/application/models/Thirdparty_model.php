<?php

class Thirdparty_model extends CI_Model {
	
	public function __construct() 
	{           
	}	
        
	
	function insert($data,$tablename)
	{
		$insert = $this->db->insert($tablename,$data);
		$quer=$this->db->insert_id();		
		return $quer;
	}	
	function get_via_phone($data,$tablename)
	{
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where($data);
		$query=$this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}else
		{
			return "";
		}
	}
	
	function key_varification($api_key,$tablename)
	{
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where('token',$api_key);
		$query=$this->db->get();
		if($query->num_rows()>0)
		{
			return true;
		}else
		{
			return "";
		}
	}

	function update($where,$def_data,$tablename)
	{
		// $where=array(
		// 	'id'=>$data['id'],
		// 	'admin_id'=>$data['admin_id']
		// );
		$this->db->where($where);
		$this->db->update($tablename,$def_data);	
		
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