<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Generate extends CI_Controller
{


    function Generate()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('csv');
    }

        function create_csv(){

            $query = $this->db->query('SELECT * FROM ci_user');

            $num = $query->num_fields();
            $var =array();
            $i=1;
            $fname="";
            while($i <= $num){
                $test = $i;
                $value = $this->input->post($test);

                if($value != ''){
                        $fname= $fname." ".$value;
                        array_push($var, $value);

                    }
                 $i++;
            }

            $fname = trim($fname);

            $fname=str_replace(' ', ',', $fname);

            $this->db->select($fname);
            $quer = $this->db->get('ci_user');
          
            query_to_csv($quer,TRUE,'Users_'.date('dMy').'.csv');
           
        }
}