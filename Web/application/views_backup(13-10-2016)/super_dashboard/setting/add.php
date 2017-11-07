
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Profile Edit
                    <?php if($this->router->fetch_method()=='add')
                    //     echo "<small>Add New Organization</small></h3>";
                    // else
                    //     echo "<small>Edit Organization</small></h3>";
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
                                echo "<h2>Edit Staff</small></h2>";
                            ?>
                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                        <div class="form-group">
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
                      { echo "<div class='form-group'>"; }
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

<script type="text/javascript">
    $(document).ready(function () {
        var currentDate = $("#birthday").val(); 
        $('#birthday').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "1930:+1",});
        $("#birthday").datepicker("setDate", currentDate); 

    var current_method = "<?php echo $this->router->fetch_method(); ?>";
    if(current_method == "add")
        $("#email").prop('readonly', false);
    else
    {
        $("#password").prop('required', false);
        $("#cnpassword").prop('required', false);
    }

    });
</script>

