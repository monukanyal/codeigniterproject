<!DOCTYPE html>

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Community | <?php echo $title; ?></title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $assets_path; ?>css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo $assets_path; ?>fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $assets_path; ?>css/animate.min.css" rel="stylesheet">
    <!-- My custom CSS -->
    <link href="<?php echo $assets_path; ?>css/admin.css" rel="stylesheet">
    <!--glance style-->
    <link href="<?php echo $assets_path; ?>style.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="<?php echo $assets_path; ?>css/custom.css" rel="stylesheet">
    <link href="<?php echo $assets_path; ?>css/icheck/flat/green.css" rel="stylesheet">
    <link href="<?php echo $assets_path; ?>css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">

    <?php 
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        if(isset($css) && !empty($css))
        {
            foreach($css as $css_val)
                echo "<link href='".$assets_path."css/".$css_val."' rel='stylesheet'>\n";
        }

    ?>
    <?php if(isset($cur_controller_method) && $cur_controller_method == 'calendar') { ?>
<link href='<?php echo $assets_path; ?>fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo $assets_path; ?>fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <?php 
        if(isset($js_header) && !empty($js_header))
        {
            foreach($js_header as $js_val)
            {
                $jss = $assets_path."/".$js_val;

                echo '<script src="'.$jss.'"></script>';
                echo "\n";
            }
           
        }
    } else { ?>
        <script src="<?php echo $assets_path; ?>js/jquery.min.js"></script>
    <?php } ?>
    <!--29 march 2017 added-->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href='<?php echo $assets_path; ?>jquery.datetimepicker.css' rel='stylesheet' />

    <!-- added -->

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body class="nav-md">

    <div class="container body">


        <div class="main_container">