
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
                <div class="col-md-6 col-sm-6 col-xs-12">
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

                       if(isset($billdata))
                       {
                          $j=1;
                          for($i=0;$i<count($billdata);$i++)
                          {

                            ?>
                            <tr>
                            <td><?php echo $j; ?></td>
                            <td><?php echo $billdata[$i]['from_range'].'-'.$billdata[$i]['to_range']; ?></td>
                            <td><span class="glyphicon glyphicon-usd" style="font-size: smaller;"></span><?php echo $billdata[$i]['total_charge']; ?></td>
                          
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

                       ?>
                      
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

        //@mkcode
            function getdetails(bill_id)
          {
          
            $('#content_bill').html('<img src="<?php echo $assets_path.'spin.gif' ?>">');
            
            $.post('<?php echo site_url('profile/get_month_complete_data');?>',{bill_id:bill_id},function(response){
              if(response!='')
              {
                  $('#content_bill').html(response);
              }

            });
          }
        </script>