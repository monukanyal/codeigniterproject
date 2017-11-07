<?php
class Password_change_model extends CI_Model {

	function Change_password($req_data){
		$data = array(	
		'password' => $req_data['password'],
		);
		$where = array('email' => $req_data['email']);
	    $this->db->where($where );
 		
        $result = $this->db->update('ci_admin', $data);
     
    } 
	function get_user_byemail($data)
	{
		$where=array(
			'email'=> $data['email']
		);
		$this->db->select()->from('ci_admin')->where($where);
		$query=$this->db->get();
		return $query->first_row('array');

	}
}
?>