
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                    <h3>Activity Management <small>Detail of Event - "<?php echo $manage_event_info['name'];?>"</small></h3>
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
                                <li><button onClick="window.location='<?php echo site_url('manage_event'); ?>'" class="btn btn-info btn-xs">Event List</button></li>
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                                 
              <!-- location information Start from here -->
                         <div id="Show" class="content active">
                            <div class="xskin-user-basic-information">
                              <div class="show-detail">
                                <h3>Basic information</h3>
                            <div class="form-group">
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Name
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $manage_event_info['name']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Description
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $manage_event_info['description']; ?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Max Attendies
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo $manage_event_info['max_attendies']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Is Active
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php if($manage_event_info['is_active'] == true) {
                                        echo '<div class="label label-success">✓</div>';
                                    } else {
                                        echo '<div class="label label-danger">✘</div>';
                                    } ?>
                                  </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Created At
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo mdate('%d %M %Y %h:%i %A',strtotime($manage_event_info['logtime'])); ?>
                                  </span>
                                </div>
                            </div>

                              </div><!-- /user-info -->
                            </div><!-- basic information close -->

                            <div class="clearfix"></div>
                         </div>
                         <!-- user information close from here -->
                            <!-- 28 march bar graph-->
                     <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Activity Popularity as per </h2>
                                <select id="range" style="float: right" onchange="getdata_activity(<?php echo $_GET['event_id'];?>,<?php echo $this->session->userdata['logged_in']['admin_id'];  ?>,this.value)">
                                <?php if($day==7){?>
                                 <option value="7">7</option>
                                  <option value="14">14</option>
                                   <option value="30">30</option>
                                 <?php }else if($day==14){?>
                                <option value="14">14</option>
                                 <option value="30">30</option>
                                  <option value="7">7</option>
                                <?php }else{ ?>
                                <option value="30">30</option>
                                 <option value="14">14</option>
                                  <option value="7">7</option>
                                <?php } ?>
                                </select>
                                
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
                          </div>
                    <!--  end -->
                          
                        </div>
                    </div>
                </div>
            </div>

        </div>
       
        <script>
  function getdata_activity(eventid,admin_id,value)
    {
        //alert(value);

        // $.post("<?php //echo site_url() ; ?>/manage_event/getdata_event_ajax", {admin_id: admin_id,day:value,event_id:eventid}, function(result){
        //   if(result!="")
        //   {
        //     $("#graph_bar_group").html("");
        //     Morris.Bar({
        //           element: 'graph_bar_group',
        //           xLabelMargin:8,
        //           data: result,
        //            hidehover:false,
        //             hoverCallback: function(index, options, content) 
        //             {
        //                return(options.data[index].c);
        //             },
        //           xkey: 'y',
        //           ykeys: ['a'],
        //            xLabelAngle: 60,
        //            barSizeRatio:0.50,
        //            resize:true,
        //           labels: []
        //         });
        //   }
        // });
        window.location.href = "<?php echo site_url() ; ?>/manage_event/show?event_id="+eventid+"&range="+value;     
    }
$(function () {

//---28 march Bar graph graph@mk 2nd
<?php
//print_r($getdata);
if(!empty($getdata))
{
    $res=array();
   for($m=0;$m<count($getdata);$m++)
   {
        $a=array();
        $str=$getdata[$m]['list_users'];
        $aid=$getdata[$m]['event_id'];
        $e=str_replace(' ', '', $getdata[$m]['event_name']);
        $meetup_date=$getdata[$m]['meetup_date'];
           
            $a=explode(",",$str);
              $attendies=count($a);
             if(count($a)>0)
             {
                $res[]="{ y: '$meetup_date',a: $attendies,c:'$e (max. attendies: $attendies)' }";
              
             }

   }

     $graph_bar_data=implode(", ",$res);
   $complete_graph_bar="[ $graph_bar_data ]";  

?>

Morris.Bar({
  element: 'graph_bar_group',
  xLabelMargin:8,
  data: <?php echo $complete_graph_bar; ?>,
   hidehover:false,
    hoverCallback: function(index, options, content) 
    {
       return(options.data[index].c);
    },
  xkey: 'y',
  ykeys: ['a'],
   xLabelAngle: 60,
   barSizeRatio:0.50,
   resize:true,
  labels: []
});
    /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
<?php
}
?>



});
</script>