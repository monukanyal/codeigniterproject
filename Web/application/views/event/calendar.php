<?php
  $admin_id = $this->session->userdata['logged_in']['admin_id'];
  //echo "vhfvghdgvfhgdf",$admin_id;
  $send_data['admin_id'] = $admin_id;
 // print_r($send_data);
  $get_calender_events=$this->event_model->get_calender_events($send_data, 'ci_plan_event');
   //print_r($get_calender_events);
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Activity Management <small>Listing</small></h3>
                    <button onClick="window.location='<?php echo site_url('event'); ?>'" class="btn btn-info btn-xs">List View</button>
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
                            <h2>Daily active activity <small>Grid List</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.open('<?php echo site_url().'/Pdfexample'; ?>');" class="btn btn-info btn-xs">Calender PDF</button></li>
                                <li><button onClick="window.open('<?php echo site_url().'/event/add'; ?>');" class="btn btn-info btn-xs">Add New</button></li>
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
                            <!--@mkcode start-->
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
    if(isset($get_calender_events) && !empty($get_calender_events))
    {
     // print_r($get_calender_events);
       $calender = array();
  foreach ($get_calender_events as $key => $row) {

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
          $end =  new DateTime( $date_E);
         
          // $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
          //print_r($daterange);
          $data_calender = array();
          foreach ($recring as $key4 => $recring_val) 
          {
            $begin =  new DateTime( $date_S);
            $end =  new DateTime( $date_E);
            $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

            foreach($daterange as $key3 => $date)
            {
                  $string = $date->format("Y-m-d");
                  $timestamp = strtotime($string);
                  $day =  date("D", $timestamp);
                 if ($day == $recring_val) {
                  # code...
               
                  $id = $row['id'];
                  $location=$row['location_name'];  //<--mkcode
                   $name = $row['name'];
                  $end_time = mdate('%H:%i ',strtotime($row['end_time']));//<--mkcode
                  $time = mdate('%H:%i ',strtotime($row['meetup_time']));
                  $etime  = date("g:i a", strtotime($end_time));
                  $stime  = date("g:i a", strtotime($time));
                  $meetup_date = $date->format("Y-m-d");
                 // $calender[]="{ id: $id,title: '$name',time: '$time',start: '$meetup_date'}";  //<--mkcode 
                  $calender[]='{ id: "'.$id.'",title: "'.$name.'",time: "'.$stime.'",start: "'.$meetup_date.'",location: "'.$location.'",end_time:"'.$etime.'",t1:"'.$time.'",t2:"'.$end_time.'"}';  //<--mkcode 
                  $calenderjs=implode(", ",$calender);

                  }
                  
          }
       }
      }else{

                    $id = $row['id'];
                   $name = $row['name'];
                  $location=$row['location_name'];  //<--mkcode
                  $end_time = mdate('%H:%i ',strtotime($row['end_time']));//<--mkcode
                  $time = mdate('%H:%i ',strtotime($row['meetup_time']));
                  $etime  = date("g:i a", strtotime($end_time));
                  $stime  = date("g:i a", strtotime($time));
                  $meetup_date = $date_S;
                  //$calender[]="{ id: $id,title: '$name',time: '$time',start: '$meetup_date'}"; 
                  $calender[]='{ id: "'.$id.'",title: "'.$name.'",time: "'.$stime.'",start: "'.$meetup_date.'",location: "'.$location.'",end_time:"'.$etime.'",t1:"'.$time.'",t2:"'.$end_time.'"}';  //<--mkcode 
                
                  $calenderjs=implode(", ",$calender); 
      }

    }
          $calenderdata="[ ".$calenderjs." ]"; 

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
               eventOrder: "t1",  //sort by t1 24 hrs 
              events: <?php echo isset($calenderdata)?$calenderdata:'';?>,
               eventMouseover: function(event) {
                //alert(event.id);
                var event_id=event.id;
               var tooltip = '<div class="tooltipevent" style="width:18%;height:120px;background:black;color:white;position:absolute;z-index:10001;"><p>Title:'+ event.title +'</p><p>Location:'+event.location+'</p><p>Meetuptime:'+event.time+'</p><p>EndTime:'+event.end_time+'</p></div>';
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
                $('#currentevent').val(event_id);
            }

          });
        
    });

          
    $(document).on("click", ".fc-event-container .fc-content", function(){

        var element = $(this);
        $(".fc-event-container .fc-content").removeClass("evt_detail");
        $(this).addClass("evt_detail");
       // var event_id = $(".evt_detail span.fc-title").attr("data-id");   //oldcode -no use
        var event_id = $('#currentevent').val();  //<--mkcode

            $("#event_id").val('');
            $("#description").val('');
            $("#location_id").val('');
            $("#max_attendies").val('');
            $("#meetup_date").val('');
            $("#meetup_time").val('');
            $("#end_date").val('');
            $("#end_time").val('');
            $("#is_active").val(1);
            $("#no_end_date").val(0);
            $(".inline-checkbox :checkbox").prop('checked', false);
        if(event_id!= "") {

            var post_data = { 
                'id'  :  event_id,
                'tablename'  :  'ci_plan_event'
            };

            $.ajax({ 
                url: "<?php echo site_url('ajax/get_record_byId'); ?>",

                type: "POST",
                data: post_data,
                dataType: "json",      
                success: function(response) //we're calling the response json array 'cities'
                {

                  console.log(response);
                    $('#editEventModal').modal('show');
                    $('#plan-event-id').val(response.id);

                    $("#delete_event").attr('href',"<?php echo site_url('event/delete/"+event_id+"') ;?>");

                    $("#event_id").val(response.event_id);
                    $("#description").val(response.description);
                    $("#location_id").val(response.location_id);
                    $("#max_attendies").val(response.max_attendies);
                    $("#meetup_date").val(response.meetup_date);
                    $("#meetup_time").val(response.meetup_time);
                    $("#end_date").val(response.end_date);
                    $("#end_time").val(response.end_time);

                    if(response.no_end_date == 1)
                    {
                      $('#no_end_date').prop('checked', true);
                      $("#mainend_date").hide();
                    }
                    else
                    {
                      $('#no_end_date').prop('checked', false);
                      $("#mainend_date").show();
                    }

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
        <div id='plan-event-id'></div>        
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
                  echo "<div class='col-md-6'>";
                  echo isset($form['meetup_date']['label'])?$form['meetup_date']['label']:'';
                    if(isset($form['meetup_date']['errors']) && $form['meetup_date']['errors']!='' && count($form['meetup_date']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['meetup_date']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['meetup_date']['field'])?$form['meetup_date']['field']:'';
                  echo "</div>";

                echo "<div class='col-md-3' style='padding:10px 0 ;'>";
                // echo "<br>";
                  echo "<div class='col-md-1'>";
                  echo isset($form['no_end_date']['field'])?$form['no_end_date']['field']:'';
                  echo "</div>";
                  echo "<div class='col-md-10'>";
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


              echo "<div class='form-group'>";
              echo "<div class='col-md-6'>";
                  echo '<label for="meetup_time">Start Time</label>';
                    if(isset($form['meetup_time']['errors']) && $form['meetup_time']['errors']!='' && count($form['meetup_time']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['meetup_time']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['meetup_time']['field'])?$form['meetup_time']['field']:'';
                  echo "</div>";

                  echo "<div class='col-md-6'>";
                  echo isset($form['end_time']['label'])?$form['end_time']['label']:'';
                    if(isset($form['end_time']['errors']) && $form['end_time']['errors']!='' && count($form['end_time']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['end_time']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['end_time']['field'])?$form['end_time']['field']:'';
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
              echo "<div class='form-group' style='clear:both;'><br/>"; 
                echo "<div class='col-md-4'>"; 
                    echo '<div class="update_event"><button type="button" class="btn btn-primary" id="update_event">Update Event</button>';
                    echo "</div><br/>";
                echo "</div>";
                echo "<div class='col-md-8'>"; 
          }

        ?>     
        
                <div class="loading-spinner" style="display:none;">
                  <img src="<?php echo base_url().'images/img/loading_icon.gif';?>" style="height:45px;">
                </div>
            </div>
        </div>
        <p class="member-or-not" style="clear:both;">&nbsp;&nbsp; Do you want to delete this event? 
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

        var event_id = $("select[name='event_id']").val();
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
        }
        if(location_id == "")
        {
          $(".error_location_id").show();
          $(".error_location_id").html("The Location Id field is required!");
        }

        if (event_id != "" && location_id != "")
        {           
            $(".loading-spinner").show();
            var post_data = { 
                'id'  :  $('#plan-event-id').val(),
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
            console.log(post_data);
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
        var currentDate = $("#meetup_date").val(); 
        $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
        //$("#end_date").datepicker("setDate", currentDate); 
        $('#end_time').timepicker({ 'step': 15,'scrollDefault': 'now','timeFormat': 'H:i A' });*/
        var currentDate = $("#meetup_date").val(); 
        //alert(currentDate);
        var d = new Date();

      /*  oldcode comment


      $("#end_date").datepicker("setDate", currentDate); 
        $("#meetup_date").datepicker("setDate", currentDate); 
       $("#meetup_date").datepicker("option","minDate", d);

       
        $("#meetup_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            minDate:new Date(),
              onSelect: function(selected) {
             // $("#end_date").datepicker("option","minDate", selected);
             // $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5"});
               //$('#end_time').timepicker({ 'step': 15,'timeFormat': 'H:i A' });  //oldcode comment no use
            }
        });
        
        $("#end_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            minDate:new Date(),
            onSelect: function(selected) {
                var d = new Date();
              // $("#meetup_date").datepicker("option","minDate", d);
               //$("#meetup_date").datepicker("option","maxDate", selected);
              // $('#meetup_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5"});
              //$('#meetup_time').timepicker({ 'step': 15,'timeFormat': 'H:i A' });  //oldcode comment no use
            }
        });
         
        */
        
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
          $('#end_time').val(endHours);
        });
         
         $('#end_time').timepicker({ 'step': 15,'timeFormat': 'H:i' });

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
    // $('#meetup_date').onclick(function() {

    //   alert('Hello');
    // });

</script>