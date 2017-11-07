<?php
$get_calender_events=$this->allactivity_model->get_calender_events();
$get_calender_meals=$this->allactivity_model->get_calender_meals();

?>
   <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Event Management <small>Listing</small></h3>
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
                            <h2>Daily active events <small>Grid List</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
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

                            <div id='calendar'></div>

                             

                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>

    $(document).ready(function() {
      <?php 
      $calenderdata = array();
          if(isset($get_calender_events) && !empty($get_calender_events))
          {
             
              foreach($get_calender_events as $key =>$row)
              {
                 
                  $rec_val = $row['recurring'];
                  $rec_explode = explode(',', $rec_val );
                  $length = count($rec_explode);
                  $recring = array();
                  foreach ($rec_explode  as $key2 => $day) {
                  # code...
                   switch ($day) {
                        case "S":
                          $recring[$day] = 'Sun';
                            break;
                        case "M":
                          $recring[$day] = 'Mon';
                            break;
                        case "T":
                          $recring[$day] = 'Tue';
                            break;
                        case "W":
                            $recring[$day] = 'Wed';
                            break;
                        case "Th":
                          $recring[$day] = 'Thu';
                            break;
                        case "F":
                            $recring[$day] = 'Fri';
                            break;
                        case "St":
                           $recring[$day] = 'Sat';
                            break;    
                       
                      }

                  }


                  $date_S = $row['meetup_date'];
                  $date_E = $row['end_date'];

                  if ( $date_S != $date_E ) {
                        date_default_timezone_set('America/New_York');

                          $begin =  new DateTime( $date_S);
                           $stop_date = date('Y-m-d', strtotime($date_E . ' +1 day'));
                           $end = new DateTime( $stop_date  );
       

                  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                  //print_r($daterange);
                  $data_calender = array();
                  foreach ($recring as $key4 => $recring_val) {


                  foreach($daterange as $key3 => $date){
                       


                        $string = $date->format("Y-m-d");
                        $timestamp = strtotime($string);
                        $day =  date("D", $timestamp);
                       if ($day == $recring_val) {
                        # code...
                     
                        $id = $row['id'];

                        $name =  str_replace("'", "",$row['name']);
                        $time = mdate('%H:%i ',strtotime($row['meetup_time']));
                        $meetup_date = $date->format("Y-m-d");
                        $calender[]="{ id: $id,title: '$name',time: '$time',start: '$meetup_date', color: '#5bc0de',className:'event'}";

                        $calenderjs=implode(", ",$calender);

                        }
                        
                  }
                  }
                  }else{

                    $id = $row['id'];

                        $name =  str_replace("'", "",$row['name']);
                        $time = mdate('%H:%i ',strtotime($row['meetup_time']));
                        $meetup_date = $date_S;
                        $calender[]="{ id: $id,title: '$name',time: '$time',start: '$meetup_date', color: '#5bc0de',className:'event'}";

                        $calenderjs=implode(", ",$calender);
                  }
              }
              echo $calenderdata="[ $calenderjs ]"; 
          }
         if(isset($get_calender_meals) && !empty($get_calender_meals))
          {
              
              foreach($get_calender_meals as $kys=>$row1)
              {
               
                 $rec_val = $row1['recurring'];
                 $rec_explode = explode(',', $rec_val );
                 $length = count($rec_explode);
                 $recring = array();
                 foreach ($rec_explode  as $key2 => $day) {
                   # code...
                     switch ($day) {
                          case "S":
                            $recring[$day] = 'Sun';
                              break;
                          case "M":
                            $recring[$day] = 'Mon';
                              break;
                          case "T":
                            $recring[$day] = 'Tue';
                              break;
                          case "W":
                              $recring[$day] = 'Wed';
                              break;
                          case "Th":
                            $recring[$day] = 'Thu';
                              break;
                          case "F":
                              $recring[$day] = 'Fri';
                              break;
                          case "St":
                             $recring[$day] = 'Sat';
                              break;    
                         
                        }
                 
                   }

      
     $date_S = date('Y-m-d');
     $date_E = date('Y-m-d', strtotime($date_S . ' +90 day'));
   
       if ( $date_S != $date_E ) {
        
       $begin =  new DateTime( $date_S);
       $stop_date = date('Y-m-d', strtotime($date_E . ' +1 day'));
       $end = new DateTime( $stop_date  );
       
       $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

        $data_calender = array();
        foreach ($recring as $key4 => $recring_val) {
       
        foreach($daterange as $key3 => $date){
               

                $string = $date->format("Y-m-d");
                $timestamp = strtotime($string);
                $day =  date("D", $timestamp);
               if ($day == $recring_val) {
                # code...
             
                $id = $row1['id'];

                $name =  str_replace("'", "",$row1['name']);
                $time = mdate('%H:%i ',strtotime($row1['end_date']));
                $start_date = $date->format("Y-m-d");
                $calender[]="{ id: $id,title: '$name',time: '$time',start: '$start_date',color: '#2a3f54', className:'meal'}";

                $calenderjs=implode(", ",$calender);

                }
                
                }
             }
           }else{

                        $id = $row1['id'];

                        $name = str_replace("'", "",$row1['name']);
                        $time = mdate('%H:%i ',strtotime($row1['start_date']));
                        $meetup_date = $date_S;
                        $calender[]="{ id: $id,title: '$name',time: '$time',start: '$meetup_date',color: '#2a3f54', className:'meal'}";

                        $calenderjs=implode(", ",$calender);
            }
    
              }
              echo $calenderdata="[ $calenderjs ]"; 
          }
      ?>      

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            // defaultDate: '2016-01-12',
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: <?php echo isset($calenderdata)?$calenderdata:'';?>,
           
        });
    });

    $(document).on("mouseover", ".fc-event-container .fc-content", function(){
        var element = $(this);
        $(".fc-event-container .fc-content").removeClass("evt_detail");
        $(this).addClass("evt_detail");
        var event_id = $(".event .evt_detail span.fc-title").attr("data-id");
        var meal_id = $(".meal .evt_detail span.fc-title").attr("data-id");

        // console.log(event_id);
        // console.log(meal_id);
            
            var dataID="";
            var tablename="";
            var functionname="";
            if (event_id  !== null && meal_id == null) {
              dataID = event_id;
              tablename = 'ci_plan_event';
              functionname = 'getevent_srecord_byId_tables';
            }
            else if(meal_id !== null && event_id == null){

              dataID = meal_id;
              tablename = 'ci_plan_meal';
              functionname = 'getmeal_record_byId_tables';
              // console.log('meal');

            }

        if(!($(this).children().is('.fc-activity-detail')))
        {
            var post_data = { 
                'id'  :  dataID,
                'tablename' : tablename
            };
            //console.log(post_data);
            $.ajax({ 
                url: "<?php echo site_url('ajax/"+functionname+"'); ?>",
                type: "POST",
                data: post_data,
                dataType: "json",      
                success: function(response) //we're calling the response json array
                {   

                  // console.log(response);
                    var A_title = "";
                    var A_startDate = "";
                    if (response.event_name !== null && response.event_name !== undefined)
                    { 
                        A_title = response.event_name;
                    }
                    else if (response.meal_name !== null && response.meal_name !== undefined) 
                    { 
                        A_title = response.meal_name;
                    }
                    
                    if (response.meetup_time !== null && response.meetup_time !== undefined) 
                    { 
                        A_startDate = response.meetup_time; 
                    }
                    else if (response.start_date !== null && response.start_date !== undefined) 
                    { 
                        A_startDate = response.start_date;
                    }

                    var _html = "";
                    _html+="<div class='fc-activity-detail'>";
                        _html+="<div class='fc-activity-title'>"+A_title+"</div>";
                        _html+="<div class='fc-activity-body'>";
                            _html+="<div class='fc-activity-location'>";
                                _html+="<span class='fc-activity-label'>Location : </span>";
                                _html+="<span class='fc-activity-field'>"+response.location_name+"</span>";
                            _html+="</div>";
                            _html+="<div class='fc-activity-start'>";
                                _html+="<span class='fc-activity-label'>Start : </span>";
                                _html+="<span class='fc-activity-field'>"+A_startDate+"</span>";
                            _html+="</div>";
                            _html+="<div class='fc-activity-end'>";
                                _html+="<span class='fc-activity-label'>End : </span>";
                                _html+="<span class='fc-activity-field'>"+response.end_time+"</span>";
                            _html+="</div>";
                        _html+="</div>";
                    _html+="</div>";
                    element.prepend(_html);
                },
                error: function(response)
                {
                    console.log(response);
                }
                
            });            
        }
    });
    $(document).on("mouseout", ".fc-event-container .fc-content", function(){
        $(".fc-event-container .fc-content").removeClass("evt_detail");
    });

    $(document).on("click", ".fc-event-container .fc-content", function(){

        var element = $(this);
        $(".fc-event-container .fc-content").removeClass("evt_detail");
        $(this).addClass("evt_detail");
        
        var event_id = $(".event .evt_detail span.fc-title").attr("data-id");
        var meal_id = $(".meal .evt_detail span.fc-title").attr("data-id");

        var tableName = "";
        var dataID = "";
        var dataID = "";
        var modelID = "";
        var functionname = "";

        if (event_id  !== null && meal_id == null) {

            dataID = event_id;
            tableName = "ci_plan_event";
            modelID = "editEventModal";
            functionname = 'get_superevent_record_byId';

        }
        else if(meal_id !== null && event_id == null){
            dataID = meal_id;  
            tableName = "ci_plan_meal";
            modelID = "editMealModal";
            functionname = 'get_supermeal_record_byId';

        }

        $("#event_id").val('');
        $("#name").val('');
        $("#description").val('');
        $("#location_id").val('');
        $("#max_attendies").val('');
        $("#meetup_date").val('');
        $("#meetup_time").val('');
        $("#start_date").val('');
        $("#start_time").val('');
        $("#end_date").val('');
        $("#end_time").val('');
        $("#meal_type").val('');
        $("#is_active").val(1);
        $("#no_end_date").val(0);
        $(".inline-checkbox :checkbox").prop('checked', false);
        if(dataID != "") {

            var post_data = { 
                'id'  :  dataID,
                'tablename'  :  tableName
            };
          
            $.ajax({ 
                url: "<?php echo site_url('ajax/"+functionname+"'); ?>",
                type: "POST",
                data: post_data,
                dataType: "json",      
                success: function(response) //we're calling the response json array 'cities'
                {
                    console.log(response);
                    $('#'+modelID).modal('show');  

                    $("#delete_event").attr('href',"<?php echo site_url('event/delete/"+event_id+"') ;?>");
                    
                    if (response.name !== null && response.name !== undefined) {
                          $("#name").val(response.name);
                          $("#editMealModal #description").val(response.description);
                          $("#editMealModal #end_date").val(response.end_date);
                          $("#editMealModal #end_time").val(response.end_time);
                          $('#editMealModal #plan_meal_id').html(response.id);
                          $("#meal_type").val(response.meal_type);
                          $("#editMealModal #location_id").val(response.location_id);

                          if(response.no_end_date == 1)
                          {
                              $('#editMealModal #no_end_date').prop('checked', true);
                              $("#editMealModal #mainend_date").hide();
                          }
                          else
                          {
                              $('#editMealModal #no_end_date').prop('checked', false);
                              $("#editMealModal #mainend_date").show();
                          }

                    }

                    if (response.event_id !== null && response.event_id !== undefined) {
                          $("#plan-event-id").html(response.id);
                          $("#event_id").val(response.event_id);
                          $("#editEventModal #description").val(response.description);
                          $("#editEventModal #end_date").val(response.end_date);
                          $("#editEventModal #end_time").val(response.end_time);
                          $("#editEventModal #location_id").val(response.location_id);
                          
                          if(response.no_end_date == 1)
                          {
                            $('#editEventModal #no_end_date').prop('checked', true);
                            $("#editEventModal #mainend_date").hide();
                          }
                          else
                          {
                            $('#editEventModal #no_end_date').prop('checked', false);
                            $("#editEventModal #mainend_date").show();
                          }
                    }
                     
                    
                    $("#max_attendies").val(response.max_attendies);
                    $("#meetup_date").val(response.meetup_date);
                    $("#meetup_time").val(response.meetup_time);

                    $("#start_date").val(response.start_date);
                    $("#start_time").val(response.start_time);

                    if(response.is_active == 1)
                    {
                        $(".icheckbox_flat-green").addClass('checked');
                        $('#is_active').prop('checked', true);
                    }
                    else
                    {
                        // alert(response.is_active);
                        $(".icheckbox_flat-green").removeClass('checked');
                        $("#is_active").attr('checked', false);
                    }

                    if(response.recurring != '')
                    {
                        var arrRecurring = response.recurring.split(",");
                        // $.each(arrRecurring, function(idx,val) {
                            // alert(val);
                            $('.inline-checkbox :checkbox').filter(function () {
                                return $.inArray(this.value, arrRecurring) >= 0;
                            }).prop('checked', true);
                            // alert($(".recurring").attr('value','S').val());
                           // $(".recurring").attr('value',val).prop( "checked", true );
                        // });
                    }
                },
                error: function(response)
                {
                    console.log(response);
                }
            });            
        }
    });
