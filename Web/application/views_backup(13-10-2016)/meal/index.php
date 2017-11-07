<?php
    $admin_id = $this->session->userdata['logged_in']['admin_id'];
?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Meal Management <small>Listing</small></h3>
                    <button onClick="window.location='<?php echo site_url('meal/calendar'); ?>'" class="btn btn-info btn-xs">Calendar View</button>

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
                            <h2>Daily active meals <small>Grid List</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button onClick="window.open('<?php echo site_url().'/Pdfexample1'; ?>');" class="btn btn-info btn-xs">Calender PDF</button></li>
                                <li><button onClick="window.open('<?php echo site_url().'/meal/add'; ?>');" class="btn btn-info btn-xs">Add New</button></li>
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
                        <?php
                        if (!empty($arrMeal))
                            echo '<table id="example" class="table table-striped responsive-utilities jambo_table">';
                        else
                            echo '<table class="table table-striped responsive-utilities jambo_table">';
                        ?>
                            
                                <thead>
                                    <tr class="headings">
                                        <th>
                                            <input type="checkbox" class="tableflat">
                                        </th>
                                        <th>Name </th>
                                        <th>Description </th>
                                        <th>Location </th>
                                        <th>Meal Start Date/Time </th>
                                        <th>Meal End Date/Time </th>
                                        <th>Status </th>
                                        <th class=" no-link last"><span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if (!empty($arrMeal))
                                    {
                                      foreach ($arrMeal as $key=>$row)
                                      { 

                                        $arrLocation = '';
                                        if($row['location_id'] != '')
                                            $arrLocation = $this->system_model->get_single(array("id" => $row['location_id'], "admin_id" => $admin_id),'ci_location');
                                        ?>
                                    <tr class="even pointer">
                                        <td class="a-center ">
                                            <input type="checkbox" class="tableflat">
                                        </td>
                                        <td class=" "><?php echo $row['name'];?></td>
                                        <td class=" "><?php echo $row['description'];?></td>
                                        <td class=" "><?php echo isset($arrLocation)?$arrLocation['name']:'--';?></td>
                                        <td class=" "><?php echo mdate('%d %M %Y %h:%i %A',strtotime($row['start_date'].$row['start_time']));?></td>
                                        <td class=" "><?php echo mdate('%d %M %Y %h:%i %A',strtotime($row['end_date'].$row['end_time']));?></td>
                                       
                            <?php if($row['is_active']==1) { ?>
                                <td class="is_active_field boolean_type" title="Active"><span class="label label-success">✓</span></td>
                            <?php } else { ?>
                                <td class="is_active_field boolean_type" title="InActive"><span class="label label-danger">✘</span></td>
                            <?php } ?>

                                         <td class=" last">
<a href="<?php echo site_url('meal/show/'.$row['id']); ?>" class="btn btn-primary btn-xs" title="Show"><i class="fa fa-info-circle"></i></a>
<a href="<?php echo site_url('meal/edit/'.$row['id']); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
<a href="<?php echo site_url('meal/delete/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Do you want to permanent delete this meal?')"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } 
                                    }
                                    else
                                    { ?>
                                        <tr><td colspan="11">
                                <div class="col-md-12"><div class="alert alert-danger alert-dismissible fade in no-data">No record found!!</div></div></td></tr>
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