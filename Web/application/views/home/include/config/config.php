<?php
//@session_start();
//date_default_timezone_set('Asia/Calcutta'); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* Server path */
define("HTTP_SERVER", "http://67.227.228.88/~development002/",true);
/* Set website */
define("DIR_WS_SITE", HTTP_SERVER."community/",true);
define("DIR_FS_SITE", dirname(dirname(dirname(__FILE__))).'/',true);

//define("DB_HOST", "127.0.0.1");
//define("DB_USER", "");
//define("DB_PASSWORD", "");
//define("DB_DATABASE", "");

/*define("ENQ_PREFIX", "ENQ-");
define("PROD_PREFIX", "PROD-");
define("ORD_PREFIX", "ORD-");*/


//include_once(DIR_FS_SITE.'function/other.php');
//include_once(DIR_FS_SITE.'include/config/db_connect.php');
include_once(DIR_FS_SITE.'include/function/db_functions.php');
//include_once(DIR_FS_SITE.'PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');

$db = new DB_Functions();

//include_once("include/db.php");
?>
