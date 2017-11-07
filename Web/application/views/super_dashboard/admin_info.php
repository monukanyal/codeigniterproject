
<?php
    
    //print_r($user_info[0]);
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3><?php echo $user_info[0]['first_name'];?> Profile</h3>
                </div>
                
            </div>
            <div class="clearfix"></div>
              <div id="myModal_bill" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog sm" id="content_bill">
               
              </div>
              </div> 

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel"
             
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
                                <div class="col-m-4 col-sm-4 col-xs-12 gen_sitecode">
                                  <span class="user-infor">
                                    <button class="" id="gen_sitecode">generate sitecode</button>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12 sitecode hide">
                                  <span class="type-info">
                                    Sitecode
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12 sitecode hide">
                                  <span class="user-infor" id="span-sitecode"">
                                    
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
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style="color:#2a3f54">Monthly Billing <small>Record</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="table table-bordered">
                      <thead style="color:#2a3f54">
                        <tr>
                          <th>#</th>
                          <th>Monthly Range</th>
                          <th>Bill Amount</th>
                          <th>Payment date</th>
                        </tr>
                      </thead>
                      <tbody style="color:#2a3f54">
                       <?php

                       if(!empty($billdata))
                       {
                          $j=1;
                        
                          for($i=0;$i<count($billdata);$i++)
                          {

                            ?>
                            <tr>
                            <td><?php echo $j; ?></td>
                            <td><?php echo $billdata[$i]['from_range'].' to '.$billdata[$i]['to_range']; ?></td>
                            <td><?php echo $billdata[$i]['total_charge']; ?><span class="glyphicon glyphicon-usd" style="font-size: smaller;"></span></td>
                            <td>
                              <?php if($billdata[$i]['paid_on']!='0000-00-00'){ ?>
                              <a href='#' style='color:green' data-toggle="modal" data-target="#myModal_bill" id='<?php echo $billdata[$i]['id']; ?>' onclick="getdetails(<?php echo $billdata[$i]['id']; ?>)"><?php echo $billdata[$i]['paid_on']; ?> </a>
                              <?php
                              } 
                              else 
                              { 
                                echo " <p style='color:brown'>waiting for payment</p>";
                               
                              } 
                            ?> 
                            </td>
                            </tr>
                          <?php
                          $j++;

                          }
                       }
                       else
                       {
                        ?>
                        <tr>
                          <td colspan="4"><center>No Information found</center></td>

                        </tr>

                        <?php
                       }

                       ?>
                      
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
               <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Trial and Prod Fee Form</h2>
                   
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="color:black">
                   <div id="msg"></div>
                   <?php  
                  
                      if(!empty($maindata))
                      {
                        if($user_info[0]['only_care_pay']==0)
                        {
                      ?>
                       <h4 style="text-align: left"> <input type="checkbox"  id="carepay" onchange="onlycarepay(<?php echo $maindata[0]['admin_id']; ?>)">Bill Care Account fee to Care Account owner </h4>
                       <?php 
                        }
                        else
                        {
                        ?>
                          <h4 style="text-align: left"> <input type="checkbox"  id="carepay" onchange="onlycarepay(<?php echo $maindata[0]['admin_id']; ?>)" checked>Bill Care Account fee to Care Account owner </h4>
                      <?php 
                        }
                      ?>
                     <h4 style="text-align: right">
                     
                     <?php if($maindata[0]['active']==1)
                     {
                     ?> 
  Trial <input type="checkbox" class="js-switch" id="tpcheck" onchange="quick_status_change(<?php echo $maindata[0]['admin_id']; ?>)" /> Prod
                     <?php 
                     }else
                     {
                      ?>  
Trial <input type="checkbox" class="js-switch" id="tpcheck" onchange="quick_status_change(<?php echo $maindata[0]['admin_id']; ?>)" checked/> Prod
                      <?php
                     } 
                     ?>

                     </h4>
                     <?php } ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Fee</th>
                          <th>Trial</th>
                          <th> Production </th>
                        
                        </tr>
                      </thead>
                      <tbody>
                      <?php  
                      if(!empty($maindata))
                      {
                      ?>
                      <tr>
                          <th>Facility Fee</th>
                          <td><input type='text' id='trial_fac' value='<?php if(isset($maindata[0]['facility_fee'])){ echo $maindata[0]['facility_fee']; } ?>'></td>
                          <td><input type='text' id='prod_fac' value='<?php if(isset($maindata[1]['facility_fee'])){ echo $maindata[1]['facility_fee']; } ?>'></td>
                          
                        </tr>
                        <tr>
                          <th>Resident Fee</th>
                          <td><input type='text' id='trial_res' value='<?php if(isset($maindata[0]['resident_fee'])){ echo $maindata[0]['resident_fee']; } ?>'></td>
                          <td><input type='text' id='prod_res' value='<?php if(isset($maindata[1]['resident_fee'])){ echo $maindata[1]['resident_fee']; } ?>'></td>
                        
                        </tr>
                        <tr>
                          <th>Care Account Fee</th>
                          <td><input type='text' id='trial_care' value='<?php if(isset($maindata[0]['care_account_fee'])){ echo $maindata[0]['care_account_fee']; } ?>'></td>
                          <td><input type='text' id='prod_care' value='<?php if(isset($maindata[1]['care_account_fee'])){ echo $maindata[1]['care_account_fee']; } ?>'></td>
                        
                        </tr>
                        <tr>
                          <th>Message Fee</th>
                          <td><input type='text' id='trial_msg' value='<?php if(isset($maindata[0]['msg_fee'])){ echo $maindata[0]['msg_fee']; } ?>'></td>
                          <td><input type='text' id='prod_msg' value='<?php if(isset($maindata[1]['msg_fee'])){ echo $maindata[1]['msg_fee']; } ?>'></td>
                          
                        </tr>
                         <tr>
                          <td><input type="hidden" id="adm_id" value="<?php echo $maindata[0]['admin_id']; ?>"></td>
                          <td><input type='button' id='trial_btn' class="btn btn-success" value='Update Trial Fee'></td>
                          <td><input type='button' id='prod_btn' class="btn btn-success" value=' Update Prod Fee'></td>
                          
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>

              <div class="clearfix"></div>
            </div>

        </div>

        <script>

        $( document ).ready(function() {
          $('.switchery').css('background-color','#440909');
          $.ajax({
            url: '<?php echo site_url('profile/get_sitecode'); ?>',
            type: 'POST',
            data: {
                id: <?php echo $user_info[0]['id']; ?>
            },
            dataType: 'json',
            success: function(data){
              console.log(data);
              if(data.result.sitecode_exist == "true"){
                $('div.sitecode').removeClass('hide');
                $('.gen_sitecode').hide();
                $('#span-sitecode').text(data.result.sitecode);
              }else{
                $('.gen_sitecode').show();
                $('div.sitecode').addClass('hide');
              }
            }
          });
        });

        $('#gen_sitecode').on("click", function(){
          var sitecode = <?php echo "'".$user_info[0]['address']."'"; ?>;
          //str.substr(1, 2);
          $.ajax({
              url: '<?php echo site_url('profile/update_sitecode'); ?>',
              type: 'POST',
              data: {
                  id: <?php echo $user_info[0]['id']; ?>,
                  sitecode: (sitecode.substr(0, 2))+(Math.floor(100 + Math.random()*900)),
              },
              dataType: 'json',
              success: function(data) {
                  //console.log(data);
                  if(data.result.already_exist){
                    //alert("already esist");
                    $('div.sitecode').removeClass('hide');
                    $('.gen_sitecode').hide();
                    $('#span-sitecode').text(data.result.sitecode);
                  }
                  if(data.result.new_sitecode_add){
                    //alert('hello');
                    $('div.sitecode').removeClass('hide');
                    $('.gen_sitecode').hide();
                    $('#span-sitecode').text(data.result.sitecode);
                  }
              }
          });
        });
          
          $('document').ready(function(){

            $('#trial_btn').click(function()
            {
                var trial_fac= $('#trial_fac').val();
                var trial_res= $('#trial_res').val();
                var trial_care= $('#trial_care').val();
                var trial_msg= $('#trial_msg').val();
                var admin_id=$('#adm_id').val();
                if((trial_msg.length>0) && (trial_fac.length>0) && (trial_res.length>0) && (trial_care.length>0))
                {
                    $.post("<?php echo site_url('organization/change_fee');?>", {fac: trial_fac,res:trial_res,care:trial_care,msg:trial_msg,type:'trial',admin_id:admin_id}, function(result){
                      if(result!='')
                      {
                        $("#msg").html('<div class="alert alert-success">Trial Fee updated successfully.</div>');
                        setTimeout(function(){
                            $('#msg').html('');
                          }, 2000);
                      }
                    });
                }
                else
                {
                  $('#msg').html('<div class="alert alert-danger">Please provide all required data of Trial.</div>');
                  setTimeout(function(){
                            $('#msg').html('');
                          }, 3000);
                }

            });

              $('#prod_btn').click(function()
              {

                  var prod_fac= $('#prod_fac').val();
                  var prod_res= $('#prod_res').val();
                  var prod_care= $('#prod_care').val();
                  var prod_msg= $('#prod_msg').val();
                  var admin_id=$('#adm_id').val();
                if((prod_msg.length>0) && (prod_fac.length>0) && (prod_res.length>0) && (prod_care.length>0))
                {
                   $.post("<?php echo site_url('organization/change_fee');?>", {fac: prod_fac,res:prod_res,care:prod_care,msg:prod_msg,type:'prod',admin_id:admin_id}, function(result){
                      if(result!='')
                      {
                        $("#msg").html('<div class="alert alert-success">Production Fee updated successfully.</div>');
                        setTimeout(function(){
                            $('#msg').html('');
                          }, 2000);
                      }
                    });
                }
                else
                {

                  $('#msg').html('<div class="alert alert-danger">Please provide all required data of Production.</div>');
                  setTimeout(function(){
                            $('#msg').html('');
                          }, 3000);
                }

              });

          });
          
          function getdetails(bill_id)
          {
            var admin_id=$('#adm_id').val();
            $('#content_bill').html('<img src="<?php echo $assets_path.'spin.gif' ?>">');
            
            $.post('<?php echo site_url('organization/get_month_complete_data');?>',{admin_id:admin_id,bill_id:bill_id},function(response){
              if(response!='')
              {
                  $('#content_bill').html(response);
              }

            });
          }

          function quick_status_change(admin_id)
          {
            var status = document.getElementById("tpcheck").checked;
             if (status) 
             {
             // yes--prod
                //alert("Yes");
                 $.post("<?php echo site_url('organization/quick_status_trial_prod');?>",{admin_id:admin_id,active:1,type:'prod'},function(data,response){ 
                  if(data!='')
                  {
                    $("#msg").html('Fee Mode has changed');
                    setTimeout(
                    function() 
                    {
                    $("#msg").html("");
                    }, 2000);
                  }
                  else
                  {
                     $("#msg").html('Unable to change Mode');
                  }
                 });
             } 
             else 
             {
              //no--> trial
               // alert("No");
                 $.post("<?php echo site_url('organization/quick_status_trial_prod');?>",{admin_id:admin_id,active:1,type:'trial'},function(data,response){ 
                    if(data!='')
                    {
                      $("#msg").html('Fee Mode has changed');
                      setTimeout(
                      function() 
                      {
                      $("#msg").html("");
                      }, 2000);
                       $('.switchery').css('background-color','#440909');
                   }else
                   {
                    $("#msg").html('Unable to change Mode');
                   }

                 });

             }

          }
          function onlycarepay(admin_id)
          {
            var status = document.getElementById("carepay").checked;
             // alert(status);
             if (status) 
             {
                //yes

                $('#trial_care').val(0).attr('readonly', 'readonly');
                $('#prod_care').val(0).attr('readonly', 'readonly');

                    $.post("<?php echo site_url('organization/update_status_care_pay');?>",{admin_id:admin_id,onlycarepay:1,prod_care:0,trial_care:0},function(data,response){ 
                    if(data!='')
                    {
                      $("#msg").html('successfully updated');
                      setTimeout(
                      function() 
                      {
                      $("#msg").html("");
                      }, 2000);
                      
                   }
                   else
                   {
                    $("#msg").html('Unable to update');
                   }

                 });
             }
             else
             {
                //no
                $('#trial_care').val(3).removeAttr('readonly');  //$3 set -client
                $('#prod_care').val(3).removeAttr('readonly');  //$3 set
                    $.post("<?php echo site_url('organization/update_status_care_pay');?>",{admin_id:admin_id,onlycarepay:0,prod_care:3,trial_care:3},function(data,response){ 
                    if(data!='')
                    {
                      $("#msg").html('successfully updated');
                      setTimeout(
                      function() 
                      {
                      $("#msg").html("");
                      }, 2000);
                      
                   }
                   else
                   {
                    $("#msg").html('Unable to update');
                   }

                 });
             }  
          }
          

        </script>