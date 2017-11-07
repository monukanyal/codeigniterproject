
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
    <link rel="stylesheet" type="text/css" href="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/css2/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/css2/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" href="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/css2/animation-effects.css" />
    <link rel="stylesheet" type="text/css" href="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/css2/custom.css" />
    <link rel="stylesheet" type="text/css" href="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/css2/jquery.fullPage.css" />
    <style>
        .done
        {
        background:url(images/pass.png) no-repeat scroll left center rgba(0, 0, 0, 0);
        float: left;
        margin: 8px 0 0;
        padding: 0 0 0 22px;
         color:purple;
        }
        #accountForm .form-group label {
          display: block;
          text-align: left;
          font-weight: normal;
          font-size: 16px;
        }
        .thankyou_page .copyright-sec {
          margin-top: 44px !important;
          position: fixed;
          bottom: 0;
          width: 100%;
          /* z-index: -1; */
        }
        #email_error{
          display: none;
          text-align: left;
          font-size: 13px;
          margin-top: 3px;
          float: left;
          width: 100%;
          color: red;
        }
        #passwordd_error{
          display: none;
          text-align: left;
          font-size: 13px;
          margin-top: 3px;
          float: left;
          width: 100%;
          color: red;
        }
        #new_password_error{
          display: none;
          text-align: left;
          font-size: 13px;
          margin-top: 3px;
          float: left;
          width: 100%;
          color: red;
        }
        #success_message{
          display: none;
          color: red;
        }
    </style>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body class="thankyou_page">
<section class="top-section">
        <header class="header" id="header">
            <div class="container">
                <div class="pull-left logo-section">
                    <a href="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/">
                 <img src="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/images2/logo.png" class="img-responsive">
                  </a>
                </div>
                <div class="pull-right nav-sec">
                <ul class="social-sec">
                <li>
                    <label>Available</label>
                </li>
                <li>
                    <a href="">
                    <img src="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/images2/apple.png">
                    </a>
                </li>
                <li>
                    <a href="">
                        <img src="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/images2/play.png">
                    </a>
                </li>
                </ul>
                <nav class="navbar navbar-default">
                    <div class="navbar-header">
                        <button aria-expanded="false" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                  <!--   <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="#">Home</a></li>
                            <li><a href="#carousel-top">Features</a></li>
                            <li><a href="#footer">Contact</a></li>
                                                        <li class="page-scroll"><a data-target="#myModal" data-toggle="modal">Sign In</a></li>         
                                                        </ul>
                        </div> -->
                    </nav>
                    </div>
                </div>
            </header>
            </section>
<section class="thank-section">
  <div class="container">
  <div class="row">
  <div class="col-md-12">
  <div class="thankyou_outer">
    <div class="heading">
      <h2>Thank you for Connect Update your New Password</h2>
       </div>
        <form role="form" id="accountForm">
 <div class="form-group">
    <label for="pwd">Email:</label>
    <input type="email" class="form-control" name="email" id="email"  placeholder="Enter your email Id!">
    <span id="email_error">Please enter your Valid login email_id</span>
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" name="password" id="pwd" placeholder="Enter your password here!">
    <span id="passwordd_error">Enter your previous password!</span>
  </div>
   <div class="form-group">
    <label for="pwd">New Password:</label>
    <input type="password" class="form-control" name="new_password" id="password" placeholder="Enter new password here!">
     <span id="new_password_error">Enter your New password!</span>
  </div>
  <button type="button" class="btn btn-default" name="update" id="update" value="update">Update</button>
  <span id="success_message">Your password Update successfully!</span>
</form>
</div>
</div>
</div>
</section>
<!-- footer here -->
<footer class="copyright-sec">
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
                </footer>
</body>

<script>
$(function(){
  $("#update").click(function(e){

      var client_email = $("#email").val();

       if (client_email.trim().length==0){
          $("#email_error").show();
          return false;
        }
         var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(re.test(client_email)==false)
    {
      $("#email_error").show();
      return false;
    }
        else{
          $("#email_error").hide(200);
        }

      var old_password = $("#pwd").val();

       if (old_password.trim().length==0){
          $("#passwordd_error").show();
          return false;
        }
        else{
          $("#email_error").hide(200);
        }

        var New_password = $("#password").val();

          if (New_password.trim().length==0){
          $("#new_password_error").show();
          return false;
        }
        else{
          $("#new_password_error").hide(200);
        }

    $.ajax({
       url:'http://www.yourday.io/index.php/Password_rest/Update_password',
       type: 'POST',
       data: $("#accountForm").serialize(),
       success: function(){
           $('#success_message').show();

        /* $('#name').val('');
           $('#company').val('');
           $('#jobtitle').val('');
           $('#address').val('');
           $('#city').val();
           $('#country').val();
           $('#Correspondence_address').val();
           $('#Correspondence_code').val();
           $('#Correspondence_city').val();
           $('#Correspondence_country').val();*/
          // window.location.href = "<?php //echo site_url('DashboardCntrl/open_account'); ?>";
       },
       error: function(){
           alert("Fail")
       }
   });
   e.preventDefault();
 });
});
</script>