
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Staff Management <small>Listing</small></h3>
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
                            <h2>Daily active staffs <small>Grid List</small></h2>
                      
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                        <div class="form-group">
                        <?php if($this->session->flashdata('flash_message')){
                            echo "<div class='flash success'>".$this->session->flashdata('flash_message')."</div>";
                        } ?>
                        <?php if($this->session->flashdata('flash_error')){
                            echo "<div class='flash error'>".$this->session->flashdata('flash_error')."</div>";
                        } ?>
                        </div>
                            <div class="row">

                            <?php
                            if (!empty($organization_info))
                            {
                     
                              foreach ($organization_info as $key=>$row)
                              { ?>
                              <?php 
                              $address = "";
                              $address.=($row['address']!="") ? $row['address'] : '';
                              $address.=($row['city']!="") ? ", ".$row['city'] : '';
                              $address.=($row['state']!="") ? ", ".$row['state'] : '';
                              $address.=($row['pincode']!="") ? " - ".$row['pincode'] : '';

                              ?>                          
                                <div class="col-md-4 col-sm-4 col-xs-12 animated fadeInDown">
                                    <div class="well profile_view">
                                        <div class="col-sm-12">
                                            <div class="left col-xs-7">
                                                <h2><?php echo $row['first_name']." ".$row['middle_name']." ".$row['last_name']; ?></h2>

                                                <p><strong>Gender: </strong> <?php echo $row['gender']; ?> </p>
                                                <?php if($row['about'] != "") { ?>
                                                <p><strong>About: </strong> <?php echo $row['about']; ?> </p>
                                                <?php } ?>
                                                
                                            </div>
                                            <div class="right col-xs-5 text-center">
                                            <?php if($row['image'] != "")
                                                    $email_src = base_url().$this->config->item('upload_staff_abs').$this->session->userdata['logged_in']['super_admin_id']."/".$row['image'];
                                                else
                                                    $email_src = base_url('images/img/user.png');
                                            ?>
                                                <img src="<?php echo $email_src ?>" alt="" class="img-circle img-responsive">
                                            </div>
                                            <div class="col-xs-12">
                                                <ul class="list-unstyled">
                                                    <li><i class="fa fa-home"></i> <?php echo $address; ?></li>
                                                    <li><i class="fa fa-envelope"></i> <?php echo $row['email']; ?></li>
                                                    <li><i class="fa fa-phone"></i> <?php echo $row['mobile']; ?> </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 bottom text-center">
                                            <div class="col-xs-12 col-sm-5 emphasis">
                                                <?php if($row['is_active'] == true) {
                                                    echo '<strong>Active </strong><div class="label label-success">✓</div>';
                                                } else {
                                                    echo '<strong>InActive </strong><div class="label label-danger">✘</div>';
                                                } ?>
                                               
                                            </div>
                                            <div class="col-xs-12 col-sm-7 emphasis">
<!--@mkcode change -->
<a href="<?php echo site_url('organization/show_admin_info/'.$row['id']); ?>" class="btn btn-success btn-xs" title="Show"><i class="fa fa-info-circle"></i></a>

<a href="<?php echo site_url('organization/edit_admin_info/'.$row['id']); ?>" type="button" class="btn btn-info btn-xs" title="Edit"> <i class="fa fa-user"></i> Edit Profile </a>
<!--@mkcode change  end-->
<a href="<?php echo site_url('staff/delete/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Do you want to permanent delete this staff member?')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div> <!-- well profile_view -->
                                </div>

                            <?php } 
                            }
                            else
                            { 
                                echo '<div class="col-md-12"><div class="alert alert-danger alert-dismissible fade in no-data">No record found!!</div></div>';
                            } ?>
                            </div> <!-- row -->
                        </div>
                    </div>
                </div>

                <br />
                <br />
                <br />

            </div>
        </div>
            <!-- footer content -->