   <!-- page content -->
<div class="right_col" role="main">
    <div class="">
      <!--@mkcode start -->

      <?php 
       // print_r($approvalcare);
      if(!empty($approvalcare)){ ?>
     <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
             <div class="x_panel">
             <div class="x_title">
                    <h2>Approval Pending <small>Care</small></h2>
                    
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>-->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>

                    <div class="clearfix"></div>
                  </div>
                   <div class="x_content">
                     <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr style="background: #2a3f54;color: #fff;">
                        <th>Name </th>
                        <th>Mobile </th>
                        <th>Email </th>
                        <th>Resident </th>
                        <th>Approve</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        for($m=0;$m<count($approvalcare);$m++)
                        {
                           $arrParent = $this->user_model->getparentuserfrmpage($approvalcare[$m]['belongs_to']);
                      ?>
                        <tr>
                          <td><?php echo $approvalcare[$m]['first_name']." ".$approvalcare[$m]['last_name']; ?></td>
                          <td><?php  echo  $approvalcare[$m]['mobile']; ?></td>
                          <td><?php  echo  $approvalcare[$m]['email']; ?></td>
                          <td><?php  echo  $arrParent[0]['first_name']; ?></td>
                          <td><?php if($approvalcare[$m]['approved']=='0'){ ?>

                          <span class="label label-danger">Pending</span>
                           <?php }else{ ?>
                         <span class="label label-success">Approve</span>

                           <?php } ?>

                           </td>
                          <td>  <input type="checkbox"   value="1" onchange="change_to_approve(<?php echo $approvalcare[$m]['id']; ?>)" /> Approve</td>
                         
                        </tr>
                        <?php 
                            }
                        ?>
                      
                      </tbody>
                    </table>
            </div>
            </div>
            </div>

            </div>

            <div class="clearfix"></div>
            <?php } ?>
              <!--@mkcode end -->
            <div class="page-title">
            <div class="title_left">
                <h3> Care <small>Listing</small></h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <!--         <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
          
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                          
                         <button type="button" id="msgsend" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Send Message </button>

                            <ul class="nav navbar-right panel_toolbox">
                                <li class="create_csv"><button onClick="window.open('<?php echo site_url().'/Generate/create_csv'; ?>');" class="btn btn-info btn-xs">User Csv</button></li>
                             
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                        <div class="form-group">
                        <p id="success_msg_send"> </p>
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
                                    <th>
                                    <input type="checkbox" name="checkedAll" id="checkedAll" />
                                    </th>
                                    <th>Name </th>
                                    <th >Mobile </th>
                                    <th>Email </th>
                                    <th>Property Name </th>
                                    <th>Resident </th>
                                   <!-- <th>Belongs Another </th>-->
                                    <!--<th>State </th>
                                    <th>Pincode </th> -->
                                    <th>Subscription status </th>
                                    <th>Approval status</th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                // echo "<pre>";
                                // print_r($arrParent);
                                
                                if (!empty($arrUser))
                                {
                                  foreach ($arrUser as $row)
                                  { 


                                    $arrParent = $this->user_model->getparentuserfrmpage($row['belongs_to']);
                                
                                    //@mkcode start
                                    if(!empty($row['belongs_another']))
                                    {
                                        $arranotherParent = $this->user_model->getparentuserfrmpage($row['belongs_another']);  
                                    }
                                    else
                                    {
                                        $arranotherParent=array();
                                    }
                                    //@mkcode end

                                    ?>
                                    <tr class="even pointer">
                                    <td class="a-center ">
                                
                                    <input type="checkbox" value="<?php echo $row['id'];?>" name="checkAll" class="checkSingle" />
                                    </td>
                                    <td class=" "><a href="<?php echo site_url('user/show/'.$row['id']); ?>" style='text-decoration: none;' class="name_anchor"><?php echo $row['first_name'];?></a></td>
                                    <td class="phone_no<?php echo $row['id']; ?>">
                                    <?php   
                                    $result = "";
                                    $mobile_num = $row['mobile'];
                                     if(  preg_match( '/(\d{3})(\d{3})(\d{4})$/', $mobile_num,  $matches ) )
                                        {
                                           $result = '('.$matches[1] . ') ' .$matches[2] . '-' . $matches[3];
                                          
                                        }
                                    //$row['mobile']= $result;
                                    echo $result; ?></td>

                                    <td class=" "><?php echo $row['email'];?></td>
                                    <td class=" "><?php echo $row['property_name'];?></td>
                                    <!-- @mkcode-->
                                    <td class=" ">
                                    <?php 
                                    if(!empty($arrParent[0]['first_name']) && !empty($arranotherParent[0]['first_name']))
                                    {
                                    echo $arrParent[0]['first_name']." , ".$arranotherParent[0]['first_name'];
                                    }
                                    else if(!empty($arrParent[0]['first_name']))
                                    {
                                       echo $arrParent[0]['first_name'];
                                    }
                                    else
                                    {
                                      echo $arranotherParent[0]['first_name'];
                                    }
                                    ?></td>

                                    <!--<td class=" "><?php //echo $row['state'];?></td>
                                    <td class=" "><?php //echo $row['pincode'];?></td> -->

                                    <!-- @mkcode-->
                                    <?php if($row['subscription_started']=='yes') { ?>
                                        <td class="is_active_field boolean_type" title="Active"><span class="label label-success">✓</span></td>
                                    <?php } else { ?>
                                        <td class="is_active_field boolean_type" title="InActive"><span class="label" style="background: #A9A9A9">✘</span></td>
                                    <?php } ?>

                                    <?php if($row['approved']=='1') { ?>
                                        <td class="is_active_field boolean_type" title="Active"><span class="label label-success">✓</span></td>
                                    <?php } else { ?>
                                        <td class="is_active_field boolean_type" title="InActive"><span class="label" style="background: #A9A9A9">✘</span></td>
                                    <?php } ?>
                                    <!--@mkcode -->
                                    
                        
                                    <td class=" last">
                                    <?php if ($row['appactive'] == 0)
                                    { ?>
                                    <a href="<?php echo site_url('Plivo_test/resend_sms/'.$row['id']); ?>" class="btn btn-primary btn-xs" title="Resend Message"><i class="fa fa-envelope"></i></a>
                                    <?php } ?>
                                        <!--<a href="<?php //echo site_url('user/show/'.$row['id']); ?>" class="btn btn-primary btn-xs" title="Show"><i class="fa fa-info-circle"></i></a>-->
                                        <a href="<?php echo site_url('user/edit/'.$row['id']); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                        <a href="<?php echo site_url('user/delete_child/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Do you want to permanent delete this child user?')"><i class="fa fa-trash"></i></a>
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
                             $('.checkSingle').each( function(){
                                
                           if( $(this).is(":checked")){
                                selected.push($(this).val());
                                }
                             });
                             
                            var post_data = { 
                                'users'  :  selected,
                                'msg' : msg
                              };
                    if(selected !=''){ 
                        if(msg.trim().length >0) {         
                              $('#myModal').modal('hide');
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
                        }else{
                          // $('#myModal').modal('hide');
                           alert("Please enter the message.");
                        }    
                    }else{
                       $('#myModal').modal('hide');
                        alert("Please select the User atleast one user.");
                    }
                       // console.log(selected);
                        // $('#myModal').modal('hide');
                  });
                
               
                </script>
            </div>
        </div>
            <!-- footer content -->

<script type="text/javascript">
    //@mkcode start
    function change_to_approve(care_id)
    {
        //alert(care_id);
       
            $.post("<?php echo site_url('user/approve_care_now'); ?>", {care_id: care_id}, function(result){
                if(result!="")
                {
                    window.open('<?php echo  site_url('user/child_listing'); ?>','_self');
                }
          });
       
    }

    //@mkcode end
    $(document).ready(function() {
        // --28 march
     $(".name_anchor").hover(function()
     {
        $(this).css("color", "#5bc0de");
        }, function(){
        $(this).css("color", "#73879C");
    });
        //------end code
  $("#checkedAll").change(function(){
    if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }     
    }else {
      $("#checkedAll").prop("checked", false);
    }
  });
});
</script>