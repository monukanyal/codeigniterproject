<?php 
include('include/config/config.php');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
?>
<!-- ***************Php Portion Start For Email ****************** -->    
    <?php
        // print_r($this->session->userdata['logged_in']);
        if(isset($_POST['submit1'])):
            $db->newsletter($_POST);
            $db->forceRedirect('index.php?success1#footer');
        endif;
        if(isset($_POST['submit2'])):
            $db->contact($_POST);
            $db->forceRedirect('index.php?success2#footer');
        endif;  
    ?>
<!-- ***************Php Portion End For Email****************** -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>MyDayApp</title>
    <meta name="author" content="Alvaro Trigo Lopez" />
    <meta name="description" content="fullPage full-screen backgrounds." />
    <meta name="keywords"  content="fullpage,jquery,demo,screen,fullscreen,backgrounds,full-screen" />
    <meta name="Resource-type" content="Document" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assets_path; ?>css2/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assets_path; ?>css2/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assets_path; ?>css2/animation-effects.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assets_path; ?>css2/custom.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assets_path; ?>css2/jquery.fullPage.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/custom.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/jquery.fullPage.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/animation-effects.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/jquery.lettering-0.6.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/jquery.superscrollorama.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/polyfill.requestAnimationFrame.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/TweenMax.min.js"></script>
    <link rel='stylesheet' href='<?php echo $assets_path; ?>fullcalendar/lib/cupertino/jquery-ui.min.css' />
    <link rel="stylesheet" type="text/css" href="<?php echo $assets_path; ?>fullcalendar/fullcalendar.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo $assets_path; ?>fullcalendar/fullcalendar.print.min.css" /> -->
    <script type="text/javascript" src="<?php echo $assets_path; ?>fullcalendar/lib/moment.min.js"></script>
    <!-- <script type="text/javascript" src="<?php //echo $assets_path; ?>fullcalendar/lib/jquery.min.js"></script> -->
    <script type="text/javascript" src="<?php echo $assets_path; ?>fullcalendar/fullcalendar.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          
        <?php 
          $calenderdata = array();
          if(isset($get_calender_events) && !empty($get_calender_events))
          {
             
              foreach($get_calender_events as $key =>$row)
              {
                 
                  $rec_val = $row['recurring'];
                  $rec_explode = explode(',', $rec_val );
                  $length = count($rec_explode);
                  $recring = array();
                  foreach ($rec_explode  as $key2 => $day) {
                    # code...
                    switch ($day) {
                      case "S":
                        $recring[$day] = 'Sun';
                      break;
                      case "M":
                        $recring[$day] = 'Mon';
                      break;
                      case "T":
                        $recring[$day] = 'Tue';
                      break;
                      case "W":
                        $recring[$day] = 'Wed';
                      break;
                      case "Th":
                        $recring[$day] = 'Thu';
                      break;
                      case "F":
                        $recring[$day] = 'Fri';
                      break;
                      case "St":
                        $recring[$day] = 'Sat';
                      break;    
                    }
                  }


                  $date_S = $row['meetup_date'];
                  $date_E = $row['end_date'];

                  if ( $date_S != $date_E ) {
                        date_default_timezone_set('America/New_York');

                          $begin =  new DateTime( $date_S);
                           $stop_date = date('Y-m-d', strtotime($date_E . ' +1 day'));
                           $end = new DateTime( $stop_date  );
       

                  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                  //print_r($daterange);
                  $data_calender = array();
                  foreach ($recring as $key4 => $recring_val) {


                  foreach($daterange as $key3 => $date){
                       


                        $string = $date->format("Y-m-d");
                        $timestamp = strtotime($string);
                        $day =  date("D", $timestamp);
                       if ($day == $recring_val) {
                        # code...
                     
                        $id = $row['id'];

                        $name = $row['name'];
                        $time = mdate('%H:%i ',strtotime($row['meetup_time']));
                        $meetup_date = $date->format("Y-m-d");
                        $calender[]="{ id: $id,title: '$name',time: '$time',start: '$meetup_date', color: '#5bc0de',className:'event'}";

                        $calenderjs=implode(", ",$calender);

                        }
                        
                  }
                  }
                  }else{

                    $id = $row['id'];
                date_default_timezone_set('America/New_York');
                        $name = $row['name'];
                        $time = mdate('%H:%i ',strtotime($row['meetup_time']));
                        $meetup_date = $date_S;
                        $calender[]="{ id: $id, title: '$name',time: '$time',start: '$meetup_date', color: '#5bc0de',className:'event'}";

                        $calenderjs=implode(", ",$calender);
                  }
              }
              $calenderdata="[ ".$calenderjs." ]"; 
          }




     //       if(isset($get_calender_meals) && !empty($get_calender_meals))
     //      {
              
     //          foreach($get_calender_meals as $kys=>$row1)
     //          {
               
     //             $rec_val = $row1['recurring'];
     //             $rec_explode = explode(',', $rec_val );
     //             $length = count($rec_explode);
     //             $recring = array();
     //             foreach ($rec_explode  as $key2 => $day) {
     //               # code...
     //                 switch ($day) {
     //                      case "S":
     //                        $recring[$day] = 'Sun';
     //                          break;
     //                      case "M":
     //                        $recring[$day] = 'Mon';
     //                          break;
     //                      case "T":
     //                        $recring[$day] = 'Tue';
     //                          break;
     //                      case "W":
     //                          $recring[$day] = 'Wed';
     //                          break;
     //                      case "Th":
     //                        $recring[$day] = 'Thu';
     //                          break;
     //                      case "F":
     //                          $recring[$day] = 'Fri';
     //                          break;
     //                      case "St":
     //                         $recring[$day] = 'Sat';
     //                          break;    
                         
     //                    }
                 
     //               }

      
     // $date_S = date('Y-m-d');
     // $date_E = date('Y-m-d', strtotime($date_S . ' +90 day'));
   
     //   if ( $date_S != $date_E ) {
        
     //    $begin =  new DateTime( $date_S);
     //   $stop_date = date('Y-m-d', strtotime($date_E . ' +1 day'));
     //   $end = new DateTime( $stop_date  );
       
     //  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

     //    $data_calender = array();
     //    foreach ($recring as $key4 => $recring_val) {
       
     //    foreach($daterange as $key3 => $date){
               

     //            $string = $date->format("Y-m-d");
     //            $timestamp = strtotime($string);
     //            $day =  date("D", $timestamp);
     //           if ($day == $recring_val) {
     //            # code...
             
     //            $id = $row1['id'];

     //            $name = $row1['name'];
     //            $time = mdate('%H:%i ',strtotime($row1['end_date']));
     //            $start_date = $date->format("Y-m-d");
     //            $calender[]="{ id: $id,title: '$name',time: '$time',start: '$start_date',color: '#2a3f54', className:'meal'}";

     //            $calenderjs=implode(", ",$calender);

     //            }
                
     //            }
     //         }
     //       }else{

     //                    $id = $row1['id'];

     //                    $name = $row1['name'];
     //                    $time = mdate('%H:%i ',strtotime($row1['start_date']));
     //                    $meetup_date = $date_S;
     //                    $calender[]="{ id: $id,title: '$name',time: '$time',start: '$meetup_date',color: '#2a3f54', className:'meal'}";

     //                    $calenderjs=implode(", ",$calender);
     //        }
    
     //          }
     //        $calenderdata="[ ".$calenderjs." ]"; 
     //        //print_r($calenderdata);
     //      }

          ?>
          <?php if(!empty($calenderdata)){ ?>

        $('#calendar').fullCalendar({

            theme: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            defaultDate: '<?php echo date('Y-m-d');?>',
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: <?php echo isset($calenderdata)?$calenderdata:''; ?>
           
        });

        <?php }else{ ?>
            $('#calendar').fullCalendar({
                theme: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },
                navLinks: true, // can click day/week names to navigate views
                editable: false
            });

            $('p.cal_event_err').text("No events available");
            $('p.cal_event_err').addClass("text-danger alert-danger");
        <?php }?>


        


           // $('#fullpage').fullpage({
                // scrollOverflow: true,
                // navigation: true,
                // navigationPosition: 'right',
                // navigationTooltips: ['First page', 'Second page', 'Third and last page']
            //});
        });

    </script>
    <style>
    .form_sec{
        width: 600px;
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding:20px;
    }
    .panel-title{
        float:left;
        font-size:20px;
    }
    #payment_form .form-group input {
        height: 35px;
        font-size: 15px;
    }
    .pay_esc {
        padding-bottom: 10px;
    }
    .pay_esc h3 {
        font-size: 22px;
        font-weight:bold;
        margin-top: 8px;
    }
    .add_sec {
        margin-bottom: 20px;
    }
    .add_sec .form-group select {
        height: 35px;
        font-size: 15px;
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        background-repeat: no-repeat;
        background-position: 95% center;
        background-size: 15px;
        position: relative;
    }
     .inside_sec .form-group select {
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        background-position: 93% center;
        background-repeat: no-repeat;
        background-size: 12px auto;
        cursor: pointer;
        font-size: 15px;
        height: 34px;
        padding: 0px 12px;
        position: relative;
    }
    .inside_sec .form-group .icon_gly span{
        position: absolute;
        right: 15px;
        top: 10px;
    }
    .add_sec .form-group .icon_gly span{
        position: absolute;
        right: 30px;
        top: 10px;
    }
    .add_sec h3 {
        margin: 0;
        padding: 0 0 15px;
        text-align: left;
        font-size: 24px;
        font-weight:bold;
    }
     
