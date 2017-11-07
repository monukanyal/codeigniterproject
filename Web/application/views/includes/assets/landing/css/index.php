<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Community | Home</title>

    <!-- Bootstrap -->
    <link href="<?php echo $assets_path; ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- font-awsome -->
    <link href="<?php echo $assets_path; ?>landing/css/font-awesome.css" rel="stylesheet">

    <!-- Responsive -->
    <link href="<?php echo $assets_path; ?>landing/css/responsive.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="<?php echo $assets_path; ?>landing/css/fonts.css" rel="stylesheet">

    <!-- custom-css -->
    <link href="<?php echo $assets_path; ?>landing/css/style.css" rel="stylesheet">

  </head>
  <body id="page-top" class="index">

  <!--navigation-start-here-->
  <nav id="site-nav" class = "navbar navbar-default navbar-fixed-top" role = "navigation"> 
    <div class="container">  
      <div class = "navbar-header page-scroll">
        <button type = "button" class = "navbar-toggle" 
           data-toggle = "collapse" data-target = "#example-navbar-collapse">
           <span class = "sr-only">Toggle navigation</span>
           <span class = "icon-bar"></span>
           <span class = "icon-bar"></span>
           <span class = "icon-bar"></span>
        </button>
        <a class = "navbar-brand" href = "#page-top"><img src="<?php echo base_url(); ?>/images/img/logo.png"></a>
      </div>
      <div class = "collapse navbar-collapse pull-right navbar-div" id = "example-navbar-collapse">
        <ul class = "nav navbar-nav">
          <li class = "active"><a href = "#page-top">Home</a></li>
          <li class="page-scroll"><a href = "#feature-section">Features</a></li>          
          <li class="page-scroll"><a href = "#video-section">Video</a></li>
          <li class="page-scroll"><a href = "#pricing-section">Prices</a></li>
          <li class="page-scroll"><a href = "#testimonial-section">Testimonials</a></li>
          <li class="page-scroll"><a href = "#download-section">Download</a></li>
          <li class="page-scroll"><a href = "#contact-section">Contact</a></li>

        <?php if (!isset($this->session->userdata['logged_in'])) { ?>
          <li class="page-scroll"><a href = "javascript:void(0);" data-toggle="modal" data-target="#myModal">Sign In</a></li>          
        <?php } else { ?>
          <li class="page-scroll"><a href = "<?php echo site_url('dashboard');?>">Dashboard</a></li>
        <?php } ?>
        </ul>
      </div>
    </div><!--container-->
  </nav>
  <!--navigation-end-here-->

