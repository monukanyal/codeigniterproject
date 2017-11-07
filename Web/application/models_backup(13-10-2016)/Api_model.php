<?php

class Api_model extends CI_Model {
    
    public function __construct() 
    {   
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Content-type: application/json');        
    }   
        
    function get_allevent($data)
    {
        $where=array(
            'admin_id'=>$data['admin_id'],
            'is_active' => 1
        );
        $this->db->select()->from('ci_plan_event')->where($where);
        $query=$this->db->get();
        return $query->result_array();
    }
function get_allmeal($data)
    {
        $where=array(
            'admin_id'=>$data['admin_id'],
            'is_active' => 1
        );
        $this->db->select()->from('ci_plan_meal')->where($where);
        $query=$this->db->get();
        return $query->result_array();
    }
    /** Fetches a record by its' passed id value*/
    function getByID($id='', $where='', $tablename) 
    {
        if (!empty($where)){ $this->db->where($where);}

        $member = $this->db->get_where($tablename, array('id' => $id))->first_row('array');
        if ($member) {
            return $member;
        }
        return false;
    }

    function getUserdata($userid) {
        $where=array(
            'id'=>$userid
        );
        $this->db->select()->from('ci_user')->where($where);
        $query=$this->db->get();
        return $query->result_array();
    }

     function getUserById($orgid) {
        $where=array(
            'admin_id'=>$orgid
        );
        $this->db->select()->from('ci_user')->where($where);
        $query=$this->db->get();
        return $query->result_array();
    }

    /** Fetches a record by its' passed id value*/
    function getEventByID($eventid,$evendate) 
    {
        $where=array(
            'plan_event_id'=>$eventid,
            'range_date' => $evendate
        );
        $this->db->select("p.user_id ");
        $this->db->where($where); 
        $this->db->group_by("p.user_id");
    
        
        $query = $this->db->get('ci_plan_eventmeta as p');
        return $query->result_array();
    }
    function getMealByID($mealid) 
    {
        $where=array(
            'plan_meal_id'=>$mealid
        );
        $this->db->select("p.user_id ");
        $this->db->where($where); 
        $this->db->group_by("p.user_id");
    
        
        $query = $this->db->get('ci_plan_mealmeta as p');
        return $query->result_array();
    }
     function getEventUsers($orgId,$eventid) 
    {              
        $where=array(
            'org_id'=>$orgId,
            'plan_event_id'=>$eventid
        );
        $this->db->select("p.user_id ");
        $this->db->where($where); 
        $this->db->group_by("p.user_id");
    
        
        $query = $this->db->get('ci_plan_eventmeta as p');
        return $query->result_array();
    }

    function getMealUsers($orgId,$mealId) 
    {              
        $where=array(
            'org_id'=>$orgId,
            'plan_meal_id' => $mealId
        );
        $this->db->select("p.user_id ");
        $this->db->where($where); 
        $this->db->group_by("p.user_id");
    
        
        $query = $this->db->get('ci_plan_mealmeta as p');
        return $query->result_array();
    }


    /** Fetches all records with limit and orderby values's */
    function getAll($where_like='', $where='', $limit='', $offset='0', $orderby='', $tablename='') 
    {              
        //print_r($orderby);die('hey');
        if (!empty($where_like)){ $this->db->like(array($where_like[0] => $where_like[1])); }
        if (!empty($where)){ $this->db->where($where);}
        if ($limit != ''){ $this->db->limit($limit, $offset);}
        if (!empty($orderby)){ $this->db->order_by($orderby[0], $orderby[1]);}
        $members = $this->db->get($tablename)->result_array();
        return $members;
    }
     /** Insert new record OR Update existing record*/
    function saveRecords($member=array(), $tablename) {
        if (!empty($member)){
            if (!isset($member['id']))
            { // new record
                $query = $this->db->insert($tablename,$member);
                return $this->db->insert_id();
            } 
            else 
            { // edit existing record
                $memberid = $member['id'];
                
                $this->db->where("id",$memberid);
                $query = $this->db->update($tablename,$member);
                return $memberid;
            }
        }
    }
    /** Fetches all records with limit and orderby values's */
    function getAllById($where_like='', $where='', $limit='', $offset='0', $orderby='', $tablename='',$user_id='') 
    {              
        //print_r($orderby);die('hey');
        // if (!empty($where_like)){ $this->db->like(array($where_like[0] => $where_like[1])); }
        if (!empty($where)){ $this->db->where($where);}
        $this->db->where('FIND_IN_SET("'.$user_id.'", list_users)');
        if ($limit != ''){ $this->db->limit($limit, $offset);}
        if (!empty($orderby)){ $this->db->order_by($orderby[0], $orderby[1]);}
        $members = $this->db->get($tablename)->result_array();
        return $members;
    }
     /** Fetches all records with limit and orderby values's */
    function getAllmealById($where_like='', $where='', $limit='', $offset='0', $orderby='', $tablename='',$user_id='') 
    {              
        //print_r($orderby);die('hey');
        if (!empty($where_like)){ $this->db->like(array($where_like[0] => $where_like[1])); }
        if (!empty($where)){ $this->db->where($where);}
        $this->db->where('FIND_IN_SET("'.$user_id.'", list_users)');
        if ($limit != ''){ $this->db->limit($limit, $offset);}
        if (!empty($orderby)){ $this->db->order_by($orderby[0], $orderby[1]);}
        $members = $this->db->get($tablename)->result_array();
        return $members;
    }
    function get_allusers($data)
    {
        $UUID = $data['uuid'];
        $where= array(
            'UUID' => $UUID,
            'appactive' => 1
            );

        $this->db->select()->from('ci_user')->where($where);
        $query=$this->db->get();
        return $query->first_row('array');
    }

