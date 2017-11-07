<?php //print_r($superadmin_info);?>
    <!-- page content -->

    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Settings</h3>
                </div>
                
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
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
                          <td></td>
                          <td><input type='button' id='trial_btn' class="btn btn-success" value='Update Trial Fee'></td>
                          <td><input type='button' id='prod_btn' class="btn btn-success" value=' Update Prod Fee'></td>
                          
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>

            </div>

        </div>
        <script type="text/javascript">
          
          $('document').ready(function(){

            $('#trial_btn').click(function()
            {
                var trial_fac= $('#trial_fac').val();
                var trial_res= $('#trial_res').val();
                var trial_care= $('#trial_care').val();
                var trial_msg= $('#trial_msg').val();
                if((trial_msg.length>0) && (trial_fac.length>0) && (trial_res.length>0) && (trial_care.length>0))
                {
                    $.post("<?php echo site_url('Super_dashboard/change_fee');?>", {fac: trial_fac,res:trial_res,care:trial_care,msg:trial_msg,type:'trial'}, function(result){
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
                if((prod_msg.length>0) && (prod_fac.length>0) && (prod_res.length>0) && (prod_care.length>0))
                {
                   $.post("<?php echo site_url('Super_dashboard/change_fee');?>", {fac: prod_fac,res:prod_res,care:prod_care,msg:prod_msg,type:'prod'}, function(result){
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
        </script>