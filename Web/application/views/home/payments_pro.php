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
<body>
<input type="hidden" id="movement_val"/>
        <div class="container-fluid">
        <section class="top-section">
        <header id="header" class="header">
            <div class="container">
                <div class="pull-left logo-section">
                    <a href="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/">
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
            </header>
            </section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-md-12 col-xs-12 footer-lefts ">

                    <h4 class="text-center">Updates your Account</h4>
                    <p class="text-center">Stay on top of MyDay by receiving regular updates from our platform. We’re constantly looking for newer and more exciting ways to make your day easier. The MyDay newsletter will keep you up-to-date!</p>   
                </div>
                <div class="col-md-8">
                  
                    <form action="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/index.php/payments_pro/Set_express_checkout" method="post" class="update-form">
                      
                    <div class="form-row">
                    <div class="row">
                     
                    <div class="col-md-12">
                    <b> Monthly Subscription Details </b>
                        <p> If you pay Monthly, Then Subscription Cost is <b> $100/Month.</b> </p>
                        <input type="hidden" required="" name="amount" placeholder="Amount " class="form-control"> 
                    </div> 
                            
                    </div>
                    </div>
                    <div class="form-row">
                 
                        <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="First Name" name="firstname" required="">
                        </div> 
                                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="row">
                        <div class="col-md-12">
                            <input type="text" required="" name="firstname" placeholder="Middle Name" class="form-control">
                        </div>  
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="row">
                        <div class="col-md-12">
                            <input type="text" required="" name="firstname" placeholder="Last Name" class="form-control">
                        </div>      
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="row">
                        <div class="col-md-12">
                            <input type="text" required="" name="firstname" placeholder="Email" class="form-control">
                        </div>       
                        </div>
                    </div>
                      <div class="form-row">
                        <div class="row">
                          <div class="col-md-12">
                <textarea name="description" placeholder="Description" class="form-control"></textarea>
                       </div> 
                                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="row">
                          <div class="col-md-12">
                            <input type="submit" name="add_submit" class="form-control" value="Subscriber"> 
                        </div>    
                        </div>
                    </div>   
                 </form></div> 
                 <div class="col-md-4">
                 <div class="paypall">
                    <div class="row">
                       <div class="col-md-12 paypall_icon1">
                            <img src="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/images2/paypal_icon.png" alt="">
                        </div>
                            <div class="col-md-12 text-left">
                               <b>
                                New. Faster. Easier.</b>
                                <p>Welcome to the new Paypal checkout!<br>
                                    The security you rely on - now even faster.<br>
                                   It's everything checkout should be.</p>
                           </div>
                                <div class="col-md-12">
                                   <img src="http://ec2-52-40-49-3.us-west-2.compute.amazonaws.com/application/views/includes/assets/images2/wallet-hero.png">
                               </div>

                             </div>
                       </div>  
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
            </div> <!-- Container Fluid -->

    <!-- jQuery -->
    <script src="<?php echo $assets_path; ?>landing/js/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $assets_path; ?>landing/js/bootstrap.min.js"></script>
    <style type="text/css">
     .footer-lefts .form-control {
        background: #e8e8e8;
        border-color: #dedede;
        border-radius: 0;
        box-shadow: none !important;
        padding: 19px 10px;
        width: 100%;
        height: 60px;
        float: left;
        margin-top: 10px;
    }
     .form-row {
     margin: 19px 0px;
        }
    </style>
  
</body>
</html>
