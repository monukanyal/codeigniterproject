<?php
    $data_feed = array(
            "admin_id" => $this->session->userdata['logged_in']['admin_id'],
            "admin_email" => $this->session->userdata['logged_in']['admin_email']
        );
    $user_info = $this->user_model->get_userinfo($data_feed);
?>
            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo $assets_path;?>images/no_avatar.jpg" alt="">
                                        <?php
                                        if($this->session->userdata('logged_in'))
                                         echo $user_info['first_name']; 
                                        else
                                            echo "Admin";

                                         ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="<?php echo site_url('profile/index/'.$user_info['id']); ?>">  Profile</a>
                                    </li>
                                    <li>
                                        <!-- <a href="javascript:;">
                                            <span class="badge bg-red pull-right">50%</span>
                                            <span> --><!-- </span> -->
                                            <a href="<?php echo site_url('setting/edit/'.$user_info['id']); ?>"> Profile Settings</a> 
                                    </li>
                                    <!-- <li>
                                        <a href="javascript:;">Help</a>
                                    </li> -->
                                    <li><a href="<?php echo site_url('authorize/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>

                            <li role="presentation" class="dropdown">
                            <?php 
                                //@mkcode start

                            if($this->session->userdata['logged_in']['user_type']=='admin') {
                                $admin_id=$this->session->userdata['logged_in']['admin_id'];
                               // echo "admin_id:".$admin_id;
                                 $num=$this->user_model->get_newcareadd_app($admin_id);
                                ?>
                                <a href="<?php echo site_url('/user/child_listing'); ?>" class="dropdown-toggle info-number"  aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                     <span class="badge bg-green"><?php  echo $num; ?></span>
                                </a> 
                                <?php } 
                                // @mkcode end
                                ?>
                                <!--<ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="<?php echo $assets_path;?>images/no_avatar.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="<?php echo $assets_path;?>images/no_avatar.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="<?php echo $assets_path;?>images/no_avatar.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="<?php echo $assets_path;?>images/no_avatar.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where... 
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong><a href="inbox.html">See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>-->
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->