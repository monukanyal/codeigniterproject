<?php
    $admin_id = $this->session->userdata['logged_in']['super_admin_id'];
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Site Admin Management <small>Listing</small></h3>
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
                            <h2>Daily active site admins <small>Grid List</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.open('<?php echo site_url().'/organization/add'; ?>');" class="btn btn-info btn-xs">Add New</button></li>
                                <li><a href="#"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a href="#"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
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
                        <?php
                        if (!empty($organization))
                            echo '<table id="example" class="table table-striped responsive-utilities jambo_table">';
                        else
                            echo '<table class="table table-striped responsive-utilities jambo_table">';
                        ?>
                            
                                <thead>
                                    <tr class="headings">
                                        <th>
                                            <input type="checkbox" class="tableflat">
                                        </th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Property Name</th>
                                        <th>Status </th>
                                        <th>Number <br/> of users</th>
                                        <th>Number <br/> of staff</th>
                                        <th>Last Login<br/> Time</th>
                                        <th class=" no-link last"><span class="nobr">Action</span></th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if (!empty($organization))
                                    {
                                      foreach ($organization as $key=>$row)
                                      { 

                                      ?>
                                    <tr class="even pointer">
                                        <td class="a-center ">
                                            <input type="checkbox" class="tableflat">
                                        </td>
                                        <td class=" "><?php echo $row['first_name'].' '.$row['middle_name'] .' '. $row['last_name']; ?></td>
                                        <td class=" "><?php echo $row['email'];?></td>
                                        <td class=" "><?php echo $row['address'] ?></td>
                                <?php if($row['is_active']==1) { ?>
                                <td class="is_active_field boolean_type" title="Active"><span class="label label-success">✓</span></td>
                                <?php } else { ?>
                                <td class="is_active_field boolean_type" title="InActive"><span class="label label-danger">✘</span></td>
                                <?php } ?>

                        <?php 
                        $admin_id = $row['id'];
                        $results_no_user = $this->organization_model->getTotalusers($admin_id); 
                        $results_no_staff = $this->organization_model->getTotalstaff($admin_id); 

                        ?>

                                <td><?php echo count( $results_no_user); ?></td>
                                <td><?php echo count( $results_no_staff); ?></td>
                                <td><?php echo $row['logtime'] ?></td>
                                         <td class=" last">
                                            <a href="<?php echo site_url('organization/show/'.$row['id']); ?>" class="btn btn-primary btn-xs" title="Show"><i class="fa fa-info-circle"></i></a>
                                            <a href="<?php echo site_url('organization/edit/'.$row['id']); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href="<?php echo site_url('organization/delete/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Do you want to permanent delete this user member?')"><i class="fa fa-trash"></i></a>
                                         <!--    <a href="<?php //echo site_url('organization/delete/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Do you want to permanent delete this meal?')"><i class="fa fa-trash"></i></a> -->
                                        </td>
                                        <td ><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm<?php echo $row['id'];?>"> Sign In </button></td>
                                        <div class="modal fade bs-example-modal-sm<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel2">Sign In  </h4>
                                                </div>
                                                <div class="modal-body">
                                               <h2>Are you sure login with <?php echo $row['first_name'].' '.$row['middle_name'] .' '. $row['last_name']; ?> Account. </h2>
                                                <section class="login_content">
                                                    <?php //echo form_open('authorize/admin_login_process','class="form-signin"');?> 
                                                    <?php echo form_open('authorize/dashbaord_login','class="form-signin"');?> 
                                                        <form class="form-signin" action="authorize/dashbaord_login" target="_blank">   
                                                        <?php
                                                        echo "<div class='flash error'>";
                                                        if (isset($error)) {
                                                            echo $error;
                                                        }
                                                        echo validation_errors();
                                                        echo "</div>";
                                                        ?>
                                                        <?php if($this->session->flashdata('flash_message')){
                                                            echo "<div class='flash success'>".$this->session->flashdata('flash_message')."</div>";
                                                        } ?>
                                                        <?php if($this->session->flashdata('flash_error')){
                                                            echo "<div class='flash error'>".$this->session->flashdata('flash_error')."</div>";
                                                        } ?>
                                                        <div class="flash success"><?php echo $message;?></div>
                                                        <div style="display:none;" >
                                                        <?php 
                                                        $useremail = $row['email']; 
                                                        $userid = $row['id']; 

                                                        ?>
                                                            <?php echo form_input(array('name'=>'email','type'=>'email','class'=>'form-control','id'=>'email', 'value'=>"$useremail"));?>
                                                        </div>
                                                        <div  style="display:none;">
                                                            <?php echo form_input(array('name'=>'userID','type'=>'text','class'=>'form-control','id'=>'userID', 'value'=>"$userid"));?>
                                                        </div>
                                                 
                                                        <div class="clearfix"></div>
                                                       
                                              
                                                    <!-- form -->
                                                </section>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                
                                                        <?php echo form_submit(array('name' =>'submit','class' =>'btn btn-default submit','value' => 'Log in')); ?>
                                                                                                      
                                                        <?php echo form_close(); ?>
                                                </div>

                                            </div>
                                        </div>
                                </div>
                                    </tr>
                                    <?php } 
                                    }
                                    else
                                    { ?>
                                        <tr><td colspan="11">
                                <div class="col-md-12"><div class="alert alert-danger alert-dismissible fade in no-data">No record found!!</div></div></td></tr>
                                    <?php } ?>
                                    
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <br />
                <br />
                <br />

            </div>
        </div>
            <!-- footer content -->