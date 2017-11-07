<?php

class Common_model extends CI_Model {
	
	public function __construct() 
    {           
    }

    function check_make_dir($dir_path)
	{
		if (!file_exists($dir_path)) {
			mkdir($dir_path, 0777, true);
		}
		return true;
	}
	function resize_file($path,$file,$size)
	{
		$config['image_library']='gd2';
		$config['source_image']=$path.'/'.$file;
		$config['create_thumb']=TRUE;
		$config['maintain_ratio']=TRUE;		
        $config['thumb_marker'] = 'mg';
		$config['width']=$size;
		$config['height']=$size;
		$this->load->library('image_lib', $config); 
		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->resize())
		{
			echo $config["source_image"];
		    echo $this->image_lib->display_errors();
		}
		$this->image_lib->clear();
		
		$new_image = explode(".",$file);
		$new_image[count($new_image)-2] .="mg";
		//print_r($start);
		return implode(".",$new_image);
	}
	function createColorCode()
	{
		for($i=0;$i<200;++$i)
		{
			$r = $this->random_color_part();
			$g = $this->random_color_part();
			$b = $this->random_color_part();    
			$data[] = "#".$r.$g.$b;    
		}
		
		return $data;
	}
	
	function random_color_part()
	{
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}
}
