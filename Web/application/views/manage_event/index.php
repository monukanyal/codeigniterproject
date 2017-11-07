
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
                            <h2>Daily active manage_events <small>Grid List</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.open('<?php echo site_url().'/manage_event/add'; ?>');" class="btn btn-info btn-xs">Add New</button></li>
                               
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
                        
                        <?php
                        if (!empty($arrEvent))
                            echo '<table id="example" class="table table-striped responsive-utilities jambo_table">';
                        else
                            echo '<table class="table table-striped responsive-utilities jambo_table">';
                        ?>
                            <thead>
                                <tr class="headings">
                                    <th>
                                         <input type="checkbox" name="checkedAll" id="checkedAll" />
                                    </th>
                                    <th>Name </th>
                                    <th>Description </th>
                                    <th>Max Attendies </th>
                                    <th>Status </th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($arrEvent))
                                {
                                  
                                  foreach ($arrEvent as $key=>$row)
                                  { ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                                       <input type="checkbox" name="checkAll" class="checkSingle" />

                                    </td>
                                     <!--<td class=" "><a href="<?php //echo site_url('manage_event/show/'.$row['id']); ?>" style='text-decoration: none;' class='name_anchor'><?php //echo $row['name'];?></a></td>-->
                                     <td class=" "><a href="<?php echo site_url('manage_event/show?event_id='.$row['id']); ?>" style='text-decoration: none;' class='name_anchor'><?php echo $row['name'];?></a></td>
                                    <td class=" "><?php echo $row['description'];?></td>
                                    <td class=" "><?php echo $row['max_attendies'];?></td>

                        <?php if($row['is_active']==1) { ?>
                            <td class="is_active_field boolean_type" title="Active"><span class="label label-success">✓</span></td>
                        <?php } else { ?>
                            <td class="is_active_field boolean_type" title="InActive"><span class="label label-danger">✘</span></td>
                        <?php } ?>
                                <td class="last" style="width:15%;">
                                    <!--<a href="<?php //echo site_url('manage_event/show/'.$row['id']); ?>" class="btn btn-primary btn-xs" title="Show"><i class="fa fa-info-circle"></i></a>-->
                                    <a href="<?php echo site_url('manage_event/edit/'.$row['id']); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                    <?php if($row['is_active']==1) { ?>
                                    <a href="<?php echo site_url('manage_event/inactive/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Hidden from Pull Down" onclick="return confirm('Do you want to permanent Hide this manage event from Pull Down?')"><i class="fa fa-thumbs-o-down"> Hide</i></a>
                                    <?php } else { ?>
                                    <a href="<?php echo site_url('manage_event/active/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Show from Pull Down" onclick="return confirm('Do you want to permanent show this manage event from Pull Down?')"><i class="fa fa-thumbs-o-up"> Show</i></a>
                                    <?php } ?>
                                </td>
                                </tr>
                                <?php } 
                                }
                                else
                                { ?>
                                    <tr>
                                        <td colspan="11">
                                            <div class="col-md-12">
                                                <div class="alert alert-danger alert-dismissible fade in no-data">No record found!!</div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                
                            </tbody>

                        </table>
                    </div>
                    </div>
                </div>

                <br />
                <br />
                <br />

            </div>
        </div>
            <!-- footer content -->

                        <!-- footer content -->
            <script type="text/javascript">
    
    $(document).ready(function() {
         // --28 march
     $(".name_anchor").hover(function()
     {
        $(this).css("color", "#5bc0de");
        }, function(){
        $(this).css("color", "#73879C");
    });
        //------end code
  $("#checkedAll").change(function(){
    if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }     
    }else {
      $("#checkedAll").prop("checked", false);
    }
  });
});
</script>