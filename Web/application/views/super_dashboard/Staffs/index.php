
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
                            <h2>Daily active Staff <small>Grid List</small></h2>&nbsp;&nbsp;
                         <!-- <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Send Message </button> -->

                            <ul class="nav navbar-right panel_toolbox">
                                <!---<li><button onClick="window.open('<?php// echo site_url().'/Staff/add'; ?>');" class="btn btn-info btn-xs">Add New</button></li>-->
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
                        if (!empty($arrUser))
                            echo '<table id="example" class="table table-striped responsive-utilities jambo_table">';
                        else
                            echo '<table class="table table-striped responsive-utilities jambo_table">';
                        ?>
                            <thead>
                                <tr class="headings">
                                    <th><input type="checkbox" class="tableflat"></th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Property Name</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <!--<th>Pincode </th>-->
                                    <th>Gender</th>
                                    <th>Org Name</th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($arrUser))
                                {
                                  foreach ($arrUser as $key=>$row)
                                  { ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" value="<?php echo $row['id'];?>" class="tableflat">
                                    </td>
                                    <td class=" "><?php echo $row['first_name'];?></td>
                                    <td class=" "><?php echo $row['mobile'];?></td>
                                    <td class=" "><?php echo $row['email'];?></td>
                                    <td class=" "><?php echo $row['address'];?></td>
                                    <td class=" "><?php echo $row['city'];?></td>
                                    <td class=" "><?php echo $row['state'];?></td>
                                   <!--- <td class=" "><?php //echo $row['pincode'];?></td>-->
                                    <td class=" "><?php echo $row['gender'];?></td>
                                    <td class=" "><?php echo $row['adminname'];?></td>
                                    <td class=" last">
<a href="<?php echo site_url('Staffs/show/'.$row['id']); ?>" class="btn btn-primary btn-xs" title="Show"><i class="fa fa-info-circle"></i></a>
<a href="<?php echo site_url('Staffs/edit/'.$row['id']); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
<a href="<?php echo site_url('Staffs/delete/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Do you want to permanent delete this user member?')"><i class="fa fa-trash"></i></a>
<a href="<?php echo site_url('Staffs/reset/'.$row['id']); ?>" class="btn btn-info btn-xs" title="Reset"><i class="fa fa-pencil"></i></a>
                                    </td>
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
                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Send Message</h4>
                      </div>
                      <div class="modal-body">
                        <textarea id="message-text" rows="4" cols="50" placeholder="Type Message" > </textarea>
                      </div>
                      <div class="modal-footer">

                        <button type="button" id="send-message" class="btn btn-default">Send</button>
                      </div>
                    </div>

                  </div>
                </div>


                <script type="text/javascript">
                      $(document).on("click","#send-message",function() {
                        var selected = new Array();
                            var msg = $('#message-text').val();
                             $('.tableflat').each( function(){
                                
                               if( $(this).is(":checked")){
                                selected.push($(this).val());
                                }

                             });
             var post_data = { 
                      'Staffs'  :  selected,
                    'msg' : msg
                  };
                $.ajax({ 
                    url: "<?php echo site_url('plivo_test/send_sms'); ?>",
                        
                        type: "POST",
                        data: post_data,
                        dataType: "json",      
                        success: function(response) //we're calling the response json array 'cities'
                        {
                         console.log(response);
               
                        },
                        error: function(response)
                        {
                        }

                });
            console.log(selected);
          });
                </script>
            </div>
        </div>
            <!-- footer content -->