<!-- Modal -->
<div class="signin modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="text_heading" style="text-align:center;">
        <h3 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Sign In</h3>
        <h5 class="modal-title">Signin to access your account.</h5>
      </div>
      </div>
      <div class="modal-body">
        <div class='message error'></div>        
        <div>
          <div class="error_email message_message" style="display:none;"></div> 
            <?php echo form_input(array('name'=>'email','type'=>'email','class'=>'form-control','id'=>'email','placeholder'=>'Email'));?>
        </div>
        <div>
          <div class="error_password message_message" style="display:none;"></div>
            <?php echo form_input(array('name'=>'password','type'=>'password','class'=>'form-control','id'=>'password','placeholder'=>'Password'));?>
        </div>
        <div class="forgot-pass"><button type="button" class="btn btn-primary" id="sign-in">Sign In</button>
        <a href="<?php echo site_url('authorize/forgot'); ?>">Forgot Password?</a>
        
        <div class="loading-spinner" style="display:none;">
          <img src="<?php echo base_url().'images/img/loading_icon.gif';?>" style="height:45px;">
        </div>
        </div>
        <p class="member-or-not">Not a member? <a href="javascript:void(0);" class="modal_signup">Sign Up</a></p>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="signup modal fade" id="firstModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="text_heading" style="text-align:center;">
        <h3 class="modal-title" id="myModalLabel"><i class="fa fa-unlock"></i> Sign Up</h3>
        <h5 class="modal-title">Signup to create your account.</h5>
      </div>
      </div>
      <div class="modal-body">
        <div class='message error'></div>        
        <div>
          <div class="error_first_name message_message" style="display:none;"></div> 
            <?php echo form_input(array('name'=>'first_name','type'=>'email','class'=>'form-control','id'=>'signup_first_name','placeholder'=>'First Name'));?>
        </div>       
        <div>
          <div class="error_email message_message" style="display:none;"></div> 
            <?php echo form_input(array('name'=>'email','type'=>'email','class'=>'form-control','id'=>'signup_email','placeholder'=>'Email'));?>
        </div>
        <div>
          <div class="error_password message_message" style="display:none;"></div>
            <?php echo form_input(array('name'=>'password','type'=>'password','class'=>'form-control','id'=>'signup_password','placeholder'=>'Password'));?>
        </div>
        <div>
          <div class="error_password_confirmation message_message" style="display:none;"></div>
            <?php echo form_input(array('name'=>'password_confirmation','type'=>'password','class'=>'form-control','id'=>'signup_password_confirmation','placeholder'=>'Password Confirmation'));?>
        </div>
        <div class="forgot-pass"><button type="button" class="btn btn-primary" id="sign-up">Sign Up</button>
        
        <div class="loading-spinner" style="display:none;">
          <img src="<?php echo base_url().'images/img/loading_icon.gif';?>" style="height:45px;">
        </div>
        </div>
        <p class="member-or-not">Already a member? <a href="javascript:void(0);" class="modal_signin">Sign In</a></p>
      </div>
    </div>
  </div>
