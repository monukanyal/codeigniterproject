<?php
class Api_model extends CI_Model {
    
    public function __construct() 
    {   
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Content-type: application/json');        
    }   
        //@mkcode

    function getstatus_event($id,$user_id,$r_dates)
    {
         $this->db->select()->from('ci_plan_eventmeta')->where('user_id',$user_id)->where('plan_event_id',$id)->where("range_date","$r_dates");

            $query_new=$this->db->get();
            $newarr= $query_new->result_array();
            if(!empty($newarr))
            {
                return $newarr;
            }else
            {
                return "";
            }
    }
    function getstatus_Meal($mealid,$user_id,$r_dates)
    {

 $this->db->select('*')->from('ci_plan_mealmeta')->where('user_id',$user_id)->where('plan_meal_id',$mealid)->where("range_date","$r_dates");
            $query_new=$this->db->get();
            $newarr= $query_new->result_array();
            if(!empty($newarr))
            {
                return $newarr;
            }
            else
            {
                return "";
            }
    }
    function get_allevent_new($data,$user_id)
    {
        $where=array(
            'admin_id'=>$data['admin_id'],
            'is_active' => 1,

        );
        $today=date('Y-m-d');
        //$this->db->select()->from('ci_plan_event')->where($where)->where('meetup_date>=',$today)->order_by("meetup_time","asc");  //@mk
        $this->db->select()->from('ci_plan_event')->where($where)->order_by("meetup_time","asc");
        $query=$this->db->get();
        $arr= $query->result_array();
        if(!empty($arr))
        {
            for($m=0;$m<count($arr);$m++)
            {
                $id=$arr[$m]['id'];
                  $this->db->select()->from('ci_plan_eventmeta')->where('user_id',$user_id)->where('plan_event_id',$id);
                $query_new=$this->db->get();
                $newarr= $query_new->result_array();
                if(!empty($newarr))
                {
                    $status=$newarr[0]['status'];
                    $arr[$m]['status']=$status;
                }
            }
            return $arr;
        }
        else
        {
            return "";
        }
    }
    function get_allevent($data)
    {
        // $where=array(
        //     'admin_id'=>$data['admin_id'],
        //     'is_active' => 1,

        // );
        $admin_id=$data['admin_id'];
        $today=date('Y-m-d');
      //  $query = $this->db->query("select * from ci_plan_event where(meetup_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW()) and (admin_id='$admin_id' and is_active='1') ");  //<--CHANGED  LAST 30+ LATEST
        $query = $this->db->query("select * from ci_plan_event where(end_date >=NOW()) and (admin_id='$admin_id' and is_active='1') ");  
        //$this->db->select()->from('ci_plan_event')->where($where)->order_by("meetup_time","asc");
       // $query=$this->db->get();
        $len1=$query->num_rows();
        if($len1>0)
        {
         $res1= $query->result_array();
        }
        $query2=$this->db->query("select * from ci_plan_event where((meetup_date >NOW()) and (admin_id='$admin_id' and is_active='1'))");
        $len2=$query2->num_rows();
        if($len2>0)
        {
            $res2= $query2->result_array();
        }
        if(($len1>0)&&($len2>0))
        {
            return array_merge($res1,$res2);
        }else if($len1>0)
        {
            return $res1;
        }else if($len2>0)
        {
                return $res2;
        }else
        {
            return "";
        }

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
//----------mk----
     function usercheck($code) 
     {
          $this->db->select('*');
         $this->db->from('ci_user');
        $this->db->where("msg_recieved LIKE '%$code%'");
        $query=$this->db->get();
        if($query->num_rows()==1)
        {
            $row = $query->row_array();
            return $row;
        }else{
            return "";
        }
        
    }

    //-------------
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

    //@mkcode
    function getAll_new($where_like='', $where='', $limit='', $offset='0', $orderby='', $tablename='') 
    {              
        //print_r($orderby);die('hey');
        if (!empty($where_like)){ $this->db->like(array($where_like[0] => $where_like[1])); }
        if (!empty($where)){ $this->db->where($where);}
        if ($limit != ''){ $this->db->limit($limit, $offset);}
        if (!empty($orderby)){ $this->db->order_by($orderby[0], $orderby[1]);}
            //$this->db->like('recurring','S');
          $this->db->order_by('start_time','asc');
        $members = $this->db->get($tablename)->result_array();
        return $members;
    }
    function getAll_new_test($where_like='', $where='', $limit='', $offset='0', $orderby='', $tablename='') 
    {              

       $where="created_from_glance=1";
        if (!empty($where_like)){ $this->db->like(array($where_like[0] => $where_like[1])); }
        if (!empty($where)){ $this->db->where($where);}
        if ($limit != ''){ $this->db->limit($limit, $offset);}
        if (!empty($orderby)){ $this->db->order_by($orderby[0], $orderby[1]);}
          $this->db->order_by('start_time','asc');
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
        //$this->db->where("(p.user_id = ".$user_id ." and e.is_active = 1) or (p.user_id = ".$user_id ." and e.is_active = 1 and p.status=1)");
        $this->db->where("(p.user_id = ".$user_id ." and e.is_active = 1 and p.status=1)");
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

    //@mkcode start
    function get_calender_meals_withdate($where,$tablename)
    {
        
        $where=array(
            'admin_id'=>$where['admin_id'],
            'no_end_date'=>0    //no end date
        );
        $this->db->select()->from('ci_plan_meal')->where($where)->order_by('id','desc');

        //$sql="SELECT c_e.name, p_e.* from $tablename as p_e INNER JOIN ci_event as c_e on p_e.event_id = c_e.id WHERE p_e.admin_id = $admin_id  order by p_e.meetup_date DESC";   
        $query=$this->db->get();
        $res=$query->result_array();
        if(count($res)>0)
        {
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
        else
        {
            return "";
        }
    }
      function get_my_events_new($user_id){

        $this->db->select("p.plan_event_id, p.range_date, p.week_day , p.status , e.event_id, c.name ,l.name as location, e.meetup_time as event_time");
        $this->db->where("(p.user_id = ".$user_id ." and e.is_active = 1 and p.status=1)");
        
        //$this->db->where('p.range_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() and p.status=1');
        //$this->db->or_where('p.range_date >= CURDATE()  and p.status=1');

        $this->db->order_by("p.range_date", "asc");
        $this->db->join("ci_plan_event as e","e.id = p.plan_event_id","left"); 
        $this->db->join("ci_event as c ","c.id = e.event_id","left"); 
        $this->db->join("ci_location as l ","l.id = e.location_id","left"); 
        
        $query = $this->db->get('ci_plan_eventmeta as p');  
        return $query->result_array();
    }
     function get_my_meals_new($user_id){

        $this->db->select("m.plan_meal_id, m.user_id, p.name , m.meal_time as event_time ,l.name as location, m.week_day , m.range_date");
        $this->db->where("user_id = ".$user_id." and p.is_active = 1 and m.status=1"); 
       // $this->db->where('m.range_date BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() and m.status=1');
        //$this->db->or_where('m.range_date >= CURDATE() and m.status=1');

        $this->db->order_by("m.week_day", "asc");  
        $this->db->order_by("m.id", "desc");  

        $this->db->join("ci_plan_meal as p","p.id = m.plan_meal_id","left"); 
        $this->db->join("ci_location as l ","l.id = p.location_id","left"); 
        
        $query = $this->db->get('ci_plan_mealmeta as m');
        return $query->result_array();
    }

    //-------@mkcode end
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
    //@mkcode
    function remove_oldjoined($mealid,$resident_id)
    {
         $this->db->query("DELETE FROM ci_plan_mealmeta WHERE plan_meal_id=$mealid and user_id=$resident_id and range_date<CURDATE()");
    }
    //@mkcode
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

    //@mkcode start 
    function get_event_or_meal_reloader_info($admin_id,$tablename)
    {
         $this->db->select('*')->from($tablename)->where('admin_id',$admin_id);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            return $query->num_rows();
        }
        else
        {
            return 0;
        }
    }
    function get_care_info($care_id)
    {
         $this->db->select()->from('ci_user')->where('id',$care_id)->where("user_type","child");
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
    function save_transaction_info($newdata,$tablename)
    {
        $insert = $this->db->insert($tablename,$newdata);
        $quer=$this->db->insert_id();       
        return $quer;
    }

    function get_care_belongs_to($care_id)
    {
         $this->db->select()->from('ci_user')->where('id',$care_id)->where("user_type","child");
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $res=$query->result_array();
            $r1=$res[0]['belongs_to'];
            $r2=$res[0]['belongs_another'];
            $this->db->select()->from('ci_user')->where('id',$r1)->where("user_type","resident");
            $query2=$this->db->get();
            $output=$query2->result_array();
            $resident_id1=$output[0]['id'];
            $fname=$output[0]['first_name'];
            $lname=$output[0]['last_name'];
            $fullname1=$fname." ".$lname;
            $res[0]['resident_details'][0]=array('resident_id'=>$resident_id1,'resident_name'=>$fullname1);
            if(!empty($r2))
            {
                 $this->db->select()->from('ci_user')->where('id',$r2)->where("user_type","resident");
                $querys=$this->db->get();
                $outputs=$querys->result_array();
                $resident_id2=$outputs[0]['id'];
                $fnames=$outputs[0]['first_name'];
                $lnames=$outputs[0]['last_name'];
                $fullname2=$fnames." ".$lnames; 
                $res[0]['resident_details'][1]=array('resident_id'=>$resident_id2,'resident_name'=>$fullname2);
            }
            return $res[0];
        }
        else
        {
            return "";
        }
    }
    
    

    function get_alladmin_list()
    {
        $newarr=array();
        $this->db->select('*')->from('ci_admin');
         $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $res=$query->result_array(); 
            for($j=0;$j<count($res);$j++)
            {
                $newarr[$j]['admin_id']=$res[$j]['id'];
                $newarr[$j]['first_name']=$res[$j]['first_name'];
                $newarr[$j]['last_name']=$res[$j]['last_name'];

            }
            return $newarr;
        }
        else
        {
            return "";
        }
    }


    function get_resident_list($admin_id)
    {
        $newarr=array();
         $m=0;  
        $this->db->select('*')->from('ci_user')->where('admin_id',$admin_id)->where('user_type','resident');
         $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $res=$query->result_array(); 
             
            for($j=0;$j<count($res);$j++)
            {
                $resident_id=$res[$j]['id'];
                $num=$this->check_care_account_limit($resident_id);
                if($num<4)
                {
                    $newarr[$m]['resident_id']=$res[$j]['id'];
                    $newarr[$m]['first_name']=$res[$j]['first_name'];
                    $newarr[$m]['last_name']=$res[$j]['last_name'];
                    $newarr[$m]['user_type']=$res[$j]['user_type'];
                     $m++;
                }
               
            }
            return $newarr;
        }
        else
        {
            return "";
        }
    }

