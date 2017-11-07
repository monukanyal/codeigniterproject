<?php
    $admin_id = $this->session->userdata['logged_in']['admin_id'];
  $send_data['admin_id'] = $admin_id;
 $get_calender_events=$this->event_model->get_calender_events($send_data, 'ci_plan_event');
 $get_calender_meals=$this->meal_model->get_calender_meals($send_data, 'ci_plan_meal');
  $meals_withdate=$this->meal_model->get_calender_meals_withdate($send_data,'ci_plan_meal');
 //echo "<pre>";
 //print_r($meals_withdate);
 //echo "calendar test";

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
                            <!--@mkcode start  [id,meal/event]-->
                            <input type="hidden" id="currentevent" value="">
                            <!-- @mkcode end-->
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

                        $name = $row['name'];
                        $location=$row['location_name'];  //<--mkcode
                        if($location==''){
                        $location='Not Available';
                        }  //<--mkcode
                       $end_time = mdate('%H:%i ',strtotime($row['end_time']));//<--mkcode
                        $time = mdate('%H:%i ',strtotime($row['meetup_time']));
                        $etime  = date("g:i a", strtotime($end_time));
                        $stime  = date("g:i a", strtotime($time));
                        $meetup_date = $date->format("Y-m-d");
                     $calender[]='{ id: "'.$id.'",title: "'.$name.'",time: "'.$stime.'",start: "'.$meetup_date.'", color: "#5bc0de",className:"event",location: "'.$location.'",end_time:"'.$etime.'",t1:"'.$time.'",t2:"'.$end_time.'"}'; //@mkcode

                        $calenderjs=implode(", ",$calender);

                        }
                        
                  }
                  }
                  }else{

                    $id = $row['id'];

                        $name = $row['name'];
                         $location=$row['location_name'];  //<--mkcode
                         if($location==''){
                          $location='Not Available';
                          }  //<--mkcode
                        $end_time = mdate('%H:%i ',strtotime($row['end_time']));//<--mkcode
                        $time = mdate('%H:%i ',strtotime($row['meetup_time']));
                        $etime  = date("g:i a", strtotime($end_time));
                        $stime  = date("g:i a", strtotime($time));
                        $meetup_date = $date_S;
                        $calender[]='{ id: "'.$id.'",title: "'.$name.'",time: "'.$stime.'",start: "'.$meetup_date.'", color: "#5bc0de",className:"event",location: "'.$location.'",end_time:"'.$etime.'",t1:"'.$time.'",t2:"'.$end_time.'"}'; //@mkcode
                    
                        $calenderjs=implode(", ",$calender);
                  }
              }
               $calenderdata="[ ".$calenderjs." ]"; 
               print_r($calenderdata);
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
                          $location=$row1['location_name'];  //<--mkcode
                          if($location=='')
                          {
                          $location='Not Available';
                          }  //<--mkcode
                         
                          $name = $row1['name'];
                          $time = mdate('%H:%i ',strtotime($row1['start_time'])); //<--mkcode
                          $end_time = mdate('%H:%i ',strtotime($row1['end_time']));//<--mkcode
                           $etime  = date("g:i a", strtotime($end_time));
                            $stime  = date("g:i a", strtotime($time));
                          $start_date = $date->format("Y-m-d");
                          $calender[]='{ id: "'.$id.'",title: "'.$name.'",time: "'.$stime.'",start: "'.$start_date.'",color: "#2a3f54", className:"meal",location: "'.$location.'",end_time:"'.$etime.'",t1:"'.$time.'",t2:"'.$end_time.'"}';  //@mkcode

                          //$calenderjs=implode(", ",$calender);

                          }
                          
                          }
                       }
                }else{

                        $id = $row1['id'];
                        $location=$row1['location_name'];  //<--mkcode
                        if($location==''){
                          $location='Not Available';
                          }  //<--mkcode
                        
                        $name = $row1['name'];
                        $end_time = mdate('%H:%i ',strtotime($row1['end_time']));//<--mkcode
                        $time = mdate('%H:%i ',strtotime($row1['start_time']));  //<--mkcode
                         $etime  = date("g:i a", strtotime($end_time));
                         $stime  = date("g:i a", strtotime($time));
                        $meetup_date = $date_S;
                        $calender[]='{ id: "'.$id.'",title: "'.$name.'",time: "'.$stime.'",start: "'.$start_date.'",color: "#2a3f54", className:"meal",location: "'.$location.'",end_time:"'.$etime.'",t1:"'.$time.'",t2:"'.$end_time.'"}';  //@mkcode

                        //$calenderjs=implode(", ",$calender);
                 }
    
           }  //for loop end
            //new changes meal with date
          if(isset($meals_withdate) && !empty($meals_withdate))
          {
               
             foreach ($meals_withdate as $key => $rows) {
                 $recur = $rows['recurring'];
                $recur_day = explode(',', $recur );
                foreach ($recur_day as &$str) {
                $str = str_replace('Th','thu', $str);
                $str = str_replace('T','tue', $str);
                $str = str_replace('S','sun', $str);
                $str = str_replace('M','mon', $str);
                $str = str_replace('W','wed', $str);
                $str = str_replace('F','fri', $str);
                $str = str_replace('St','sat', $str);
                }
               // print_r($recur_day);
              
                $date1 = $rows['start_date'];  //y-m-d
                $date2 = $rows['end_date'];
                 $start_date=strtotime($date1);
                 $end_date=strtotime($date2);
                for($j=0;$j<count($recur_day);$j++)
                {
                   
                    $listday= mygetdate($recur_day[$j],$start_date,$end_date);
                        for($k=0;$k<count($listday);$k++)
                        {
                            $id = $rows['id'];
                            $location=$rows['location_name'];  //<--mkcode
                            if($location=='')
                            {
                             $location='Not Available';
                            }  //<--mkcode

                            $name = $rows['name'];
                            $time = mdate('%H:%i ',strtotime($rows['start_time'])); //<--mkcode
                            $stime  = date("g:i a", strtotime($time));
                            $end_time = mdate('%H:%i ',strtotime($rows['end_time']));//<--mkcode
                            $etime  = date("g:i a", strtotime($end_time));
                            $meetup_date = $listday[$k];
                            //echo "<br>".$meetup_date;
                            $calender[]="{ id: $id,title: '$name',className:'meal',color: '#2a3f54', time:'$stime',start: '$meetup_date',location: '$location',end_time:'$etime',t1:'$time',t2:'$end_time'}";
                        }
                     
                }
                  
               
            }

          }
          $calenderjs=implode(", ",$calender);
             $calenderdata="[ ".$calenderjs." ]"; 
        }

      function mygetdate($day,$start_date,$end_date)
      {
         $listday=array();
         $dayofdate = date('D', $start_date);
           $dayofdate2 = date('D', $end_date);
             if(strtolower($dayofdate2)==$day)
              {
                $listday[]=date("Y-m-d",$end_date);
              }
                if(strtolower($dayofdate)==$day)
                {
                  $listday[]=date("Y-m-d",$start_date);
                }
                    while($start_date<$end_date){
                    $start_date=strtotime("next $day", $start_date);
                    if($start_date>$end_date)
                    {
                      break;
                    }
                     $listday[]=date("Y-m-d",$start_date);
                   // echo "Next $day: ".date("Y-m-d",$start_date)."</br>";

                  }
                  return $listday;
               
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
            eventOrder: "t1",  //sort by t1 24 hrs 
            eventMouseover: function(event) {
                //alert(event.id);
               // console.log(event);
              var event_id=event.id;
               var tooltip = '<div class="tooltipevent" style="padding-left:2%;width:18%;height:120px;background:black;color:white;position:absolute;z-index:10001;"><p>Title:'+ event.title +'</p><p>Location:'+event.location+'</p><p>Meetuptime:'+event.time+'</p><p>EndTime:'+event.end_time+'</p></div>';
                      var $tooltip = $(tooltip).appendTo('body');
                      $(this).mouseover(function(e) {
                          $(this).css('z-index', 10000);
                          $tooltip.fadeIn('500');
                          $tooltip.fadeTo('10', 1.9);
                      }).mousemove(function(e) {
                          $tooltip.css('top', e.pageY + 10);
                          $tooltip.css('left', e.pageX + 20);
                      });
                        
                  },
                  eventMouseout: function(calEvent, jsEvent) {
                      $(this).css('z-index', 8);
                      $('.tooltipevent').remove();
                  },

            eventClick:function(event,jsEvent){
              //alert(event.id);
              var event_id=event.id;
              $('#currentevent').val(event_id+','+event.className);

            }
        });
    });

    

    $(document).on("click", ".fc-event-container .fc-content", function(){

        var element = $(this);
        $(".fc-event-container .fc-content").removeClass("evt_detail");
        $(this).addClass("evt_detail");
        //@mkcode start
        var currentinfo=$('#currentevent').val();
        var myarr = currentinfo.split(",");
        console.log(myarr);
        if(myarr[1]=='meal')
        {
          var meal_id=myarr[0];
          var event_id=null;
        }
        else if(myarr[1]=='event')
        {
          var event_id=myarr[0];
          var meal_id=null;
        }
        //@mkcode end
      //  var event_id = $(".event .evt_detail span.fc-title").attr("data-id");  //old code comment
       // var meal_id = $(".meal .evt_detail span.fc-title").attr("data-id");     //old code comment

        var tableName = "";
        var dataID = "";
        var dataID = "";
        var modelID = "";
        if (event_id  !== null && meal_id == null) {

            dataID = event_id;
            tableName = "ci_plan_event";
            modelID = "editEventModal"

        }
        else if(meal_id !== null && event_id == null){
             
            dataID = meal_id;  
            tableName = "ci_plan_meal";
           modelID = "editMealModal"

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
        $("#is_active").val(1);
        $("#no_end_date").val(0);
        $(".inline-checkbox :checkbox").prop('checked', false);
        if(dataID != "") {

            var post_data = { 
                'id'  :  dataID,
                'tablename'  :  tableName
            };
          
            $.ajax({ 
                url: "<?php echo site_url('ajax/get_record_byId'); ?>",

                type: "POST",
                data: post_data,
                dataType: "json",      
                success: function(response) //we're calling the response json array 'cities'
                {
                    $('#'+modelID).modal('show');    

                    $("#delete_event").attr('href',"<?php echo site_url('event/delete/"+event_id+"') ;?>");
                    console.log(response);
                    if (response.name != null && response.name != undefined){
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

                    if (response.event_id != null && response.event_id != undefined){
                  
                          $("#plan-event-id").html(response.id);
                          $("#event_id").val(response.event_id);
                          $("#editEventModal #description").val(response.description);
                          $("#editEventModal #end_date").val(response.end_date);
                          $("#editEventModal #mend_time").val(response.end_time);
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
                     
                    //$("#location_id").val(response.location_id);
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
        <h5 class="modal-title">Edit the Event by simply change the following fields:</h5>
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
                    ?>
                    <input type='text' id='mend_time' name='end_time' value='' style="width: 100%">
                  <?php
                  //echo isset($form['end_time']['field'])?$form['end_time']['field']:'';
                echo "</div>";

                echo "<div class='col-md-2'>";
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

                echo "<div class='col-md-3' id='mainend_date'>";
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
        <div id='plan_meal_id' style="display:none"></div>  
        <div id='location_htm' style="display:none"></div>  
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
                url: "<?php echo site_url('event/ajax_update'); ?>",

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

  $(document).on("click","#editMealModal #update_meal",function() {

        $(".error_event_id").hide();
        $(".message.error").html("");

        var meal_id = parseInt($('#editMealModal #plan_meal_id').html());
        var location_id = parseInt($('#editMealModal #location_htm').html());
        
        var name_meal = $("#editMealModal input[name='name']").val();
        var description = $("#editMealModal textarea[name='description']").val();
        // var location_id = $("select[name='location_id']").val();
        var start_date = $("#editMealModal input[name='start_date']").val();
        var start_time = $("#editMealModal input[name='start_time']").val();
        var end_date = $("#editMealModal input[name='end_date']").val();
        var end_time = $("#editMealModal input[name='end_time']").val();
        var meal_type = $("select[name='meal_type']").val();
        var is_active = $("#editMealModal #is_active").is(':checked') ? 1 : 0;     
        var no_end_date = $("#editMealModal #no_end_date").is(':checked') ? 1 : 0;     
        var arrRecurring=[];
        var i = 0;
        // alert(is_active);
        $('#editMealModal input[name="recurring[]"]:checked').each(function() {
            arrRecurring.push(this.value);
        });
        var recurring = arrRecurring.join(",");
        

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
                'name'  :  meal_type,  //@mkcode
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
        console.log(post_data);

           $.ajax({ 
                url: "<?php echo site_url('meal/ajax_update'); ?>",

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
    /*  var currentDate = $("#meetup_date").val(); 
      $('#meetup_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
      $("#meetup_date").datepicker("setDate", currentDate); 
      $('#meetup_time').timepicker({ 'step': 15,'scrollDefault': 'now','timeFormat': 'H:i A' });

        // var currentDate = $("#meetup_date").val();  //already commented
      $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
      $("#end_date").datepicker("setDate", currentDate); 
      $('#end_time').timepicker({ 'step': 15,'scrollDefault': 'now','timeFormat': 'H:i A' });
   

    var currentDate1 = $("#start_date").val(); 
      $('#start_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",});
      $("#start_date").datepicker("setDate", currentDate1); 
      $('#start_time').timepicker({ 'step': 15, 'scrollDefault': 'now','timeFormat': 'H:i A' });

        // var currentDate = $("#meetup_date").val();  //already commented
      $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",});
      $("#end_date").datepicker("setDate", currentDate1); 
      $('#end_time').timepicker({ 'step': 15, 'scrollDefault': 'now','timeFormat': 'H:i A' });  */

      //@mkcode start

          $("#meetup_date").datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeMonth: true,
          minDate: new Date(),
          maxDate: '+2y',
          onSelect: function(date){

              var selectedDate = new Date(date);
              var msecsInADay = 86400000;
              var endDate = new Date(selectedDate.getTime() + msecsInADay);

              $("#end_date").datepicker( "option", "minDate", endDate );
              $("#end_date").datepicker( "option", "maxDate", '+2y' );

          }
      });

      $("#end_date").datepicker({ 
          dateFormat: 'yy-mm-dd',
          changeMonth: true,
          minDate: new Date()

      });

         $('#meetup_time').timepicker({ 'step': 15 ,'timeFormat': 'H:i'});

          function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
          function z(n){
            return (n<10? '0':'') + n;
          }
          var bits = time.split(':');
          var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

          return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
        }  

        $('#meetup_time').on('changeTime', function() {
          var startTime = $(this).val().split(':');
          var getmin  = startTime[1].split(' ');
          var gettime = startTime[0]+':'+getmin[0];
          
          var endHours = addMinutes(gettime, '30');
          var endHourssplit = endHours.split(':');
          // if(endHourssplit[0] == '12' && getmin[1]== 'AM')
          // {
          //    setampm = 'PM';
          // } 
          // else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
          // {
          //    setampm = 'AM';
          // } 
          // else
          // {
          //   setampm = getmin[1];
          // }
        //  setampm = getmin[1];
          //$('#end_time').val(endHours +" "+setampm);
          $('#mend_time').val(endHours);
        });
         
         $('#mend_time').timepicker({ 'step': 15,'timeFormat': 'H:i' });

          //--------
          $('#start_time').timepicker({ 'step': 15 ,'timeFormat': 'H:i'});
           $('#end_time').timepicker({ 'step': 15,'timeFormat': 'H:i' });
          function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
          function z(n){
            return (n<10? '0':'') + n;
          }
          var bits = time.split(':');
          var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

          return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
        }  

        $('#start_time').on('changeTime', function() {
          var startTime = $(this).val().split(':');
          var getmin  = startTime[1].split(' ');
          var gettime = startTime[0]+':'+getmin[0];
          
          var endHours = addMinutes(gettime, '30');
          var endHourssplit = endHours.split(':');
          // if(endHourssplit[0] == '12' && getmin[1]== 'AM')
          // {
          //    setampm = 'PM';
          // } 
          // else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
          // {
          //    setampm = 'AM';
          // } 
          // else
          // {
          //   setampm = getmin[1];
          // }
        //  setampm = getmin[1];
          //$('#end_time').val(endHours +" "+setampm);
          $('#end_time').val(endHours);
        });
         
         //$('#end_time').timepicker({ 'step': 15,'timeFormat': 'H:i' });


         //@mkcode end

    });


 var getval=$("input#no_end_date").val();
  // alert(getval);
    if($("input#no_end_date").is(":checked"))
      $("#mainend_date").hide();
    else
      $("#mainend_date").show();

    $("input#no_end_date").click(function(){
        $("#mainend_date").toggle();
      });

$( "#editMealModal #location_id" )
  .change(function () {
    var str = "";
    $( "#editMealModal #location_id option:selected" ).each(function() {
      str += $( this ).val() + " ";
    });
    $( "#location_htm" ).text( str );
  })
  .change();
</script>