</script>


<!-- Modal -->
<div class="calendar_edit modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="text_heading" style="text-align:center;">
        <h3 class="modal-title" id="myModalLabel"><i class="fa fa-envelope"></i> Edit Event</h3>
        <h5 class="modal-title">Edit the event by simply change the following fields:</h5>
      </div>
      </div>
      <div class="modal-body">
        <div class='message error'></div>        
        <div style="display:none" id='plan-event-id'> </div>  

        <?php
    
          if(!empty($form))
          {
            $i=0;
              echo "<div class='form-group'>"; 
                  echo "<div class='col-md-6'>";
                  echo isset($form['event_id']['label'])?$form['event_id']['label']:'';
                  echo '<div class="error_event_id message_message" style="display:none;"></div>';
                    if(isset($form['event_id']['errors']) && $form['event_id']['errors']!='' && count($form['event_id']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['event_id']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['event_id']['field'])?$form['event_id']['field']:'';
                echo "</div>";
                  echo "<div class='col-md-6'>";
                  echo isset($form['description']['label'])?$form['description']['label']:'';
                    if(isset($form['description']['errors']) && $form['description']['errors']!='' && count($form['description']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['description']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['description']['field'])?$form['description']['field']:'';
                echo "</div>";
              echo "</div>";
              echo "<div class='form-group'>"; 
                  echo "<div class='col-md-6'>";
                  echo isset($form['location_id']['label'])?$form['location_id']['label']:'';
                  echo '<div class="error_location_id message_message" style="display:none;"></div>';
                    if(isset($form['location_id']['errors']) && $form['location_id']['errors']!='' && count($form['location_id']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['location_id']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['location_id']['field'])?$form['location_id']['field']:'';
                echo "</div>";
                  echo "<div class='col-md-6'>";
                  echo isset($form['max_attendies']['label'])?$form['max_attendies']['label']:'';
                    if(isset($form['max_attendies']['errors']) && $form['max_attendies']['errors']!='' && count($form['max_attendies']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['max_attendies']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['max_attendies']['field'])?$form['max_attendies']['field']:'';
                echo "</div>";
              echo "</div>";
              echo "<div class='form-group'>"; 
                  echo "<div class='col-md-3'>";
                  echo isset($form['meetup_date']['label'])?$form['meetup_date']['label']:'';
                    if(isset($form['meetup_date']['errors']) && $form['meetup_date']['errors']!='' && count($form['meetup_date']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['meetup_date']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['meetup_date']['field'])?$form['meetup_date']['field']:'';
                  echo "</div>";

                  echo "<div class='col-md-2'>";
                  echo '<label for="meetup_time">Start Time</label>';
                    if(isset($form['meetup_time']['errors']) && $form['meetup_time']['errors']!='' && count($form['meetup_time']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['meetup_time']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['meetup_time']['field'])?$form['meetup_time']['field']:'';
                  echo "</div>";

                  echo "<div class='col-md-2'>";
                  echo isset($form['end_time']['label'])?$form['end_time']['label']:'';
                    if(isset($form['end_time']['errors']) && $form['end_time']['errors']!='' && count($form['end_time']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['end_time']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['end_time']['field'])?$form['end_time']['field']:'';
                echo "</div>";

                echo "<div class='col-md-3'>";
                // echo "<br>";
                  echo "<div class='col-md-1'>";
                  echo isset($form['no_end_date']['field'])?$form['no_end_date']['field']:'';
                  echo "</div>";
                  echo "<div class='col-md-11'>";
                  echo isset($form['no_end_date']['label'])?$form['no_end_date']['label']:'';
                    if(isset($form['no_end_date']['errors']) && $form['no_end_date']['errors']!='' && count($form['no_end_date']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['no_end_date']['errors'];
                      echo "</div>";
                    }
                  echo "</div>";
                echo "</div>";

                echo "<div class='col-md-2' id='mainend_date'>";
                  echo isset($form['end_date']['label'])?$form['end_date']['label']:'';
                    if(isset($form['end_date']['errors']) && $form['end_date']['errors']!='' && count($form['end_date']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['end_date']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['end_date']['field'])?$form['end_date']['field']:'';
                echo "</div>";
              echo "</div>";
              
              echo '<div class="form-group">';
                echo '<div class="col-md-12">';
                  echo isset($form['recurring']['label'])?$form['recurring']['label']:'';
                  echo '<div class="row-fluid">';
                
                  if(isset($form['recurring']['errors']) && $form['recurring']['errors']!='' && count($form['recurring']['errors'])>0) { ?>
                      <div class="message_message">
                         <?php echo $form['recurring']['errors']; ?>
                      </div>
                    <?php }     
                      echo "<ul class='inline-checkbox'>";
                  foreach ($form['recurring'] as $key=>$formrol)
                  {
                    if($key != 'label')
                    {
                      
                      echo "<li class='col-md-2'>";                              
                      echo isset($formrol['field'])?$formrol['field']:'';
                      
                      echo isset($formrol['role_label'])?$formrol['role_label']:'';
                      echo "</li>";
                      // $j++;                           
                    }                         
                  }
                echo "</ul>";                  
                echo "</div>";
                echo "</div>";              
              echo "</div>";
              echo "<div class='form-group'>"; 
                echo "<div class='col-md-4'>";                     
                    echo "<div class='col-md-2 no-padd'>";                     
                      echo isset($form['is_active']['field'])?$form['is_active']['field']:'';
                    echo "</div>";                   
                    echo "<div class='col-md-10 no-padd'>"; 
                      echo isset($form['is_active']['label'])?$form['is_active']['label']:'';
                    echo "</div>";
                echo "</div>";
                echo "<div class='col-md-8'>&nbsp;</div>";
              echo "</div>";
              echo "<div class='form-group' style='clear:both;'>"; 
                echo "<div class='col-md-4'>"; 
                    echo '<div class="update_event"><button type="button" class="btn btn-primary" id="update_event">Update Event</button>';
                    echo "</div>";
                echo "</div>";
                echo "<div class='col-md-8'>"; 
          }

        ?>     
        
                <div class="loading-spinner" style="display:none;">
                  <img src="<?php echo base_url().'images/img/loading_icon.gif';?>" style="height:45px;">
                </div>
            </div>
        </div>
        <p class="member-or-not" style="clear:both;">Do you want to delete this event? 
            <a  class="label label-danger" id="delete_event" title="Delete" onclick="return confirm('Do you want to permanent delete this event?')"><i class="fa fa-trash"></i> Delete Event</a>
        </p>
      </div>
    </div>


  </div>
</div>

<!-- Modal -->
<div class="calendar_edit modal fade" id="editMealModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="text_heading" style="text-align:center;">
        <h3 class="modal-title" id="myModalLabel"><i class="fa fa-envelope"></i> Edit Meal</h3>
        <h5 class="modal-title">Edit the Meal by simply change the following fields:</h5>
      </div>
      </div>
      <div class="modal-body">
        <div class='message error'></div>        
        <!-- <div id='plan_meal_id'></div>   -->

      <?php
          if(!empty($form))
          {
             $i=0;
            echo isset($startform)?$startform:'';
              echo "<div class='form-group'>"; 
                 
                  echo "<div class='col-md-3'>";
                  echo isset($form['location_id']['label'])?$form['location_id']['label']:'';
                    if(isset($form['location_id']['errors']) && $form['location_id']['errors']!='' && count($form['location_id']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['location_id']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['location_id']['field'])?$form['location_id']['field']:'';
                echo "</div>";
                  echo "<div class='col-md-6'>";
                  echo isset($form['description']['label'])?$form['description']['label']:'';
                    if(isset($form['description']['errors']) && $form['description']['errors']!='' && count($form['description']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['description']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['description']['field'])?$form['description']['field']:'';
                echo "</div>";
              echo "</div>";
              echo "<div class='form-group'>"; 
                echo "<div class='col-md-4'>";
                  echo isset($form['meal_type']['label'])?$form['meal_type']['label']:'';
                  if (isset($form['meal_type']['errors']) && $form['meal_type']['errors']!='' && count($form['meal_type']['errors'])>0) {                              
                      echo "<div class='message_message'>";
                        echo $form['meal_type']['errors'];
                      echo "</div>";  
                  }
                  echo isset($form['meal_type']['field'])?$form['meal_type']['field']:'';
                echo "</div>";
                echo "<div class='col-md-4'>";
                  echo isset($form['start_time']['label'])?$form['start_time']['label']:'';
                    if(isset($form['start_time']['errors']) && $form['start_time']['errors']!='' && count($form['start_time']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['start_time']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['start_time']['field'])?$form['start_time']['field']:'';
                echo "</div>";

                echo "<div class='col-md-4'>";
                  echo isset($form['end_time']['label'])?$form['end_time']['label']:'';
                    if(isset($form['end_time']['errors']) && $form['end_time']['errors']!='' && count($form['end_time']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['end_time']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['end_time']['field'])?$form['end_time']['field']:'';
                echo "</div>";
                
              echo '<div class="form-group">';
                echo '<div class="col-md-12">';
                  echo isset($form['recurring']['label'])?$form['recurring']['label']:'';
                  echo '<div class="row-fluid">';
                
                  if(isset($form['recurring']['errors']) && $form['recurring']['errors']!='' && count($form['recurring']['errors'])>0) { ?>
                      <div class="message_message">
                         <?php echo $form['recurring']['errors']; ?>
                      </div>
                    <?php }     
                      echo "<ul class='inline-checkbox'>";
                  foreach ($form['recurring'] as $key=>$formrol)
                  {
                    if($key != 'label')
                    {
                      echo "<li class='col-md-1'>";                              
                      echo isset($formrol['field'])?$formrol['field']:'';
                      
                      echo isset($formrol['role_label'])?$formrol['role_label']:'';
                      echo "</li>";
                      // $j++;                           
                    }                         
                  }
                echo "</ul>";                  
                echo "</div>";
                echo "</div>";              
              echo "</div>";

              echo "<div class='form-group'>"; 
                echo "<div class='col-md-6'>";                     
                    echo "<div class='col-md-1 no-padd'>";                     
                      echo isset($form['is_active']['field'])?$form['is_active']['field']:'';
                    echo "</div>";                   
                    echo "<div class='col-md-11 no-padd'>"; 
                      echo isset($form['is_active']['label'])?$form['is_active']['label']:'';
                    echo "</div>";
                echo "</div>";
              echo "</div>";
              echo "<div class='form-group'>"; 
                echo "<div class='col-md-12'>";                 
                  echo '<div class="update_event"><button type="button" class="btn btn-primary" id="update_meal">Update Meal</button>';
                echo "</div>";
             

            echo isset($endform)?$endform:'';
      
          }

        ?>     
        
                <div class="loading-spinner" style="display:none;">
                  <img src="<?php echo base_url().'images/img/loading_icon.gif';?>" style="height:45px;">
                </div>
            </div>
        </div>
        <p class="member-or-not" style="clear:both;">Do you want to delete this event? 
            <a  class="label label-danger" id="delete_event" title="Delete" onclick="return confirm('Do you want to permanent delete this event?')"><i class="fa fa-trash"></i> Delete Event</a>
        </p>
      </div>
    </div>
</div>
</div>



<script type="text/javascript">
    $(document).on("click","#editEventModal #update_event",function() {
        $(".error_event_id").hide();
        $(".message.error").html("");

        var event_id = $("#editEventModal select[name='event_id']").val();
        var description = $("textarea[name='description']").val();
        var location_id = $("select[name='location_id']").val();
        var max_attendies = $("input[name='max_attendies']").val();
        var meetup_date = $("input[name='meetup_date']").val();
        var meetup_time = $("input[name='meetup_time']").val();
        var end_date = $("input[name='end_date']").val();
        var end_time = $("input[name='end_time']").val();        
        var is_active = $("#is_active").is(':checked') ? 1 : 0;     
        var no_end_date = $("#no_end_date").is(':checked') ? 1 : 0;     
        var arrRecurring=[];
        var i = 0;
        // alert(is_active);
        $('#editEventModal input[name="recurring[]"]:checked').each(function() {
            arrRecurring.push(this.value);
        });
        var recurring = arrRecurring.join(",");
        console.log(recurring);
        // exit('update');

        if(event_id == "")
        {
          $(".error_event_id").show();
          $(".error_event_id").html("The Event Id field is required!");
          console.log('event id not found');

        }
        if(location_id == "")
        {
          console.log('location id not found');
          $(".error_location_id").show();
          $(".error_location_id").html("The Location Id field is required!");
        }

        if (event_id != "" && location_id != "")
        {           
            $(".loading-spinner").show();
            var post_data = { 
                'id'  :  parseInt($('#editEventModal #plan-event-id').html()),
                'event_id'  :  event_id,
                'description'  :  description,
                'location_id'  :  location_id,
                'max_attendies'  :  max_attendies,
                'meetup_date'  :  meetup_date,
                'meetup_time'  :  meetup_time,
                'end_date'  :  end_date,
                'end_time'  :  end_time,
                'is_active'  :  is_active,
                'no_end_date'  :  no_end_date,
                'recurring'  :  recurring
            };
            $.ajax({ 
                url: "<?php echo site_url('event/superadmin_ajax_update'); ?>",
                type: "POST",
                data: post_data,
                dataType: "json",      
                success: function(response) //we're calling the response json array 'cities'
                {
                  console.log(response);
                    $(".message.error").html("<div class='flash success'>Record has been updated successfully.</div>");   
                    setTimeout(function() {
                      window.location.href = window.location.href;
                    }, 2000);
          // window.location = delay(1800).window.location.href;
                    $(".loading-spinner").hide();
                },
                error: function(response)
                {
                    console.log(response);
                    $(".loading-spinner").hide();
                }
            });  
        }
    });

  $(document).on("click","#editMealModal #update_meal",function() {

        $(".error_event_id").hide();
        $(".message.error").html("");

        var meal_id = parseInt($('#editMealModal #plan_meal_id').html());
        
        var name_meal = $("#editMealModal input[name='name']").val();
        var description = $("#editMealModal textarea[name='description']").val();
        var location_id = $("select[name='location_id']").val();
        var start_date = $("#editMealModal input[name='start_date']").val();
        var start_time = $("#editMealModal input[name='start_time']").val();
        var end_date = $("#editMealModal input[name='end_date']").val();
        var end_time = $("#editMealModal input[name='end_time']").val();
        var meal_type = $("#editMealModal select[name='meal_type']").val();
        var is_active = $("#editMealModal #is_active").is(':checked') ? 1 : 0;     
        var no_end_date = $("#editMealModal #no_end_date").is(':checked') ? 1 : 0;     
        var arrRecurring=[];
        var i = 0;
        // alert(is_active);
        $('#editMealModal input[name="recurring[]"]:checked').each(function() {
            arrRecurring.push(this.value);
        });
        var recurring = arrRecurring.join(",");
        console.log(recurring);
        

        if(meal_id == "")
        {
          $("#editMealModal .error_event_id").show();
          $("#editMealModal .error_event_id").html("The Meal Id field is required!");
        }
        if(location_id == "")
        {
          
          $(".error_location_id").show();
          $(".error_location_id").html("The Location Id field is required!");
        }

        if (meal_id != "" && location_id != "")
        {           
             
            $(".loading-spinner").show();
            var post_data = { 
                'id'  :   parseInt($('#plan_meal_id').html()),
                'name'  :  name_meal,
                'description'  :  description,
                'meal_id'  :  meal_id,
                'location_id'  :  location_id,
                'start_date'  :  start_date,
                'start_time'  :  start_time,
                'end_date'  :  end_date,
                'end_time'  :  end_time,
                'is_active'  :  is_active,
                'no_end_date'  :  no_end_date,
                'recurring'  :  recurring,
                'meal_type' : meal_type
            };
        
           $.ajax({ 
                url: "<?php echo site_url('meal/superadmin_ajax_update'); ?>",
                type: "POST",
                data: post_data,
                dataType: "json",      
                success: function(response) //we're calling the response json array 'cities'
                {
                    $(".message.error").html("<div class='flash success'>Record has been updated successfully.</div>");   
                    setTimeout(function() {
                      window.location.href = window.location.href;
                    }, 2000);
          // window.location = delay(1800).window.location.href;
                    $(".loading-spinner").hide();
                },
                error: function(response)
                {
                    console.log(response);
                    $(".loading-spinner").hide();
                }
            });              
        }
    });


    $(document).on("change","#event_id",function() {
      var event_id = $(this).val();
      var post_data = { 
          'id'  :  event_id,
          'tablename'  :  'ci_event'
      };
      $.ajax({ 
          url: "<?php echo site_url('ajax/get_record_byId'); ?>",
          type: "POST",
          data: post_data,
          dataType: "json",      
          success: function(response) //we're calling the response json array 'cities'
          {
            // console.log(response);
            $("#description").val(response.description);
            $("#max_attendies").val(response.max_attendies);
          },
          error: function(response)
          {
          }
          
      });
    });
    $(document).ready(function () {
      var currentDate = $("#meetup_date").val(); 
      $('#meetup_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
      $("#meetup_date").datepicker("setDate", currentDate); 
      $('#meetup_time').timepicker({ 'step': 15,'scrollDefault': 'now','timeFormat': 'H:i A' });

        // var currentDate = $("#meetup_date").val(); 
      $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
      $("#end_date").datepicker("setDate", currentDate); 
      $('#end_time').timepicker({ 'step': 15,'scrollDefault': 'now','timeFormat': 'H:i A' });
   

    var currentDate1 = $("#start_date").val(); 
      $('#start_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",});
      $("#start_date").datepicker("setDate", currentDate1); 
      $('#start_time').timepicker({ 'step': 15, 'scrollDefault': 'now','timeFormat': 'H:i A' });

        // var currentDate = $("#meetup_date").val(); 
      $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",});
      $("#end_date").datepicker("setDate", currentDate1); 
      $('#end_time').timepicker({ 'step': 15, 'scrollDefault': 'now','timeFormat': 'H:i A' });
    });


 var getval=$("input#no_end_date").val();
  // alert(getval);
    if($("input#no_end_date").is(":checked"))
      $("#mealnodate").hide();
    else
      $("#mealnodate").show();

    $("input#no_end_date").click(function(){
        $("#mealnodate").toggle();
      });


</script>