    <!-- page content -->
  <style>
  .inside_form_top .set_grid li label{
    margin:0px;
    padding:0px;
    display: block;
  }
  .inside_form_top .form-group ul li{
    display:inline-block;
    margin:0px;
    padding: 0 10px;
  }
</style>

    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Activity Management</h3>

                   
                </div>
                <div class="title_right">
                    <div class="col-xs-12 ">
                     <button onClick="window.location='<?php echo site_url('event/calendar'); ?>'" class="btn btn-info btn-xs" style='float: right;margin-top: 2%'>Event List</button>  
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                     <form action="<?php echo site_url('event/add_multiple_event');?>" method="POST">
                        <div class="x_title">
                        <?php
                                echo "<h2>Add 10 Muliple Events</small></h2>";
                  
                         ?>
                         <label class="checkbox-inline" style="padding: 7px 0 0 36px;">
                          <input  id='checkall'  value="1" onclick='check_uncheck_all();' type="checkbox">Select All</label>
                        <ul class="nav navbar-right panel_toolbox">
          <!--<li><button onClick="window.open('<?php //echo site_url().'/Pdfexample'; ?>');" class="btn btn-info btn-xs">Calender PDF</button></li>-->
                    
                      <li><input type="submit" name="submit_multiple" id="main_submit2" class='btn btn-primary' value="Submit"/></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                        <div class="form-group">
                      
                        <?php if($this->session->flashdata('flash_error')){
                            echo "<div class='flash error'>".$this->session->flashdata('flash_error')."</div>";
                        } ?>
                        </div>
                          <!-- form start-->
                        <?php

                            for($i=1;$i<=10;$i++)
                            {
                            ?>
                          <div class="inside_form_top">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                      <label class="checkbox-inline" style="float: right">
                                      <input name='noend<?php echo $i;?>' id='noend<?php echo $i;?>'  value="1" onclick='change_end_date(<?php echo $i; ?>);' type="checkbox">No End Date</label>
                                    </div>
                                  </div>
                                  <div class="row" style="border-width: 0px 0px 1px 0px; border-style: solid; border-color: #73879C;">
                                    <div class="col-md-1 col-sm-1">
                                      <span class="label label-default"><?php echo $i; ?></span>
  <input name='form<?php echo $i; ?>' id='form<?php echo $i;?>'  value="1" onclick='change_form(<?php echo $i; ?>);' type="checkbox" style="display:block;"/>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                      <div class="form-group">
                                        <label for="event_id">Location:</label>
                                        <select class="form-control" id="location_id<?php echo $i;?>" name="location_id<?php echo $i;?>" onchange="populatemycheckbox(this.value,<?php echo $i; ?>)">
                                           <option value="">Select Location</option>
                                            <?php 
                                            if(isset($location_arrays))
                                            {
                                              for($k=0;$k<count($location_arrays);$k++)
                                              {
                                            ?>
                                              <option value="<?php echo $location_arrays[$k]['id']; ?>"><?php echo $location_arrays[$k]['name']; ?></option>
                                            <?php 
                                              }
                                             }
                                            ?>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label for="usr">Max Attendies:</label>
                                        <input class="form-control" id="max_attendies<?php echo $i;?>"  name="max_attendies<?php echo $i;?>" value="" type="text">
                                      </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                      <div class="form-group">
                                        <label for="event_id">Events:</label>
                                <select class="form-control" id="eventid<?php echo $i;?>" name="event_ids<?php echo $i;?>" onchange="change_event_id(this.value,<?php echo $i; ?>)">
                                         <option value="">Select Events:</option>
                                          <?php 
                                          if(isset($event_arrays))
                                          {
                                            for($k=0;$k<count($event_arrays);$k++)
                                            {
                                          ?>
                                            <option value="<?php echo $event_arrays[$k]['id']; ?>"><?php echo $event_arrays[$k]['name']; ?></option>
                                          <?php 
                                            }
                                           }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label for="usr">Meetup Date:</label>
                                        <input class="form-control meetup_date" id="meetup_date<?php echo $i;?>" name="meetup_dates<?php echo $i;?>" value="" type="text">
                                      </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                      <div class="form-group">
                                        <label for="description">Description:</label>
                                        <textarea class="form-control" rows="4" id="description<?php echo $i;?>" name="descriptions<?php echo $i;?>"></textarea>
                                      </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                      <div class="form-group">
                                        <label for="usr">Meetup Time:</label>
                                        <input class="form-control" id="meetup_time<?php echo $i;?>"  name="meetup_times<?php echo $i;?>" value="08:00 AM" type="text">
                                      </div>
                                      <div class="form-group">
                                        <label for="usr">Duration:</label>
                                        <!-- <input type="text" class="form-control end_time" id="end_time1"  name="end_times1[]" value="" required> -->
                                        <select class="form-control" name="duration<?php echo $i;?>">
                                          <option value="30">.5</option>
                                          <option value="60">1</option>
                                          <option value="90">1.5</option>
                                          <option value="120">2</option>
                                          <option value="150">2.5</option>
                                          <option value="180">3</option>
                                          <option value="210">3.5</option>
                                          <option value="240">4</option>
                                          <option value="270">4.5</option>
                                          <option value="300">5</option>
                                          <option value="330">5.5</option>
                                          <option value="360">6</option>
                                          <option value="390">6.5</option>
                                          <option value="420">7</option>
                                          <option value="450">7.5</option>
                                          <option value="480">8</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                      <div class="form-group" id="end_div<?php echo $i; ?>">
                                        <label for="usr">End Date:</label>
                                       <input class="form-control end_date" id="end_date<?php echo $i;?>"  name="end_dates<?php echo $i;?>" value="" type="text">
                                      </div>
                                      <div class="form-group">
                                        <label style="display:block">
                                          <center>Recurring Event</center>
                                        </label>
                                        <ul class="set_grid" style="padding:0px;margin:0px;width:100%;text-align: center;">
                                          <li>
                                            <label class="checkbox-inline newcheck">S</label>
                                            <input name='recurring<?php echo $i;?>[]' value="S" class="chng" type="checkbox"/>
                                          </li>
                                          <li>
                                            <label class="checkbox-inline newcheck">M</label>
                                            <input name='recurring<?php echo $i;?>[]' value="M" class="chng" type="checkbox"/>
                                          </li>
                                          <li>
                                            <label class="checkbox-inline newcheck">T</label>
                                            <input name='recurring<?php echo $i;?>[]' value="T" class="chng" type="checkbox"/>
                                          </li>
                                          <li>
                                            <label class="checkbox-inline newcheck">W</label>
                                            <input name='recurring<?php echo $i;?>[]' value="W" class="chng" type="checkbox"/>
                                          </li>
                                          <li>
                                            <label class="checkbox-inline newcheck">Th</label>
                                            <input name='recurring<?php echo $i;?>[]' value="Th" class="chng" type="checkbox"/>
                                          </li>
                                          <li>
                                            <label class="checkbox-inline newcheck">F</label>
                                            <input name='recurring<?php echo $i;?>[]' value="F" class="chng" type="checkbox"/>
                                          </li>
                                          <li>
                                            <label class="checkbox-inline newcheck">St</label>
                                            <input name='recurring<?php echo $i;?>[]' value="St" class="chng" type="checkbox"/>
                                          </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                             <?php 
                                }
                             ?>
                             <div class="row">
                             <div class="col-md-12"><input type="submit" name="submit_multiple" class='btn btn-primary' id="main_submit1" value="Submit" style="float: right;margin-top: 1%" /></div>
                             </div>

                             </form>
                          <!-- form end -->
                        </div>
                    </div>
                </div>
            </div>

        </div>


