<!-- page content -->

<div class="right_col" role="main">
  <div>
    <div class="page-title">
      <div class="title_left">
        <h3>Child Management 
        <?php if($this->router->fetch_method()=='child')
            echo "<small>Add New Child </small></h3>";
        else
            echo "<small>Edit Child</small></h3>";
        ?>
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
                     <h4> Resident - <?php echo $arrUser[0]['first_name']." ".$arrUser[0]['last_name']; ?></h4>
                          <?php 

                            if(isset($Message))
                            {
                              ?>
                              <div class="alert alert-danger" style="margin-top: 1%">
                              <p>
                                <?php echo $Message; ?>
                              <p>
                              </div>

                              <?php
                            }
                            else
                            {
                              if($this->router->fetch_method()=='child')
                              {
                                  echo "<h2>Add New</small></h2>";
                              }
                              else
                              {
                                  echo "<h2>Edit Child</small></h2>";
                              }
                           }
                          ?>
                        
                        <ul class="nav navbar-right panel_toolbox">
                            <?php if($this->router->fetch_method()=='edit'){
                              $parentUrl = site_url('user/child').'/'.$parrentId;  ?>
                            <li><button onClick="window.location='<?php echo $parentUrl; ?>'" class="btn btn-info btn-xs">Add Care Account</button></li>
                            <li><button onClick="window.location='<?php echo site_url('user'); ?>'" class="btn btn-info btn-xs">Resident List</button></li>
                        <?php  } 
                          
                            else
                            { ?>
                            
                            <li><button onClick="window.location='<?php echo site_url('user/child_listing'); ?>'" class="btn btn-info btn-xs">Care List</button></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <?php } ?>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
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
                    echo "<div class='flash error'>";
                    if (isset($error)) {
                        echo $error;
                    }
                    // echo validation_errors();
                    echo "</div>";
                    ?>
                    </div>
                    <!--mkcode-->
                     <?php

                if(!empty($form))
                {
                  //print_r($carelist);
                  if(count($carelist)>0)
                  {
                  ?>
                    <div class="row" style="background: #73879C; color:white; height:100px; margin-bottom: 2%">
                    <div class="col-md-3">
                        <p style=" float: right"> Select Any Care: </p>
                    </div>
                    <div class="col-md-6">
                      <select class="form-control col-md-5" style="width:70%;color: black" id="careid">
                         <?php
                          for($m=0;$m<count($carelist);$m++)
                          {
                         ?>
          <option value="<?php echo $carelist[$m]['id']; ?>"><?php echo $carelist[$m]['first_name'].' '.$carelist[$m]['last_name'].' ('.$carelist[$m]['mobile'].')'; ?></option>
                          
                          <?php

                              }
                          ?>
                        
                        </select>
                        <input type="hidden" id="residentid" value="<?php echo $arrUser[0]['id']; ?>">
                        <button type="button" class="btn btn-success" id="update_care_btn" style="margin-left: 3%">Update</button>
                    </div>
                    <div class="col-md-3" id="showlist">
                       
                    </div>
                    </div>

                    <!--mkcode_end-->
       <?php
        }

        $i=0;
        echo isset($startform)?$startform:'';
          foreach($form as $k=>$forms)
          {
              if($k!='id' && $k!='submit' && $k!='is_active' && $k!='gender')
              {
                if($i%2==0)
                  { echo "<div class='form-group'  oncontextmenu='return false'>"; }
                  echo "<div class='col-md-6'>";
                  echo isset($forms['label'])?$forms['label']:'';
                    if(isset($forms['errors']) && $forms['errors']!='' && count($forms['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $forms['errors'];
                      echo "</div>";
                    }
                  echo isset($forms['field'])?$forms['field']:'';
                echo "</div>";
                $i++; if($i%2==0) {  echo "</div>"; }
              }
              elseif($k=='gender')
              {   
                if($i%2==0)
                  { echo "<div class='form-group'>"; }
                    echo "<div class='col-md-6'>";
                    echo isset($forms['label'])?$forms['label']:'';
                    echo "<br>";
                    echo '<div id="gender" class="btn-group" data-toggle="buttons">';

                    foreach ($form['gender'] as $key=>$formrol)
                    {
                        echo isset($formrol['field'])?$formrol['field']:''; 
                    }
                    echo "</div>";
                  echo "</div>";
                $i++; if($i%2==0) {  echo "</div>"; }
              }
              elseif($k=='is_active')
              {   
                if($i%2!=0) {  echo "</div>"; }
                echo "<div class='form-group'>"; 
                  echo "<div class='col-md-4'>";                     
                      echo "<div class='col-md-1 no-padd'>";                     
                        echo isset($forms['field'])?$forms['field']:'';
                      echo "</div>";                   
                      echo "<div class='col-md-11 no-padd'>"; 
                        echo isset($forms['label'])?$forms['label']:'';
                      echo "</div>";
                  echo "</div>";
                echo "</div>";
                echo "<input type='hidden' value='".$parentIds."' name='parentID'>";
              }
              elseif($k=='submit')
              {   
                echo "<div class='form-group'>"; 
                  echo "<div class='col-md-12'>";                 
                    echo isset($forms['field'])?$forms['field']:'';
                  echo "</div>";
                echo "</div>";
              }
          }
        echo isset($endform)?$endform:'';
      }

    ?>                        
                      
                    </div>
                </div>
            </div>
        </div>

    </div>

<script>        
$(document).ready(function () {

//@mkcode start
  $('#update_care_btn').click(
    function()
    {
      var careid=$('#careid').val();
      var residentid=$('#residentid').val();
      $("#showlist").html('<p style="color:blue">processing...</p>');
      $.post("<?php echo site_url();?>/user/update_belongs_another", {careid: careid,residentid:residentid}, function(result){
        $("#showlist").html(result);
        setTimeout(function(){ window.open('<?php echo site_url("user/child"); ?>/'+residentid+'','_self'); }, 3000);
     });

    });

  //@mkcode end

// var current_method = "<?php echo $this->router->fetch_method(); ?>";
// if(current_method == "add"){
  $("#email").prop('readonly', false);
// }
var default_val = "";
default_val = $('#property_name').val();
$('#city').prop( "disabled", true );
$('#state').prop( "disabled", true );
$('#pincode').prop( "disabled", true );

$('#property_name').on("keyup", function(){

  var self = $(this);
  var new_val = self.val();
  if(default_val == new_val){
    $('#city').prop( "disabled", true );
    $('#state').prop( "disabled", true );
    $('#pincode').prop( "disabled", true );
  } else {
    $('#city').prop( "disabled", false );
    $('#state').prop( "disabled", false );
    $('#pincode').prop( "disabled", false );
  }
});
});
$('#mobile , #child_mobile').keydown(function (e) {

});
$('#mobile , #child_mobile').keydown(function (e) {
var key = e.charCode || e.keyCode || 0;
$phone = $(this);
  console.log(key);
if(e.shiftKey){
  return false;
}
if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {

// Auto-format- do not expose the mask as the user begins to type
// if (key !== 8 && key !== 9) {
  if ($phone.val().length === 0) {
    $phone.val($phone.val() + '(');

  }
   if ($phone.val().length === 1) 
   {
    if (key === 97 || key === 96 || key === 48 || key === 49 ) {
    return false;
    

    }
   
   }
  if ($phone.val().length === 4) {
    $phone.val($phone.val() + ')');
  }
  if ($phone.val().length === 5) {
    $phone.val($phone.val() + ' ');
  }     
  if ($phone.val().length === 9) {
    $phone.val($phone.val() + '-');
  }
}

// Allow numeric (and tab, backspace, delete) keys only
return (key == 8 || 
    key == 9 ||
    key == 46 ||
    (key >= 48 && key <= 57) ||
    (key >= 96 && key <= 105)); 
})

.bind('focus click', function () {
$phone = $(this);

if ($phone.val().length === 0) {
  $phone.val('(');
}
else {
  var val = $phone.val();
  if(val==0 || val==1)
  {
  $phone.val('').val(val);
  } // Ensure cursor remains at the end
}
})

.blur(function () {
$phone = $(this);

if ($phone.val() === '(') {
  $phone.val('');
}
});

$('#room_no').keydown(function (e) {
var key = e.charCode || e.keyCode || 0;
$room_no = $(this);
console.log(key);

if(e.shiftKey){ return false;}
if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) 
{
    // Auto-format- do not expose the mask as the user begins to type
    if ($room_no.val().length === 1) 
    {
      if (key === 97 || key === 96 || key === 48 || key === 49 ) {
        return false;
      }
    }
}
// Allow numeric (and tab, backspace, delete) keys only
return (key == 8 || key == 9 || key == 46 ||(key >= 48 && key <= 57) ||(key >= 96 && key <= 105)); 
});
</script>