</div>

  <!--header-start-here-->
  <header id="site-header">
    <div id="myCarousel" class="carousel slide site-header" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- <a class="slider-bg" href="#"><img src="img/slider-bg.jpg"></a> -->

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="carousel-caption container">
                  <div class="slider-content">
                    <div class="slider-left-col col-lg-9 col-md-9 col-sm-9">
                      <h2>Convenient Scheduling, Systemized Reminders,
                       <span> Automated Peace of Mind</span></h2>
                      <h4>
                        With the MyDay app and scheduling platform, it has never been so<br/> 
                        easy to plan your day, week or month, ensure you don’t miss events <br/> 
                        you’d like to attend and make sure your loved ones make sure <br/> 
                        your loved ones know that you have been busy. <br/> 
                     
                        Start living your day based on YOUR schedule. Participate in  <br/> 
                        activities as they fit your schedule, not the other way around.<br/>  Get the most out of life!
                      </h4>

                      <a class="download-btn" href="#">Download</a>
                      <ul class="available-ul">
                        <li>Aavailable on :</li>
                        <li><a href="#"><i class="fa fa-apple"></i></a></li>
                        <li><a href="#"><i class="fa fa-android"></i></a></li>
                      </ul>
                    </div><!--slider-left-col-->
                    <div class="slider-right-col col-lg-3 col-md-3 col-sm-3">
                      <a href="#"><img src="<?php echo base_url(); ?>/images/img/slider-img.png"></a>
                    </div><!--col-->
                  </div>
                </div>
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="carousel-caption container">
                  <div class="slider-content">
                    <div class="slider-left-col col-lg-9 col-md-9 col-sm-9">
                      <h1>Sit back and relax,<span> on auto-pilot</span></h1>
                      <h4>
                        Automate your schedule of events through our seamless scheduling system. <br/> 
                        Don’t worry about others micromanaging your life. Once events <br/> 
                        and activities are listed, take advantage of those that <br/>
                        best fit based on your wants and time availability.
                  
                      </h4>
                      <a class="download-btn" href="#">Download</a>
                      <ul class="available-ul">
                        <li>Aavailable on :</li>
                        <li><a href="#"><i class="fa fa-apple"></i></a></li>
                        <li><a href="#"><i class="fa fa-android"></i></a></li>
                      </ul>
                    </div><!--slider-left-col-->
                    <div class="slider-right-col col-lg-3 col-md-3 col-sm-3">
                      <a href="#"><img src="<?php echo base_url(); ?>/images/img/slider-img.png"></a>
                    </div><!--col-->
                  </div>
                </div>
            </div>
            <div class="item">
                <!-- Set the third background image using inline CSS below. -->
                <div class="carousel-caption container">
                  <div class="slider-content">
                    <div class="slider-left-col col-lg-9 col-md-9 col-sm-9">
                      <h1>Simple, Beautiful <span>and Amazing</span></h1>
                      <h4>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eget<br/> 
                        ullamcorper. Nam porttitor ullamcorper felis at convallis.<br/> 
                        fringilla lacinia. Nullam pulvinar sollicitudin velit.
                      </h4>
                      <a class="download-btn" href="#">Download</a>
                      <ul class="available-ul">
                        <li>Aavailable on :</li>
                        <li><a href="#"><i class="fa fa-apple"></i></a></li>
                        <li><a href="#"><i class="fa fa-android"></i></a></li>
                      </ul>
                    </div><!--slider-left-col-->
                    <div class="slider-right-col col-lg-3 col-md-3 col-sm-3">
                      <a href="#"><img src="<?php echo base_url(); ?>/images/img/slider-img.png"></a>
                    </div><!--col-->
                  </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a> -->

    </div>
  </header>
  <!--header-end-here-->

  <!--feature-start-here-->
  <section id="feature-section">
    <div class="container">
      <div class="feature-section">
        <div class="feature-head text-center">
          <h2>Event Scheduling</h2>
          <h3>What do you have scheduled next Tuesday? </h3>
          <p>Never miss an opportunity again. MyDay takes all of the difficulty out of scheduling events, to make sure you make the fullest of the opportunities made available. Our scheduling platform allows for:</p>
          <span><img src="<?php echo base_url(); ?>/images/img/feature-head-img.png"></span>
        </div><!--feature-head-->
        <div class="feature-box-col">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="feature-box-inner text-center">
                <span><img src="<?php echo base_url(); ?>/images/img/icon-1.png"></span>
                <h3>Instantaneous Listings</h3>
                <p>Immediate event listing and availability updates so residence are instantly notified of new events.</p>
              </div>
            </div><!--col-->
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="feature-box-inner text-center">
                <span><img src="<?php echo base_url(); ?>/images/img/icon-2.png"></span>
                <h3>Ease-of-use</h3>
                <p>Easy event navigation and scheduling, at your fingertips, making event registration more convenient.</p>
              </div>
            </div><!--col-->
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="feature-box-inner text-center">
                <span><img src="<?php echo base_url(); ?>/images/img/icon-3.png"></span>
                <h3>Systemized Reminders</h3>
                <p>Itinerary reminders and change notifications to keep residence up-to-date on all of the community events!</p>
              </div>
            </div><!--col-->
          </div><!--row-->
        </div><!--feature-box-col-->
      </div><!--container-->
    </div><!--container-->
    <div class="feature-bottom-div">
      <img src="<?php echo base_url(); ?>/images/img/feature-bottom-img.png">
    </div><!--feature-bottom-div-->
  </section>
  <!--feature-end-here-->

  <!--video-start-here-->
  <section id="video-section">
    <div class="video-section">
      <div class="video-col">
        <!-- <video width="100%" height="550" controls>
          <source src="movie.mp4" type="video/mp4">
          <source src="movie.ogg" type="video/ogg">
          Your browser does not support the video tag.
        </video> -->
      </div><!--video-col-->
      <div class="video-content text-center">
        <div class="container">
          <span class="video-icon"><a href="#"><img src="<?php echo base_url(); ?>/images/img/video-icon.png"></a></span>
          <h1>Watch the best Technology in Action</h1>
          <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eget nunc vitae tellus<br/> luctus ullamcorper. Nam porttitor ullamcorper felis at convallis. Aenean ornare vestibulum<br/> nisi fringilla lacinia. Nullam pulvinar sollicitudin velit id laoreet. Quisque non rhoncus sem.</h4>
        </div>
      </div><!--video-content-->
    </div><!--video-section-->
  </section>
  <!--video-end-here-->


  <!--pricing-start-here-->
  <section id="pricing-section">
    <div class="container">
      <div class="pricing-head text-center">
        <h2>Everyone’s Schedule In One Place</h2>
        <h3>Keep your residence scheduled without burdening staff and family members. 
            Get your community started today – for free.</h3>
      </div>
      <div class="pricing-trial-col">
       
 
        <div class="col-sm-12">
          <div class="pricing-rgt-col">
            <div class="pricing-trial-box">
    
              <ul class="pricing-ul">
                <li><a href="#"><img src="<?php echo base_url(); ?>/images/img/pricing-list-icon.png"> Post Events</a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>/images/img/pricing-list-icon.png"> Update Schedules </a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>/images/img/pricing-list-icon.png"> Provide reminders </a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>/images/img/pricing-list-icon.png"> Check attendance </a></li>
              </ul>

              
            </div><!--pricing-trial-box-->
            <div class="text-center">
              <br>
            <a class="dwn-btn modal_signup" href="javascript:void(0);">Start Our Free Trial</a></div>
          </div>
        </div><!--col-->
      </div><!--pricing-trial-col-->
    </div><!--container-->
  </section>
  <!--pricing-end-here--> 

  <!--twitter-start-here-->
  <section id="testimonial-section">
    <div class="container-fiuld clearfix">
       <div class="col-sm-6 no-padding ">
           <blockquote class="social-twitts back">
                  <h2>Reminders</h2>
                  <h4>What medicines do I need to take today? When? Have I taken them?</h4>
                  <small>- MyDay is there for me! </small>
                  <p>Keeping track of medications and other events can be burdensome. You don’t want to be inconvenienced with remembering if you’ve taken your medication or when you need to take it again. MyDay takes care of this for you. One-time programing your medication schedule allows automated reminders and others to be able to help with making sure your on schedule.</p>
                  <div class="text-center"><img src="<?php echo base_url(); ?>/images/img/twitter-icon.png"></div>
                </blockquote>


       </div>
          <div class="col-sm-6 no-padding ">
           <blockquote class="social-twitts">
                  <h2>Peace of Mind</h2>
                  <h4>I worry too much? My loved ones worry too much about me?</h4>
                  <small>- MyDay is there for me and my family! </small>
                  <p>Your loved ones want to know that you’re staying active and keeping healthy but it’s a hassle for them to constantly call you to make sure. Now they don’t have to, it’s easy as connecting to our scheduling platform to see it.</p>
                <div class="text-center"><img src="<?php echo base_url(); ?>/images/img/twitter-icon.png"></div>
                </blockquote>


       </div>
       
    </div>
  </section>
  <!--twitter-end-here-->


  <!--dopwnload-start-here-->
  <section id="download-section">
    <div class="container">
      <div class="download-inner-col">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="download-lft-col">
               <h2>Easy Accessibility- Connect by computer or phone</h2>
              <p>Connect anytime, anywhere. Access individual residence and master schedules directly from a computer or phone. Appointment reminders go straight to residence by notification, text message or email. </p>
              <ul class="download-btn-ul">
                <li><a href="#"><img src="<?php echo base_url(); ?>/images/img/app-store-img.png"></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>/images/img/google-play-img.png"></a></li>
                <li><a class="dwn-btn" href="#">Download Now</a></li>
              </ul>
              
            </div><!--download-lft-col-->
          </div><!--col-->
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="download-rgt-col">
              <span><img src="<?php echo base_url(); ?>/images/img/iphone_hand-img.png"></span>
            </div>
          </div><!--col-->
        </div><!--row-->
      </div><!--download-inner-col-->
    </div><!--container-->
  </section>
  <!--dopwnload-end-here-->


  <!--subscribe-start-here-->
  <section id="subscribe-section">
    <div class="container">
      <div class="col-lg-7 col-md-7 col-sm-7">
        <div class="subscribe-lft-col">
          <h2> Get Our Updates </h2>
          <p>Stay on top of MyDay by receiving regular updates from our platform. We’re constantly looking for newer and more exciting ways to make your day easier. The MyDay newsletter will keep you up-to-date! </p>
          <div class="submit-form">
            <form>
              <input type="text" placeholder="Enter Your Email">
              <a class="submit-btn" href="#">Submit</a>
            </form>
          </div>
        </div>
      </div><!--col-->
      <div class="col-lg-5 col-md-5 col-sm-5">
        <div class="subscribe-rgt-col">
          <span><img src="<?php echo base_url(); ?>/images/img/subscribe-img.png"></span>
        </div>
      </div>
    </div><!--container-->
  </section>
  <!--subscribe-end-here-->

  <!--contact-start-here-->
  <section id="contact-section">
    <div class="container">
      <div class="contact-head text-center">
        <h2>Contact</h2>
      </div>
      <div class="contact-form-col">
        <form>
          <div class="form-group">
              <input type="text" class="form-control" id="inputname" placeholder="ENTER YOUR Name">
          </div>
          <div class="form-group">
              <input type="email" class="form-control" id="inputEmail" placeholder="ENTER YOUR EMAIL">
          </div>
          <div class="form-group">
              <input type="text" class="form-control" id="inputWebsite" placeholder="ENTER YOUR Website">
          </div>
          <div class="form-group textarea">
              <textarea placeholder="Message..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      </div>
    </div><!--container-->
  </section>
  <!--contact-end-here-->

  <!--footer-start-here-->
  <footer id="site-footer">
    <div class="container">
      <div class="col-sm-6 col-xs-12">
        <div class="footer-lft-col">
          <span><img src="<?php echo base_url(); ?>/images/img/footer-logo.png"></span>
          <p><span>Community App</span> © 2016 All Rights Reserved</p>
        </div>
      </div><!--col-->
      <div class="col-sm-6 col-xs-12">
        <div class="footer-rgt-col">
          <ul class="footer-social-ul">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
          </ul>
        </div>
      </div><!--col-->
    </div>
  </footer>
  <!--footer-end-here-->










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

    $(document).on("click",".modal_signin",function(evented){
      $('.modal').modal('hide');
      $('#myModal').modal('show');
    });
    $(document).on("click",".modal_signup",function(evented){
      $('.modal').modal('hide');
      $('#firstModal').modal('show');
    });

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
        dataType: "json",
          
        success: function(response) //we're calling the response json array 'cities'
        {     
          $.each(response, function(key, val) {     
            if(key == 'success')
            {
              //console.log(val); 
              var url = "<?php echo site_url('dashboard');?>";    
              $(location).attr('href',url);         
            }
            else
            {
              if(val.email)
              {
                $(".signin .error_email").show();
                $(".signin .error_email").html(val.email);              
              }
              
            }
          });
          $(".loading-spinner").hide();
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
    $(".signup .error_password").hide();
    $(".signup .error_password_confirmation").hide();
    $(".signup .error_message").html("");

    var form_first_name = $("#signup_first_name").val();
    var form_email = $("#signup_email").val();
    var form_password = $("#signup_password").val();
    var form_password_cn = $("#signup_password_confirmation").val();
        
    if(form_first_name == "")
    {
      $(".signup .error_first_name").show();
      $(".signup .error_first_name").html("The First Name field is required!");
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

    if (form_first_name != "" && form_email != "" && form_password != "")
    {
      $(".loading-spinner").show();
      var post_data = {
        'first_name' : form_first_name,
        'email' : form_email,
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
          // console.log(response);
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
            else
            {
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
});
  </script>
  </body>
</html>