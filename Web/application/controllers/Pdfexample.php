<?php 
class pdfexample extends CI_Controller{
      function __construct() { 
		 parent::__construct();
		 $this->load->model('api_model');
		 $this->load->model('user_model');
	     $this->load->model('system_model');
	    header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


	    if (!isset($this->session->userdata['logged_in'])) {
			$this->session->set_flashdata('flash_error', 'Please Login First!!');
			redirect(base_url());
		}	
	 } 
	 
     function index()
	 {

	 	$admin_id = $this->session->userdata['logged_in']['admin_id'];
		$where['admin_id'] =$admin_id ;


		$arrEvents = $this->api_model->get_allevent($where);
		if (empty($arrEvents)) {
			$data['arrEvent'] = array('status'=>'Error','message'=>'No Record Found.');			
		}
		
		// $arrEvents = $this->api_model->get_allevent($where);
		if(!empty($arrEvents))
        {
        	foreach($arrEvents as $arrevent)
			{
				
				$rec_val = $arrevent['recurring'];
				$rec_explode = explode(',', $rec_val );
				$length = count($rec_explode);
				$recring = array();
				$db_days= array(
						'S' => 'Sunday',
						'M' => 'Monday',
						'T' => 'Tuesday',
						'W' => 'Wednesday',
						'Th' => 'Thursday',
						'F' => 'Friday',
						'St' => 'Saturday',
					);
				foreach ($rec_explode  as $key2 => $day) 
				{
	                $recring[$day] = $db_days[$day];
	            }
	            date_default_timezone_set('America/New_York');

	         
	            $meetup_date = $arrevent['meetup_date'];
				$end_date = $arrevent['end_date'];

				$range_date = array();
		  		$begin =  new DateTime( $meetup_date);
           		$stop_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
           		$end = new DateTime( $stop_date  );
            	$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
				
				$event_id = $arrevent['event_id'];
				
    			$event_name=$this->api_model->getByID($event_id, $where ='','ci_event');
				$arrevent['event_name'] = $event_name['name'];

				$currentDateTime = $arrevent['meetup_date'] ." ". $arrevent['meetup_time'];
				$newDateTime = date('h:i A', strtotime($currentDateTime));
				$arrevent['event_time'] = $newDateTime;

				// print_r($arrevent);
				// die();
 				$today = date('Y-m-d');

				$expiry_event = $arrevent['end_date'];
				$d = 1;
				$m =  date('m');
				$y =  date('Y');
				
				$No_of_days = cal_days_in_month(CAL_GREGORIAN,$m,$y);
				 
				 $m_first_date = $y.'-'.$m.'-'.$d;
				 $m_last_date = $y.'-'.$m.'-'.$No_of_days;

				foreach ($recring as $key4 => $recring_val) 
	      		{ 
					foreach($daterange as $key => $date)
		        	{
		        		$r_dates = $date->format("Y-m-d");
	        		 	if ($r_dates >= $m_first_date  && $r_dates <= $m_last_date ) 
						{
						
							$timestamp = strtotime($r_dates);
		                    $r_day =  date("l", $timestamp);
		                    if ($r_dates == $meetup_date) {
		                    	$response[$r_dates][$event_id] = array($arrevent);
		                    }
		                    if ( ($r_day == $recring_val) ) {
		                    	$response[$r_dates][$event_id] = array($arrevent);
		                    }
	             
						}
					}
				}

			}
			
			if(!empty($response)){
			
					$responseArrayObject = new ArrayObject($response);
					$responseArrayObject->ksort();
					$c = (array) $responseArrayObject;
			}
			// echo "<pre>";
			// print_r($c);
			// echo "</pre>";
			// die();

        }
		else
		{
			$response[]	= array('status'=>'Error','message'=>'No Record Found.');			
			 $response;
		}

		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Lorem Ipsum');
		$pdf->SetTitle('MyDay Calendar PDF');
		$pdf->SetSubject('Lorem Ipsum');
		$pdf->SetKeywords('Lorem, Lorem, Lorem, Lorem, Lorem');

		// set default header data
		$pdf->SetHeaderData("logo.png", PDF_HEADER_LOGO_WIDTH , "Convenient Scheduling".', Systemized Reminders',"Automated Peace of Mind");

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// add a page
		$pdf->AddPage();
		$d = 1;
		$current_M =  date('m');
		$current_y =  date('Y');
		$No_of_days =cal_days_in_month(CAL_GREGORIAN,$current_M,$current_y);
		$time = strtotime($current_y.'-'.$current_M.'-'.$d);
		$mounth_f_day = date('l',$time);
		$pdf->SetLineWidth(0.508);

		// Table with rowspans and THEAD
$tbl = <<<EOD
<table style="background-color: #ffffff;"  cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr valign="middle">
<td>
<table cellpadding="20" cellspacing="0" width="100%" style="background-color: #1b3853;">
	<tbody valign="middle">
		<tr>
			<td style="color: #fff; font-weight: bold;font-size: 24px;padding: 0;margin: 0;"> Community App </td>
			<td align="right" style="color: #fff;color: #ffffff;font-size:14px;margin:10px 0;">
EOD;
$tbl .=  $current_M ." ".$current_y; 
$tbl .= <<<EOD
			</td>
		</tr>
	</tbody>
</table>


<table class="table" cellpadding="5" cellspacing="0" style="background-color:#ffffff;font-family:Arial; border: 1px solid #ddd;">
<thead  style="">
 <tr align="center" style="background-color:#dadfea;color:#173941;font-size:9px;">
  <th><table><tr><th></th></tr><tr><th><h3>Sun</h3></th></tr><tr><th></th></tr></table> </th>
  <th><table><tr><th></th></tr><tr><th><h3>Mon</h3></th></tr><tr><th></th></tr></table></th>
  <th><table><tr><th></th></tr><tr><th><h3>Tue</h3></th></tr><tr><th></th></tr></table></th>
  <th><table><tr><th></th></tr><tr><th><h3>Wed</h3></th></tr><tr><th></th></tr></table></th>
  <th><table><tr><th></th></tr><tr><th><h3>Thu</h3></th></tr><tr><th></th></tr></table></th>
  <th><table><tr><th></th></tr><tr><th><h3>Fri</h3></th></tr><tr><th></th></tr></table></th>
  <th><table><tr><th></th></tr><tr><th><h3>Sat</h3></th></tr><tr><th></th></tr></table></th>
 </tr>

</thead>
<tbody> 
<tr style="color:#212121;color:#333333;font-size:10px;">

EOD;
		$custom_days=array(
				'Sunday' => '1',
				'Monday' => '2',
				'Tuesday' => '3',
				'Wednesday' => '4',
				'Thursday' => '5',
				'Friday' => '6',
				'Saturday' => '7'
			);	
	
	for($y=0; $y < $custom_days[$mounth_f_day]-1; $y++){

		$tbl .= '<td  style="font-size:12px;border:1px solid #ddd;">'; 

		$tbl .= "</td>";
	}
		
	for($x=1; $x <= $No_of_days; $x++){

		$e_dates =  $current_y.'-'.$m.'-'.$x;
		$arrar_data = $c[$e_dates];
		$tbl .= '<td  style="border:1px solid #ddd;color:#333;font-size:7px;font-family:Times;font-weight:normal;">'; 
			
						$tbl .="";
						$tbl .="<table cellpadding='0' cellspacing='0' font-size='20'><tr style='border-bottom: 1px solid #ddd;'><td bgcolor='#1b3853' align='left'><h3 style='font-size: 26px;font-family:arial;color:#fff;background-color:#1b3853;'>";
						$tbl .=$x;
						$tbl .="</h3></td></tr>";
						$tbl .="</table>";
						$tbl .="<table cellpadding='0' cellspacing='0'><tr><td><h3>&nbsp;</h3></td><td colspan='2'><h3>&nbsp;</h3></td></tr></table>";
						# code...

					

			// if (!empty($arrar_data)) {
				$count = 1;
				 foreach ($arrar_data as $key => $arrardata) {
					// echo "<pre>";
					//  print_r($arrardata);
					// echo "</pre>"; 
					
					foreach ($arrardata as $value) {
						$tbl .="<table cellpadding='0' cellspacing='0'>";
						$tbl .="<tr align='left'>";
						$tbl .="<td style='text-align:left;'>";
						$tbl .=$value['event_name'];
						$time =$value['meetup_time'];
						$tbl .="&nbsp;&nbsp;<span>$time</span></td>";
						$tbl .="</tr>";
						$tbl .="</table>";
						$tbl .="<table cellpadding='0' cellspacing='0'><tr><td><h6>&nbsp;</h6></td></tr></table>";

						}	
				$count++;
				 }
			//$tbl .= $arrar_data;
			// }
		// $tbl .= $x; 

		$tbl .= "</td>"; 
		// if ( ($x == 7 - $custom_days[$mounth_f_day]) ) {
		// 	# code...
		// 	$tbl .= "</tr>"; 
		// 	$tbl .= '<tr align="" style="color:#212121;border-bottom: 1px solid #ddd;color:#333;font-size:10px;">'; 
		// }
			
		if ( ($x == 8 - $custom_days[$mounth_f_day]) ) {
			# code...
			$tbl .= "</tr>"; 
			$tbl .= '<tr align="" style="background-color:#f1f1f1;color:#212121;border-bottom: 1px solid #ddd;color:#333;font-size:10px;font-family: sans-serif;">'; 
		}
			if ( ($x == 15 - $custom_days[$mounth_f_day] )  ) {
			# code...
			$tbl .= "</tr>"; 
			$tbl .= '<tr align="" style="color:#212121;border-bottom: 1px solid #ddd;color:#333;font-size:10px;">'; 
		}
			if ( ($x == 22 - $custom_days[$mounth_f_day] ) ) {
			# code...
			$tbl .= "</tr>"; 
			$tbl .= '<tr align="" style="background-color:#f1f1f1;color:#212121;border-bottom: 1px solid #ddd;color:#333;font-size:10px;">'; 
		}
		if ( ($x == 29 -$custom_days[$mounth_f_day]) ) {
			# code...
			$tbl .= "</tr>"; 
			$tbl .= '<tr align="" style="color:#212121;border-bottom: 1px solid #ddd;color:#333;font-size:10px;">'; 
		}

		
	}

$tbl .= <<<EOD

</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
EOD;
//print_r($tbl);

$pdf->writeHTML($tbl, true, false, false, false, false, '');


		$pdf->Output('pdfexample.pdf', 'i');
		$pdf->Output();
      }
}


