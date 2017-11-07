
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3><?php echo $user_info[0]['first_name'];?> Profile</h3>
                </div>
                
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel"
              <!-- user information Start from here -->
                         <div id="Show" class="content active">
                            <div class="xskin-user-basic-information">
                              <div class="show-detail">
                                <h3>Profile information</h3>
                            <div class="form-group">
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Name
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $user_info[0]['first_name']." ".$user_info[0]['last_name']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Email
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                     <?php echo $user_info[0]['email']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Address
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $user_info[0]['address']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    City
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $user_info[0]['city']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    State
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $user_info[0]['state']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Pin Code
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $user_info[0]['pincode']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Mobile
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $user_info[0]['mobile']; ?>
                                  </span>
                                </div>
                            </div>
                            
                               
                            </div>
                          

                            <div class="clearfix"></div>
                         </div>
                         <!-- user information close from here -->

                          
                        </div>
                    </div>
                </div>
            </div>

        </div>