</style>
</head>
<body>
<input type="hidden" id="movement_val"/>
<div class="container-fluid">
        <section class="top-section">
                <header id="header" class="header">
                    <div class="container">
                        <div class="pull-left logo-section">
                            <a href="#">
                                <img class="img-responsive" src="<?php echo $assets_path; ?>images2/logo.png" />
                            </a>
                        </div>
                        <div class="pull-right nav-sec">
                            <ul class="social-sec">
                                <li>
                                    <label>Available</label>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="<?php echo $assets_path; ?>images2/apple.png">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://play.google.com/store/apps/details?id=com.community.newresident&hl=en">
                                        <img src="<?php echo $assets_path; ?>images2/play.png">
                                    </a>
                                </li>
                            </ul>
                            <nav class="navbar navbar-default">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <ul class="nav navbar-nav">
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#carousel-top">Features</a></li>
                                        <li><a href="#footer">Contact</a></li>
                                        <li><a data-toggle="modal" data-target="#my_Modal">View Schedule</a></li>
                                        <?php if (!isset($this->session->userdata['logged_in'])) { ?>
                                          <li class="page-scroll"><a data-toggle="modal" data-target="#myModal">Sign In</a></li>         
                                        <?php } else {
                                        if($this->session->userdata['logged_in']['user_type']== 'superadmin') { ?>
                                            <li class="page-scroll"><a href = "<?php echo site_url('super_dashboard');?>">Dashboard</a></li>
                                        <?php  } 
                                        else { ?>
                                          <li class="page-scroll"><a href = "<?php echo site_url('dashboard');?>">Dashboard</a></li>
                                        <?php }
                                        } ?>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- view schedule modal-->
                    <?php //echo form_open(''); ?>
                    <!-- <div class="signin modal fade" id="viewSchedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="text_heading" style="text-align:center;">
                                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-calender"></i> Display Calender</h4>
                              </div>
                          </div>
                          <div class="modal-body">
                            <div class='message error'></div>        
                            <div>
                              <div class="error_sitecode message_message error" style="display:none;"></div> 
                                <?php //echo form_input(array('name'=>'sitecode','type'=>'text','class'=>'form-control','id'=>'sitecode','placeholder'=>'Sitecode'));?>
                            </div>
                            <div>
                              <button type="button" class="btn btn-primary" id="displaycalbtn">display calender</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <?php //echo form_close(); ?>
                    <!--view schedule modal end-->
                <!-- Modal -->
                <?php echo form_open('Authorize/ajax_login'); ?>
                    <div class="signin modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="close1">&times;</span></button>
                              <div class="text_heading" style="text-align:center;">
                                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Sign In</h4>
                                <h5 class="modal-title">Signin to access your account.</h5>
                              </div>
                          </div>
                          <div class="modal-body">
                            <div class='message error'></div> 
                            <div class="form_group">

                              <p>
                                Admin:
                                <input type="radio" class="flat" name="role" id="role1" value="admin" checked="" required /> &nbsp;Staff:
                                <input type="radio" class="flat" name="role" id="role2" value="staff" />
                              </p>
                            </div>       
                            <div>
                              <div class="error_email message_message error" style="display:none;"></div> 
                                <?php echo form_input(array('name'=>'email','type'=>'email','class'=>'form-control','id'=>'email','placeholder'=>'Email','value'=>''));?>
                            </div>
                            <div>
                              <div class="error_password message_message error" style="display:none;"></div>
                                <?php echo form_input(array('name'=>'password','type'=>'password','class'=>'form-control','id'=>'password','placeholder'=>'Password','value'=>''));?>
                            </div>
                            <div><br/><input type="checkbox" name="remember_me"/> Remember Me</div>
                            <div class="forgot-pass"><br/><button type="button" class="btn btn-primary" id="sign-in">Sign In</button>
                            <!--<a href="<?php //echo site_url('authorize/forgot_password'); ?>">Forgot Password?</a>-->
                            
                            <div class="loading-spinner" style="display:none;">
                              <!-- <img src="<?php //echo base_url().'images2/img/loading_icon.gif';?>" style="height:45px;"> -->
                            </div>
                            </div>
                            <p class="member-or-not">Not a member? 
                            <a data-toggle="modal" class="modal_signup" data-target="#firstModal">Sign Up</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php echo form_close();?>
                    <!-- Modal -->
                   <?php //echo form_open('Authorize/ajax_login'); ?>
                    <div class="signup modal fade" id="firstModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close2"><span aria-hidden="true">&times;</span></button> 
                          <div class="text_heading" style="text-align:center;">
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-unlock"></i> Sign Up</h4>
                            <h5 class="modal-title">Signup to create your account.</h5>
                          </div>
                          </div>
                          <div class="modal-body">
                            <div class='message error'></div>  
                            <form action="<?php echo site_url('payments_pro/Set_express_checkout'); ?>" method="post">      
                            <div class="form-group">
                              <div class="error error_first_name message_message" style="display:none;"></div> 
                                <?php echo form_input(array('name'=>'first_name','type'=>'text','class'=>'form-control','id'=>'signup_first_name','placeholder'=>'First Name'));?>
                            </div>       
                            <div class="form-group"> 
                              <div class="error error_email message_message" style="display:none;"></div> 
                                <?php echo form_input(array('name'=>'email','type'=>'email','class'=>'form-control','id'=>'signup_email','placeholder'=>'Email','required'=>'required'));?>
                            </div>
                            <div class="form-group">
                              <div class="error error_address message_message" style="display:none;"></div> 
                                <?php echo form_input(array('name'=>'address','type'=>'text','class'=>'form-control','id'=>'signup_address','placeholder'=>'Property Name','required'=>'required'));?>
                            </div>   
                            <div class="form-group">
                              <div class="error error_password message_message" style="display:none;"></div>
                                <?php echo form_input(array('name'=>'password','type'=>'password','class'=>'form-control','id'=>'signup_password','placeholder'=>'Password','required'=>'required'));?>
                            </div>
                            <div class="form-group">
                              <div class="error error_password_confirmation message_message" style="display:none;"></div>
                                <?php echo form_input(array('name'=>'password_confirmation','type'=>'password','class'=>'form-control','id'=>'signup_password_confirmation','placeholder'=>'Password Confirmation'));?>
                            </div>
                            <div class="form-group">
                            <div class="forgot-pass"><button type="button" class="btn btn-primary" id="sign-up">Sign Up</button>
                            </div>
                             <!-- <div class="hide_test"><input type="button" class="btn btn-primary" id="sign-up"></div> -->
                            <div class="loading-spinner" style="display:none;">
                              <!--<img src="<?php //echo base_url().'images2/img/loading_icon.gif';?>" style="height:45px;">-->
                            </div>
                            </div>
                            <p class="member-or-not">Already a member? <a data-toggle="modal" data-target="#myModal">Sign In</a></p>
                          </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--@mkpayment form -->
                    <!-- Modal -->
                    <a data-toggle="modal" data-target="#myModal_email" id="trig1"></a>
                        <div id="myModal_email" class="modal fade" role="dialog">
                            
                        </div>
                    <a data-toggle="modal" data-target="#myModal3" id="trig2"></a>
                        <div id="myModal3" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg" > 
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <center><h4 class="modal-title" style="color:black">More Infomation</h4></center>
                            </div>
                            <div class="modal-body">
                                <!-- CREDIT CARD FORM STARTS HERE -->
                            <form id="payment_form">
                            <div class="add_sec">
                                <div class="row">
                                <div class="col-md-12 col-md-12" id="response_msg"></div>
                                </div>
                                <input type="hidden" id="org_email" value="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">First Name:</label>-->
                                            <input class="form-control" placeholder="First Name" type="text" id="first_name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Last Name:</label>-->
                                            <input class="form-control" placeholder="Last Name" type="text" id="last_name" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Address:</label>-->
                                            <input class="form-control" placeholder="Email-Id" type="text" id="user_email" value="" title="Payment gateway keep this email id for transaction record" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 showcancel">
                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Address:</label>-->
                                            <input class="form-control" placeholder="Address" type="text" id="address" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">City:</label>-->
                                            <input class="form-control"  placeholder="City" type="text" id="city" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">State:</label>-->
                                            <input class="form-control" placeholder="state" type="text" id="state" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Post Code:</label>-->
                                            <input class="form-control" placeholder="Post Code" type="text" id="zipcode" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Phone no.</label>-->
                                            <input class="form-control" placeholder="Phone no." type="text" id="phone_num" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="sel1">Country:</label>-->
                                            <select class="form-control" id="country">
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Anguilla">Anguilla</option>
                                                    <option value="Antartica">Antarctica</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Bouvet Island">Bouvet Island</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Cape Verde">Cape Verde</option>
                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Christmas Island">Christmas Island</option>
                                                    <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Congo">Congo, the Democratic Republic of the</option>
                                                    <option value="Cook Islands">Cook Islands</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                                                    <option value="Croatia">Croatia (Hrvatska)</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="East Timor">East Timor</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="France Metropolitan">France, Metropolitan</option>
                                                    <option value="French Guiana">French Guiana</option>
                                                    <option value="French Polynesia">French Polynesia</option>
                                                    <option value="French Southern Territories">French Southern Territories</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Gibraltar">Gibraltar</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Greenland">Greenland</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                    <option value="Guam">Guam</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                                                    <option value="Holy See">Holy See (Vatican City State)</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran">Iran (Islamic Republic of)</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
                                                    <option value="Korea">Korea, Republic of</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Lao">Lao People's Democratic Republic</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon" selected>Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macau">Macau</option>
                                                    <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Martinique">Martinique</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mayotte">Mayotte</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Micronesia">Micronesia, Federated States of</option>
                                                    <option value="Moldova">Moldova, Republic of</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montserrat">Montserrat</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                    <option value="New Caledonia">New Caledonia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Niue">Niue</option>
                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Pitcairn">Pitcairn</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Reunion">Reunion</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russia">Russian Federation</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                                                    <option value="Saint LUCIA">Saint LUCIA</option>
                                                    <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia (Slovak Republic)</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
                                                    <option value="Span">Spain</option>
                                                    <option value="SriLanka">Sri Lanka</option>
                                                    <option value="St. Helena">St. Helena</option>
                                                    <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                                                    <option value="Swaziland">Swaziland</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syria">Syrian Arab Republic</option>
                                                    <option value="Taiwan">Taiwan, Province of China</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania">Tanzania, United Republic of</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tokelau">Tokelau</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Turks and Caicos">Turks and Caicos Islands</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Vietnam">Viet Nam</option>
                                                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                                    <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                                                    <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                                                    <option value="Western Sahara">Western Sahara</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Yugoslavia">Yugoslavia</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                            <div class="icon_gly">
                                                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel_heading">
                                <div class="row display-tr" style="padding: 0px 15px">
                                    <h3 class="panel-title display-td">Payment Details</h3>
                                    <div class="display-td">                            
                                        <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>                    
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control" name="cardNumber" placeholder="Valid Card Number" type="text" id="card_num" value="">
                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                            <div class="row inside_sec">
                                <div class="col-xs-6 col-md-6">
                                    <div class="col-md-5 col-sm-5" style="padding:0px;">
                                        <div class="form-group">
                                            <label for="cardExpiry">EXPIRATION DATE:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6" style="padding: 0 5px 0 0;">
                                                <div class="form-group">
                                                    <select class="form-control" id="exp_month">
                                                       <?php 
                                                        for($l=1;$l<=12;$l++)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $l; ?>"><?php echo $l; ?></option>
                                                        
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="icon_gly">
                                                        <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6" style="padding: 0 0 0 5px;">
                                                <div class="form-group">
                                                    <select class="form-control" id="exp_year">
                                                        <?php 
                                                        for($k=17;$k<31;$k++)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $k; ?>"><?php echo $k; ?></option>
                                                        
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="icon_gly">
                                                        <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 pull-right">
                                    <div class="form-group">
                                        <!-- <label for="cardCVC">CV CODE:</label> -->
                                        <input class="form-control" name="cardCVC" placeholder="CVC" type="text" id="card_code" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                                <ul class="nav nav-pills nav-stacked">
                                <li class="active"><a href="#"><span class="badge pull-right"><span class="glyphicon glyphicon-usd"></span>1</span> Final Payment</a>
                                 </li>
                                </ul>

                            </div>

                            <div class="row">
                            <div class="col-xs-12" style="padding: 5px"></div>
                            </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="subscribe btn btn-success btn-lg btn-block" type="button" id="paynow">Pay Now</button>
                                </div>
                            </div>
                        </form>          
                    <!-- CREDIT CARD FORM ENDS HERE -->
                            
                            </div> 
                            
                            </div>
                            </div>
                        </div>
                    <!--end form -->
                </header>
                <div class="container caption-sec">
                    <center>
                        <h3 class="">Convenient Scheduling, Systemized Reminders, <br/> Automated Peace of Mind </h3>
                        <button class="btn btn-primary blue"><a href="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/index.php/subscription" class="modal_signup">START OUR FREE TRAIL NOW</a></button>
                    </center>
                </div>
            </section>
            <div class="site-wrapper">
                <div class="container desktop-view">
                    <div class="carousel-top" id="carousel-top">
                            <center>
                                <h1>Schedule your events</h1>
                                <p>Never miss an opportunity again. MyDay takes all of the difficulty out of scheduling events, to make sure you make the fullest<br/> of the opportunities made available.</p>
                            </center>
                    </div>
                    <div id="fullpage">
                        <div class="section " id="section0">
                            <div class="col-md-6 col-sm-6 col-xs-6 carousel-left">
                               <img class="img-responsive" src="<?php echo $assets_path; ?>images2/desktop.png" />
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 carousel-right">
                                <h2>Manage activities</h2>
                                <p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. </p>
                            </div>
                        </div>
                        <div class="section" id="section1">
                                <div class="col-md-6 col-sm-6 col-xs-6 carousel-left">
                                    <img class="img-responsive" src="<?php echo $assets_path; ?>images2/mobile.png" />
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 carousel-right">
                                    <h2>Instantaneous Listings &<br/>Ease-of-use</h2>
                                    <p>Immediate event listing and availability updates so residence are instantly notified of new events.<br/><br/>Easy event navigation and scheduling, at your fingertips, making event registration more convenient.</p>
                                </div>
                        </div>
                        <div class="section" id="section2">
                            <div class="col-md-6 col-sm-6 col-xs-6 carousel-left">
                                    <img class="img-responsive" src="<?php echo $assets_path; ?>images2/mobile.png" />
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 carousel-right">
                                    <h2>Systemized Reminders</h2>
                                    <p>Itinerary reminders and change notifications to keep residence up-to-date on all of the community events!</p>
                                    <p><b>What medicines do I need to take today? When? Have I taken them?</b></p>
                                    <p><b>MyDay is there for me!</b></p>
                                    <p>Keeping track of medications and other events can be burdensome. You don’t want to be inconvenienced with remembering if you’ve taken your medication or when you need to take it again. MyDay takes care of this for you. One-time programing your medication schedule allows automated reminders and others to be able to help with making sure your on schedule.</p>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="container mobile-view">
                    <div class="carousel-top">
                            <center>
                                <h1>Schedule your events</h1>
                                <p>Never miss an opportunity again. MyDay takes all of the difficulty out of scheduling events, to make sure you make the fullest<br/> of the opportunities made available.</p>
                            </center>
                    </div>
                    <div id="fullpagemobile">
                        <div class="slide " id="slide0">
                            <div class="col-md-6 col-sm-6 col-xs-6 carousel-left">
                               <img class="img-responsive" src="<?php echo $assets_path; ?>images2/desktop.png" />
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 carousel-right">
                                <h2>Manage activities</h2>
                                <p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. </p>
                            </div>
                        </div>
                        <div class="slide" id="slide1">
                                <div class="col-md-6 col-sm-6 col-xs-6 carousel-left">
                                    <img class="img-responsive" src="<?php echo $assets_path; ?>images2/mobile.png" />
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 carousel-right">
                                    <h2>Instantaneous Listings &<br/>Ease-of-use</h2>
                                    <p>Immediate event listing and availability updates so residence are instantly notified of new events.<br/><br/>Easy event navigation and scheduling, at your fingertips, making event registration more convenient.</p>
                                </div>
                        </div>
                        <div class="slide" id="slide2">
                            <div class="col-md-6 col-sm-6 col-xs-6 carousel-left">
                                    <img class="img-responsive" src="<?php echo $assets_path; ?>images2/mobile.png" />
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 carousel-right">
                                    <h2>Systemized Reminders</h2>
                                    <p>Itinerary reminders and change notifications to keep residence up-to-date on all of the community events!</p>
                                    <p><b>What medicines do I need to take today? When? Have I taken them?</b></p>
                                    <p><b>MyDay is there for me!</b></p>
                                    <p>Keeping track of medications and other events can be burdensome. You don’t want to be inconvenienced with remembering if you’ve taken your medication or when you need to take it again. MyDay takes care of this for you. One-time programing your medication schedule allows automated reminders and others to be able to help with making sure your on schedule.</p>
                                </div>
                        </div>
                    </div>
                </div>
            </div> <!-- site-wrapper -->
        <div class="carousel-bottom" id="carousel-bottom">
            <div class="container">
                <center>
                    <h1 class="">Everyone's Schedule In One Place</h1>
                    <p class="schedule-desc animated-p">Keep your residence scheduled without burdening staff and family members. Get your community started<br/>today - for free.</p>
                </center>
                <ul class="schedule-actions">
                    <li><figure><a href=""><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Post Events</a></figure></li>
                    <li><figure><a href=""><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Update Schedule</a></figure></li>
                    <li><figure><a href=""><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Provide Reinders</a></figure></li>
                    <li><figure><a href=""><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>Check Attendance</a></figure></li>
                </ul>
            </div>
        </div>

        <div class="carousel-calendar" id="carousel-calendar">
            <div class="container">
                <div class = 'calendar'>
	                <center>
	                    <h1 class="">Calendar</h1>
	                   
	                    <?php //echo "<br><pre>".print_r($get_calender_events); ?>
	                </center>
                    <center><p class="cal_event_err"></center>
	                <div id='calendar'></div>
                  <!-- <div id='calendar_new'></div> -->
	            </div>

				<!-- Modal -->
				<div id="my_Modal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Your Site Code :</h4>
				      </div>
				      <div class="modal-body">
                        <div id="loader_modal" class="hide"><i class="fa fa-spinner fa-spin"></i></div>
                        <p id="site_code_err" class=""></p>
				        <p id="site_code"><?php echo form_input(array('name'=>'sitecode','type'=>'text','class'=>'form-control','id'=>'sitecode','placeholder'=>'Sitecode'));?></p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" id="display_calendar">Display Calendar</button>
				      </div>
				    </div>

				  </div>
				</div>
                <!-- modal used for error showing for incorrect sitecode by URL(http://localhost/geoff/?sitecode=xyz)-->
                <div id="sitecode_err_modal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body alert-danger">
                        Sitecode not exists.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <footer id="footer" class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-6 col-xs-12 footer-left">
                            <h4>Get Our Updates</h4>
                            <p>Stay on top of MyDay by receiving regular updates from our platform. We’re constantly looking for newer and more exciting ways to make your day easier. The MyDay newsletter will keep you up-to-date!</p>   
                            <form class="update-form" method="post" action="index.php">
                                <input type="text" class="form-control" placeholder="Enter Your Email" name='email' required/>
                                <button class="btn btn-primary dark-blue" type='submit' name="submit1">Submit</button>
                            </form>
                            <?php if(isset($_REQUEST['success1'])): ?>
                            <span class="done">You are successfully subscribed for newsletters.</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 col-md-6 col-xs-12 footer-right">
                            <h4>Contact</h4>
                            <form class="contact-form" method="post" action="index.php">
                                <div class="col-md-6 col-sm-6 col-xs-12  contact-form-left">
                                    <p>
                                        <input class="form-control" type="text" placeholder="Enter Your Name" name='name' required/>
                                    </p>
                                    <p>
                                        <input class="form-control" type="text" placeholder="Enter Your Email" name='email' required/>
                                    </p>
                                    <p>
                                        <input class="form-control" type="text" placeholder="Enter Your Website" name='website' required/>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 message-area">
                                    <textarea class="form-control" placeholder="Message" name='message'></textarea>
                                    <button class="btn btn-primary dark-blue" type='submit' name="submit2">Submit</button>
                                </div>
                            </form>
                            <?php if(isset($_REQUEST['success2'])): ?>
                            <span class="done">Your message has been successfully submitted.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="copyright-sec">
                    <div class="container">
                        <div class="pull-left copyright">Community App &copy; 2016 All Rights Reserved</div>
                        <div class="pull-right">
                            <ul class="footer-social">
                                <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
</div> <!-- Container Fluid -->

    <!-- jQuery -->
    <!-- <script src="<?php echo $assets_path; ?>landing/js/jquery.min.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
   <!--  <script src="<?php echo $assets_path; ?>landing/js/bootstrap.min.js"></script> -->

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="<?php echo $assets_path; ?>landing/js/classie.js"></script>
    <script src="<?php echo $assets_path; ?>landing/js/cbpAnimatedHeader.js"></script>   

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo $assets_path; ?>landing/js/freelancer.js"></script>


<script>
 
    // $(document).on("click",".modal_signin",function(){
    //   // $('.modal').modal('hide');
    //   $('#myModal').modal('show');
    // });
    // $(document).on("click",".modal_signup",function(){
    //   // $('.modal').modal('hide');
    //   // $('#myModal').modal('hide');
    //   $('#firstModal').modal('show');
    // });


    $(document).on("click",".message_message, .flash.error, .flash.success",function(evented){
        $( this ).fadeOut(100);
    });

    $(document).on("click","#paynow",function(evented) {
    
        
            $("#response_msg").html("");
            var f_name=$("#first_name").val();
            var l_name= $("#last_name").val();
            var address=$("#address").val();
            var country= $("#country").val();
            var state=$("#state").val();
            var city=$("#city").val();
            var zipcode=$("#zipcode").val();
            var phone_num=$("#phone_num").val();
            var email=$("#user_email").val();
            //--------------------------------
            var card_num=$("#card_num").val();
            var exp_month=$("#exp_month").val();
            var exp_year=$("#exp_year").val();
            var card_code=$("#card_code").val();

            if((f_name.length>0)&&(l_name.length>0)&&(address.length>0)&&(country.length>0)&&(state.length>0)&&(city.length>0)&&(zipcode.length>0)&&(phone_num.length>0)&&(card_num.length>0)&&(card_code.length>0)&&(exp_month.length>0)&&(exp_year.length>0)&&(email.length>0))
            {
                    var exp_date=exp_month+'/'+exp_year;

                    $.post("<?php echo site_url().'/Paynow/pay_instant'; ?>", 
                        { x_first_name: f_name,x_last_name:l_name,x_address:address,x_country:country,x_state:state,x_city:city,x_zip:zipcode,x_phone:phone_num,x_email:email,x_card_num:card_num,x_card_code:card_code,x_exp_date:exp_date,amount:1 },
                         function(result){
                            $("#response_msg").html("<center>"+result+"</center>");
                                //alert(result);
                              var delay=2000;//1 seconds
                                setTimeout(function(){ 
                                window.open("<?php echo site_url('dashboard');?>","_self");
                                },delay); 
                        });
            }
            else
            {
                $("#response_msg").html("<p style='color:crimson'> Please provide all information Properly.</p>");
            }
    });

 $(document).on("click","#emailuse",function(evented) {

    var admin_email=$('#sec_email').val();
     //alert(admin_email);
     $('#org_email').val(admin_email);
     $('#user_email').val(admin_email);
     $('#user_email').attr('readonly', true);
    $( ".close3" ).trigger( "click" );
      $( "#trig2" ).trigger( "click" );
   

 });

 $(document).on("click","#noemail",function(evented) {

    //var admin_email=$('#sec_email').val();
     //alert(admin_email);
     $("#user_email").removeAttr("readonly"); 
    $( ".close3" ).trigger( "click" );
      $( "#trig2" ).trigger( "click" );
   

 });
    // $(document).on("click","#change_email",function(evented) {
    //      alert();
    //       $("#user_email").removeAttr("readonly"); 
    //       $(".showcancel").html("<a href='#' id='cancel_email' style='color:red'>Cancel</a>");
    // });

    //  $(document).on("click","#cancel_email",function(evented) {
         
    //      var email=$("#org_email").val();
    //      $("#user_email").val(email);
    //      $('#user_email').attr('readonly', true);
    //       $(".showcancel").html("<a href='#' id='change_email'>change</a>&nbsp;<small>(Payment gateway keep this email id for transaction record)</small>");
    // });
    $(document).on("click","#sign-in",function(evented) {
    $(evented).preventDefault; // Prevent Link's default behaviour  
    $(".signin .error_emailId").hide();
    $(".signin .error_password").hide();
    $(".signin .message.error").html("");
    var role = $("input[name='role']:checked"). val();
    var form_email = $("#email").val();
    var form_password = $("#password").val();
    if(form_email == "")
    {
      $(".signin .error_email").show();
      $(".signin .error_email").html("The Email Id field is required!");
    }
    if(form_password == "")
    {
      $(".signin .error_password").show();
      $(".signin .error_password").html("The Password Id field is required!");
    }

    if (form_email != "" && form_password != "")
    {
      $(".loading-spinner").show();
       var post_data = {
        'role':role,
        'email' : form_email,
        'password' : form_password,
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      };
      //console.log(post_data);
      $.ajax({ 
        url: "<?php echo site_url().'/authorize/ajax_login'; ?>",
        type: "POST",
        data: post_data,
        success: function(response) 
        {
           // alert(response);
          var data = JSON.parse(response);
          $.each(data, function(key,val) {    
            if(key == 'success')
            {
             $(".signin .message.error").hide();
              var url = "<?php echo site_url('dashboard');?>";    
              $(location).attr('href',url);         
            }
            else
            {
              //$(".signin .message.error").html("<div class='flash error'>Invalid Email Id or Password.</div>");   
              // $(".signin .loading-spinner").hide();
              if(val.email)
              {
                $(".signin .error_email").show();
                $(".signin .error_email").html(val.email);              
              }
              else if(val.password)
              {
                $(".signin .error_password").show();
                $(".signin .error_password").html(val.password);              
              }
              else{
                $(".signin .message.error").html("<div class='flash error'>Invalid Email Id or Password.</div>");
              }              
            }
          });
          // $(".loading-spinner").hide();
        },
        error: function()
        {
          $(".signin .message.error").html("<div class='flash error'>Invalid Email Id or Password.</div>");   
          $(".signin .loading-spinner").hide();     
        }

      });
    }
  });
  


  $(document).on("click","#sign-up",function(evented) {
    $(evented).preventDefault; // Prevent Link's default behaviour  
      // $(".loading-spinner").show();
       $("#response_msg").html("");
    $(".signup .error_first_name").hide();
    $(".signup .error_email").hide();
    $(".signup .error_address").hide();
    $(".signup .error_password").hide();
    $(".signup .error_password_confirmation").hide();
    $(".signup .error_message").html("");

    var form_first_name = $("#signup_first_name").val();
    var form_address = $("#signup_address").val();
    var form_email = $("#signup_email").val();
    var form_password = $("#signup_password").val();
    var form_password_cn = $("#signup_password_confirmation").val();

    if(form_first_name == "")
    {
      $(".signup .error_first_name").show();
      $(".signup .error_first_name").html("The User Name field is required!");
    } 
    if(form_address == "")
    {
      $(".signup .error_address").show();
      $(".signup .error_address").html("The Property Name field is required!");
    }
    if(form_email == "")
    {
      $(".signup .error_email").show();
      $(".signup .error_email").html("The Email Id field is required!");
    }
    if(form_password == "")
    {
      $(".signup .error_password").show();
      $(".signup .error_password").html("The Password Id field is required!");
    }
    if(form_password != form_password_cn)
    {
      $(".signup .error_password_confirmation").show();
      $(".signup .error_password_confirmation").html("The Password and Password Confirmation field should be matched!");
    }
 
    if (form_first_name != "" && form_address !="" && form_email != "" && form_password != "")
    {
      if(form_password == form_password_cn)
      {
      $(".loading-spinner").show();
      var post_data = {
        'first_name' : form_first_name,
        'email' : form_email,
        'address' : form_address,
        'password' : form_password
      };
      // console.log(post_data);
      $.ajax({ 
        url: "<?php echo site_url().'/authorize/ajax_register'; ?>",

        type: "POST",
        data: post_data,
        dataType: "html",
          
        success: function(response) //we're calling the response json array 'cities'
        {     
          //console.log(response);
          if(response!="")
          {

           $(".signup .message.error").html("<div class='alert alert-success'>Congrates!! You are successfully registered. Please check your mail id for confirmation.</div>");

           /*------payment gateway is not using now----------
                    $("#myModal_email").html(response);
                    $( "#trig1" ).trigger( "click" );
                    $( "#close1" ).trigger( "click" );
                    $( "#close2" ).trigger( "click" );
            -------------------------------------------------*/
            // var url = "<?php //echo site_url('dashboard');?>";
            //   var delay=1000;//1 seconds
            //     setTimeout(function(){ 
            //     $(location).attr('href',url);   
            //     },delay);  
          }
          else
          {
                $(".signup .message.error").html("<div class='alert alert-danger'>Email id already exist</div>");
          }
      //     $.each(response, function(key, val) {     
      //       if(key == 'success')
      //       {

      //         $(".signup .message.error").html("<div style='color:green'>Congrates!! You are successfully registered.</div>");
      //         //payment form
      //         // var url = "<?php //echo site_url('dashboard');?>";
      //         // var delay=1000;//1 seconds
      //         //   setTimeout(function(){ 
      //         //   $(location).attr('href',url);   
      //         //   },delay);       
      //       }
      //       else if(key == 'user_exist')
      //       {
      //         $(".signup .message.error").html("<div class='flash error'>"+val+"</div>");
      //       }
      //       else if(key == 'error')
      //       {
      //           if(val.address) {
      //               $(".signup .error_address").show();
      //               $(".signup .error_address").html(val.address);
      //           }
      //           if(val.email)
      //           {
      //               $(".signup .error_email").show();
      //               $(".signup .error_email").html(val.email);              
      //           }
      //       }
      //     });

      //     $(".loading-spinner").hide();
      //   },
      //   error: function()
      //   {   
      //     $(".signup .message.error").html("<div class='flash error'>Invalid Email Id or Password.</div>");    
      //     $(".loading-spinner").hide();
      //   }
  }
       });
         }
    }
  });

 $(document).ready(function(){
       var successBox = $('.flash.success');
       var errorBox = $('.flash.error');
   // fade $alertBox out after 1 second (1000 ms)
   successBox.delay(3000).fadeOut('slow');
   errorBox.delay(3000).fadeOut('slow');
});
 $('#myModal').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    // alert();
   $('#sign-in').trigger( "click" );
  }

  // var userip;  

});
 
  </script>
  <script type="text/javascript" src="https://l2.io/ip.js?var=userip"></script>
  <script type="text/javascript">
	$(document).ready(function(){
	  var country_code = null;
	  // $.getJSON('http://ipinfo.io/' + userip, function(data){
	     
	    //$("#my_Modal").modal('show');

      
	    $('.calendar').hide();
	      
	    $('#display_calendar').on('click' , function(){

            var sitecode = $("#sitecode").val();
            //-----
            if(sitecode != ""){
              $("#loader_modal").removeClass('hide');
              $.ajax({
                  url: '<?php echo site_url('home/get_adminid_bysitecode'); ?>',
                  type: 'POST',
                  data: {
                      scode: sitecode
                  },
                  dataType: 'json',
                  success: function(data) {
                      //console.log(data);
                      $("#loader_modal").addClass('hide');
                      if(data.result.sitecode_exist == "true"){
                        //alert("sitecode exist, redirect to home index with admin id");
                        window.location.href = "<?php echo site_url() ; ?>/home/index?admin_id="+data.result.admin_id;
                      }else if(data.result.sitecode_exist == "false"){
                        $("#site_code_err").show();
                        $("#site_code_err").text(data.errmsg);
                        $("#site_code_err").addClass('alert-danger');
                        $("#my_Modal").modal('show');

                        setTimeout(function(){
                          $('#site_code_err').hide('slow');
                        }, 5000);
                      }
                  }
              });
            }
            else{
              $("#site_code_err").show();
              $("#site_code_err").text("Enter site code");
              $("#site_code_err").addClass('alert-danger');
              setTimeout(function(){
                $('#site_code_err').hide('slow');
              }, 5000);
            }
            //-----
            
  		  // $('.calendar').show();
  	   //    $('html, body').animate({
  		  //   scrollTop: $("#carousel-calendar").offset().top
  		  // }, 2000);
  	   //  $("#my_Modal").modal('hide');
	    });

        <?php if(isset($_GET['sitecode'])){ ?>
            <?php if(isset($sitecode_notexisterr)){ ?>
                    $('.calendar').hide();
                    $("#sitecode_err_modal").modal('show');
            <?php }else{ ?>
                    $('.calendar').show();
                    $('html, body').animate({
                        scrollTop: $("#carousel-calendar").offset().top
                    }, 2000);
                    $("#my_Modal").modal("hide");
            <?php 
                }
            }
        ?>

        <?php if(isset($_GET['admin_id'])){ ?>
            $('.calendar').show();
            $('html, body').animate({
                scrollTop: $("#carousel-calendar").offset().top
            }, 2000);
            $("#my_Modal").modal('hide');
        <?php } ?>
    });
    
  </script>
</body>
</html>
