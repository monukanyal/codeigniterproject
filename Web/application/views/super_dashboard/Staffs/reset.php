
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Staff Management </h3>
                </div>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Change Staff password</small></h2>
                            
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.location='<?php echo site_url('Staffs'); ?>'" class="btn btn-info btn-xs">Staff List</button></li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                                 
              <!-- user information Start from here -->
                         <div id="Show" class="content active">
                            <div class="xskin-user-basic-information">
                              <div class="show-detail">
                                <h3>Change Password information</h3>
                              </div>
                            <form role="form" action="" method="post">
                  <div class="box-body" align="center">
                    <!--<div class="form-group">
                      <label for="exampleInputEmail1">Old Password&nbsp;&nbsp;</label>
                      <input type="password" class="form-control" name="opass" id="opass" placeholder="Enter Old Password">
                    </div>--><br/>
                    <div class="form-group">
                      <label for="exampleInputEmail1">New Passwors&nbsp;&nbsp;</label>
                      <input type="password" class="form-control" name="npass" id="npass" placeholder="Enter New Password ">
                    </div><br/>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer" align="center">
               
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
                                      </div><!-- /user-info -->
                            </div><!-- basic information close -->

                            <div class="clearfix"></div>
                         </div>
                         <!-- user information close from here -->

                          
                        </div>
                    </div>
                </div>
            </div>

        </div>