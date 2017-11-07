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
                <a href="http://52.88.242.243/">
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
                    <div class="col-md-8 col-md-8 col-xs-12 footer-lefts">
                    <h4>Updates your Account</h4>
                    <p>Stay on top of MyDay by receiving regular updates from our platform. We’re constantly looking for newer and more exciting ways to make your day easier. The MyDay newsletter will keep you up-to-date!</p>   
                    <form class="update-form" method="post">
                        <h4>Payment Information </h4>
                       <input type="text" class="form-control" placeholder="Amount " name='amount' required/> 
                        <input type="text" class="form-control" placeholder="Description " name='description' required/>
                        <h4>Billing Information </h4>
                        <input type="email" class="form-control" placeholder="email " name='email' required/>
                        <input type="text" class="form-control" placeholder="Phone Number " name='phonenum' required/>
                        <input type="text" class="form-control" placeholder="First Name" name='firstname' required/>
                        <input type="text" class="form-control" placeholder="Middle Name" name='middlename' />
                        <input type="text" class="form-control" placeholder="Last Name" name='lastname' required/>
                        <input type="text" class="form-control" placeholder="Street" name='street' required/>
                        <input type="text" class="form-control" placeholder="City" name='city' required/>
                        <input type="text" class="form-control" placeholder="State" name='state' required/>
                        <input type="text" class="form-control" placeholder="zip" name='zip' required/>
                        <input type="text" class="form-control" placeholder="country" name='country' required/>
                        <h4>Card Details </h4>
                        <input type="text" class="form-control" placeholder="credit card" name='credit_card' required/>
                       <!--  <input type="text" class="form-control" placeholder="authcode" name='authcode' required/> -->
                        <input type="text" class="form-control" placeholder="CSV Number " name='cvv2' required/>
                      
                        <?php
                        echo "<select name=month>";
                        for($i=0;$i<=11;$i++){
                        $month=date('m',strtotime("first day of -$i month"));
                        echo "<option value='$month'>$month</option> ";
                        }
                        echo "</select>";
                        echo "<select name=year>";
                        for($i=0;$i<=10;$i++){
                        $year=date('Y',strtotime("last day of +$i year"));
                        $small=date('y',strtotime("last day of +$i year"));
                        echo "<option value='$small'>$year</option>";
                        }
                        echo "</select>";
                        ?> 
                        <input class="btn btn-primary dark-blue" type='submit' name="subscription" value="Add">
                      
                    </form>
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
    </style>
  
</body>
</html>