    function get_adusers($data)
    {
        $orgId = $data['org_id'];
        $userId = $data['user_id'];

        $where= array(
            'id' => $userId,
            'admin_id' => $orgId
        );

        $this->db->select()->from('ci_user')->where($where);
        $query=$this->db->get();
        return $query->first_row('array');
    }

    // function get_my_events($user_id){

    //     $this->db->select("p.meetup_date as event_date , e.name , p.meetup_time as event_time ");
    //     $this->db->where("FIND_IN_SET('".$user_id."',p.list_users) and p.is_active = 1");
    //     $this->db->group_by("p.meetup_date");
    //     $this->db->order_by("p.meetup_date", "asc");

    //     $this->db->join("ci_event as e","e.id = p.event_id","left"); 
    //     $query = $this->db->get('ci_plan_event as p');
    //     return $query->result_array();
    // }
    function get_my_events($user_id){

        $this->db->select("p.plan_event_id, p.range_date, p.week_day , p.status , e.event_id, c.name ,l.name as location, e.meetup_time as event_time");
        $this->db->where("(p.user_id = ".$user_id ." and e.is_active = 1) or (p.user_id = ".$user_id ." and e.is_active = 1 and p.status=1)");
        // $this->db->group_by("week_day");
        $this->db->order_by("p.range_date", "asc");
        $this->db->join("ci_plan_event as e","e.id = p.plan_event_id","left"); 
        $this->db->join("ci_event as c ","c.id = e.event_id","left"); 
        $this->db->join("ci_location as l ","l.id = e.location_id","left"); 
        
        $query = $this->db->get('ci_plan_eventmeta as p');  
        return $query->result_array();
    }

    function get_my_meals($user_id){

        $this->db->select("m.plan_meal_id, m.user_id, p.name , m.meal_time as event_time ,l.name as location, m.week_day , m.range_date");
        $this->db->where("user_id = ".$user_id." and p.is_active = 1"); 
        //$this->db->group_by("p.start_date");
        $this->db->order_by("m.week_day", "asc");  

        $this->db->join("ci_plan_meal as p","p.id = m.plan_meal_id","left"); 
        $this->db->join("ci_location as l ","l.id = p.location_id","left"); 
        
        $query = $this->db->get('ci_plan_mealmeta as m');
        return $query->result_array();
    }
    function get_myevent_detail($data)
    {
        $this->db->select("p.event_id as eventid, p.meetup_date as event_date , e.name , p.meetup_time as event_time ");
        $this->db->where("FIND_IN_SET('".$data['user_id']."',p.list_users) and p.meetup_date = '".$data['eventdate']."' and p.is_active = 1");
        $this->db->group_by("p.meetup_date");
        $this->db->order_by("p.meetup_date", "asc");

        $this->db->join("ci_event as e","e.id = p.event_id","left"); 
        $query = $this->db->get('ci_plan_event as p');
        return $query->result_array();
    }

    function get_mymeal_detail($data)
    {
        $this->db->select("p.id as eventid, p.start_date as event_date , p.name , p.start_time as event_time ");
        $this->db->where("FIND_IN_SET('".$data['user_id']."',p.list_users) and p.start_date = '".$data['eventdate']."' and p.is_active = 1"); 
        $this->db->group_by("p.start_date");
        $this->db->order_by("p.start_date", "asc");  
        
        $query = $this->db->get('ci_plan_meal as p');
        return $query->result_array();
    }

    function activation_login_data($data)
    {
        $activationcode = $data['activationcode'];
       $where="appcode='{$activationcode}'";
        
        $this->db->select()->from('ci_user')->where($where);
        $query=$this->db->get();
        return $query->first_row('array');
    }

    function updateApp_status($data)
    {
        $datavalue = array(
               'appcode' => 0,
               'appactive' => 1,
               'app_install'=> GETDATE()
        );
        $where = array(
            'id' => $data['user_id']
        );
        $this->db->where($where);
        $this->db->update('ci_user', $datavalue); 
    }

    function insert_range_data($data,$tablename)
    {
        $insert = $this->db->insert($tablename,$data);
        $quer=$this->db->insert_id();       
        return $quer;
    }
    function update_range_data($where,$datavalue,$tablename)
    {
         $this->db->where($where);
         $this->db->update($tablename, $datavalue); 
    }
    function getrangeByID($where,$tablename)
    {
        
        $this->db->select()->from($tablename)->where($where);
        $query=$this->db->get();
        return $query->result_array();
    }
    function rangedelete($data,$tablename)
    {
       
        $this->db->where($data);
        $this->db->delete($tablename);
    }
}
?>