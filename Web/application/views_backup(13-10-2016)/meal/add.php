    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Meal Management 
                    <?php if($this->router->fetch_method()=='add')
                        echo "<small>Add New Meal</small></h3>";
                    else
                        echo "<small>Edit Meal</small></h3>";
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
                                echo "<h2>Edit Meal</small></h2>";
                            ?>
                            
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.open('<?php echo site_url().'/Pdfexample1'; ?>');" class="btn btn-info btn-xs">Calender PDF</button></li>
                                <li><button onClick="window.location='<?php echo site_url('meal'); ?>'" class="btn btn-info btn-xs">Meal List</button></li>
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
                  echo "<div class='col-md-3'>";
                  echo isset($form['meal_type']['label'])?$form['meal_type']['label']:'';
                  if (isset($form['meal_type']['errors']) && $form['meal_type']['errors']!='' && count($form['meal_type']['errors'])>0) {                              
                      echo "<div class='message_message'>";
                        echo $form['meal_type']['errors'];
                      echo "</div>";  
                  }
                  echo isset($form['meal_type']['field'])?$form['meal_type']['field']:'';
                echo "</div>";
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
        
                echo "<div class='col-md-2'>";
                  echo isset($form['start_time']['label'])?$form['start_time']['label']:'';
                    if(isset($form['start_time']['errors']) && $form['start_time']['errors']!='' && count($form['start_time']['errors'])>0) {
                      echo "<div class='message_message'>";
                         echo $form['start_time']['errors'];
                      echo "</div>";
                    }
                  echo isset($form['start_time']['field'])?$form['start_time']['field']:'';
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
            

              echo '<div class="form-group">';
                echo '<div class="col-md-8 recurring-day">';
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
    $(document).ready(function () {
      // var currentDate = $("#start_date").val(); 
      // if(currentDate!='')
      // {

      // }
      // else
      // {
      //   var fullDate = new Date()
      //   var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
      //   var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
      // }

      // $('#start_date').datepicker( {minDate: 0,dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",onSelect: function(dateText, inst) { 
      // $('#end_date').val(dateText); }});
      // var currentDate1 = $("#start_date").val(); 

      // if(currentDate1 == '')
      // {
      // $("#start_date").datepicker("setDate", currentDate); 
    
      // }

  $('#start_time').timepicker({ 'step': 15 ,'scrollDefault': 'now','timeFormat': 'h:i A' });
      // $('#start_time').on('changeTime', function() {
        
      //   var startTime = $(this).val().split(':');
      //   var endHours = parseInt(startTime[0]) +1;
      //   endHours = Math.min(Math.max(endHours, 1), 24);
      //   var totaltime=endHours+':'+ startTime[1];
      //   $('#end_time').val(endHours +':'+ startTime[1]);

      // });
     function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
        function z(n){
          return (n<10? '0':'') + n;
        }
        var bits = time.split(':');
        var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

        return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
      }  

      // addMinutes('05:30', '30');  // '06:00'


      $('#start_time').on('changeTime', function() {
        var startTime = $(this).val().split(':');
        var getmin  = startTime[1].split(' ');
        var gettime = startTime[0]+':'+getmin[0];
        var endHours = addMinutes(gettime, '30');
        $('#end_time').val(endHours);

      });

      
        // var currentDate = $("#start_date").val(); 
    //  $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
      //$("#end_date").datepicker("setDate", currentDate); 
      $('#end_time').timepicker({ 'step': 15, 'timeFormat': 'h:i A','scrollDefault': 'now'});

  var getval=$("input#no_end_date").val();
  // alert(getval);
    if($("input#no_end_date").is(":checked"))
      $("#mealnodate").hide();
    else
      $("#mealnodate").show();

    $("input#no_end_date").click(function(){
        $("#mealnodate").toggle();

    });

    });
</script>
<style type="text/css">
  .recurring-day ul.inline-checkbox {
    margin: 0;
    padding: 0;
}
</style>