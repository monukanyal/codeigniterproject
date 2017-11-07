<?php
    $admin_id = $this->session->userdata['logged_in']['admin_id'];

 $send_data['admin_id'] = $admin_id;
 $get_calender_events=$this->event_model->get_calender_events($send_data, 'ci_plan_event');
//   print_r($get_planned_activity);
//   die();
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Event Management <small>Listing</small></h3>
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
                            <h2>Daily active events <small>Grid List</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.open('<?php echo site_url().'/event/add'; ?>');" class="btn btn-info btn-xs">Add New</button></li>
                                <li><a href="#"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a href="#"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
							<div id='calendar'></div>

							<div class="fc-activity-detail">
								<div class='fc-activity-title'>Meeting</div>
								<div class='fc-activity-body'>
									<div class='fc-activity-location'>
										<span class="fc-activity-label">Location : </span>
										<span class="fc-activity-field">Delhi</span>  
									</div>
									<div class='fc-activity-start'>
										<span class="fc-activity-label">Start : </span>
										<span class="fc-activity-field">1 Jan 2016 9:30AM</span>  
									</div>
									<div class='fc-activity-end'>
										<span class="fc-activity-label">End : </span>
										<span class="fc-activity-field">10 Jan 2016 9:30AM</span>
									</div>
								</div> 
							</div> 

						</div>
                    </div>
                </div>
            </div>
        </div>
<script>

    $(document).ready(function() {
        
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: '2016-01-12',
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2016-01-01'
                },
                {
                    title: 'Long Event',
                    start: '2016-01-07',
                    end: '2016-01-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2016-01-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2016-01-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2016-01-11',
                    end: '2016-01-13'
                },
                {
                    title: 'Meeting',
                    start: '2016-01-12T10:30:00',
                    end: '2016-01-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2016-01-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2016-01-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2016-01-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2016-01-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2016-01-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2016-01-28'
                }
            ]
        });
        
    });

</script>

