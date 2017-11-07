
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
<a href="<?php echo site_url('dashboard'); ?>" class="site_title"><img src="<?php echo $assets_path;?>images2/logo_dashboard.png" style='height: 95%;'> <span>My Day</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="<?php echo $assets_path;?>images/no_avatar.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <?php $send_data['admin_id'] = $this->session->userdata['logged_in']['admin_id']; 

                            $admininfo = $this->user_model->get_admindata($send_data);
                            echo "<h2>";
                            echo  $admininfo[0]['first_name'];
                            echo  " </h2>";
                            ?>
                          
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3>  <a href="<?php echo site_url('setting/edit/'.$admininfo[0]['id']); ?>">General</a></h3>
                            <ul class="nav side-menu">
                                <li class="active">
                                    <a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-home"></i> Home </a>
                                </li>
                                <li>
                                    <a><i class="fa fa-calendar"></i> Plan Activities <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo site_url('event'); ?>">Activities List</a>
                                        </li>
                                        <li><a href="<?php echo site_url('event/add'); ?>">Add Activities</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a><i class="fa fa-coffee"></i> Plan Meals <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo site_url('meal'); ?>">Meals List</a>
                                        </li>
                                        <li><a href="<?php echo site_url('meal/add'); ?>">Add Meal</a>
                                        </li>
                                        <li><a href="<?php echo site_url('meal/meals_at_a_glance'); ?>">Meals At A Glance</a>
                                        </li>
                                    </ul>
                                </li>
                           </ul>
                        </div>
                        <div class="menu_section">
                            <h3>System</h3>
                            <ul class="nav side-menu">
                                <li>
                                    <a><i class="fa fa-user"></i> Manage Residents <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo site_url('user'); ?>">Residents List</a>
                                        </li>
                                        <li><a href="<?php echo site_url('user/add'); ?>">Add Resident</a>
                                        </li>
                                        <li><a href="<?php echo site_url('user/child_listing'); ?>"> Care Account List</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('calendar_activity/calendar'); ?>"><i class="fa fa-calendar"></i>Manage Calendar</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('manage_event'); ?>"><i class="fa fa-calendar"></i>Manage Activities</a>
                                </li>

                                <li>
                                    <a href="<?php echo site_url('location'); ?>"><i class="fa fa-location-arrow"></i>Manage Locations</a>
                                </li>
                                <li>
                                    <a><i class="fa fa-user"></i> Manage Staff <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo site_url('staff'); ?>">Staffs List</a>
                                        </li>
                                        <li><a href="<?php echo site_url('staff/add'); ?>">Add Staff</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <!-- <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div> -->
                    <!-- /menu footer buttons -->
                </div>
            </div>