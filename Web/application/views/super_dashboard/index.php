<?php
    $colorcode=$this->common_model->createColorCode();

$send_data['admin_id'] = $this->session->userdata['logged_in']['super_admin_id'];
$get_planned_activity=$this->super_dashboard_model->get_planned_activity($send_data);
// die();
$graph6_count = 0;
$graph6_count = 0;
if(!empty($get_planned_activity))
{
    foreach ($get_planned_activity as $key_count => $value_count)
        $graph6_count += $value_count['sum_rec'];    
}
// $get_planned_activity=$this->dashboard_model->get_planned_activity($send_data);

  
?>
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Activities Area</h3>
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

                        <!-- bar chart -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Activities <small>per last 7 days</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="graph_bar" style="width:100%; height:280px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /bar charts -->
                        <!-- bar chart -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Activities <small>attendies last 7 days</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="graph_bar_group" style="width:100%; height:280px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /bar charts -->
                        
                        <!-- bar chart -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Residents <small>10 Most active residents</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="graph_most_resident" style="width:100%; height:280px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /bar charts -->
                        <!-- bar chart -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Residents <small>10 least active residents</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="graph_least_resident" style="width:100%; height:280px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /bar charts -->

                        <!-- pie chart -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Residents <small>% that attended at least 1 event in the last 7 days.</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content2">
                                    <div id="pie_residents" style="width:100%; height:300px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /pie chart -->

                        <!-- pie chart -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><?php echo $graph6_count; ?> Activities <small>Total planned activities last 30 days.</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content2">
                                    <div id="pie_activity" style="width:100%; height:300px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /pie chart -->

                    </div>
                </div>

                <!-- footer content -->

<script>

