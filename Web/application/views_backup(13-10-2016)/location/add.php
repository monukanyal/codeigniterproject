
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Location Management 
                    <?php if($this->router->fetch_method()=='add')
                        echo "<small>Add New Location</small></h3>";
                    else
                        echo "<small>Edit Location</small></h3>";
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
                                echo "<h2>Edit Location</small></h2>";
                            ?>
                            
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.location='<?php echo site_url('location'); ?>'" class="btn btn-info btn-xs">Location List</button></li>
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
                  if($k!='id' && $k!='submit' && $k!='is_active')
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
