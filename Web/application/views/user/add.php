
<div class="right_col" role="main">
  <div>
    <div class="page-title">
      <div class="title_left">
      
        <?php if($this->router->fetch_method()=='add')
            echo "<small>Add New Resident</small></h3>";
        else
          if ($user_type_db == "resident") {
            # code...
            echo "  <h3>Resident Management";
            echo "<small>Edit Resident</small></h3>";
          }else{
            echo "  <h3>Child Management";
            echo "<small>Edit Child</small></h3>";
          }
         
        ?>
      </div>
      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
             <button class="btn btn-default" type="button">Go!</button>
             </span>
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
                   
                        <?php if($this->router->fetch_method()=='add')

                            echo "<h2>Add New</small></h2>";
                        else
                            if ($user_type_db == "resident") {
                                  # code...
                         
                                     echo "<h2>Edit Resident</h2>";
                                }else{
                    

                                    echo "<h2>Edit Child</h2>";
                                }
                        ?>
                        
                        <ul class="nav navbar-right panel_toolbox">
                            <?php if($this->router->fetch_method()=='edit'){
                       
                            $parentUrl = site_url('user/child').'/'.$parrentId;
          
                           if ($user_type_db == "resident") { ?>
                          <!--@mkcode start do comment  
                            <li><button onClick="window.location='<?php //echo $parentUrl; ?>'" class="btn btn-info btn-xs">Add Care Account</button></li>
                         @mkcode end -->
                            <li><button onClick="window.location='<?php echo site_url('user'); ?>'" class="btn btn-info btn-xs">Resident List</button></li>

                     <?php }
                          else{ ?>

                        <li><button onClick="window.location='<?php echo site_url('user'); ?>/child_listing'" class="btn btn-info btn-xs">Care List</button></li>
                        <?php
                              }
                            } 
                          
                            else
                            { ?>
                            
                            <li><button onClick="window.location='<?php echo site_url('user'); ?>'" class="btn btn-info btn-xs">Resident List</button></li>
                            <?php } ?>
                      
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
    <?php
      if(!empty($form))
      {
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
var current_method = "<?php echo $this->router->fetch_method(); ?>";
if(current_method == "add"){
  $("#email").prop('readonly', false);
}
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

/*$('#pincode').on("focusout", function(){
  var zipcode = $('#pincode').val();
  //alert("<?php //echo site_url('user/get_countrycode'); ?>");
  if(zipcode!=''){
    $.ajax({
        url: '<?php //echo site_url('user/get_countrycode'); ?>',
        type: 'POST',
        data: {
            zcode: zipcode
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);
        }
    });

    $.getJSON("http://maps.googleapis.com/maps/api/geocode/json?address=" + zipcode + "&sensor=true", function (data) {
      //console.log(data);
      var add_com_len = data.results[0].address_components.length - 1;
      if($('#countrycode').val() == '' ){
        $('#countrycode').val((data.results[0].address_components[add_com_len].short_name)+(Math.floor(100 + Math.random()*900)));
      }
    });
  }

});*/

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
  if($phone.val().length === 5) {
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
// console.log($room_no.val().length);
    // Auto-format- do not expose the mask as the user begins to type
    if ($room_no.val().length === 0) 
    {
        // console.log('hr');
      if (key == 96 || key == 48 ) {
        return false;
      }
    }
    //  if ($room_no.val().length === 0) 
    // {
    //     // console.log('hr');
    //   if (key === 97 || key === 96 || key === 48 || key === 49 ) {
    //     return false;
    //   }
    // }

}
// Allow numeric (and tab, backspace, delete) keys only
return (key == 8 || key == 9 || key == 46 ||(key >= 48 && key <= 57) ||(key >= 96 && key <= 105)); 
});
</script>