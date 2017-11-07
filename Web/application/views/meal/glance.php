<?php
    $admin_id = $this->session->userdata['logged_in']['admin_id'];
?>
    <!-- page content -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <div class="right_col" role="main">
        <div class="">
        	<div class="row">
        		<div class="col-md-8" id="mealresponse">
        			
                    <?php if($this->session->flashdata('flash_msg')){?>
                    <div class="alert alert-success">      
                      <?php echo $this->session->flashdata('flash_msg')?>
                    </div>
                  	<?php } ?>
        		</div>
        		<div class="col-md-4">
        			
        		</div>
        	</div>
            <div class="page-title">
                <div class="title_left row">
                    <div class="col-md-8"><h3>Meals At a Glance </h3></div>
                     <div class="col-md-4 form-inline">
                      <div id="save_glance_response1"></div>
                          <div class="form-group custom_latest">
                          <input type="button" id="review_now1" class="btn btn-md btn-primary" value="Print">&nbsp;
                          <input type="button" id="save_now1" class="btn btn-md btn-primary" value="Save">
                        </div>
                     </div>
                    <div>
          						<div class="col-md-2">
          						<h4><label for="Month">Month for:</label></h4>
          			              <select name="start_month" id='start_month' class="form-control" required >
          			          
            			              <?php
                              for ($i = 0; $i <= 2; ++$i) {
                                    if($i==0)
                                    {
                                        $time = strtotime(sprintf('first day of this month'));
                                    }
                                    else
                                    {
                                        $time=strtotime('next month',$time);
                                    }
                                   
                                    $value = date('m/d/Y', $time);
                                    $label = date('F', $time);
                                    printf('<option value="%s" id="'.$i.'">%s</option>', $value, $label);
                                }
                              ?>              
          			              </select>
          						</div>
          						<div class="col-md-5"> 
          							<h4>Sub Title1:</h4><input type="text" class="form-control"  name="sub_title" id="subtitle1" value="" >
          						</div>
          						<div class="col-md-5"> 
          							<h4>Sub Title2:</h4><input type="text" class="form-control" name="sub_title" id="subtitle2" value="" >
          						</div>
                 	</div>
                </div>
                  <!--8th sept-->
    <div class="carriage_left_area1">
        <ul class="carrige_table1">
        <div class="break_outer">
          <li class="break">
            <p><span><i class="fa fa-coffee" aria-hidden="true"></i>BREAKFAST<i type="button" class="fa fa-plus-square-o" data-toggle="modal" data-target="#myModal" aria-hidden="true" style="float: right; cursor: pointer;" onclick="placetime1();"></i></span>
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
              <div class='form-group custom_latest' style="margin: 0;">
              <input type="hidden" name="meal_type" value="breakfast">
     
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
              <div class='col-md-4'>
              <label for="description">Description &nbsp;&nbsp;&nbsp;&nbsp;<div id="charNum1"></div></label>
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
            <span class="draggable_breakfast" style="width:auto"  id="<?php echo 'dinner'.$rowb['id']; ?>" recur="<?php echo $rowb['recurring']; ?>"><?php echo $rowb['description'];?></span>
          </li>
         <?php
           }
         }
        else
         {
          ?>
          <li>
            <span >No Breakfast list available</span>
          </li>
          <?php
         }
          ?>
          </div>
          </div>

          <div class="break_outer">
          <li class="break">
            <p><span><i class="fa fa-cutlery" aria-hidden="true"></i>LUNCH<i class="fa fa-plus-square-o" data-toggle="modal" data-target="#myModal2" aria-hidden="true" style="float: right; cursor: pointer;" onclick="placetime2();"></i></span>
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
              	<input type="hidden" name="meal_type" value="lunch">
              <div class='form-group'>
               <div class='col-md-2'>
              <label for="start_time">Meal Time</label>
              <input type="text" name="start_time" value="" class="start_time" id="stime2" class="form-control" autofocus="true" onkeydown="return false"  required />
              </div>
              <div class='col-md-2'>
              <label for="end_time">End Time</label>
      <input type="text" name="end_time" value="" class="end_time" class="form-control" id="etime2" autofocus="true" onkeydown="return false" required />
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
              <div class='col-md-5'>
              <label for="description">Description &nbsp;&nbsp;&nbsp;&nbsp;<div id="charNum2"></div></label>
              <textarea name="description" cols="40" rows="1" type="textarea" id="description2" value="" class="form-control" autofocus="true" required ></textarea>
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
            <span class="draggable_lunch"  style="width:auto"  id="<?php echo 'dinner'.$rowl['id']; ?>" recur="<?php echo $rowl['recurring']; ?>"><?php echo $rowl['description'];?></span>
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
            <p><span><i class="fa fa-cutlery" aria-hidden="true"></i>DINNER<i class="fa fa-plus-square-o" data-toggle="modal" data-target="#myModal3" aria-hidden="true" style="float: right; cursor: pointer;" onclick="placetime3();"></i></span>
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
              <input type="hidden" name="meal_type" value="dinner">
              <div class='col-md-2'>
              <label for="start_time">Meal Time</label>
              <input type="text" name="start_time" value="" class="start_time" id="stime3" class="form-control" autofocus="true" onkeydown="return false"  required />
              </div>
              <div class='col-md-2'>
              <label for="end_time">End Time</label>
      <input type="text" name="end_time" value="" class="end_time" class="form-control" id="etime3" autofocus="true" onkeydown="return false" required />
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
              <div class='col-md-5'>
              <label for="description">Description &nbsp;&nbsp;&nbsp;&nbsp;<div id="charNum3"></div></label>
              <textarea name="description" cols="40" rows="1" type="textarea" id="description3" value="" class="form-control" autofocus="true" required ></textarea>
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
            <span class="draggable_dinner" style="width:auto" id="<?php echo 'dinner'.$rowd['id']; ?>" recur="<?php echo $rowd['recurring']; ?>"><?php echo $rowd['description'];?></span>
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
       		<div id="myreviewmodal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
      			  <div class="modal-dialog modal-lg">

      			    <!-- Modal content-->
      			    <div class="modal-content">
      			      <div class="modal-header text-center">
      			        <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal">&times;</button>
      			        <h4 class="modal-title" style="display: inline-block;">Select Week To Print:</h4>
      			        <input id="date_timepicker_start" name="start" type="text" value="" class="form-control">
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
		    <p class="align_2 titile_customm"><?php echo $address; ?></p>
		    <p class="align_3 titile_customm" id="subt1">---Subtitle 1--</p>
		    <p class="align_4 titile_customm" id="subt2">---Subtitle 2--</p>
      <div class="brk_lunch_outer_main">
       <ul class="brk_lunch_outer">
          <li><span>BREAKFAST</span>
          <span>LUNCH</span>
          <span class="dinner">DINNER</span></li>
        </ul>
      </div>

		    <div class="carriage_left_area">
		      <ul class="carrige_table">
		        <li >
		          <span>S<br>U<br>N</span>
		          <span class="droppable11"></span>
		          <span class="droppable12"></span>
		          <span class="droppable13"></span>
		          <span id="d1"></span>
		        </li>
		        <li >
		          <span>M<br>O<br>N</span>
		          <span class="droppable21"></span>
		          <span class="droppable22"></span>
		          <span class="droppable23"></span>
		          <span id="d2"></span>
		        </li>
		        <li>
		          <span>T<br>U<br>E</span>
		          <span class="droppable31"></span>
		           <span class="droppable32"></span>
		           <span class="droppable33"></span>
		           <span id="d3"></span>
		        </li>
		        <li>
		          <span>W<br>E<br>D</span>
		           <span class="droppable41"></span>
		           <span class="droppable42"></span>
		           <span class="droppable43"></span>
		         
		          <span id="d4"></span>
		        </li>
		        <li>
		          <span>T<br>H<br>U</span>
		            <span class="droppable51"></span>
		           <span class="droppable52"></span>
		           <span class="droppable53"></span>
		         <span id="d5"></span>
		        </li>
		        <li>
		          <span>F<br>R<br>I</span>
		           <span class="droppable61"></span>
		           <span class="droppable62"></span>
		           <span class="droppable63"></span>
		          <span id="d6"></span>
		        </li>
		        <li>
		          <span>S<br>A<br>T</span>
		           <span class="droppable71"></span>
		           <span class="droppable72"></span>
		           <span class="droppable73"></span>
		          <span id="d7"></span>
		        </li>
		      </ul>
		     	 <div class="align_1" id="footer_print"></div>
				
		    </div>
  	</div>
  </div>

     <div class="row">
       <div class="col-md-8 form-inline">
        <div id="toolbar-toolbar" class="toolbar">
          <span class="ql-formats">
          <select class="ql-font">
          <option selected=""></option>
          <option value="serif"></option>
          <option value="monospace"></option>
          </select>
          <select class="ql-size">
          <option value="small"></option>
          <option selected=""></option>
          <option value="large"></option>
          <option value="huge"></option>
          </select>
          </span>
          <span class="ql-formats">
          <button class="ql-bold"></button>
          <button class="ql-italic"></button>
          <button class="ql-underline"></button>
          <button class="ql-strike"></button>
          </span>
          <span class="ql-formats">
          <select class="ql-color"></select>
          <select class="ql-background"></select>
          </span>
          <span class="ql-formats">
          <button class="ql-list" value="ordered"></button>
          <button class="ql-list" value="bullet"></button>
          <select class="ql-align">
          <option selected=""></option>
          <option value="center"></option>
          <option value="right"></option>
          <option value="justify"></option>
          </select>
          </span>
          <span class="ql-formats">
          <button class="ql-link"></button>
          <button class="ql-image"></button>
          </span>
          </div>
    			    <div id='edit' style="margin-top: 0px;">
    			      <h2>Footer Headline</h2>
    			      <p>Footer Quotes</p>
    			    </div>
       </div>
             <div class="col-md-8 form-inline">
                 
                  <div class="form-group custom_latest">
                   <div id="save_glance_response2 "></div>
                  <input type="button" id="review_now" class="btn btn-md btn-primary" value="Print">&nbsp;
                  <input type="button" id="save_now" class="btn btn-md btn-primary" value="Save">
                 
                </div>
             </div>
  </div>
       
  </form>
        </div>
        </div>
            <!-- footer content -->
    
        <!-- Theme included stylesheets -->
        <link href="https://cdn.quilljs.com/1.3.3/quill.snow.css" rel="stylesheet">
         <script src="//cdn.quilljs.com/1.3.3/quill.js"></script>

            <script type="text/javascript">
    				function printDiv(divName) {
    					  var printContents, popupWin;
					    var printContents = document.getElementById(divName).innerHTML;
					    popupWin = window.open('', '_blank', 'top=0,left=0,height=100%,width=auto');
					    popupWin.document.open();
					  	popupWin.document.write(' <html><head><link href="<?php echo $assets_path; ?>style.css" rel="stylesheet"></head><body onload="window.print();window.close()">'+printContents+'</body></html>');
					    popupWin.document.close();
				    }

              $(document).ready(function() {
                      var quill = new Quill('#edit', {
                          modules: {
                            toolbar: { container: '#toolbar-toolbar' }
                          },
                          theme: 'snow'
                        });
  
                    
                    // console.log(JSON.stringify(quill.getContents().ops));
                    
                 //---glance date range picker
                 $("#start_month").change(function(){
                   
                     	$("#date_timepicker_start" ).datepicker("destroy");
                     	var smonth=$('#start_month').val();
                       $("#date_timepicker_start").val('');
                     	console.log(smonth);

                     	$("#date_timepicker_start").datepicker({ 
              						autoSize: true,
              						//stepMonths: 0,
              						firstDay: 0, // Start with Sunday
              						//defaultDate: new Date('11/8/2017'),
              						defaultDate: new Date(smonth),
              						altFormat: 'dd-mm-yy',
              						beforeShowDay: function (date) {
              						return [date.getDay() === 0,'']
              						}
                   		}); // Allow only one day a week
                      if(smonth!='')
                      {
                          var x=smonth.split("/");
                          var monthyear=x[0]+'_'+x[2];
                           $.post("<?php  echo site_url(); ?>/Meal/get_glance_month", {monthyear:monthyear}, function(result){
                                //console.log(result);
                                var maindata=JSON.parse(result);
                                if(parseInt(maindata.length)>0)
                                {
                                   if(maindata[0]['subtitle1']!='')
                                   {
                                      $('#subt1').html(maindata[0]['subtitle1']);
                                      $('#subt2').html(maindata[0]['subtitle2']);
                                      $('#subtitle1').val(maindata[0]['subtitle1']);
                                      $('#subtitle2').val(maindata[0]['subtitle2']);
                                      //$('#edit').html();
                                      if(maindata[0]['footer']!='')
                                      {
                                        var x=JSON.parse(maindata[0]['footer']);
                                        var length=x.length;
                                       // console.log(length);
                                        //console.log(maindata[0]['footer']);
                                        //quill.setContents([{"insert":x[0]['insert']},{"attributes":x[1]['attributes'],"insert":"\n"},{"insert":x[2]['insert']}]);
                                        //quill.setContents([{"insert":"Footer Headline"},{"attributes":{"header":2},"insert":"\n"},{"insert":"Footer Quotes\n"}]);
                                        quill.setContents(x,'api');
                                      }else
                                      {
                                         quill.setContents([{"insert":"Footer Headline"},{"attributes":{"header":2},"insert":"\n"},{"insert":"Footer Quotes\n"}]);
                                      }
                                  
                                   }
                                   else
                                   {
                                      $('#subt1').html('--Subtitle1--');
                                      $('#subt2').html('--Subtitle2--');
                                      
                                   }
                                  for(var g=0;g<maindata.length;g++)
                                  {
                                     // console.log(maindata[g]['data']);
                                     // console.log(maindata[g]['position']);
                                      $(".droppable"+maindata[g]['position']).html(maindata[g]['data']);
                                  }
                                }
                                else
                                {
                                    for(var i=1;i<=7;i++)
                                    {
                                        for(var j=1;j<=3;j++)
                                        {
                                           $(".droppable"+i+j).html(''); 
                                        }
                                    }
                                     $('#subt1').html('--Subtitle1--');
                                     $('#subt2').html('--Subtitle2--');
                                } 
                          });
                      }

                 });
               
                 $('#save_now, #save_now1').click(function(){
            					var str=$('#start_month').val();
            					if(str!='')
            					{
            					var x=str.split("/");
            					//console.log('\n month of date:'+x[0]);
            					var monthyear=x[0]+'_'+x[2];
            					var mainarr=[];
            					for(var i=1;i<=7;i++)
            					{
            					    for(var j=1;j<=3;j++)
            					    {
            							  var title=$(".droppable"+i+j).html();
            							 mainarr.push('{'+i+j+'<>'+title+'}');
            					    }
            					}
            					var subtitle1=$('#subtitle1').val();
            					var subtitle2=$('#subtitle2').val();
            					//var footercontnt=document.querySelector("#edit").innerHTML;
                     // var footercontnt=document.querySelector(".ql-editor").innerHTML;
                      var footercontnt=JSON.stringify(quill.getContents().ops);
            					console.log('saving data length'+mainarr);
            					$('#save_glance_response1,#save_glance_response2').html('<strong style="color:green">Processing</strong><img src="<?php echo $assets_path;?>spin.gif" style="height: 17px;"/>');
            					$.post("<?php  echo site_url(); ?>/Meal/save_glance", {mainarr:mainarr,monthyear:monthyear,subtitle1:subtitle1,subtitle2:subtitle2,footer:footercontnt}, function(result){
            					     //alert(result);
            					    console.log(result);

            					if(result=='success')
            					{
            					$('#save_glance_response1,#save_glance_response2').html('<strong style="color:green"><i class="fa fa-check-circle"></i> Success! Data Saved.</strong>');
            					setTimeout(function(){ $('#save_glance_response1,#save_glance_response2').html(''); }, 2000);

            					    }
            					else
            					{
            					$('#save_glance_response1,#save_glance_response2').html('<strong style="color:red"> <i class="fa fa-times-circle"></i> Oops! Data did not saved, try again later!!</strong>');
            					setTimeout(function(){ $('#save_glance_response1,#save_glance_response2').html(''); }, 3000);

            					}
            					});

            					}
            					else
            					{
            					alert('Please select Month!!');
            					}
                 });

              	$('#subtitle1').keyup(function()
              	{	
              		var dInput = this.value;
              		$('#subt1').html(dInput);
              	});
              	$('#subtitle2').keyup(function()
              	{	
              		var Input = this.value;
              		$('#subt2').html(Input);
              	});

                 $('#review_now, #review_now1').click(function(){   

                        var str=$('#start_month').val();
                        if(str!='')
                        {
                            var x=str.split("/");
                            //console.log('\n month of date:'+x[0]);
                            var monthyear=x[0]+'_'+x[2];
                            var mainarr=[];
                            for(var i=1;i<=7;i++)
                            {
                                for(var j=1;j<=3;j++)
                                {
                                   var title=$(".droppable"+i+j).html();
                                   mainarr.push('{'+i+j+'<>'+title+'}');
                                }
                            }
                            var subtitle1=$('#subtitle1').val();
                            var subtitle2=$('#subtitle2').val();
                            //var footercontnt=document.querySelector("#edit").innerHTML;
                               //var footercontnt=document.querySelector(".ql-editor").innerHTML;
                                var footercontnt=JSON.stringify(quill.getContents().ops);
                            console.log('saving data length'+mainarr);
                               $('#save_glance_response1,#save_glance_response2').html('<strong style="color:green">Processing</strong><img src="<?php echo $assets_path;?>spin.gif" style="height: 17px;"/>');
                            $.post("<?php  echo site_url(); ?>/Meal/save_glance", {mainarr:mainarr,monthyear:monthyear,subtitle1:subtitle1,subtitle2:subtitle2,footer:footercontnt}, function(result){
                                 //alert(result);
                                console.log(result);
                                if(result=='success')
                                {
                                   $('#save_glance_response1,#save_glance_response2').html('<strong style="color:green">Success! Data Saved.</strong>');
                                    setTimeout(function(){ $('#save_glance_response1,#save_glance_response2').html(''); 
                                          $('#printarea').html('');
                                        $('.ql-hidden').html('');
                                        $('#date_timepicker_start').val('');
                                        var footercontent=document.querySelector("#edit").innerHTML;
                                        $('#footer_print').html(footercontent);
                                        //console.log(footercontent);
                                        $('#printarea').html($('#showit').html());
                                        $('#myreviewmodal').modal('show');
                                        $('#printarea .carriage_outer').attr('id','mkid');
                                    }, 1000);
                                   
                                }
                                else
                                {
                                   $('#save_glance_response1,#save_glance_response2').html('<strong style="color:red">Oops! Data did not saved, try again later!!</strong>');
                                   setTimeout(function(){ $('#save_glance_response1,#save_glance_response2').html(''); 
                                        $('#printarea').html('');
                                        $('.ql-hidden').html('');
                                        $('#date_timepicker_start').val('');
                                        var footercontent=document.querySelector("#edit").innerHTML;
                                        $('#footer_print').html(footercontent);
                                        //console.log(footercontent);
                                        $('#printarea').html($('#showit').html());
                                        $('#myreviewmodal').modal('show');
                                        $('#printarea .carriage_outer').attr('id','mkid');
                                    }, 2000);
                                }
                            });
                        }
                        else
                        {
                        alert('Please select Month!!');
                        }             
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

                  var d1 = mm1 + '/' + dd1;

                  newdate2.setDate(newdate2.getDate() + 1);
                  var dd2 = newdate2.getDate();
                  var mm2 = newdate2.getMonth() + 1;
                  var y2 = newdate2.getFullYear();
                  var d2 = mm2 + '/' + dd2 ;

                  newdate3.setDate(newdate3.getDate() + 2);
                  var dd3 = newdate3.getDate();
                  var mm3 = newdate3.getMonth() + 1;
                  var y3 = newdate3.getFullYear();
                  var d3 = mm3 + '/' + dd3 ;

                  newdate4.setDate(newdate4.getDate() + 3);
                  var dd4 = newdate4.getDate();
                  var mm4 = newdate4.getMonth() + 1;
                  var y4 = newdate4.getFullYear();
                  var d4 = mm4 + '/' + dd4 ;

                  newdate5.setDate(newdate5.getDate() + 4);
                  var dd5 = newdate5.getDate();
                  var mm5 = newdate5.getMonth() + 1;
                  var y5 = newdate5.getFullYear();
                  var d5 = mm5 + '/' + dd5 ;

                  newdate6.setDate(newdate6.getDate() + 5);
                  var dd6 = newdate6.getDate();
                  var mm6 = newdate6.getMonth() + 1;
                  var y6 = newdate6.getFullYear();
                  var d6 = mm6 + '/' + dd6 ;

                  newdate7.setDate(newdate7.getDate() + 6);
                  var dd7 = newdate7.getDate();
                  var mm7 = newdate7.getMonth() + 1;
                  var y7 = newdate7.getFullYear();
                  var d7 = mm7 + '/' + dd7;
             			
                 		$('#d1').html(d1); 
                 		$('#d2').html(d2); 
                 		$('#d3').html(d3); 
                 		$('#d4').html(d4); 
                 		$('#d5').html(d5); 
                 		$('#d6').html(d6); 
                 		$('#d7').html(d7); 
                 		//console.log(d);

                 		var dd = newdate.getDate();
        						var mm = newdate.getMonth()+1; //January is 0!
        						var yyyy = newdate.getFullYear();
        						if(dd<10){
        						    dd='0'+dd;
        						} 
        						if(mm<10){
        						    mm='0'+mm;
        						} 
        						var startdate = dd+'-'+mm+'-'+yyyy;
                 	 $.post("<?php  echo site_url(); ?>/Meal/get_glance_week", {startdate:startdate}, function(result){
                          //console.log(result);
                         var maindata=JSON.parse(result);
                          if(parseInt(maindata.length)>0)
                          {
                              for(var g=0;g<maindata.length;g++)
                              {
                                  //console.log(maindata[g]['data']);
                                 // console.log(maindata[g]['position']);
                                  $(".droppable"+maindata[g]['position']).html(maindata[g]['data']);
                              }
                          }

                    });
                 });
                 $('.draggable_breakfast').draggable({
                  revert: "invalid",
                  //stack: ".draggable",
                  helper: 'clone'
                  
                });
                  $('.draggable_lunch').draggable({
                  revert: "invalid",
                  //stack: ".draggable",
                  helper: 'clone'
                  
                });

                   $('.draggable_dinner').draggable({
                  revert: "invalid",
                  //stack: ".draggable",
                  helper: 'clone'
                  
                });

                $('.droppable11').droppable({
                  accept: ".draggable_breakfast",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    if ($(".droppable11").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                       //alert(JSON.stringify(droppable));

                    }
          					var startdate = $("#start_month").val();
          					$(".droppable11 .draggable_breakfast").html();
          					var str=$(".droppable11 .draggable_breakfast").attr('id');
          					var recurring_org=$(".droppable11 .draggable_breakfast").attr('recur');

          					var mealid=str.substring(6);
          					$.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'S',mealid:mealid}, function(result){
          						//$("#mealresponse").html(result);
          						if(result=="true")
          						{
                         $(".droppable11 .draggable_breakfast").attr("cur_recur","S");
          							$('#save_now1').click();
          						}
          					});
                   //draggable.css({backgroundColor: '#abece0'});
                  }

                });
                $('.droppable12').droppable({
                  accept: ".draggable_lunch",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    if ($(".droppable12").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                  	var startdate = $("#start_month").val();
            					$(".droppable12 .draggable_lunch").html();
            					var str=$(".droppable12 .draggable_lunch").attr('id');
            					var recurring_org=$(".droppable12 .draggable_lunch").attr('recur');

            					var mealid=str.substring(6);
            					$.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'S',mealid:mealid}, function(result){
            						if(result=="true")
            						{
                           $(".droppable12 .draggable_lunch").attr("cur_recur","S");
            							$('#save_now1').click();
            						}
            					});
                   //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable13').droppable({
                  accept: ".draggable_dinner",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                      if ($(".droppable13").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                    	var startdate = $("#start_month").val();
        						$(".droppable13 .draggable_dinner").html();
        						var str=$(".droppable13 .draggable_dinner").attr('id');
        						var recurring_org=$(".droppable13 .draggable_dinner").attr('recur');
        						var mealid=str.substring(6);
        						$.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'S',mealid:mealid}, function(result){
        							if(result=="true")
        							{
                        $(".droppable13 .draggable_dinner").attr("cur_recur","S");
        								$('#save_now1').click();
        							}
        						});
                   //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                 $('.droppable21').droppable({
                  accept: ".draggable_breakfast",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                       if ($(".droppable21").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                    var startdate = $("#start_month").val();
        					$(".droppable21 .draggable_breakfast").html();
        					var str=$(".droppable21 .draggable_breakfast").attr('id');
        					var recurring_org=$(".droppable21 .draggable_breakfast").attr('recur');

        					var mealid=str.substring(6);
        					$.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'M',mealid:mealid}, function(result){
        						if(result=="true")
        						{
                       $(".droppable21 .draggable_breakfast").attr("cur_recur","M");
        							$('#save_now1').click();
        						}
        					});
                    //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable22').droppable({
                  accept: ".draggable_lunch",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                       if ($(".droppable22").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                    var startdate = $("#start_month").val();
            					$(".droppable22 .draggable_lunch").html();
            					var str=$(".droppable22 .draggable_lunch").attr('id');
            					var recurring_org=$(".droppable22 .draggable_lunch").attr('recur');

            					var mealid=str.substring(6);
            					$.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'M',mealid:mealid}, function(result){
            						if(result=="true")
            						{
                          $(".droppable22 .draggable_lunch").attr("cur_recur","M");
            							$('#save_now1').click();
            						}
            					});
                  //  draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable23').droppable({
                  accept: ".draggable_dinner",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    if ($(".droppable23").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                    	var startdate = $("#start_month").val();
        						$(".droppable23 .draggable_dinner").html();
        						var str=$(".droppable23 .draggable_dinner").attr('id');
        						var recurring_org=$(".droppable23 .draggable_dinner").attr('recur');
        						var mealid=str.substring(6);
        						$.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'M',mealid:mealid}, function(result){
        							if(result=="true")
        							{
                        $(".droppable23 .draggable_dinner").attr("cur_recur","M");
        								$('#save_now1').click();
        							}
        						});
                  //  draggable.css({backgroundColor: '#abece0'});
                  }
                });
                   $('.droppable31').droppable({
                  accept: ".draggable_breakfast",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    if ($(".droppable31").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
          					$(".droppable31 .draggable_breakfast").html();
          					var str=$(".droppable31 .draggable_breakfast").attr('id');
          					var recurring_org=$(".droppable31 .draggable_breakfast").attr('recur');

          					var mealid=str.substring(6);
          					$.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'T',mealid:mealid}, function(result){
          						if(result=="true")
          						{
                         $(".droppable31 .draggable_breakfast").attr("cur_recur","T");
          							$('#save_now1').click();
          						}
          					});
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable32').droppable({
                  accept: ".draggable_lunch",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    if ($(".droppable32").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                    var startdate = $("#start_month").val();
            					$(".droppable32 .draggable_lunch").html();
            					var str=$(".droppable32 .draggable_lunch").attr('id');
            					var recurring_org=$(".droppable32 .draggable_lunch").attr('recur');

            					var mealid=str.substring(6);
            					$.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'T',mealid:mealid}, function(result){
            						if(result=="true")
            						{
                          $(".droppable32 .draggable_lunch").attr("cur_recur","T");
            							$('#save_now1').click();
            						}
            					});
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable33').droppable({
                  accept: ".draggable_dinner",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable33").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                      var startdate = $("#start_month").val();
                    $(".droppabl33 .draggable_dinner").html();
                    var str=$(".droppable33 .draggable_dinner").attr('id');
                    var recurring_org=$(".droppable33 .draggable_dinner").attr('recur');
                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'T',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                        $(".droppable33 .draggable_dinner").attr("cur_recur","T");
                        $('#save_now1').click();
                      }
                    });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                  $('.droppable41').droppable({
                  accept: ".draggable_breakfast",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable41").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                      var startdate = $("#start_month").val();
                    $(".droppable41 .draggable_breakfast").html();
                    var str=$(".droppable41 .draggable_breakfast").attr('id');
                    var recurring_org=$(".droppable41 .draggable_breakfast").attr('recur');

                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'W',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                         $(".droppable41 .draggable_breakfast").attr("cur_recur","W");
                        $('#save_now1').click();
                      }
                    });
                  //  draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable42').droppable({
                  accept: ".draggable_lunch",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable42").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
                      $(".droppable42 .draggable_lunch").html();
                      var str=$(".droppable42 .draggable_lunch").attr('id');
                      var recurring_org=$(".droppable42 .draggable_lunch").attr('recur');

                      var mealid=str.substring(6);
                      $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'W',mealid:mealid}, function(result){
                        if(result=="true")
                        {
                           $(".droppable42 .draggable_lunch").attr("cur_recur","W");
                          $('#save_now1').click();
                        }
                      });
                    //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable43').droppable({
                  accept: ".draggable_dinner",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable43").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
                    $(".droppabl43 .draggable_dinner").html();
                    var str=$(".droppable43 .draggable_dinner").attr('id');
                    var recurring_org=$(".droppable43 .draggable_dinner").attr('recur');
                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'W',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                         $(".droppable43 .draggable_dinner").attr("cur_recur","W");
                        $('#save_now1').click();
                      }
                    });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                    $('.droppable51').droppable({
                  accept: ".draggable_breakfast",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable51").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                      var startdate = $("#start_month").val();
                    $(".droppable51 .draggable_breakfast").html();
                    var str=$(".droppable51 .draggable_breakfast").attr('id');
                    var recurring_org=$(".droppable51 .draggable_breakfast").attr('recur');

                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'Th',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                         $(".droppable51 .draggable_breakfast").attr("cur_recur","Th");
                        $('#save_now1').click();
                      }
                    });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable52').droppable({
                  accept: ".draggable_lunch",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable52").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
                      $(".droppable52 .draggable_lunch").html();
                      var str=$(".droppable52 .draggable_lunch").attr('id');
                      var recurring_org=$(".droppable52 .draggable_lunch").attr('recur');

                      var mealid=str.substring(6);
                      $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'Th',mealid:mealid}, function(result){
                        if(result=="true")
                        {
                          $(".droppable52 .draggable_lunch").attr("cur_recur","Th");
                          $('#save_now1').click();
                        }
                      });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable53').droppable({
                  accept: ".draggable_dinner",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    if ($(".droppable53").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
                    $(".droppabl53 .draggable_dinner").html();
                    var str=$(".droppable53 .draggable_dinner").attr('id');
                    var recurring_org=$(".droppable53 .draggable_dinner").attr('recur');
                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'Th',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                        $(".droppable53 .draggable_dinner").attr("cur_recur","Th");
                        $('#save_now1').click();
                      }
                    });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                   $('.droppable61').droppable({
                  accept: ".draggable_breakfast",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable61").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                      var startdate = $("#start_month").val();
                    $(".droppable61 .draggable_breakfast").html();
                    var str=$(".droppable61 .draggable_breakfast").attr('id');
                    var recurring_org=$(".droppable61 .draggable_breakfast").attr('recur');

                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'F',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                      $(".droppable61 .draggable_breakfast").attr("cur_recur","F");
                        $('#save_now1').click();
                      }
                    });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable62').droppable({
                  accept: ".draggable_lunch",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable62").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
                      $(".droppable62 .draggable_lunch").html();
                      var str=$(".droppable62 .draggable_lunch").attr('id');
                      var recurring_org=$(".droppable62 .draggable_lunch").attr('recur');

                      var mealid=str.substring(6);
                      $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'F',mealid:mealid}, function(result){
                        if(result=="true")
                        {
                            $(".droppable62 .draggable_dinner").attr("cur_recur","F");
                          $('#save_now1').click();
                        }
                      });
                    //draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable63').droppable({
                  accept: ".draggable_dinner",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable63").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
                    $(".droppabl63 .draggable_dinner").html();
                    var str=$(".droppable63 .draggable_dinner").attr('id');
                    var recurring_org=$(".droppable63 .draggable_dinner").attr('recur');
                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'F',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                          $(".droppable63 .draggable_dinner").attr("cur_recur","F");
                        $('#save_now1').click();
                      }
                    });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                   $('.droppable71').droppable({
                  accept: ".draggable_breakfast",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable71").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
                    $(".droppable71 .draggable_breakfast").html();
                    var str=$(".droppable71 .draggable_breakfast").attr('id');
                    var recurring_org=$(".droppable71 .draggable_breakfast").attr('recur');

                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'St',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                           $(".droppable71 .draggable_breakfast").attr("cur_recur","St");
                        $('#save_now1').click();
                      }
                    });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable72').droppable({
                  accept: ".draggable_lunch",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                     if ($(".droppable72").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                    var startdate = $("#start_month").val();
                      $(".droppable72 .draggable_lunch").html();
                      var str=$(".droppable72 .draggable_lunch").attr('id');
                      var recurring_org=$(".droppable72 .draggable_lunch").attr('recur');

                      var mealid=str.substring(6);
                      $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'St',mealid:mealid}, function(result){
                        if(result=="true")
                        {
                           $(".droppable72 .draggable_lunch").attr("cur_recur","St");
                          $('#save_now1').click();
                        }
                      });
                   // draggable.css({backgroundColor: '#abece0'});
                  }
                });
                $('.droppable73').droppable({
                  accept: ".draggable_dinner",
                  drop: function(event, ui) {
                    var droppable = $(this);
                    var draggable = ui.draggable;
                    // Move draggable into droppable
                    if ($(".droppable73").html().length <= 0){ 
                        //alert('yay!! its blank');
                       draggable.clone().appendTo(droppable);
                    }
                     var startdate = $("#start_month").val();
                    $(".droppabl73 .draggable_dinner").html();
                    var str=$(".droppable73 .draggable_dinner").attr('id');
                    var recurring_org=$(".droppable73 .draggable_dinner").attr('recur');
                    var mealid=str.substring(6);
                    $.post("<?php echo site_url('meal/update_meal_glance');?>", {start_date: startdate,recurring:'St',mealid:mealid}, function(result){
                      if(result=="true")
                      {
                        $(".droppable73 .draggable_dinner").attr("cur_recur","St");
                        $('#save_now1').click();
                      }
                    });
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
      $('.start_time').timepicker({ 'step': 15 ,'defaultTime': '00','timeFormat': 'H:i A' });
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
       // console.log('startTime'+startTime);
        var getmin  = startTime[1].split(' ');
        var gettime = startTime[0]+':'+getmin[0];
        var endHours = addMinutes(gettime, '90');
        var endHourssplit = endHours.split(':');
       // console.log(endHours);
      //console.log(endHourssplit+' '+getmin[1]);
       if(startTime[0] == '23' && getmin[1]== 'PM')
        {
           //console.log('if');
           setampm = 'AM';
        } 
        else
        {
          //console.log('else');
          setampm = getmin[1];
        }
        $('.end_time').val(endHours +" "+setampm);
      });

      
     
      $('.end_time').timepicker({ 'step': 15, 'timeFormat': 'H:i A','scrollDefault': 'now'});  
      
      $( ".start_time" ).addClass("form-control");
      $( ".end_time" ).addClass("form-control");

		// add breakfast
		$("#sub_break").click(function() {

		   if(($('#location_id1').val().length>0)&&($('#description1').val().length>0)&&( $('#stime1').val().length>0)&&($('#etime1').val().length>0)&&($('#is_active1').val().length>0))
		      {
              if(parseInt($('#description1').val().length)<=100)
              {
      		         /*if ($('input[name^= recurring]:checked').length <= 0) {
      		              alert("Please provide Recurring day");
      		          }
      		          else
      		          {
      		               //alert('all ok');
      		               $("form[name='form_breakfast']").submit();
      		          } */

                     $("form[name='form_breakfast']").submit();
              }
              else
              {
                 alert("Description Character limit exceeded");
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
		   if(($('#location_id2').val().length>0)&&($('#description2').val().length>0)&&( $('#stime2').val().length>0)&&($('#etime2').val().length>0)&&($('#is_active2').val().length>0))
		        {
              if(parseInt($('#description2').val().length)<=100)
              {
    		         /*if ($('input[name^= recurring]:checked').length <= 0) {
    		              alert("Please provide Recurring day");
    		          }
    		          else
    		          {
    		               //alert('all ok');
    		               $("form[name='form_lunch']").submit();
    		          }*/
                  $("form[name='form_lunch']").submit();
              }
              else
              {
                 alert("Description Character limit exceeded");
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
		   if(($('#location_id3').val().length>0)&&($('#description3').val().length>0)&&( $('#stime3').val().length>0)&&($('#etime3').val().length>0)&&($('#is_active3').val().length>0))
		        {
               if(parseInt($('#description3').val().length)<=100)
              {
    		        /* if ($('input[name^= recurring]:checked').length <= 0) {
    		              alert("Please provide Recurring day");
    		          }
    		          else
    		          {
    		               $("form[name='form_dinner']").submit();
    		          }*/
                   $("form[name='form_dinner']").submit();
              }
              else
              {
                 alert("Description Character limit exceeded");
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
              console.log($('.'+str1).html().length);
                if (parseInt($('.'+str1).html().length)>0) {
                  $('.'+str1).prepend('<i class="fa fa-times-circle" style="z-index: 1000;" aria-hidden="true" onclick="clearit('+str2+');"></i>');
               }
          });
       $("span.ui-droppable").dblclick(function(){
          //alert("The paragraph was double-clicked");
            var str = $(this).attr('class');
              var str1 = str.substr(0,str.indexOf(' '));
              var str2=str1[9]+str1[10];
              if(parseInt($('.droppable'+str2).children().length)>1)
              {
                var totalchild=parseInt($('.droppable'+str2).children().length);
                var target=totalchild-1;
                $('.droppable'+str2+' i:lt('+target+')').remove();
              }
      });

             $("#start_month option[id='0']").attr("selected", "selected").trigger("change");
             $('#description1').keyup(function () {
              var max = 100;
              var len = $(this).val().length;
              if (len == max) {
                $('#charNum1').html('<strong style="color:green">Ok<i class="fa fa-check" aria-hidden="true"></i></strong>');
              } else if(len<max){
                var char = max - len;
                $('#charNum1').text(char + ' characters left');
              }else
              {
                $('#charNum1').html('<strong style="color:crimson">Limit Exceeded!!</strong>');
              }
            });
              $('#description2').keyup(function () {
              var max = 100;
              var len = $(this).val().length;
              if (len == max) {
                $('#charNum2').html('<strong style="color:green">Ok<i class="fa fa-check" aria-hidden="true"></i></strong>');
              } else if(len<max){
                var char = max - len;
                $('#charNum2').text(char + ' characters left');
              }else
              {
                $('#charNum2').html('<strong style="color:crimson">Limit Exceeded!!</strong>');
              }
            });
               $('#description3').keyup(function () {
              var max = 100;
              var len = $(this).val().length;
              if (len == max) {
                $('#charNum3').html('<strong style="color:green">Ok<i class="fa fa-check" aria-hidden="true"></i></strong>');
              } else if(len<max){
                var char = max - len;
                $('#charNum3').text(char + ' characters left');
              }else
              {
                $('#charNum3').html('<strong style="color:crimson">Limit Exceeded!!</strong>');
              }
            });
    });
    function clearit(id)
    {
      
        var str=$('.droppable'+id).children('span').attr('id');
       
        var recurring_org=$('.droppable'+id).children('span').attr('recur');
        var recurring_cur=$('.droppable'+id).children('span').attr('cur_recur');
        var mealid=str.substring(6);
        //console.log('Mealid:'+mealid);
        $.post("<?php echo site_url('meal/delete_meal_from_glance');?>", {recurring_current:recurring_cur, recurring_org:recurring_org,mealid:mealid}, function(result){
            //alert(result);
              if(result=="true")
              {
                 $('.droppable'+id).html('');
                  $('#save_now1').click();
              }
            });
       
    }
    function placetime1()
    {
       // alert('clicked event1');
        $('#stime1').val('07:00 AM');
        $('#etime1').val('08:30 AM');
    }
    function placetime2()
    {
        //alert('clicked event2');
        $('#stime2').val('11:00 AM');
        $('#etime2').val('12:30 PM');
    }
    function placetime3()
    {
        //alert('clicked event3');
        $('#stime3').val('17:00 PM');
        $('#etime3').val('18:30 PM');
    }
</script>