<script type="text/javascript">
function populatemycheckbox(location, id)
{
  if(location!='')
  {
    $("#form"+id).prop('checked', true);
    $('#location_id'+id).attr('required', 'required');
    $('#max_attendies'+id).attr('required', 'required');
    $('#eventid'+id).attr('required', 'required');
    $('#meetup_date'+id).attr('required', 'required');
    $('#description'+id).attr('required', 'required');
    $('#meetup_time'+id).attr('required', 'required');
    $('#end_date'+id).attr('required', 'required');
    $("#main_submit1").removeAttr("disabled");
    $("#main_submit2").removeAttr("disabled");
  }


}
function change_form(id)
{
	//alert(id);

		if($("#form"+id).is(":checked"))
		{
			//alert("checked"+id);
			
			$('#location_id'+id).attr('required', 'required');
			$('#max_attendies'+id).attr('required', 'required');
			$('#eventid'+id).attr('required', 'required');
			$('#meetup_date'+id).attr('required', 'required');
			$('#description'+id).attr('required', 'required');
			$('#meetup_time'+id).attr('required', 'required');
			$('#end_date'+id).attr('required', 'required');

			$("#main_submit1").removeAttr("disabled");
			$("#main_submit2").removeAttr("disabled");
		}
		else
		{
			$('#location_id'+id).removeAttr('required');
			$('#max_attendies'+id).removeAttr('required');
			$('#eventid'+id).removeAttr('required');
			$('#meetup_date'+id).removeAttr('required');
			$('#description'+id).removeAttr('required');
			$('#meetup_time'+id).removeAttr('required');
			$('#end_date'+id).removeAttr('required');
			 $("#main_submit1").attr("disabled", true);
			 $("#main_submit2").attr("disabled", true);
			//alert("unchecked"+id);
		}
}

