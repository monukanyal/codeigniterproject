  <!-- page content -->
  <?php

   //print_r($user_info);
  ?>
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Profile Edit
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
                        <h2>Edit Admin</small></h2>                            
                        <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                        <div class="form-group">
                        <div id='msg'></div>                        
                        </div>
                         <form action="" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" accept-charset="utf-8">

                        <div class='form-group'>
                        <div class='col-md-6'>
                        <label for="first_name">First Name:*</label>
                        <input type="text" name="first_name" id="fname" value="<?php if(isset($user_info[0]['first_name'])){ echo $user_info[0]['first_name']; } ?>" id="first_name" class="form-control" required="required" autofocus="true"  />
                        <input type="hidden" id="admin_id" value="<?php echo $user_info[0]['id'];?>">
                        </div>
                        <div class='col-md-6'>
                        <label for="middle_name">Middle Name</label>
                        <input type="text" name="middle_name" id="mname" value="<?php if(isset($user_info[0]['middle_name'])){ echo $user_info[0]['middle_name']; } ?>" id="middle_name" class="form-control" autofocus="true"  />
                        </div>
                        </div>
                        <div class='form-group'>
                        <div class='col-md-6'><label for="last_name">Last Name</label><input type="text" name="last_name"  id="lname" value="<?php if(isset($user_info[0]['last_name'])){ echo $user_info[0]['last_name']; } ?>" id="last_name" class="form-control" required="required" autofocus="true"  />
                        </div>
                        <div class='col-md-6'>
                        <label for="email">Email</label><input type="email" name="email" id="email" value="<?php if(isset($user_info[0]['email'])){ echo $user_info[0]['email']; } ?>" id="email" class="form-control" required="required" readonly="1" autofocus="true" />
                        </div>
                        </div>
                        <div class='form-group'>
                        <div class='col-md-6'>
                        <label for="address">Address</label><input type="text" name="address" id="address" value="<?php if(isset($user_info[0]['address'])){ echo $user_info[0]['address']; } ?>" id="address" class="form-control" autofocus="true"  />
                        </div>
                        <div class='col-md-6'>
                        <label for="city">City</label><input type="text" name="city" id="city" value="<?php if(isset($user_info[0]['city'])){ echo $user_info[0]['city']; } ?>" id="city" class="form-control" autofocus="true"  />
                        </div>
                        </div>
                        <div class='form-group'>
                        <div class='col-md-6'><label for="state">State</label><input type="text" name="state" id="state" value="<?php if(isset($user_info[0]['state'])){ echo $user_info[0]['state']; } ?>" id="state" class="form-control" autofocus="true"  />
                        </div>
                        <div class='col-md-6'><label for="pincode">Pincode</label><input type="text" name="pincode" id="pincode" value="<?php if(isset($user_info[0]['pincode'])){ echo $user_info[0]['pincode']; } ?>" id="pincode" class="form-control" autofocus="true"  />
                        </div>
                        </div>
                        <div class='form-group'>
                        <div class='col-md-6'><label for="mobile">Mobile</label><input type="text" name="mobile" id="mobile" value="<?php if(isset($user_info[0]['mobile'])){ echo $user_info[0]['mobile']; } ?>" id="mobile" class="form-control" autofocus="true"  />
                        </div>
                        </div>
                        <div class='form-group'>
                        <div class='col-md-4'><div class='col-md-1 no-padd'><input type="checkbox" name="is_active" id="is_active" value="<?php if(isset($user_info[0]['is_active'])){ echo $user_info[0]['is_active']; } ?>" checked="checked"  class=flat id=is_active />
                        </div>
                        <div class='col-md-11 no-padd'>
                        <label for="is_active">Is Active?</label></div>
                        </div>

                        </div>
                        <div class='form-group'>
                        <div class='col-md-12'>
                        <input type="button" name="update" id="up_btn" value="Update" class="btn btn-success" />
                        </div>
                        </div>
                        </form>                        
                          
                        </div>
                    </div>
                </div>
            </div>

        </div>

<script type="text/javascript">
    $(document).ready(function () {
       $('#up_btn').click(function()
            {
                var fname= $('#fname').val();
                var mname= $('#mname').val();
                var lname= $('#lname').val();
                var email= $('#email').val();
                var address= $('#address').val();
                var city= $('#city').val();
                var state= $('#state').val();
                var pincode= $('#pincode').val();
                var mobile= $('#mobile').val();
                var is_active= $('#is_active').val();
                var id= $('#admin_id').val();
                if((fname.length>0) && (lname.length>0) && (email.length>0) && (address.length>0)&& (city.length>0)&& (state.length>0)&& (pincode.length>0)&& (mobile.length>0)&& (is_active.length>0))
                {
                    $.post("<?php echo site_url('organization/update_admin_info');?>", {fname:fname,mname:mname,lname:lname,email:email,address:address,city:city,state:state,pincode:pincode,mobile:mobile,is_active:is_active,admin_id:id}, function(result){
                      if(result!='')
                      {
                        $("#msg").html('<div class="alert alert-success">Admin record updated successfully.</div>');
                        setTimeout(function(){
                            $('#msg').html('');
                          }, 2000);
                      }
                    });
                }
                else
                {
                  $('#msg').html('<div class="alert alert-danger">Please provide all required data.</div>');
                  setTimeout(function(){
                            $('#msg').html('');
                          }, 3000);
                }

            });


    });
</script>