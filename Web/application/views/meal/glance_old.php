<?php
    $admin_id = $this->session->userdata['logged_in']['admin_id'];
?>
    <!-- page content -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0/css/froala_style.min.css" rel="stylesheet" type="text/css" />  

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Meals At a Glance </h3>
                 
                    
                    <?php if($this->session->flashdata('flash_msg')){?>
                    <div class="alert alert-success">      
                      <?php echo $this->session->flashdata('flash_msg')?>
                    </div>
                  <?php } ?>
                    <div>
                    <div class="col-md-2">
                     <h4>Start Date : </h4><input id="date_timepicker_start" name="start" type="text" value="" class="form-control"> </div><div class="col-md-5"> <h4>Sub Title1:</h4><input type="text" class="form-control"  name="sub_title" id="subtitle1" value="" ></div><div class="col-md-5"> <h4>Sub Title2:</h4><input type="text" class="form-control" name="sub_title" id="subtitle2" value="" ></div></div>
                </div>
                  <!--8th sept-->
    <div class="carriage_left_area1">
        <ul class="carrige_table1">
        <div class="break_outer">
          <li class="break">
            <p><span><i class="fa fa-coffee" aria-hidden="true"></i>BREAKFAST<i type="button" class="fa fa-plus-square-o" data-toggle="modal" data-target="#myModal" aria-hidden="true" style="float: right; cursor: pointer;"></i></span>
              <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Breakfast</h4>
                      </div>
                      <div class="modal-body">
                          <!--content start-->
              <form name="form_breakfast" action="<?php echo site_url('meal/add_meal_glance');?>" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" accept-charset="utf-8">
              <div class='form-group'>
              <div class='col-md-3'>
              <input type="hidden" name="meal_type" value="breakfast">
              <label for="Month">Month for:</label>
              <select name="start_date" id='sdate1' class="form-control" required>
              <option value="" selected="selected">Select Month...</option>
              <?php
              for ($i = 0; $i <= 2; ++$i) {
              $time = strtotime(sprintf('+%d months', $i));
              $value = date('Y/m/d', $time);
              $label = date('F', $time);
              printf('<option value="%s">%s</option>', $value, $label);
              }
              ?>        
              </select>
              </div>
              <div class='col-md-3'>
              <label for="location_id">Location:</label>
              <select name="location_id" class="form-control" id="location_id1" required>
              <option value="" selected="selected">Select Location...</option>
              <?php 
              if(isset($location))
              {
              for($k=0;$k<count($location);$k++)
              {
              ?>
              <option value="<?php echo $location[$k]['id'];?>"><?php echo $location[$k]['name'];?></option>
              <?php 
              }
              }
              ?>
              </select>
              </div>
              <div class='col-md-6'>
              <label for="description">Description</label>
              <textarea name="description" cols="40" rows="1" type="textarea" id="description1" value="" class="form-control" autofocus="true" required ></textarea>
              </div>
              </div>
              <div class='col-md-2'>
              <label for="start_time">Meal Time</label>
              <input type="text" name="start_time" value="" class="start_time" id="stime1" class="form-control" autofocus="true" onkeydown="return false"  required />
              </div>
              <div class='col-md-2'>
              <label for="end_time">End Time</label>
      <input type="text" name="end_time" value="" class="end_time" class="form-control" id="etime1" autofocus="true" onkeydown="return false" required />
              </div>
              <div class="form-group">
              <div class="col-md-8 recurring-day">
              <label for="recurring">Recurring Meal</label>
              <div class="row-fluid">
              <ul class='inline-checkbox'>
              <li class=''><input type="checkbox" name="recurring[]" value="S"  id=recurring[S] />
              S</li><li class=''><input type="checkbox" name="recurring[]" value="M"  id=recurring[M] />
              M</li><li class=''><input type="checkbox" name="recurring[]" value="T"  id=recurring[T] />
              T</li><li class=''><input type="checkbox" name="recurring[]" value="W"  id=recurring[W] />
              W</li><li class=''><input type="checkbox" name="recurring[]" value="Th"  id=recurring[Th] />
              Th</li><li class=''><input type="checkbox" name="recurring[]" value="F"  id=recurring[F] />
              F</li><li class=''><input type="checkbox" name="recurring[]" value="St"  id=recurring[St] />
              St</li>
              </ul>
              </div>
              </div>
              </div>
              <div class='form-group'>
              <div class='col-md-4'>
              <div class='col-md-1 no-padd'>
              <input type="checkbox" name="is_active" value="1" checked="checked"  class='flat' id='is_active1' />
              </div>
              <div class='col-md-11 no-padd'>
              <label for="is_active">Is Active?</label>
              </div>
              </div>
              </div>
              <div class='form-group'>
              <div class='col-md-12'>
              <input type="button" id="sub_break" value="Submit" class="btn btn-success"  />
              </div>
              </div>
              </form>        
      <!--content end-->
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            </p>
          </li>
          <div class="list_outer">
          <?php
        if (!empty($arrbreakfast))
        {
          foreach ($arrbreakfast as $keyb=>$rowb)
          { 

            $arrLocation = '';
            if($rowb['location_id'] != '')
              $arrLocation = $this->system_model->get_single(array("id" => $rowb['location_id'], "admin_id" => $admin_id),'ci_location');
            ?>
          <li>
            <span class="draggable"  id="<?php echo 'dinner'.$rowb['id']; ?>"><?php echo $rowb['description'];?></span>
          </li>
         <?php
           }
         }
        else
         {
          ?>
          <li>
            <span >No Dinner list available</span>
          </li>
          <?php
         }
          ?>
          </div>
          </div>

          <div class="break_outer">
          <li class="break">
            <p><span><i class="fa fa-cutlery" aria-hidden="true"></i>LUNCH<i class="fa fa-plus-square-o" data-toggle="modal" data-target="#myModal2" aria-hidden="true" style="float: right; cursor: pointer;"></i></span>
              <!-- Modal -->
                <div class="modal fade" id="myModal2" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">ADD LUNCH</h4>
                      </div>
                      <div class="modal-body">
              <!--content start-->
              <form name="form_lunch" action="<?php echo site_url('meal/add_meal_glance');?>" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" accept-charset="utf-8">
              <div class='form-group'>
              <div class='col-md-3'>
              <input type="hidden" name="meal_type" value="lunch">
              <label for="Month">Month for:</label>
              <select name="start_date" id='sdate2' class="form-control" required>
              <option value="" selected="selected">Select Month...</option>
              <?php
              for ($i = 0; $i <= 2; ++$i) {
              $time = strtotime(sprintf('+%d months', $i));
              $value = date('Y/m/d', $time);
              $label = date('F', $time);
              printf('<option value="%s">%s</option>', $value, $label);
              }
              ?>        
              </select>
              </div>
              <div class='col-md-3'>
              <label for="location_id">Location:</label>
              <select name="location_id" class="form-control" id="location_id2" required>
              <option value="" selected="selected">Select Location...</option>
              <?php 
              if(isset($location))
              {
              for($k=0;$k<count($location);$k++)
              {
              ?>
              <option value="<?php echo $location[$k]['id'];?>"><?php echo $location[$k]['name'];?></option>
              <?php 
              }
              }
              ?>
              </select>
              </div>
              <div class='col-md-6'>
              <label for="description">Description</label>
              <textarea name="description" cols="40" rows="1" type="textarea" id="description2" value="" class="form-control" autofocus="true" required ></textarea>
              </div>
              </div>
              <div class='col-md-2'>
              <label for="start_time">Meal Time</label>
              <input type="text" name="start_time" value="" class="start_time" id="stime2" class="form-control" autofocus="true" onkeydown="return false"  required />
              </div>
              <div class='col-md-2'>
              <label for="end_time">End Time</label>
      <input type="text" name="end_time" value="" class="end_time" class="form-control" id="etime2" autofocus="true" onkeydown="return false" required />
              </div>
              <div class="form-group">
              <div class="col-md-8 recurring-day">
              <label for="recurring">Recurring Meal</label>
              <div class="row-fluid">
              <ul class='inline-checkbox'>
              <li class=''><input type="checkbox" name="recurring[]" value="S"  id=recurring[S] />
              S</li><li class=''><input type="checkbox" name="recurring[]" value="M"  id=recurring[M] />
              M</li><li class=''><input type="checkbox" name="recurring[]" value="T"  id=recurring[T] />
              T</li><li class=''><input type="checkbox" name="recurring[]" value="W"  id=recurring[W] />
              W</li><li class=''><input type="checkbox" name="recurring[]" value="Th"  id=recurring[Th] />
              Th</li><li class=''><input type="checkbox" name="recurring[]" value="F"  id=recurring[F] />
              F</li><li class=''><input type="checkbox" name="recurring[]" value="St"  id=recurring[St] />
              St</li>
              </ul>
              </div>
              </div>
              </div>
              <div class='form-group'>
              <div class='col-md-4'>
              <div class='col-md-1 no-padd'>
              <input type="checkbox" name="is_active" value="1" checked="checked"  class='flat' id='is_active2' />
              </div>
              <div class='col-md-11 no-padd'>
              <label for="is_active">Is Active?</label>
              </div>
              </div>
              </div>
              <div class='form-group'>
              <div class='col-md-12'>
              <input type="button" id="sub_lunch" value="Submit" class="btn btn-success"  />
              </div>
              </div>
              </form>        
      <!--content end-->
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            </p>
          </li>
          <div class="list_outer">
        <?php
        if (!empty($arrlunch))
        {
          foreach ($arrlunch as $keyl=>$rowl)
          { 

            $arrLocation = '';
            if($rowl['location_id'] != '')
              $arrLocation = $this->system_model->get_single(array("id" => $rowl['location_id'], "admin_id" => $admin_id),'ci_location');
            ?>
          <li>
            <span class="draggable" id="<?php echo 'dinner'.$rowl['id']; ?>"><?php echo $rowl['description'];?></span>
          </li>
         <?php
           }
         }
         else
         {
          ?>
          <li>
            <span >No Lunch list available</span>
          </li>
          <?php
         }
          ?>
          </div>
          </div>

          <div class="break_outer">
          <li class="break">
            <p><span><i class="fa fa-cutlery" aria-hidden="true"></i>DINNER<i class="fa fa-plus-square-o" data-toggle="modal" data-target="#myModal3" aria-hidden="true" style="float: right; cursor: pointer;"></i></span>
              <!-- Modal -->
                <div class="modal fade" id="myModal3" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Dinner</h4>
                      </div>
                      <div class="modal-body">
                          <!--content start-->
              <form name="form_dinner" action="<?php echo site_url('meal/add_meal_glance');?>" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" accept-charset="utf-8">
              <div class='form-group'>
              <div class='col-md-3'>
              <input type="hidden" name="meal_type" value="dinner">
              <label for="Month">Month for:</label>
              <select name="start_date" id='sdate3' class="form-control" required>
              <option value="" selected="selected">Select Month...</option>
              <?php
              for ($i = 0; $i <= 2; ++$i) {
              $time = strtotime(sprintf('+%d months', $i));
              $value = date('Y/m/d', $time);
              $label = date('F', $time);
              printf('<option value="%s">%s</option>', $value, $label);
              }
              ?>        
              </select>
              </div>
              <div class='col-md-3'>
              <label for="location_id">Location:</label>
              <select name="location_id" class="form-control" id="location_id3" required>
              <option value="" selected="selected">Select Location...</option>
              <?php 
              if(isset($location))
              {
              for($k=0;$k<count($location);$k++)
              {
              ?>
              <option value="<?php echo $location[$k]['id'];?>"><?php echo $location[$k]['name'];?></option>
              <?php 
              }
              }
              ?>
              </select>
              </div>
              <div class='col-md-6'>
              <label for="description">Description</label>
              <textarea name="description" cols="40" rows="1" type="textarea" id="description3" value="" class="form-control" autofocus="true" required ></textarea>
              </div>
              </div>
              <div class='col-md-2'>
              <label for="start_time">Meal Time</label>
              <input type="text" name="start_time" value="" class="start_time" id="stime3" class="form-control" autofocus="true" onkeydown="return false"  required />
              </div>
              <div class='col-md-2'>
              <label for="end_time">End Time</label>
      <input type="text" name="end_time" value="" class="end_time" class="form-control" id="etime3" autofocus="true" onkeydown="return false" required />
              </div>
              <div class="form-group">
              <div class="col-md-8 recurring-day">
              <label for="recurring">Recurring Meal</label>
              <div class="row-fluid">
              <ul class='inline-checkbox'>
              <li class=''><input type="checkbox" name="recurring[]" value="S"  id=recurring[S] />
              S</li><li class=''><input type="checkbox" name="recurring[]" value="M"  id=recurring[M] />
              M</li><li class=''><input type="checkbox" name="recurring[]" value="T"  id=recurring[T] />
              T</li><li class=''><input type="checkbox" name="recurring[]" value="W"  id=recurring[W] />
              W</li><li class=''><input type="checkbox" name="recurring[]" value="Th"  id=recurring[Th] />
              Th</li><li class=''><input type="checkbox" name="recurring[]" value="F"  id=recurring[F] />
              F</li><li class=''><input type="checkbox" name="recurring[]" value="St"  id=recurring[St] />
              St</li>
              </ul>
              </div>
              </div>
              </div>
              <div class='form-group'>
              <div class='col-md-4'>
              <div class='col-md-1 no-padd'>
              <input type="checkbox" name="is_active" value="1" checked="checked"  class='flat' id='is_active3' />
              </div>
              <div class='col-md-11 no-padd'>
              <label for="is_active">Is Active?</label>
              </div>
              </div>
              </div>
              <div class='form-group'>
              <div class='col-md-12'>
              <input type="button" id="sub_dinner" value="Submit" class="btn btn-success"  />
              </div>
              </div>
              </form>        
      <!--content end-->
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            </p>
          </li>
          <div class="list_outer">
         <?php
        if (!empty($arrdinner))
        {
          foreach ($arrdinner as $keyd=>$rowd)
          { 

            $arrLocation = '';
            if($rowd['location_id'] != '')
              $arrLocation = $this->system_model->get_single(array("id" => $rowd['location_id'], "admin_id" => $admin_id),'ci_location');
            ?>
          <li>
            <span class="draggable" id="<?php echo 'dinner'.$rowd['id']; ?>"><?php echo $rowd['description'];?></span>
          </li>
         <?php
           }
         }
         else
         {
          ?>
          <li>
            <span >No Dinner list available</span>
          </li>
          <?php
         }
          ?>
          </div>
          </div>
        </ul>
    </div>
    <!--end of 8th sept-->

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                          
                        </div>
                    </div>
                </div>
            </div>
           
            <div class=""></div>
       		<!-- modal-->
       		<div id="myreviewmodal" class="modal fade" role="dialog">
			  <div class="modal-dialog modal-lg">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"></h4>
			      </div>
			      <div class="modal-body" id="printarea">
			       
			      </div>
			      <div class="modal-footer">
			      <input type="button" class="btn btn-default" onclick="printDiv('printarea')" value="Print" />
			        <!-- <button type="button" class="btn btn-default" data-dismiss="modal" id="cls_btn">Close</button> -->
			      </div>
			    </div>

			  </div>
			</div>
       		<!--modal end-->
       		<div id="showit">
           <div class="carriage_outer">
		    <h4 class="align_1"><?php echo $address; ?></h4>
		    <p class="align_1" id="subt1">---Subtitle 1--</p>
		    <p class="align_1" id="subt2">---Subtitle 2--</p>
      <div class="brk_lunch_outer_main">
       <ul class="brk_lunch_outer">
          <li><span>Breakfast</span>
          <span>Lunch</span>
          <span class="dinner">Dinner</span></li>
        </ul>
      </div>

		    <div class="carriage_left_area">
		      <ul class="carrige_table">
		        <li >
		          <span>S<br>U<br>N</span>
		          <span class="droppable11"></span>
		          <span class="droppable12"></span>
		          <span class="droppable13"></span>
		          <span id="d1">12-aug</span>
		        </li>
		        <li >
		          <span>M<br>O<br>N</span>
		          <span class="droppable21"></span>
		          <span class="droppable22"></span>
		          <span class="droppable23"></span>
		          <span id="d2">12-aug</span>
		        </li>
		        <li>
		          <span>T<br>U<br>E</span>
		          <span class="droppable31"></span>
		           <span class="droppable32"></span>
		           <span class="droppable33"></span>
		           <span id="d3">12-aug</span>
		        </li>
		        <li>
		          <span>W<br>E<br>D</span>
		           <span class="droppable41"></span>
		           <span class="droppable42"></span>
		           <span class="droppable43"></span>
		         
		          <span id="d4">12-aug</span>
		        </li>
		        <li>
		          <span>T<br>H<br>U</span>
		            <span class="droppable51"></span>
		           <span class="droppable52"></span>
		           <span class="droppable53"></span>
		         <span id="d5">12-aug</span>
		        </li>
		        <li>
		          <span>F<br>R<br>I</span>
		           <span class="droppable61"></span>
		           <span class="droppable62"></span>
		           <span class="droppable63"></span>
		          <span id="d6">12-aug</span>
		        </li>
		        <li>
		          <span>S<br>A<br>T</span>
		           <span class="droppable71"></span>
		           <span class="droppable72"></span>
		           <span class="droppable73"></span>
		          <span id="d7">12-aug</span>
		        </li>
		      </ul>
		     	 <div class="align_1" id="footer_print"></div>
				
		    </div>
  	</div>
  </div>

   <div class="row">
     <div class="col-md-8 form-inline">
        
           <div id="editor">
  	    <div id='edit' style="margin-top: 0px;">
  	      <h1>Footer Headline</h1>

  	      <p>Footer Quotes</p>
  	    
  	    </div>
  	  </div>
     </div>
  </div>
        <div class="row">
       <div class="col-md-12 form-inline">
            <div class="form-group">
           
            <input type="button" id="review_now" class="btn btn-md btn-primary" value="Review">
           
          </div>
       </div>
  </div>
  </form>
  </div>
         
        </div>
            <!-- footer content -->
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.0//js/froala_editor.pkgd.min.js"></script>
            <script type="text/javascript">
    				function printDiv(divName) {
    					  var printContents, popupWin;
					    var printContents = document.getElementById(divName).innerHTML;
					    popupWin = window.open('', '_blank', 'top=0,left=0,height=100%,width=auto');
					    popupWin.document.open();
					  	popupWin.document.write('<html><head><link href="<?php echo $assets_path; ?>style.css" rel="stylesheet"></head><body onload="window.print();window.close()">'+printContents+'</body></html>');
					    popupWin.document.close();
				  }

              $(document).ready(function() {
			         	$('#edit').froalaEditor();

              	$('#cls_btn').click(function()
              	{	
              		$("#myreviewmodal").modal("hide");
              	});
              	$('#subtitle1').keypress(function()
              	{	
              		var dInput = this.value;
              		$('#subt1').html(dInput);
              		//Week-at-a-Glance Menu
              	});
              	$('#subtitle2').keypress(function()
              	{	
              		var Input = this.value;
              		$('#subt2').html(Input);
              		//Week-at-a-Glance Menu
              	});
                 $('#review_now').click(function(){
					       
                 $('#printarea').html('');
                 	var footercontent=$("#edit").froalaEditor('html.get', true);
                 	$('#footer_print').html(footercontent);
                 	//console.log(footercontent);
                 	$('#printarea').html($('#showit').html());
                 	$('#myreviewmodal').modal('show');
                  $('#printarea .carriage_outer').attr('id','mkid');
                 });
                $('#date_timepicker_start').change(function(){
                  var month = new Array();
                  month[0] = "Jan";
                  month[1] = "Feb";
                  month[2] = "Mar";
                  month[3] = "Apr";
                  month[4] = "May";
                  month[5] = "Jun";
                  month[6] = "Jul";
                  month[7] = "Aug";
                  month[8] = "Sep";
                  month[9] = "Oct";
                  month[10] = "Nov";
                  month[11] = "Dec";

                  var newdate = $('#date_timepicker_start').datepicker('getDate'); 
                  var newdate2 = $('#date_timepicker_start').datepicker('getDate'); 
                  var newdate3 = $('#date_timepicker_start').datepicker('getDate'); 
                  var newdate4 = $('#date_timepicker_start').datepicker('getDate'); 
                  var newdate5 = $('#date_timepicker_start').datepicker('getDate'); 
                  var newdate6 = $('#date_timepicker_start').datepicker('getDate'); 
                  var newdate7 = $('#date_timepicker_start').datepicker('getDate'); 

                  newdate.setDate(newdate.getDate());
                  var dd1 = newdate.getDate();
                  var mm1 = newdate.getMonth()+1;
                  var y1 = newdate.getFullYear();
                  var d1 = dd1 + '/' + mm1;

                  newdate2.setDate(newdate2.getDate() + 1);
                  var dd2 = newdate2.getDate();
                  var mm2 = newdate2.getMonth() + 1;
                  var y2 = newdate2.getFullYear();
                  var d2 = dd2 + '/' + mm2 ;

                  newdate3.setDate(newdate3.getDate() + 2);
                  var dd3 = newdate3.getDate();
                  var mm3 = newdate3.getMonth() + 1;
                  var y3 = newdate3.getFullYear();
                  var d3 = dd3 + '/' + mm3 ;

                  newdate4.setDate(newdate4.getDate() + 3);
                  var dd4 = newdate4.getDate();
                  var mm4 = newdate4.getMonth() + 1;
                  var y4 = newdate4.getFullYear();
                  var d4 = dd4 + '/' + mm4 ;

                  newdate5.setDate(newdate5.getDate() + 4);
                  var dd5 = newdate5.getDate();
                  var mm5 = newdate5.getMonth() + 1;
                  var y5 = newdate5.getFullYear();
                  var d5 = dd5 + '/' + mm5 ;

                  newdate6.setDate(newdate6.getDate() + 5);
                  var dd6 = newdate6.getDate();
                  var mm6 = newdate6.getMonth() + 1;
                  var y6 = newdate6.getFullYear();
                  var d6 = dd6 + '/' + mm6 ;

                  newdate7.setDate(newdate7.getDate() + 6);
                  var dd7 = newdate7.getDate();
                  var mm7 = newdate7.getMonth() + 1;
                  var y7 = newdate7.getFullYear();
                  var d7 = dd7 + '/' + mm7;
             			
                 		$('#d1').html(d1); 
                 		$('#d2').html(d2); 
                 		$('#d3').html(d3); 
                 		$('#d4').html(d4); 
                 		$('#d5').html(d5); 
                 		$('#d6').html(d6); 
                 		$('#d7').html(d7); 
                 		//console.log(d);
                 });
              

                 $('.draggable').draggable({
                  revert: "invalid",
                  //stack: ".draggable",
                  helper: 'clone'
                  
                });

                $('.droppable11').droppable({
                  //accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                  // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable12').droppable({
                  //accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable13').droppable({
                  //accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                 $('.droppable21').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                    //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable22').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                  //  draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable23').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;    
                    draggable.clone().appendTo(droppable);
                  //  draggable.css({backgroundColor: '#abece0'});
                  }
                });
                   $('.droppable31').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable32').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable33').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                  $('.droppable41').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                  //  draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable42').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                    //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable43').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                    $('.droppable51').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable52').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable53').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                   $('.droppable61').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable62').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                    //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable63').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                   $('.droppable71').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable72').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable73').droppable({
                  accept: ".draggable",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    draggable.clone().appendTo(droppable);
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });

                     $(".name_anchor").hover(function()
                     {
                        $(this).css("color", "#5bc0de");
                        }, function(){
                        $(this).css("color", "#73879C");
                    });

                  //-------time ------------
      $('.start_time').timepicker({ 'step': 15 ,'scrollDefault': 'now','timeFormat': 'h:i A' });
       function addMinutes(time/*"hh:mm"*/, minsToAdd/*"N"*/) {
        function z(n){
          return (n<10? '0':'') + n;
        }
        var bits = time.split(':');
        var mins = bits[0]*60 + (+bits[1]) + (+minsToAdd);

        return z(mins%(24*60)/60 | 0) + ':' + z(mins%60);  
      }
       $('.start_time').on('changeTime', function() {
        var startTime = $(this).val().split(':');
        var getmin  = startTime[1].split(' ');
        var gettime = startTime[0]+':'+getmin[0];
        
        var endHours = addMinutes(gettime, '30');
        var endHourssplit = endHours.split(':');

        if(endHourssplit[0] == '12' && getmin[1]== 'AM')
        {
           setampm = 'PM';
        } 
        else if(endHourssplit[0] == '12' && getmin[1]== 'PM')
        {
           setampm = 'AM';
        } 
        else
        {
          setampm = getmin[1];
        }
        $('.end_time').val(endHours +" "+setampm);
      });

      
        // var currentDate = $("#start_date").val(); 
    //  $('#end_date').datepicker( {dateFormat: "yy-mm-dd", changeYear: true, yearRange:  "+0:+5",minDate: 0});
      //$("#end_date").datepicker("setDate", currentDate); 
      $('.end_time').timepicker({ 'step': 15, 'timeFormat': 'h:i A','scrollDefault': 'now'});  
      
      $( ".start_time" ).addClass("form-control");
      $( ".end_time" ).addClass("form-control");

		// add breakfast
		$("#sub_break").click(function() {
		   if(($('#location_id1').val().length>0)&&( $('#sdate1').val().length>0)&&($('#description1').val().length>0)&&( $('#stime1').val().length>0)&&($('#etime1').val().length>0)&&($('#etime1').val().length>0)&&($('#is_active1').val().length>0))
		        {

		         if ($('input[name^= recurring]:checked').length <= 0) {
		              alert("Please provide Recurring day");
		          }
		          else
		          {
		               //alert('all ok');
		               $("form[name='form_breakfast']").submit();
		          }
		        }
		        else
		        { 
		           alert("Please provide all required fields value!!");
		        }
		});

		// end add breakfase
		// add lunch
		$("#sub_lunch").click(function() {
		   if(($('#location_id2').val().length>0)&&( $('#sdate2').val().length>0)&&($('#description2').val().length>0)&&( $('#stime2').val().length>0)&&($('#etime2').val().length>0)&&($('#is_active2').val().length>0))
		        {

		         if ($('input[name^= recurring]:checked').length <= 0) {
		              alert("Please provide Recurring day");
		          }
		          else
		          {
		               //alert('all ok');
		               $("form[name='form_lunch']").submit();
		          }
		        }
		        else
		        { 
		           alert("Please provide all required fields value!!");
		        }
		});
		// end add lunch
		// add dinner
		$("#sub_dinner").click(function() {
		   if(($('#location_id3').val().length>0)&&( $('#sdate3').val().length>0)&&($('#description3').val().length>0)&&( $('#stime3').val().length>0)&&($('#etime3').val().length>0)&&($('#is_active3').val().length>0))
		        {

		         if ($('input[name^= recurring]:checked').length <= 0) {
		              alert("Please provide Recurring day");
		          }
		          else
		          {
		               //alert('all ok');
		               $("form[name='form_dinner']").submit();
		          }
		        }
		        else
		        { 
		           alert("Please provide all required fields value!!");
		        }
	   	});
     
       $("span.ui-droppable").click(function () { 
              
              var str = $(this).attr('class');
              var str1 = str.substr(0,str.indexOf(' '));
              var str2=str1[9]+str1[10];
              //console.log(str2);
              //console.log($('.'+str1).html().length);
                if ($('.'+str1).html().length>0) {
             
                  $('.'+str1).prepend('<i class="fa fa-times-circle" aria-hidden="true" onclick="clearit('+str2+');"></i>');
               }
          });
    

    });
    function clearit(id)
    {

      $('.droppable'+id).html('');

    }
 

</script>

<style type="text/css"> @media print{ ul.carrige_table span {border: 1px solid #000;color: #000;} }</style>