function check_uncheck_all()
{
  var j;
    if($("#checkall").is(":checked"))
    {
      
     
      for (j=1;j<=10;j++)
      {
       
        $("#form"+j).click();

      
      }
      
    }
    else
    {
     
       
      for (j=1;j<=10;j++)
      {
         
         $("#form"+j).click();

      }

    }
}
function change_end_date(id)
{
  //alert(id);

  if($("#noend"+id).is(":checked"))
  {
      $("#end_date"+id).val($("#meetup_date"+id).val());
      $("#end_div"+id).hide();
   }
     else
    {
       $("#end_div"+id).show();
    }
}
  function change_event_id(eid,id)
  {
      //alert(id);
      var event_id =eid;
      var post_data = { 
          'id'  :  event_id,
          'tablename'  :'ci_event'
      };
      $.ajax({ 
          url: "<?php echo site_url('ajax/get_record_byId'); ?>",
          type: "POST",
          data: post_data,
          dataType: "json",      
          success: function(response) //we're calling the response json array 'cities'
          {
             console.log(response);
            $("#description"+id).val(response.description);
            $("#max_attendies"+id).val(response.max_attendies);
          },
          error: function(response)
          {
          }
          
      });

}
    $(document).ready(function () {

    	 $("#main_submit1").attr("disabled", true);
		$("#main_submit2").attr("disabled", true);
//---------------1-----------------------
  $('#meetup_date1').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
      var currentDate = $("#meetup_date1").val(); 
      if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date1").val(currentDate); 
      }
      else
      {
      $("#end_date1").val(currentDate); 
      }
  });

$('#meetup_date1').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date1").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date1").val(); 
$('#end_date1').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date1").val(); 
if(currentDate2 =='')
{
  $("#end_date1").datepicker("setDate", currentDate); 
}


  
  $('#meetup_time1').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});


//     function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
//     function z(n){
//       return (n<10? '0':'') + n;
//     }
//     var bits = time.split(':');
//     var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

//     return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
//   }  


//   $('#meetup_time1').on('changeTime', function() {
//     var startTime = $(this).val().split(':');
//     var getmin  = startTime[1].split(' ');
//     var gettime = startTime[0]+':'+getmin[0];
    
//     var endHours = addMinutes(gettime, '30');
//     var endHourssplit = endHours.split(':');
//     if(endHourssplit[0] == '12' && getmin[1]== 'AM')
//     {
//        setampm = 'PM';
//     } 
//     else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
//     {
//        setampm = 'AM';
//     } 
//     else
//     {
//       setampm = getmin[1];
//     }
//     $('#end_time1').val(endHours +" "+setampm);
//   });


// $('#end_time1').timepicker({ 'step': 15,'timeFormat': 'h:i A' });

//------------2----------------

$('#meetup_date2').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date2").val(); 

    if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date2").val(currentDate); 
      }
      else
      {
      $("#end_date2").val(currentDate); 
      }
  
  });

$('#meetup_date2').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date2").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date2").val(); 
$('#end_date2').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date2").val(); 
if(currentDate2 =='')
{
  $("#end_date2").datepicker("setDate", currentDate); 
}

  $('#meetup_time2').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time2').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time2').val(endHours +" "+setampm);
  });


$('#end_time2').timepicker({ 'step': 15,'timeFormat': 'h:i A' });

//---------------------3-------------------      
$('#meetup_date3').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date3").val(); 
   
     if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date3").val(currentDate); 
      }
      else
      {
      $("#end_date3").val(currentDate); 
      }
  });

$('#meetup_date3').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date3").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date3").val(); 
$('#end_date3').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date3").val(); 
if(currentDate2 =='')
{
  $("#end_date3").datepicker("setDate", currentDate); 
}


  $('#meetup_time3').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time3').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time3').val(endHours +" "+setampm);
  });


$('#end_time3').timepicker({ 'step': 15,'timeFormat': 'h:i A' });

    //----------------------4--------------------------

$('#meetup_date4').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date4").val(); 
    if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date4").val(currentDate); 
      }
      else
      {
      $("#end_date4").val(currentDate); 
      }
  });

$('#meetup_date4').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date4").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date4").val(); 
$('#end_date4').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date4").val(); 
if(currentDate2 =='')
{
  $("#end_date4").datepicker("setDate", currentDate); 
}


  $('#meetup_time4').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time4').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time4').val(endHours +" "+setampm);
  });


