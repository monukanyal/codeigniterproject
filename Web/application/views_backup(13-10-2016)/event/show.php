<?php
  $admin_id = $this->session->userdata['logged_in']['admin_id'];
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Event Management </small></h3>
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
                            <h2>Show Event</small></h2>
                            
                            <ul class="nav navbar-right panel_toolbox">
                            <li><button onClick="window.open('<?php echo site_url().'/Pdfexample'; ?>');" class="btn btn-info btn-xs">Calender PDF</button></li>
                                <li><button onClick="window.location='<?php echo site_url('event'); ?>'" class="btn btn-info btn-xs">Event List</button></li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                                 
              <!-- event information Start from here -->
                         <div id="Show" class="content active">
                          <div class="col-m-6 col-sm-6 col-xs-12">
                            <div class="xskin-user-basic-information">
                              <div class="show-detail">
                                <h3>Basic information</h3>
                            <div class="form-group">
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="type-info">
                                    Event Name
                                  </span>
                                </div>
                                <div class="col-m-8 col-sm-8 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo isset($arrEvent)?$arrEvent['name']:'--'; ?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="type-info">
                                    Description
                                  </span>
                                </div>
                                <div class="col-m-8 col-sm-8 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo ($event_info['description']!="")?$event_info['description']:'--'; ?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="type-info">
                                    Location
                                  </span>
                                </div>
                                <div class="col-m-8 col-sm-8 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo isset($arrLocation)?$arrLocation['name']:'--'; ?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                    <span class="type-info">Max Attendies</span>
                                </div>
                                <div class="col-m-8 col-sm-8 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo ($event_info['max_attendies']!="")?$event_info['max_attendies']:"--";; ?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="type-info">
                                    Meetup Date/Time
                                  </span>
                                </div>
                                <div class="col-m-8 col-sm-8 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo mdate('%d %M %Y %h:%i %A',strtotime($event_info['meetup_date'].$event_info['meetup_time']));?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="type-info">
                                    End Date/Time
                                  </span>
                                </div>
                                <div class="col-m-8 col-sm-8 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo mdate('%d %M %Y %h:%i %A',strtotime($event_info['end_date'].$event_info['end_time']));?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="type-info">
                                    Is Active
                                  </span>
                                </div>
                                <div class="col-m-8 col-sm-8 col-xs-12">
                                  <span class="user-infor">
                                    <?php if($event_info['is_active'] == true) {
                                        echo '<div class="label label-success">✓</div>';
                                    } else {
                                        echo '<div class="label label-danger">✘</div>';
                                    } ?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="type-info">
                                    Created At
                                  </span>
                                </div>
                                <div class="col-m-8 col-sm-8 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo mdate('%d %M %Y %h:%i %A',strtotime($event_info['logtime'])); ?>
                                  </span>
                                </div>
                            </div>

                              </div><!-- /user-info -->
                            </div><!-- basic information close -->
                          </div> <!-- col-m-6 col-sm-6 col-xs-12 -->

                          <div class="col-m-6 col-sm-6 col-xs-12">
                            <div class="xskin-user-basic-information">
                              <div class="show-detail text-center">
                                <h3>Users Activities</h3>
                                <div class="form-group">

                                  <div class="col-m-6 col-sm-6 col-xs-12 right-border">
                                    <h4><center>Invited Users</center></h4>
                                    <?php
                                      if($event_info['list_users'] != "")
                                      {
                                        $arrListUsers = explode(",", $event_info['list_users']);
                                        foreach ($arrListUsers as $key => $value) {
                                          $data_feed = array('id'=>$value,'admin_id'=>$admin_id);
                                          $user_in = $this->user_model->get_user($data_feed);
                                          echo '<span class="type-info">';
                                            echo "<a title='".$user_in['email']."'>".$user_in['first_name']." ".$user_in['middle_name']." ".$user_in['last_name']."</a>";
                                          echo '</span>';
                                        }
                                      }
                                      else
                                        echo "<span class=\"user-infor\">No Record Found!!</span>";
                                      
                                    ?>
                                  </div>
                                  <div class="col-m-6 col-sm-6 col-xs-12 left-border">
                                    <h4><center>Attended Users</center></h4>
                                    <?php
                                      if($event_info['attend_users'] != "")
                                      {
                                        $arrAttendUsers = explode(",", $event_info['attend_users']);
                                        foreach ($arrAttendUsers as $keys => $values) {
                                          $data_feed = array('id'=>$values,'admin_id'=>$admin_id);
                                          $user_att = $this->user_model->get_user($data_feed);
                                          echo '<span class="type-info">';
                                            echo "<a title='".$user_att['email']."'>".$user_att['first_name']." ".$user_att['middle_name']." ".$user_att['last_name']."</a>";
                                          echo '</span>';
                                        }
                                      }
                                      else
                                        echo "<span class=\"user-infor\">No Record Found!!</span>";
                                      
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div> <!-- col-m-6 col-sm-6 col-xs-12 -->
                        <div class="clearfix"></div>
                        </div>
                         <!-- user information close from here -->

                          
                      </div>
                    </div>
                </div>
            </div>

        </div>