  
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="page-title">
                <div class="title_left">
                 <?php if ($user_info['user_type'] == "child") {
                               ?>
                                 <h3>Care Management </br>
                                 <small>Detail of care Member - "<?php echo $user_info['first_name'];?>"</small>
                                 </h3>
                                         <?php 
                                } 
                                else { ?>
                    <h3>Resident Management </br><small>Detail of Resident Member - "<?php echo $user_info['first_name'];?>"</small></h3>
                    <?php  } ?>
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
                            <h2>Show Resident</small></h2>
                             <?php 
                          
                            $userId = $user_info['id'];

                            ?>
                            <ul class="nav navbar-right panel_toolbox">
                            <!--@mkcode start-->
                             <?php if ($user_info['user_type']!= "child") { ?>
                             <li><button onClick="window.location='<?php   echo site_url('user/child').'/'.$userId; ?>'" class="btn btn-info btn-xs">Add Care Account</button></li> 
                             <?php } ?>
                             <!--@mkcode end-->
                             <li><button onClick="window.location='<?php echo site_url('user'); ?>/edit/<?php echo $userId; ?>'" class="btn btn-info btn-xs">User Edit</button></li>
                                 <!--@mkcode start-->
                                <?php if ($user_info['user_type'] == "child") { ?>
                                  <li><button onClick="window.location='<?php echo site_url('user'); ?>/child_listing'" class="btn btn-info btn-xs">Care List</button></li>
                                  <?php 
                                  if(isset($only_care_pay)){ 
                                  if($only_care_pay=='disable')
                                  {
                                      if(isset($care_subscription))
                                      { 
                                       if($care_subscription=='unpaid')
                                        {
                                          ?>
                                        <li>
                                           <button id="show_care_subscription_start_form" class="btn btn-primary btn-xs">START SUBSCRIPTION</button>
                                       </li>
                                    <?php
                                        }
                                      } 
                                    }
                                  }

                                } 
                                else 
                                { ?>
                                      
                                   <li><button onClick="window.location='<?php echo site_url('user'); ?>'" class="btn btn-info btn-xs">Resident List</button></li>
                         <?php  } ?>
                                   <!--@mkcode end-->
                                
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                                 
              <!-- user information Start from here -->
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
                                    <?php echo $user_info['first_name']." ".$user_info['last_name']; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Email
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo ($user_info['email']!="")?$user_info['email']:'--'; ?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Gender
                                  </span>
                                </div>
                              <?php 
                              $address = "";
                              $address.=($user_info['property_name']!="") ? $user_info['property_name'] : '';
                              $address.=($user_info['city']!="") ? ", ".$user_info['city'] : '';
                              $address.=($user_info['state']!="") ? ", ".$user_info['state'] : '';
                              $address.=($user_info['pincode']!="") ? " - ".$user_info['pincode'] : '';

                              ?>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo ($user_info['gender']!="")?$user_info['gender']:"--"; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                    <span class="type-info">Address</span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo ($address!="")?$address:"--";; ?>
                                  </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Mobile
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php echo ($user_info['mobile']!="")?$user_info['mobile']:"--"; ?>
                                  </span>
                                </div>
                                <div class="col-m-2 col-sm-2 col-xs-12">
                                  <span class="type-info">
                                    Is Active
                                  </span>
                                </div>
                                <div class="col-m-4 col-sm-4 col-xs-12">
                                  <span class="user-infor">
                                    <?php if($user_info['is_active'] == true) {
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
                                    <?php echo mdate('%d %M %Y %h:%i %A',strtotime($user_info['logtime'])); ?>
                                  </span>
                                </div>
                            </div>

                              </div><!-- /user-info -->
                            </div><!-- basic information close -->

                            <div class="clearfix"></div>
                         </div>
                         <!-- user information close from here -->
                        </div>
                          <?php if ($user_info['user_type'] == "child") { 


                            ?>
                           <div class="row">
                          <div class="col-md-6"> 
                           <div class="x_panel">
                          <div class="x_title">
                          <h2 style="color:black">Subscription Information</h2>
                          <ul class="nav navbar-right panel_toolbox">
                         <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                          </ul>
                          <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                          <table id="datatable" class="table table-striped table-bordered">
                          <thead>
                            <tr style="background: #2a3f54;color:white">
                              <th style="text-align: center"> Subscription id</th>
                              <th style="text-align: center"> Start date</th>
                              <th style="text-align: center"> Amount</th>
                              <th style="text-align: center"> Status</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                           if($care_subscription!='unpaid')
                            {

                            ?>
                          <tr>
                           <td style="text-align: center"><?php echo $care_subscription['subscription_id']; ?> </td>   
                           <td style="text-align: center"><?php echo $care_subscription['start_on']; ?> </td>   
                           <td style="text-align: center"> <i class="fa fa-usd" aria-hidden="true"></i><?php echo $care_subscription['amount']; ?></td> 
                           <td style="text-align: center" ><?php if($care_subscription['status']=='active'){ ?><span class="label label-success"> <?php echo $care_subscription['status']; ?></span><?php }else{ ?><span class="label label-danger"> <?php echo $care_subscription['status']; ?></span><?php } ?></td>    
                          </tr>
                          <?php 
                           }
                           else
                           { 
                          ?>
                          <tr>
                          <td style="text-align: center;color:red" colspan="3">Subscription hasn't started yet.</td>   
                          
                          </tr>
                          <?php } ?>
                          </tbody>
                          </table>
                          </div>
                          </div>
                           
                           </div>
                          <div class="col-md-6">
                          <div class="x_panel">
                          <div class="x_title">
                          <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                        
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                          </ul>
                          <div class="clearfix"></div>
                          </div>
                          <div class="x_content">

                          <table id="datatable" class="table table-striped table-bordered">
                          <thead>
                            <tr style="background: #2a3f54;color:white">
                              <th colspan="2" style="text-align: center"> Resident Care For </th>
                            </tr>
                          </thead>


                          <tbody>
                         
                          <?php
                          if(!empty($care_belongs_to))
                          {
                           
                          ?>
                          <tr>
                          <?php if(count($care_belongs_to)>1)
                          {   
                          ?>            
<td style="text-align: center"><a href="<?php echo site_url('user/show/'.$care_belongs_to[0]['parent1_id']); ?>" class="label label-primary" style='text-align: center'><?php echo strtoupper($care_belongs_to[0]['parent1']);  ?></a></td>
<td style="text-align: center"><a href="<?php echo site_url('user/show/'.$care_belongs_to[1]['parent2_id']); ?>" class="label label-primary" style='text-align: center'><?php echo strtoupper($care_belongs_to[1]['parent2']);  ?></a></td>  
                        <?php }else{ ?>                
                        <td colspan="2" style="text-align: center"><a href="<?php echo site_url('user/show/'.$care_belongs_to[0]['parent1_id']); ?>" class="label label-primary" >
                        <?php echo strtoupper($care_belongs_to[0]['parent1']);  ?></a></td> 
                         
                          <?php } ?>          
                          </tr>
                          <?php } ?>
                          </tbody>
                          </table>
                          </div>
                          </div>
                           </div>
                          </div>
                          <div class="row">
                          <div class="col-md-12">
                          <div class="border_sec2">
                            <!-- CREDIT CARD FORM STARTS HERE -->
                       <form id="payment_form" style="border: 1px solid #ccc;padding: 20px;width: 66%;margin: 15px auto;border-radius: 5px; display: none">

                            <div class="add_sec">
                                <h4>Payment Form</h4>
                                <div class="row">
                                <div class="col-md-12 col-md-12" id="response_msg"></div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">First Name:</label>-->
                                            <input class="form-control" placeholder="First Name" type="text" id="first_name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Last Name:</label>-->
                                            <input class="form-control" placeholder="Last Name" type="text" id="last_name" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Address:</label>-->
                                            <input class="form-control" placeholder="Email-Id" type="text" id="user_email" value="" title="Payment gateway keep this email id for transaction record" >
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 showcancel">
                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Address:</label>-->
                                            <input class="form-control" placeholder="Address" type="text" id="address" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">City:</label>-->
                                            <input class="form-control"  placeholder="City" type="text" id="city" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">State:</label>-->
                                            <input class="form-control" placeholder="state" type="text" id="state" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Post Code:</label>-->
                                            <input class="form-control" placeholder="Post Code" type="text" id="zipcode" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="">Phone no.</label>-->
                                            <input class="form-control" placeholder="Phone no." type="text" id="phone_num" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <!--<label for="sel1">Country:</label>-->
                                            <select class="form-control" id="country">
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Anguilla">Anguilla</option>
                                                    <option value="Antartica">Antarctica</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Bouvet Island">Bouvet Island</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Cape Verde">Cape Verde</option>
                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Christmas Island">Christmas Island</option>
                                                    <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Congo">Congo, the Democratic Republic of the</option>
                                                    <option value="Cook Islands">Cook Islands</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                                                    <option value="Croatia">Croatia (Hrvatska)</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="East Timor">East Timor</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="France Metropolitan">France, Metropolitan</option>
                                                    <option value="French Guiana">French Guiana</option>
                                                    <option value="French Polynesia">French Polynesia</option>
                                                    <option value="French Southern Territories">French Southern Territories</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Gibraltar">Gibraltar</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Greenland">Greenland</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                    <option value="Guam">Guam</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                                                    <option value="Holy See">Holy See (Vatican City State)</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran">Iran (Islamic Republic of)</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
                                                    <option value="Korea">Korea, Republic of</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Lao">Lao People's Democratic Republic</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon" selected>Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macau">Macau</option>
                                                    <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Martinique">Martinique</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mayotte">Mayotte</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Micronesia">Micronesia, Federated States of</option>
                                                    <option value="Moldova">Moldova, Republic of</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montserrat">Montserrat</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                    <option value="New Caledonia">New Caledonia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Niue">Niue</option>
                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Pitcairn">Pitcairn</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Reunion">Reunion</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russia">Russian Federation</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                                                    <option value="Saint LUCIA">Saint LUCIA</option>
                                                    <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia (Slovak Republic)</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
                                                    <option value="Span">Spain</option>
                                                    <option value="SriLanka">Sri Lanka</option>
                                                    <option value="St. Helena">St. Helena</option>
                                                    <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                                                    <option value="Swaziland">Swaziland</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syria">Syrian Arab Republic</option>
                                                    <option value="Taiwan">Taiwan, Province of China</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania">Tanzania, United Republic of</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tokelau">Tokelau</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Turks and Caicos">Turks and Caicos Islands</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Vietnam">Viet Nam</option>
                                                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                                    <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                                                    <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                                                    <option value="Western Sahara">Western Sahara</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Yugoslavia">Yugoslavia</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel_heading">
                                <div class="row display-tr" style="padding: 0px 15px">
                                    <h3 class="panel-title display-td">Payment Details</h3>
                                    <div class="display-td">                            
                                        <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>                    
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control" name="cardNumber" placeholder="Valid Card Number" type="text" id="card_num" value="">
                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                            <div class="row inside_sec">
                                <div class="col-xs-6 col-md-6">
                                    <div class="col-md-5 col-sm-5" style="padding:0px;">
                                        <div class="form-group">
                                            <label for="cardExpiry">EXPIRATION DATE:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6" style="padding: 0 5px 0 0;">
                                                <div class="form-group">
                                                    <select class="form-control" id="exp_month">
                                                       <?php 
                                                        for($l=1;$l<=12;$l++)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $l; ?>"><?php echo $l; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                  
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6" style="padding: 0 0 0 5px;">
                                                <div class="form-group">
                                                    <select class="form-control" id="exp_year">
                                                        <?php 
                                                        for($k=17;$k<31;$k++)
                                                        {
                                                         ?>
                                                         <option value="<?php echo $k; ?>"><?php echo $k; ?></option>
                                                         <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 pull-right">
                                    <div class="form-group">
                                        <!-- <label for="cardCVC">CV CODE:</label> -->
                                        <input class="form-control" name="cardCVC" placeholder="CVC" type="text" id="card_code" value="">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                            <div class="col-xs-12">
                                <ul class="nav nav-pills nav-stacked">
                                <li class="active"><a href="#"><span class="badge pull-right"><span class="glyphicon glyphicon-usd"></span>5</span> Final Payment</a>
                                 </li>
                                </ul>

                            </div>

                            <div class="row">
                            <div class="col-xs-12" style="padding: 5px"><input type="hidden" id="amount" value="">
                            <input type="hidden" id="care_id" value="<?php echo $userId;//echo $this->session->userdata['logged_in']['admin_id'];  ?>">
                            </div>
                            </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="subscribe btn btn-success btn-lg btn-block" type="button" id="paynow">Start Subsciption</button>
                                </div>
                            </div>
                        </form>   
                        </div>
                        </div> 
                      </div>      
                         <!-- CREDIT CARD FORM ENDS HERE -->
                          <?php }else { ?>
                        <!-- start new code-->
                           <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <center><h3 style="color: black"> Events </h3></center>
                            </div>
                            </div>
                          <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-6">
                          <div class="x_panel">
                          <div class="x_title">
                          <h2 style="color:black">History</h2>
                          <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                        
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                          </ul>
                          <div class="clearfix"></div>
                          </div>
                          <div class="x_content">

                          <table id="datatable" class="table table-striped table-bordered">
                          <thead>
                            <tr style="background: #2a3f54;color:white">
                              <th>id</th>
                              <th>Name</th>
                              <th>Log time</th>
                            </tr>
                          </thead>


                          <tbody>
                         
                          <?php
                          if(!empty($old_events))
                          {
                             if(count($old_events)>0)
                             {
                              $j=1;
                              for($i=0;$i<count($old_events);$i++)
                              {
                                //print_r($old_events);
                          ?>
                          <tr>
                          <td><?php echo $j;  ?></td>                  
                          <td><a href="<?php echo site_url('event/show/'.$old_events[$i]['linkid']); ?>"><?php echo $old_events[$i]['name'];  ?></a></td>                  
                          <td><?php echo $old_events[$i]['logtime'];  ?></td>                  
                          </tr>
                          <?php
                                $j++;
                              }
                            }
                            else
                            {
                              ?>
                              <tr>
                              <td colspan="3"><strong>No Past events available</strong></td>
                              </tr>
                              <?php
                            }
                          }else
                          {
                            ?>
                              <tr>
                              <td colspan="3"><strong>No Past events available</strong></td>
                              </tr>
                              <?php
                          }
                          ?>
                          
                          </tbody>
                          </table>
                          </div>
                          </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-6">
                          <div class="x_panel">
                          <div class="x_title">
                          <h2 style="color: black">Upcoming</h2>
                          <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                        
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                          </ul>
                          <div class="clearfix"></div>
                          </div>
                          <div class="x_content">

                          <table id="datatable" class="table table-striped table-bordered">
                          <thead>
                            <tr style="background: #2a3f54;color:white">
                              <th>id</th>
                              <th>Name</th>
                              <th>Log time</th>
                              
                            </tr>
                          </thead>
                          <tbody>
                             <?php
                            print_r($upcoming_events);
                          if(!empty($upcoming_events))
                          {
                             if(count($upcoming_events)>0)
                             {
                              $m=1;
                              for($k=0;$k<count($upcoming_events);$k++)
                              {
                                
                              ?>
                              <tr>
                              <td><?php echo $m;  ?></td>                  
                            <td><a href="<?php echo site_url('event/show/'.$upcoming_events[$i]['linkid']); ?>"><?php echo $upcoming_events[$i]['name'];  ?></a></td>                  
                              <td><?php echo $upcoming_events[$i]['logtime'];  ?></td>                  
                              </tr>
                              <?php
                                $m++;
                              }

                            }
                            else
                            {
                              ?>
                              <tr>
                              <td colspan="3"><strong>No Upcoming events available</strong></td>
                              </tr>
                              <?php
                            }
                          }else
                          {
                            ?>
                              <tr>
                              <td colspan="3"><strong>No Upcoming events available</strong></td>
                              </tr>
                              <?php
                          }
                          ?>
                          </tbody>
                          </table>
                          </div>
                          </div>
                          </div>
                       </div>
                         <!--  end new code-->
                         <!-- meal code -->
                          <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                          <center><h3 style="color: black"> Meals</h3></center>
                          </div>
                          </div>
                         <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-6">
                          <div class="x_panel">
                          <div class="x_title">
                          <h2 style="color:black">History</h2>
                          <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                        
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                          </ul>
                          <div class="clearfix"></div>
                          </div>
                          <div class="x_content">

                          <table id="datatable" class="table table-striped table-bordered">
                          <thead>
                            <tr style="background: #2a3f54;color:white">
                              <th>id</th>
                              <th>Name</th>
                              <th>Log time</th>
                              
                            </tr>
                          </thead>


                          <tbody>
                         
                          <?php
                          if(!empty($old_planmeals))
                          {
                             if(count($old_planmeals)>0)
                             {
                              $j=1;
                              for($i=0;$i<count($old_planmeals);$i++)
                              {
                                //print_r($old_planmeals);
                          ?>
                          <tr>
                          <td><?php echo $j;  ?></td>                  
                          <td><a href="<?php echo site_url('meal/show/'.$old_planmeals[$i]['id']); ?>"><?php echo $old_planmeals[$i]['name'];  ?></a></td>                  
                          <td><?php echo $old_planmeals[$i]['logtime'];  ?></td>                  
                          </tr>
                          <?php
                                $j++;
                              }
                            }
                            else
                            {
                              ?>
                              <tr>
                              <td colspan="3"><strong>No Past Meals Plan available</strong></td>
                              </tr>
                              <?php
                            }
                          }else
                          {
                            ?>
                              <tr>
                              <td colspan="3"><strong>No Past Meals plan available</strong></td>
                              </tr>
                              <?php
                          }
                          ?>
                          
                          </tbody>
                          </table>
                          </div>
                          </div>
                          </div>
                           <div class="col-md-6 col-sm-6 col-xs-6">
                          <div class="x_panel">
                          <div class="x_title">
                          <h2 style="color: black">Upcoming</h2>
                          <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                        
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                          </ul>
                          <div class="clearfix"></div>
                          </div>
                          <div class="x_content">

                          <table id="datatable" class="table table-striped table-bordered">
                          <thead>
                            <tr style="background: #2a3f54;color:white">
                              <th>id</th>
                              <th>Name</th>
                              <th>Log time</th>
                            </tr>
                          </thead>
                          <tbody>
                             <?php
                            //print_r($up_planmeals);
                          if(!empty($up_planmeals))
                          {
                             if(count($up_planmeals)>0)
                             {
                              $m=1;
                              for($k=0;$k<count($up_planmeals);$k++)
                              {
                                
                              ?>
                              <tr>
                              <td><?php echo $m;  ?></td>                  
                            <td><a href="<?php echo site_url('meal/show/'.$up_planmeals[$i]['id']); ?>"><?php echo $up_planmeals[$i]['name'];  ?></a></td>                  
                              <td><?php echo $up_planmeals[$i]['logtime'];  ?></td>                  
                              </tr>
                              <?php
                                $m++;
                              }

                            }
                            else
                            {
                              ?>
                              <tr>
                              <td colspan="3"><strong>No Upcoming Meals plan available</strong></td>
                              </tr>
                              <?php
                            }
                          }else
                          {
                            ?>
                              <tr>
                              <td colspan="3"><strong>No Upcoming Meals plan available</strong></td>
                              </tr>
                              <?php
                          }
                          ?>
                          </tbody>
                          </table>
                          </div>
                          </div>
                          </div>
                          </div>
                         <!-- end meal code -->
                         <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                        <div class="x_title">
                          
                         <button type="button" id="msgsend" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Send Message </button>

                           <!-- <ul class="nav navbar-right panel_toolbox">
                                <li class="create_csv"><button onClick="window.open('<?php //echo site_url().'/Generate/create_csv'; ?>');" class="btn btn-info btn-xs">User Csv</button></li>
                               
                            </ul>-->
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                        <div class="form-group">
                        <p id="success_msg_send"> </p>
                        <?php if($this->session->flashdata('flash_message')){
                            echo "<div class='flash success'>".$this->session->flashdata('flash_message')."</div>";
                        } ?>
                        <?php if($this->session->flashdata('flash_error')){
                            echo "<div class='flash error'>".$this->session->flashdata('flash_error')."</div>";
                        } ?>
                        </div>
                 
                         <h3><center> Resident - <?php  echo $arrUserP[0]['first_name']; ?></center></h3>
                        
                        <?php
                        if (!empty($arrUser))
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
                                    <th>Mobile </th>
                                    <th>Email </th>
                                    <th>Property Name </th>
                            <!--         <th>State </th>
                                    <th>Pincode </th> -->
                                    <th>Status </th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($arrUser))
                                {
                                  foreach ($arrUser as $key=>$row)
                                  { ?>
                                    <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" value="<?php echo $row['id'];?>" class="tableflat">
                                    </td>
                                    <td class=" "><a href="<?php echo site_url('user/show/'.$row['id']); ?>"><?php echo $row['first_name'];?></a></td>
                                    <td class="phone_no<?php echo $row['id']; ?>">
                                    <?php 
                                    $result = "";
                                     $mobile_num = $row['mobile'];
                                     if(  preg_match( '/(\d{3})(\d{3})(\d{4})$/', $mobile_num,  $matches ) )
                                        {
                                           $result = '('.$matches[1] . ') ' .$matches[2] . '-' . $matches[3];
                                          
                                        }
                                    //$row['mobile']= $result;
                                    echo $result; ?></td>
                                    <td class=" "><?php echo $row['email'];?></td>
                                    <td class=" "><?php echo $row['property_name'];?></td>
                        
                               <!--      <td class=" "><?php //echo $row['state'];?></td>
                                    <td class=" "><?php //echo $row['pincode'];?></td> -->

                                    <?php if($row['is_active']==1) { ?>
                                        <td class="is_active_field boolean_type" title="Active"><span class="label label-success">✓</span></td>
                                    <?php } else { ?>
                                        <td class="is_active_field boolean_type" title="InActive"><span class="label label-danger">✘</span></td>
                                    <?php } ?>

                                     <td class=" last">
                                     <?php if ($row['appactive'] == 0)
                                     {
                                    
                                     ?>
        <a href="<?php echo site_url('Plivo_test/resend_sms/'.$row['id']); ?>" class="btn btn-primary btn-xs" title="Resend Message"><i class="fa fa-envelope"></i></a>
                                    <?php } ?>
     
        <!--<a href="<?php //echo site_url('user/show/'.$row['id']); ?>" class="btn btn-primary btn-xs" title="Show"><i class="fa fa-info-circle"></i></a>-->
        <a href="<?php echo site_url('user/edit/'.$row['id']); ?>" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
        <a href="<?php echo site_url('user/delete/'.$row['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Do you want to permanent delete this user member?')"><i class="fa fa-trash"></i></a>
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
                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Send Message</h4>
                      </div>
                      <div class="modal-body">
                        <textarea id="message-text" rows="4" cols="50" placeholder="Type Message" > </textarea>
                      </div>
                      <div class="modal-footer">

                        <button type="button" id="send-message" class="btn btn-default">Send</button>
                      </div>
                    </div>

                  </div>
                </div>
                          </div>
                         <?php } ?>
                    </div>
                </div>
            </div>

        </div>
        <script type="text/javascript">
          $("document").ready(function(){
              //@mkcode
               //$('#payment_form').hide();

                $("#show_care_subscription_start_form").click(function(){
                 // $("#payment_form").css("display","block");
                  $("#payment_form").fadeToggle();
                });

                $(document).on("click","#paynow",function(evented) {
                    $("#response_msg").html("");
                    var f_name=$("#first_name").val();
                    var l_name= $("#last_name").val();
                    var address=$("#address").val();
                    var country= $("#country").val();
                    var state=$("#state").val();
                    var city=$("#city").val();
                    var zipcode=$("#zipcode").val();
                    var phone_num=$("#phone_num").val();
                    var email=$("#user_email").val();
                    var amount=$("#amount").val();
                  
                    var care_id=$("#care_id").val();
                    //--------------------------------
                    var card_num=$("#card_num").val();
                    var exp_month=$("#exp_month").val();
                    var exp_year=$("#exp_year").val();
                    var card_code=$("#card_code").val();

                    if((f_name.length>0)&&(l_name.length>0)&&(address.length>0)&&(country.length>0)&&(state.length>0)&&(city.length>0)&&(zipcode.length>0)&&(phone_num.length>0)&&(card_num.length>0)&&(card_code.length>0)&&(exp_month.length>0)&&(exp_year.length>0)&&(email.length>0)&&(care_id.length>0))
                    {
                            var exp_date=exp_month+'/'+exp_year;

                            $.post("<?php echo site_url().'/Paynow/create_subscription'; ?>", 
                                { firstname: f_name,lastname:l_name,address:address,country:country,state:state,city:city,zipcode:zipcode,cardnum:card_num,exp_date:exp_date,care_id:care_id },
                                 function(result){
                                     var obj=JSON.parse(result);
                                    $("#response_msg").html("<center>"+obj.text+"</center>");
                                        //alert(result);
                                      var delay=3000;//3 seconds
                                        setTimeout(function(){ 
                                        window.open("<?php echo site_url('user/show/')+$care_id;?>","_self");
                                        },delay); 
                                });
                    }
                    else
                    {
                        $("#response_msg").html("<p style='color:crimson'> Please provide all information Properly.</p>");
                    }
            });

                 $(document).on("click","#send-message",function() {
                        var selected = new Array();
                            var msg = $('#message-text').val();
                             $('.checkSingle').each( function(){
                                
                           if( $(this).is(":checked")){
                                selected.push($(this).val());
                                }
                             });
                             
                            var post_data = { 
                                'users'  :  selected,
                                'msg' : msg
                              };
                    if(selected !=''){ 
                        if(msg.trim().length >0) {         
                                $.ajax({ 
                                url: "<?php echo site_url('plivo_test/send_sms'); ?>",
                                    
                                    type: "POST",
                                    data: post_data,
                                    dataType: "json",      
                                    success: function(response) //we're calling the response json array 'cities'
                                    {
                                     console.log(response);
                              
                                    },
                                    error: function(response)
                                    {
                                    }
                    
                            });
                        }else{
                          // $('#myModal').modal('hide');
                           alert("Please enter the message.");
                        }    
                    }else{
                        $('#myModal').modal('hide');
                        alert("Please select the User atleast one user.");
                    }
                        console.log(selected);
                         $('#myModal').modal('hide');
                  });
                
        });

        </script>