$(function () {

    /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
<?php
  $send_data['admin_id'] = $this->session->userdata['logged_in']['super_admin_id'];
  $get_activities=$this->super_dashboard_model->get_activities($send_data);
      
    $i=0;
    if(isset($get_activities) && !empty($get_activities))
    {
        foreach($get_activities as $kys=>$row)
        {
            $meetup_date = mdate('%d %M',strtotime($row['meetup_date']));
            // $meetup_date = $row['meetup_date'];
            $sum_rec = str_replace("'", "",$row['sum_rec']);

            $graph_bar_res[]="{ date: '$meetup_date',Total: $sum_rec}";
            
            $i++;
            $comb_graph_bar=implode(", ",$graph_bar_res);
        }
        $comb_graph_bardata="[ $comb_graph_bar ]"; 
     
    //print_r($piearraychartdata);      
?>   

    Morris.Bar({
        element: 'graph_bar',
        data: <?php echo isset($comb_graph_bardata)?$comb_graph_bardata:'';?>,
        xkey: 'date',
        ykeys: ['Total'],
        labels: ['Total'],
        barRatio: 0.4,
        barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        xLabelAngle: 35,
        hideHover: 'auto'
    });
<?php
    }
$get_attendactivities=$this->super_dashboard_model->get_attendActivities($send_data);   
 
    $i=0;
    if(isset($get_attendactivities) && !empty($get_attendactivities))
    {
        foreach($get_attendactivities as $kys=>$row)
        {
            $meetup_date = mdate('%d %M',strtotime($row['meetup_date']));
            // $meetup_date = $row['meetup_date'];
            $sum_rec = str_replace("'", "",$row['sum_rec']);

            $graph_bar_group_res[]="{ date: '$meetup_date',Total: $sum_rec}";
            
            $i++;
            $comb_graph_bar_group=implode(", ",$graph_bar_group_res);
        }
        $comb_graph_bar_groupdata="[ $comb_graph_bar_group ]"; 
    
?>
    Morris.Bar({
        element: 'graph_bar_group',
        data: <?php echo isset($comb_graph_bar_groupdata)?$comb_graph_bar_groupdata:'';?>,
        xkey: 'date',
        ykeys: ['Total'],
        labels: ['Total'],
        barRatio: 0.4,
        lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        xLabelAngle: 35,
        hideHover: 'auto'
    });
<?php
    }
$get_most_active=$this->super_dashboard_model->get_most_active($send_data);

    $i=0;
    if(isset($get_most_active) && !empty($get_most_active))
    {
        foreach($get_most_active as $kys=>$row)
        {
            $user_name = str_replace("'", "",$row['user_name']);
            // $meetup_date = $row['meetup_date'];
            $sum_rec = str_replace("'", "",$row['sum_rec']);

            $graph_most_resident_res[]="{ date: '$user_name',Total: $sum_rec}";
            
            $i++;
            $comb_graph_most_resident=implode(", ",$graph_most_resident_res);
        }
        $comb_graph_most_residentdata="[ $comb_graph_most_resident ]"; 
     
?>
    Morris.Bar({
        element: 'graph_most_resident',
        data: <?php echo isset($comb_graph_most_residentdata)?$comb_graph_most_residentdata:'';?>,
        xkey: 'date',
        ykeys: ['Total'],
        labels: ['Total'],
        barRatio: 0.4,
        barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        xLabelAngle: 35,
        hideHover: 'auto'
    });
<?php
    }

$get_least_active=$this->super_dashboard_model->get_least_active($send_data);

    $i=0;
    if(isset($get_least_active) && !empty($get_least_active))
    {
        foreach($get_least_active as $kys=>$row)
        {
            $user_name = str_replace("'", "",$row['user_name']);
            $sum_rec = str_replace("'", "",$row['sum_rec']);

            $graph_least_resident_res[]="{ date: '$user_name',Total: $sum_rec}";
            
            $i++;
            $comb_graph_least_resident=implode(", ",$graph_least_resident_res);
        }
        $comb_graph_least_residentdata="[ $comb_graph_least_resident ]"; 
    
?>
    Morris.Bar({
        element: 'graph_least_resident',
        data: <?php echo isset($comb_graph_least_residentdata)?$comb_graph_least_residentdata:'';?>,
        xkey: 'date',
        ykeys: ['Total'],
        labels: ['Total'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto'
    });
<?php
    }
    $get_least_residents=$this->super_dashboard_model->get_least_residents($send_data); 
    $color=$colorcode;
    
    $i=0;
    if(isset($get_least_residents) && !empty($get_least_residents))
    {
        foreach($get_least_residents as $kys=>$row)
        {
            $user_name = str_replace("'", "",$row['user_name']);
            $sum_rec = str_replace("'", "",$row['sum_rec']);

            $piearray[]="{ label: '$user_name',value: $sum_rec}";
            $piecolor[]="'$color[$i]'";
            
            $i++;
            $piearrayregion=implode(", ",$piearray);
            $piecolorregion=implode(", ",$piecolor);
        }
        $piearradata="[ $piearrayregion ]"; 
        $piearracolor="[ $piecolorregion ]";
    
    //print_r($piearraychartdata);      
?>
    Morris.Donut({
        element: 'pie_residents',
        data: <?php echo isset($piearradata)?$piearradata:'';?>,
       colors: <?php echo isset($piearracolor)?$piearracolor:'';?>,
        formatter: function (y) {
            return y + "%"
        }
    });

<?php
    }
    $get_planned_activity=$this->super_dashboard_model->get_planned_activity($send_data);

    $color2=$colorcode;
    
    $i=0;
    if(isset($get_planned_activity) && !empty($get_planned_activity))
    {
        foreach($get_planned_activity as $kys=>$row)
        {
            $event_name = str_replace("'", "",$row['name']);
            $sum_rec = str_replace("'", "",$row['sum_rec']);

            $piearray2[]="{ label: '$event_name',value: $sum_rec}";
            $piecolor2[]="'$color2[$i]'";
            
            $i++;
            $piearrayregion2=implode(", ",$piearray2);
            $piecolorregion2=implode(", ",$piecolor2);
        }
        $piearradata2="[ $piearrayregion2 ]"; 
        $piearracolor2="[ $piecolorregion2 ]";
    
?>
    Morris.Donut({
        element: 'pie_activity',
        data: <?php echo isset($piearradata2)?$piearradata2:'';?>,
        colors: <?php echo isset($piearracolor2)?$piearracolor2:'';?>
    });
<?php } ?>

});
</script>