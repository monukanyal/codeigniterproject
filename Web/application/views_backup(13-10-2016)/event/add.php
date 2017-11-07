    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Activity Management 
                    <?php if($this->router->fetch_method()=='add')
                        echo "<small>Add New Event</small></h3>";
                    else
                        echo "<small>Edit Event</small></h3>";
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

                            <?php if($this->router->fetch_method()=='add')
                                echo "<h2>Add New</small></h2>";
                            else
                                echo "<h2>Edit Event</small></h2>";
                            ?>
                            
                            <ul class="nav navbar-right panel_toolbox">
                            <li><button onClick="window.open('<?php echo site_url().'/Pdfexample'; ?>');" class="btn btn-info btn-xs">Calender PDF</button></li>
                                <li><button onClick="window.location='<?php echo site_url('event/calendar'); ?>'" class="btn btn-info btn-xs">Event List</button></li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                        <div class="form-group">
                        <?php
                        echo "<div class='flash error'>";
                        if (isset($error)) {
                            echo $error;
                        }
                         echo validation_errors();
                        echo "</div>";
                        ?>
                        </div>
 <?php
          if(!empty($form))
          {
            $i=0;
            echo isset($startform)?$startform:'';
              echo "<div class='form-group'>"; 
                  echo "<div class='col-md-6'>";
                  echo isset($form['event_id']['label'])?$form['event_id']['label']:'';
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

                  echo "<div class='col-md-3'>";
                  echo isset($form['meetup_time']['label'])?$form['meetup_time']['label']:'';
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
                echo "<div class='col-md-4'>";                     
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
                  echo isset($form['submit']['field'])?$form['submit']['field']:'';
                echo "</div>";
              echo "</div>";

            echo isset($endform)?$endform:'';
          }

        ?>                        
                          
                        </div>
                    </div>
                </div>
            </div>

        </div>


<script type="text/javascript">
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
              $("#description").val(response.description);
              $("#max_attendies").val(response.max_attendies);
            },
            error: function(response)
            {  }
        });
    });
    $(document).ready(function () {
      var currentDate = $("#meetup_date").val(); 
      if(currentDate!='')
      {  }
      else
      {
        var fullDate = new Date()
        var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
        var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
      }
        var currentDate1 = $("#meetup_date").val(); 
        var d = new Date();

        $("#end_date").datepicker("setDate", currentDate1); 
        $("#meetup_date").datepicker("setDate", currentDate1); 
        $("#meetup_date").datepicker("option","minDate", d);

     $('#meetup_date').datepicker({ 
          minDate: 0,
          dateFormat: "yy-mm-dd", 
          changeYear: true, 
          yearRange:  "+0:+5",
          onSelect: function(dateText, inst) { 
              $("#end_date").datepicker("option","minDate", dateText);
              $('#end_time').timepicker({ 'step': 15,'scrollDefault': 'now','timeFormat': 'H:i A' });
          }
      });
     /* var currentDate1 = $("#meetup_date").val(); 
      if(currentDate1 ==''){
         $("#meetup_date").datepicker("setDate", currentDate);
      } 
      $('#meetup_time').timepicker({ 'step': 15 ,'scrollDefault': 'now','timeFormat': 'h:i A','defaultTime': '8:00 AM'});
      */
      $("#end_date").datepicker({
          dateFormat: 'yy-mm-dd',
          changeYear: true,
         
          onSelect: function(selected) {
              var d = new Date();
             $("#meetup_date").datepicker("option","minDate", d);
             $("#meetup_date").datepicker("option","maxDate", selected);
             $('#meetup_time').timepicker({ 'step': 15,'scrollDefault': 'now','timeFormat': 'H:i A' });
          }
      });


      function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
        function z(n){
          return (n<10? '0':'') + n;
        }
        var bits = time.split(':');
        var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

        return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
      }  

      // addMinutes('05:30', '30');  // '06:00'


      $('#meetup_time').on('changeTime', function() {
        var startTime = $(this).val().split(':');
        var getmin  = startTime[1].split(' ');
        var gettime = startTime[0]+':'+getmin[0];
        var endHours = addMinutes(gettime, '30');
        $('#end_time').val(endHours);

      });


 
        // var currentDate = $("#meetup_date").val(); 
      $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
     
      var currentDate2 = $("#end_date").val(); 
     
      if(currentDate2 ==''){

      $("#end_date").datepicker("setDate", currentDate); 

  }
      $('#end_time').timepicker({ 'step': 15, 'scrollDefault': 'now','timeFormat': 'h:i A' });

      


  var getval=$("input#no_end_date").val();
  // alert(getval);
    if($("input#no_end_date").is(":checked"))
      $("#mainend_date").hide();
    else
      $("#mainend_date").show();

    $("input#no_end_date").click(function(){
        $("#mainend_date").toggle();

    });



     

    });
</script>