
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?php echo site_url('Super_dashboard'); ?>" class="site_title"><i class="fa fa-paw"></i> <span>Schedulling App!</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="<?php echo $assets_path;?>images/no_avatar.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Super Admin</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li class="active">
                                    <a href="<?php echo site_url('Super_dashboard'); ?>"><i class="fa fa-home"></i> Home </a>
                                </li>
                                <li>
                                    <a><i class="fa fa-user"></i>Site Admin Management<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo site_url('organization'); ?>">Site Admin List</a>
                                        </li>
                                        <li><a href="<?php echo site_url('organization/add'); ?>">Add Site Admin</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a><i class="fa fa-user"></i> Resident Management <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo site_url('users'); ?>">Residents List</a>
                                        </li>
                                      
                                    </ul>
                                </li>
                                 <li>
                                    <a><i class="fa fa-user"></i> Staff Management <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo site_url('Staffs'); ?>">Staff List</a>
                                        </li>
                                      
                                    </ul>
                                </li>

                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>System</h3>
                            <ul class="nav side-menu">
                                <li>
                                    <a href="<?php echo site_url('allactivity/calendar'); ?>"><i class="fa fa-calendar"></i>Calendar Activity</a>
                                </li>

                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
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
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>