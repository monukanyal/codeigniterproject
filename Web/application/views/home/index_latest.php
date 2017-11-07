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

    <link rel="stylesheet" type="text/css" href="<?php echo $assets_path; ?>fullcalendar/fullcalendar.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assets_path; ?>fullcalendar/fullcalendar.print.min.css" />
    <script type="text/javascript" src="<?php echo $assets_path; ?>fullcalendar/lib/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>fullcalendar/lib/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>fullcalendar/fullcalendar.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#calendar').fullCalendar({
            // theme: true,
            // header: {
            //  left: 'prev,next today',
            //  center: 'title',
            //  right: 'month,agendaWeek,agendaDay,listMonth'
            // },
            // defaultDate: '2017-02-12',
            // navLinks: true, // can click day/week names to navigate views
            // editable: true,
            // eventLimit: true // allow "more" link when too many events
            
        });
            
            $('#fullpage').fullpage({
                scrollOverflow: true,
                navigation: true,
                navigationPosition: 'right',
                navigationTooltips: ['First page', 'Second page', 'Third and last page']
            });
        });
    </script>
    <style>
        .done
        {
        background:url(images/pass.png) no-repeat scroll left center rgba(0, 0, 0, 0);
        float: left;
        margin: 8px 0 0;
        padding: 0 0 0 22px;
         color:purple;
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
                                    <a href="">
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
                <!-- Modal -->
                <?php echo form_open('Authorize/ajax_login'); ?>
                    <div class="signin modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <div class="text_heading" style="text-align:center;">
                                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Sign In</h4>
                                <h5 class="modal-title">Signin to access your account.</h5>
                              </div>
                          </div>
                          <div class="modal-body">
                            <div class='message error'></div>        
                            <div>
                              <div class="error_email message_message error" style="display:none;"></div> 
                                <?php echo form_input(array('name'=>'email','type'=>'email','class'=>'form-control','id'=>'email','placeholder'=>'Email'));?>
                            </div>
                            <div>
                              <div class="error_password message_message error" style="display:none;"></div>
                                <?php echo form_input(array('name'=>'password','type'=>'password','class'=>'form-control','id'=>'password','placeholder'=>'Password'));?>
                            </div>
                            <div><br/><input type="checkbox" name="remember_me"/> Remember Me</div>
                            <div class="forgot-pass"><br/><button type="button" class="btn btn-primary" id="sign-in">Sign In</button>
                            <!--<a href="<?php echo site_url('authorize/forgot_password'); ?>">Forgot Password?</a>-->
                            
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
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                          <div class="text_heading" style="text-align:center;">
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-unlock"></i> Sign Up</h4>
                            <h5 class="modal-title">Signup to create your account.</h5>
                          </div>
                          </div>
                          <div class="modal-body">
                            <div class='message error'></div>  
                            <form action="http://www.yourday.io/index.php/payments_pro/Set_express_checkout" method="post">      
                            <div>
                              <div class="error error_first_name message_message" style="display:none;"></div> 
                                <?php echo form_input(array('name'=>'first_name','type'=>'text','class'=>'form-control','id'=>'signup_first_name','placeholder'=>'First Name'));?>
                            </div>       
                            <div>
                              <div class="error error_email message_message" style="display:none;"></div> 
                                <?php echo form_input(array('name'=>'email','type'=>'email','class'=>'form-control','id'=>'signup_email','placeholder'=>'Email','required'=>'required'));?>
                            </div>
                            <div>
                              <div class="error error_address message_message" style="display:none;"></div> 
                                <?php echo form_input(array('name'=>'address','type'=>'text','class'=>'form-control','id'=>'signup_address','placeholder'=>'Property Name','required'=>'required'));?>
                            </div>   
                            <div>
                              <div class="error error_password message_message" style="display:none;"></div>
                                <?php echo form_input(array('name'=>'password','type'=>'password','class'=>'form-control','id'=>'signup_password','placeholder'=>'Password','required'=>'required'));?>
                            </div>
                            <div>
                              <div class="error error_password_confirmation message_message" style="display:none;"></div>
                                <?php echo form_input(array('name'=>'password_confirmation','type'=>'password','class'=>'form-control','id'=>'signup_password_confirmation','placeholder'=>'Password Confirmation'));?>
                            </div>

                            <div class="forgot-pass"><button type="submit" class="btn btn-primary">Sign Up</button>
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
        <div class="carosel-bottom" id="carusel-bottom">
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
                <p>Calendar</p>
                <div id='calendar'></div>
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
    <script src="<?php echo $assets_path; ?>landing/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $assets_path; ?>landing/js/bootstrap.min.js"></script>

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
    $(document).on("click","#sign-in",function(evented) {
    $(evented).preventDefault; // Prevent Link's default behaviour  
    $(".signin .error_emailId").hide();
    $(".signin .error_password").hide();
    $(".signin .message.error").html("");
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
        'email' : form_email,
        'password' : form_password,
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      };
      //console.log(post_data);
      $.ajax({ 
        url: "<?php echo site_url().'/authorize/ajax_login'; ?>",
        type: "POST",
        data: post_data,
        success: function(response) //we're calling the response json array 'cities'
        {
          // console.log(response); 
          var data = JSON.parse(response);
          // console.log(data);

          $.each(data, function(key,val) {    
            // console.log(key);
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
        dataType: "json",
          
        success: function(response) //we're calling the response json array 'cities'
        {     
          console.log(response);
          $.each(response, function(key, val) {     
            if(key == 'success')
            {
              var url = "<?php echo site_url('dashboard');?>";

              $(".signup .message.error").html("<div class='flash success'>Congrates!! You are successfully registered.</div>");

              var delay=1000;//1 seconds
                setTimeout(function(){ 
                $(location).attr('href',url);   
                },delay);       
            }
            else if(key == 'user_exist')
            {
              $(".signup .message.error").html("<div class='flash error'>"+val+"</div>");
            }
            else if(key == 'error')
            {
                if(val.address) {
                    $(".signup .error_address").show();
                    $(".signup .error_address").html(val.address);
                }
                // $(".signup .message.error").html("<div class='flash error'>The Property Name already exist</div>");
                if(val.email)
                {
                    $(".signup .error_email").show();
                    $(".signup .error_email").html(val.email);              
                }
            }
          });
          $(".loading-spinner").hide();
        },
        error: function()
        {   
          $(".signup .message.error").html("<div class='flash error'>Invalid Email Id or Password.</div>");    
          $(".loading-spinner").hide();
        }

      });
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

  var userip;  

});
  </script>
  <script type="text/javascript" src="https://l2.io/ip.js?var=userip"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    var country_code = null;
    // console.log("User IP :"+userip);
    $.getJSON('http://ipinfo.io/' + userip, function(data){
      country_code = data.country;
      // console.log("Country Code :"+country_code);

      var random_number = Math.floor(1000 + Math.random() * 9000);
      // console.log("Random Number :"+random_number);
      
      var site_code = country_code+"@"+random_number;
      // console.log("site_code :"+site_code);
    });

    // $('#calendar').fullCalendar({
    //   header: {
    //     left: 'prev,next today',
    //     center: 'title',
    //     right: 'month,basicWeek,basicDay'
    //   },
    //   // defaultDate: '2016-01-12',
    //   editable: false,
    //   eventLimit: true // allow "more" link when too many events
    // });

  });
  </script>
</body>
</html>
