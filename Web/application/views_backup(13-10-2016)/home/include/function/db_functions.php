<?php
	
class DB_Functions {

    private $db;
    function __construct() { 
        // connecting to database
        //$this->db = new DB_Connect();
    	//$this->db->connect();
		
    }
    function __destruct() {
    }
	
	
/////////////// Our Database Function  ///////////////////////

    public function forceRedirect($filename)
	{
		$filename=$filename;
    	if (!headers_sent())
       		 header('Location: '.$filename);
		else {
		        echo '<script type="text/javascript">';
		        echo 'window.location.href="'.$filename.'";';
		        echo '</script>';
		        echo '<noscript>';
		        echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
		        echo '</noscript>';
    	}
	}

    public function newsletter($array) {
		    /*$message = '<html><body>';
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr><td><strong>NewsLetter Subscription Email:</strong> </td><td>" . $array['email'] . "</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
			
			//  MAKE SURE THE "FROM" EMAIL ADDRESS DOESN'T HAVE ANY NASTY STUFF IN IT
			
			
			$cleanedFrom='amrinder@ourdesignz.com';
            //   CHANGE THE BELOW VARIABLES TO YOUR NEEDS
             
			$to = 'kamaldipkaur6785@gmail.com';
			
			$subject = "Newsletter Subscription";
			
			$headers = "From: " . $cleanedFrom . "\r\n";
			//$headers .= "Reply-To: ". strip_tags('amrinder@ourdesignz.com') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            @mail($to, $subject, $message, $headers);*/

            // the message
			$msg = "Newsletter Subscription Email: ".$array['email'];

			// use wordwrap() if lines are longer than 70 characters
			//$msg = wordwrap($msg,70);

			// send email
			@mail("lakhvir@ourdesignz.com","Newsletter Subscription",$msg);
    }

    public function contact($array) {
		    $message = '<html><body>';
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr><td><strong>Name:</strong> </td><td>" . $array['name'] . "</td></tr>";
			$message .= "<tr><td><strong>From:</strong> </td><td>" . $array['email'] . "</td></tr>";
			$message .= "<tr><td><strong>Website:</strong> </td><td>" . $array['website'] . "</td></tr>";
			$message .= "<tr><td><strong>Message:</strong> </td><td>" . $array['message'] . "</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
			
			//  MAKE SURE THE "FROM" EMAIL ADDRESS DOESN'T HAVE ANY NASTY STUFF IN IT
			
			
			$cleanedFrom=$array['email'];
            //   CHANGE THE BELOW VARIABLES TO YOUR NEEDS
             
			$to = 'kamaldipkaur6785@gmail.com';
			$to .= ',amrinder@ourdesignz.com';
			
			$subject = "Contact For Information";
			
			$headers = "From: " . $cleanedFrom . "\r\n";
			//$headers .= "Reply-To: ". strip_tags('amrinder@ourdesignz.com') . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            @mail($to, $subject, $message, $headers);
    }
		
	///////////////// User function End Here  //////////////////



	
}

?>