
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Location Management <small>Detail of Location - "<?php echo $location_info['name'];?>"</small></h3>
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
                            <h2>Show Location</small></h2>
                            
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.location='<?php echo site_url('location'); ?>'" class="btn btn-info btn-xs">Location List</button></li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                                 
              <!-- location information Start from here -->
                         <div id="Show" class="content active">
                            <div class="xskin-user-basic-information">
                              <div class="show-detail">
                                <h3>Basic information</h3>
                            <div class="form-group">
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Name
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $location_info['name']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Is Active
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php if($location_info['is_active'] == true) {
                                        echo '<div class="label label-success">✓</div>';
                                    } else {
                                        echo '<div class="label label-danger">✘</div>';
                                    } ?>
                                  </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Created At
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo mdate('%d %M %Y %h:%i %A',strtotime($location_info['logtime'])); ?>
                                  </span>
                                </div>
                            </div>

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