$('#end_time4').timepicker({ 'step': 15,'timeFormat': 'h:i A' });
//-----------5------------------
$('#meetup_date5').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date5").val(); 
     if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date5").val(currentDate); 
      }
      else
      {
      $("#end_date5").val(currentDate); 
      }
  });

$('#meetup_date5').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date5").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date5").val(); 
$('#end_date5').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date5").val(); 
if(currentDate2 =='')
{
  $("#end_date5").datepicker("setDate", currentDate); 
}


  $('#meetup_time5').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time5').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time5').val(endHours +" "+setampm);
  });


$('#end_time5').timepicker({ 'step': 15,'timeFormat': 'h:i A' });
//-----------6-------------------------------
$('#meetup_date6').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date6").val(); 
     if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date6").val(currentDate); 
      }
      else
      {
      $("#end_date6").val(currentDate); 
      }
  });

$('#meetup_date6').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date6").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date6").val(); 
$('#end_date6').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date6").val(); 
if(currentDate2 =='')
{
  $("#end_date6").datepicker("setDate", currentDate); 
}


  $('#meetup_time6').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time6').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time6').val(endHours +" "+setampm);
  });


$('#end_time6').timepicker({ 'step': 15,'timeFormat': 'h:i A' });
//--------------7--------------------

$('#meetup_date7').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date7").val(); 
    if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date7").val(currentDate); 
      }
      else
      {
      $("#end_date7").val(currentDate); 
      }
  });

$('#meetup_date7').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date7").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date7").val(); 
$('#end_date7').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date7").val(); 
if(currentDate2 =='')
{
  $("#end_date7").datepicker("setDate", currentDate); 
}


  $('#meetup_time7').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time7').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time7').val(endHours +" "+setampm);
  });


$('#end_time7').timepicker({ 'step': 15,'timeFormat': 'h:i A' });
//-----------------8----------------------
$('#meetup_date8').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date8").val(); 
     if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date8").val(currentDate); 
      }
      else
      {
      $("#end_date8").val(currentDate); 
      }
  });

$('#meetup_date8').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date8").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date8").val(); 
$('#end_date8').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date8").val(); 
if(currentDate2 =='')
{
  $("#end_date8").datepicker("setDate", currentDate); 
}


  $('#meetup_time8').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time8').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time8').val(endHours +" "+setampm);
  });


$('#end_time8').timepicker({ 'step': 15,'timeFormat': 'h:i A' });

//---------------------9---------------
$('#meetup_date9').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date9").val(); 
     if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date9").val(currentDate); 
      }
      else
      {
      $("#end_date9").val(currentDate); 
      }
  });

$('#meetup_date9').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date9").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date9").val(); 
$('#end_date9').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date9").val(); 
if(currentDate2 =='')
{
  $("#end_date9").datepicker("setDate", currentDate); 
}


  $('#meetup_time9').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time9').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time9').val(endHours +" "+setampm);
  });


$('#end_time9').timepicker({ 'step': 15,'timeFormat': 'h:i A' });

//-------------------10------------------------------------------
$('#meetup_date10').on('click', function() {
    $(this).datepicker({showOn:'focus'}).focus();
    var currentDate = $("#meetup_date10").val(); 
     if(currentDate=='')
      {

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        var currentDate = yyyy+'-'+mm+'-'+dd;
         $("#end_date10").val(currentDate); 
      }
      else
      {
      $("#end_date10").val(currentDate); 
      }
  });

$('#meetup_date10').datepicker({ defaultDate: new Date(), minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
  $("#end_date10").datepicker('option', 'minDate', dateText);
  
}}); 

var currentDate = $("#meetup_date10").val(); 
$('#end_date10').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
var currentDate2 = $("#end_date10").val(); 
if(currentDate2 =='')
{
  $("#end_date10").datepicker("setDate", currentDate); 
}


  $('#meetup_time10').timepicker({ 'step': 15 ,'timeFormat': 'h:i A','defaultTime': '8:00 AM'});

    function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
    function z(n){
      return (n<10? '0':'') + n;
    }
    var bits = time.split(':');
    var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

    return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
  }  


  $('#meetup_time10').on('changeTime', function() {
    var startTime = $(this).val().split(':');
    var getmin  = startTime[1].split(' ');
    var gettime = startTime[0]+':'+getmin[0];
    
    var endHours = addMinutes(gettime, '30');
    var endHourssplit = endHours.split(':');
    if(endHourssplit[0] == '12' && getmin[1]== 'AM')
    {
       setampm = 'PM';
    } 
    else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
    {
       setampm = 'AM';
    } 
    else
    {
      setampm = getmin[1];
    }
    $('#end_time10').val(endHours +" "+setampm);
  });


$('#end_time10').timepicker({ 'step': 15,'timeFormat': 'h:i A' });



    });
</script>