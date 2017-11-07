
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
    

    <!--[if IE]>
        <script type="text/javascript">
             var console = { log: function() {} };
        </script>
    <![endif]-->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo $assets_path; ?>js2/bootstrap.min.js"></script>

</head>
<body class="thankyou_page">
<section class="top-section">
        <header class="header" id="header">
            <div class="container">
                <div class="pull-left logo-section">
                    <a href="http://52.88.242.243/">
                 <img src="http://52.88.242.243/application/views/includes/assets/images2/logo.png" class="img-responsive">
                  </a>
                </div>
                <div class="pull-right nav-sec">
                <ul class="social-sec">
                <li>
                    <label>Available</label>
                </li>
                <li>
                    <a href="">
                    <img src="http://52.88.242.243/application/views/includes/assets/images2/apple.png">
                    </a>
                </li>
                <li>
                    <a href="">
                        <img src="http://52.88.242.243/application/views/includes/assets/images2/play.png">
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
                    <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="#">Home</a></li>
                            <li><a href="#carousel-top">Features</a></li>
                            <li><a href="#footer">Contact</a></li>
                                                        <li class="page-scroll"><a data-target="#myModal" data-toggle="modal">Sign In</a></li>         
                                                        </ul>
                        </div>
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
	    <h1>Thank you for your</h1>
	     </div>
	      <img src="http://52.88.242.243/application/views/includes/assets/images2/wallet-hero.png">
             <h1 class="compleated_payment"> <img src="http://52.88.242.243/application/views/includes/assets/images2/right.png">You just completed your payment.</h1>
              <p>Your transaction ID for this payment is: 5498564839839823</p>
               <div class="email"><p>We'll send a confirmation email to</p> <input type="text" required="" name="firstname" placeholder="" class="form-control"></div> 
</div>
</div>
</div>
</section>
<!-- footer here -->
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
</body>
</html>