    function check_care_account_limit($resident_id)
    {
        $query1 = $this->db->query("SELECT * FROM ci_user WHERE ((belongs_to='$resident_id' and user_type='child') or (belongs_another='$resident_id' and user_type='child'))");
        $num = $query1->num_rows();
        return $num;

    }


    function insert_child($complete_data)
    {
        $insert = $this->db->insert('ci_user',$complete_data);
        $quer=$this->db->insert_id();       
        return $quer;
    }

    function update_child($complete_data,$caremob)
    {
        $this->db->where('mobile', $caremob);
        $this->db->where('user_type', 'child');
        if($this->db->update('ci_user', $complete_data))
        {
          $this->db->select('*')->from('ci_user')->where('mobile',$caremob)->where('user_type','child');  
           $query=$this->db->get();
           $res=$query->result_array();
           return $res[0]['id'];
        }
        else
        {
            return "";
        }
    }
    function get_admin_id_ofresident($resident_id)
    {
      $this->db->select('*')->from('ci_user')->where('id',$resident_id)->where('user_type','resident');
         $query=$this->db->get();
            if($query->num_rows()==1)
            {
                $res=$query->result_array(); 
               
                return $res[0]['admin_id'];
            }
            else
            {
                return "";
            }
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
    function get_resident_id($resident_mob)
    {
        $this->db->select('*')->from('ci_user')->where('mobile',$resident_mob)->where('user_type','resident');
         $query=$this->db->get();
            if($query->num_rows()==1)
            {
                $res=$query->result_array(); 
               
                return $res[0]['id'];
            }
            else
            {
                return "";
            }
    }
    function get_care_approval_check($care_id)
    {
             $this->db->select('*')->from('ci_user')->where('id',$care_id)->where('user_type','child');
            $queryn=$this->db->get();
            if($queryn->num_rows()==1)
            {
                $response=$queryn->result_array(); 
                return array("approve"=>$response[0]['approved']);
            }
            else
            {
                return " ";
            }
    }

   /* old function check_care_exist($mobile,$resident_id)
    {
            $query1=$this->db->query("SELECT * FROM ci_user WHERE mobile='$mobile'");
            if($query1->num_rows()==1)
            {
                         $result=$query1->result_array(); 
                         $usermob=$result[0]['mobile'];
                         $belong1=$result[0]['belongs_to'];
                        $belong2=$result[0]['belongs_another'];
                        $user_type=$result[0]['user_type'];
                        if($user_type=='child')
                        {
                              if($belong1==$resident_id)
                            {

                                $belong_status='yes';
                            }
                            else if($belong2==$resident_id)
                            {
                                $belong_status='yes';
                            }
                            else 
                            {
                                $belong_status='no';
                            }
                            if($usermob==$mobile)
                            {
                                return array('status'=>'exist','mobile_num'=>$mobile,'belongs_you'=>$belong_status,'type'=>'child');
                            }
                            else
                            {
                               // return array('status'=>'not_exist','mobile_num'=>$mobile,'belongs_you'=>$belong_status,'type'=>'child');
                                return "";
                            }
                        }
                        else
                        {
                            return array('status'=>'exist','mobile_num'=>$mobile,'belongs_you'=>$belong_status,'type'=>'resident');
                        }
            }
            else
            {
               // return array('status'=>'not_exist','mobile_num'=>$mobile);
                return "";
            }
    }
    */
        function get_my_care($resident_id)
        {
            $list=array();
            $query1 = $this->db->query("SELECT * FROM ci_user WHERE ((belongs_to='$resident_id' and user_type='child') or (belongs_another='$resident_id' and user_type='child'))");
            $num = $query1->num_rows();
            if($num>0)
            {
                      $result=$query1->result_array(); 
                          if($num==1)
                          {
                            $list=array(array('name'=>$result[0]['first_name'].' '.$result[0]['last_name'],'mobile'=>$result[0]['mobile'],'registration_status'=>$result[0]['reg_status']));
                             return $list;
                          }
                          else
                          {
                              for($i=0;$i<count($result);$i++)
                              {
                        $list[]=array('name'=>$result[$i]['first_name'].' '.$result[$i]['last_name'],'mobile'=>$result[$i]['mobile'],'registration_status'=>$result[$i]['reg_status']);
                              }
                              return $list;  
                        }
                       
                     
            }
        }

    function check_care_exist($mobile,$resident_id)
    {
            $query1=$this->db->query("SELECT * FROM ci_user WHERE mobile='$mobile'");
            if($query1->num_rows()==1)
            {
                         $result=$query1->result_array(); 
                         $usermob=$result[0]['mobile'];
                         $belong1=$result[0]['belongs_to'];
                        $belong2=$result[0]['belongs_another'];
                        $user_type=$result[0]['user_type'];
                        if($user_type=='child')
                        {
                              if($belong1==$resident_id)
                            {

                                $belong_status='yes';
                            }
                            else if($belong2==$resident_id)
                            {
                                $belong_status='yes';
                            }
                            else 
                            {
                                $belong_status='no';
                            }
                            if($usermob==$mobile)
                            {
                                return array('status'=>'exist','mobile_num'=>$mobile,'type'=>'child');
                            }
                            else
                            {
                               return array('status'=>'notexist','mobile_num'=>$mobile);
                              
                            }
                        }
                        else
                        {
                            return array('status'=>'exist','mobile_num'=>$mobile,'type'=>'resident');
                        }
            }
            else
            {
                return array('status'=>'notexist','mobile_num'=>$mobile);
                //return "";
            }
    }

    function get_resident_info($resident_id)
    {
            $this->db->select('*')->from('ci_user')->where('id',$resident_id)->where('user_type','resident');
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
    function insert_temp_care($caremob,$resident_id,$admin_id)
    {
             $this->db->select('*')->from('ci_user')->where('belongs_to','$resident_id')->where('mobile',$caremob);
             $query_check=$this->db->get();
            if($query_check->num_rows()!=1)
            {   
                    $logtime=date('Y-m-d H:i:s');
                    $mainarr=array(
                        'admin_id'=>$admin_id,
                        'mobile'=>$caremob,
                        'logtime'=>$logtime,
                        'user_type'=>'child',
                        'belongs_to'=>$resident_id,
                        'added_via'=>'app',
                        'approved'=>1,
                        'reg_status'=>0
                    );
                         $insert = $this->db->insert('ci_user',$mainarr);
                        //$quer=$this->db->insert_id();       
                        return 'inserted';
            }
            else
            {
                return 'inserted';
            }
    }
 
    //@mkcode end
 


}
?>