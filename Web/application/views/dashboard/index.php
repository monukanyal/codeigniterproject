<?php 
        $colorcode=$this->common_model->createColorCode();
        $send_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
        $get_planned_activity=$this->dashboard_model->get_planned_activity($send_data);
        $graph6_count = 0;
        $graph6_count = 0;
        if(!empty($get_planned_activity))
        {
            foreach ($get_planned_activity as $key_count => $value_count)
                $graph6_count += $value_count['sum_rec'];    
        }
?>
                      <!--  @mkcode 10 may-->
                      <style type="text/css">
                        table{
                            width: 600px;
                            margin-bottom: 0 auto;
                        }
                            table, th, td {
                            border: 1px solid #93A2B2;
                            border-collapse: collapse;
                        }
                        th, td {
                            padding: 5px;
                            color: #93A2B2;
                            padding: 10px 20px;
                            font-family: 'arial';
                        }
                        table tr td span{
                            color: #4695c6;
                        }

                        </style>
                       <a data-toggle="modal" data-target="#myModal_pay1" id="trig_bill_form1"></a>
                       <a data-toggle="modal" data-target="#Modal_pay2" id="trig_bill_form2"></a>
                           <div id="myModal_pay1" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                              <div class="modal-dialog sm">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-body">
                                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                                   <table>
                                    <?php if(isset($bill_pay_data['complete_bill_info'])){
                                        $cb=$bill_pay_data['complete_bill_info'];
                                        $cb_arr=explode(",",$cb);
                                       // print_r($cb_arr);
                                     ?>
                                        <table class="table"> 
                                        <tr style="background-color: #1A82C3;">
                                            <th colspan="2" style="color: #fff;  border-right: none; font-family: 'arial'; font-size: 20px; ">Billing Information</th>
                                        </tr>
                                        <tr>
                                        <td style="width: 430px">Facility Fee :</td>
                                        <td><?php echo  '$'.$cb_arr[0]; ?></td>
                                        </tr>
                                        <tr>
                                        <td>Resident Fee : <span>[<?php echo  '$'.$cb_arr[1]; ?>]</span> x Number of Resident:<span>[<?php echo  $cb_arr[2]; ?>]</span> </td>
                                        <td><?php echo '$'.$cb_arr[1]*$cb_arr[2]; ?></td>
                                        </tr>
                                        <tr>
                                        <td>Care Account Fee :<span>[<?php echo  '$'.$cb_arr[3]; ?>]</span> x Number of Care a/c :<span>[<?php echo  $cb_arr[4]; ?>]</span></td>
                                        <td><?php echo '$'.$cb_arr[3]*$cb_arr[4]; ?></td>
                                        </tr>
                                        <tr>
                                        <td> Message Fee:<span>[<?php echo  '$'.$cb_arr[5]; ?>]</span> x Number of Message : <span>[<?php echo  '$'.$cb_arr[6]; ?>]</span></td>
                                        <td><?php echo '$'.$cb_arr[5]*$cb_arr[6]; ?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>

                                        </table>

                                      <button type="button" id="proceed_to_pay_btn" class="btn btn-success">Next</button>
                                 </div>
                                </div>

                              </div>
                            </div> 

                        <div id="Modal_pay2" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-md" > 
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <center><h4 class="modal-title" style="color:black">More Infomation</h4></center>
                            </div>
                            <div class="modal-body">
                                <!-- CREDIT CARD FORM STARTS HERE -->
                            <form id="payment_form">
                            <div class="add_sec">
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
                                <li class="active"><a href="#"><span class="badge pull-right"><span class="glyphicon glyphicon-usd"></span><?php 
                                if(isset($bill_pay_data['total_charge'])){ echo $bill_pay_data['total_charge']; } ?></span> Final Payment</a>
                                 </li>
                                </ul>

                            </div>

                            <div class="row">
                            <div class="col-xs-12" style="padding: 5px"><input type="hidden" id="amount" value="<?php if(isset($bill_pay_data['total_charge'])){ echo $bill_pay_data['total_charge']; } ?>">
                            <input type="hidden" id="bill_id" value="<?php if(isset($bill_pay_data['id'])){ echo $bill_pay_data['id']; } ?>">
                            <input type="hidden" id="admin_id" value="<?php echo $this->session->userdata['logged_in']['admin_id'];?>">
                            </div>
                            </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="subscribe btn btn-success btn-lg btn-block" type="button" id="paynow">Pay Now</button>
                                </div>
                            </div>
                        </form>          
                         <!-- CREDIT CARD FORM ENDS HERE -->
                            
                            </div> 
                            
                            </div>
                            </div>
                        </div>
                    <!--end form @mkcode 10may-->
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
                         <!-- 28 march line graph-->
                     <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Activity Popularity, Last 
                                <select id="range" onchange="getdata_activity(this.value)">
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
                                days
                                </h2>
                                
                                
                                <!--<ul class="nav navbar-right panel_toolbox pull-left">
                                <li>
                                <span class="glyphicon glyphicon-arrow-up"></span> Y-Number of attendies
                                &nbsp;
                                <span class="glyphicon glyphicon-arrow-right"></span> X-Date of activity
                                </li>
                                 
                                </ul>-->
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">

                                 <div id="graph_bar_group1" style="width:100%; height:280px; "></div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Most Popular Times, Last
                                <select id="range2" onchange="getdata_time(this.value)">
                                <?php if($range2==7){?>
                                 <option value="7">7</option>
                                  <option value="14">14</option>
                                   <option value="30">30</option>
                                 <?php }else if($range2==14){?>
                                <option value="14">14</option>
                                 <option value="30">30</option>
                                  <option value="7">7</option>
                                <?php }else{ ?>
                                <option value="30">30</option>
                                 <option value="14">14</option>
                                  <option value="7">7</option>
                                <?php } ?>
                                </select>
                                days
                                </h2>
                                <!--<ul class="nav navbar-right panel_toolbox pull-left">
                                <li>
                                <span class="glyphicon glyphicon-arrow-up"></span> Y-Average of attendies in a time slot
                                &nbsp;
                                <span class="glyphicon glyphicon-arrow-right"></span> X-Time Slot
                                </li>
                                  
                                </ul>-->
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">

                                 <div id="timeslot_bar_graph" style="width:100%; height:280px;"></div>
                              </div>
                            </div>
                          </div>

                          </div>
                    <!--  end -->
                    <div class="row">

                        <!-- bar chart -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                          
                                    <h2>Total activities per last 7 days</h2><br>
                                    <!--<ul class="nav navbar-right panel_toolbox pull-left">
                                          <li>
                                          <span class="glyphicon glyphicon-arrow-up"></span> Y-number of activities in a day
                                          &nbsp;
                                          <span class="glyphicon glyphicon-arrow-right"></span> X-date
                                          </li>
                                    </ul>-->
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
                                     <h2> Busy timeslots last 
                                        <select id="range3" onchange="getbusy_time(this.value)">
                                        <?php if($range3==7){?>
                                         <option value="7">7</option>
                                          <option value="14">14</option>
                                           <option value="30">30</option>
                                         <?php }else if($range3==14){?>
                                        <option value="14">14</option>
                                         <option value="30">30</option>
                                          <option value="7">7</option>
                                        <?php }else{ ?>
                                        <option value="30">30</option>
                                         <option value="14">14</option>
                                          <option value="7">7</option>
                                        <?php } ?>
                                        </select>
                                        days
                                        </h2>
                                    <!--<ul class="nav navbar-right panel_toolbox pull-left">
                                          <li>
                                          <span class="glyphicon glyphicon-arrow-up"></span> Y-Average of attendies in a time slot
                                          &nbsp;
                                          <span class="glyphicon glyphicon-arrow-right"></span> X-time
                                          </li>
                                        
                                    </ul>-->
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="busy_bar_graph" style="width:100%; height:280px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /bar charts -->
                        
                        <!-- bar chart -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>10 Most Active Residents</h2>
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
                                    <h2>10 Least Active Residents </small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="" style="width:100%; height:280px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /bar charts -->

                        <!-- pie chart -->
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Activity <small> Total Planned Activity for Today</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content2">
                                    <div id="today_pie_activity" style="width:100%; height:300px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /pie chart -->
                           <!-- pie chart -->
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="x_panel">
                                <div class="x_title">
                                   <h2>Activity <small> Total Planned Activity last 7 day</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content2">
                                    <div id="day_pie_activity" style="width:100%; height:300px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /pie chart -->

                        <!-- pie chart -->
                        <div class="col-md-4 col-sm-4 col-xs-4">
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
    function getdata_activity(value)
    {
        //alert(value);
        window.location.href = "<?php echo site_url() ; ?>/Dashboard/index?range="+value;     
    }
    function getdata_time(value)
    {
       //alert(value);
        window.location.href = "<?php echo site_url() ; ?>/Dashboard/index?range2="+value;     
    }
    function getbusy_time(value)
    {
      //alert(value);
      window.location.href = "<?php echo site_url() ; ?>/Dashboard/index?range3="+value;     
    }
$(function () {

    $("#proceed_to_pay_btn").click(function(){
        $('#trig_bill_form2').click();
    });
    $(".close").click(function(){
        //window.location.href = "<?php echo site_url('/authorize/logout');?>";
    });
//---28 march Bar graph graph@mk
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
            var bill_id=$("#bill_id").val();
            var admin_id=$("#admin_id").val();
            //--------------------------------
            var card_num=$("#card_num").val();
            var exp_month=$("#exp_month").val();
            var exp_year=$("#exp_year").val();
            var card_code=$("#card_code").val();

            if((f_name.length>0)&&(l_name.length>0)&&(address.length>0)&&(country.length>0)&&(state.length>0)&&(city.length>0)&&(zipcode.length>0)&&(phone_num.length>0)&&(card_num.length>0)&&(card_code.length>0)&&(exp_month.length>0)&&(exp_year.length>0)&&(email.length>0)&&(bill_id.length>0))
            {
                    var exp_date=exp_month+'/'+exp_year;

                    $.post("<?php echo site_url().'/Paynow/pay_monthly_bill'; ?>", 
                        { x_first_name: f_name,x_last_name:l_name,x_address:address,x_country:country,x_state:state,x_city:city,x_zip:zipcode,x_phone:phone_num,x_email:email,x_card_num:card_num,x_card_code:card_code,x_exp_date:exp_date,amount:amount,bill_id:bill_id,admin_id:admin_id },
                         function(result){
                            $("#response_msg").html("<center>"+result+"</center>");
                                //alert(result);
                              var delay=3000;//3 seconds
                                setTimeout(function(){ 
                                window.open("<?php echo site_url('dashboard');?>","_self");
                                },delay); 
                        });
            }
            else
            {
                $("#response_msg").html("<p style='color:crimson'> Please provide all information Properly.</p>");
            }
    });

<?php
if(!empty($bill_pay_data))
{
?>
 $('#trig_bill_form1').click();
<?php
}
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
  element: 'graph_bar_group1',
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
   resize:true,
    gridTextColor:"#000000",
  labels: []
});

<?php
}
if(!empty($timeslot_avg))
{
  $bar_data='';
   foreach($timeslot_avg as $key =>$x_value) 
      {
       
       //-----------time ----------------
          $d=$key;
          $n=explode("-",$d);
          $x1=$n[0];
          $x2=$n[1];
         $t1 = strtotime($x1);
         $new1=date('H:i', $t1);
         $t2 = strtotime($x2);
         $new2=date('H:i', $t2);
        $newkey=$new1.'-'.$new2;
      //-----------------------------------
      $response[]="{ y: '$newkey',a: $x_value,c:'average attendies-$x_value' }";
     $bar_data=implode(", ",$response);
    $complete_data="[ $bar_data ]"; 
   } 
?>
Morris.Bar({
  element: 'timeslot_bar_graph',
  xLabelMargin:8,
  data: <?php echo $complete_data; ?>,
   hidehover:false,
    hoverCallback: function(index, options, content) 
    {
       return(options.data[index].c);
    },
  xkey: 'y',
  ykeys: ['a'],
  axes:true,
  grid:true,
   gridTextColor:"#000000",
   resize:true,
  labels: ['Time-slot','Average attendies']
});


<?php
}
if(!empty($busytime_avg))
{
  foreach($busytime_avg as $key =>$x_value) 
      {
       
       //-----------time ----------------
          $d=$key;
         $t = strtotime($d);
         $newkey=date('h:i A', $t);
      //-----------------------------------
      $newres[]="{ y: '$newkey',a: $x_value,c:'average attendies-$x_value' }";
     $busy_bar_data=implode(", ",$newres);
    $complete_data="[ $busy_bar_data ]"; 
   } 
?>
Morris.Bar({
  element: 'busy_bar_graph',
  xLabelMargin:8,
  data: <?php echo $complete_data; ?>,
   hidehover:false,
    hoverCallback: function(index, options, content) 
    {
       return(options.data[index].c);
    },
  xkey: 'y',
  ykeys: ['a'],
   resize:true,
   barColors: ['#3498DB'],
    gridTextColor:"#000000",
  labels: []
});

<?php

 }
  $send_data['admin_id'] = $this->session->userdata['logged_in']['admin_id'];
  $get_activities=$this->dashboard_model->get_activities($send_data);
      
    $i=0;
    if(isset($get_activities) && !empty($get_activities))
    {
        foreach($get_activities as $kys=>$row)
        {
            $meetup_date = mdate('%d %M',strtotime($row['meetup_date']));
            // $meetup_date = $row['meetup_date'];
            $sum_rec = $row['sum_rec'];

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
        gridTextColor:"#000000",
        hideHover: 'auto'
    });
<?php
    }
// $get_attendactivities=$this->dashboard_model->get_attendActivities($send_data);   
 
//     $i=0;
//     if(isset($get_attendactivities) && !empty($get_attendactivities))
//     {
//         foreach($get_attendactivities as $kys=>$row)
//         {
//             $meetup_date = mdate('%d %M',strtotime($row['meetup_date']));
//             // $meetup_date = $row['meetup_date'];
//             $sum_rec = $row['sum_rec'];

//             $graph_bar_group_res[]="{ date: '$meetup_date',Total: $sum_rec}";
            
//             $i++;
//             $comb_graph_bar_group=implode(", ",$graph_bar_group_res);
//         }
//         $comb_graph_bar_groupdata="[ $comb_graph_bar_group ]"; 
    
?>
    // Morris.Bar({
    //     element: 'graph_bar_group',
    //     data: <?php //echo isset($comb_graph_bar_groupdata)?$comb_graph_bar_groupdata:'';?>,
    //     xkey: 'date',
    //     ykeys: ['Total'],
    //     labels: ['Total'],
    //     barRatio: 0.4,
    //     lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
    //     xLabelAngle: 35,
    //      gridTextColor:"#000000",
    //     hideHover: 'auto'
    // });
<?php
    //}
$get_most_active=$this->dashboard_model->get_most_active($send_data);

    $i=0;
    if(isset($get_most_active) && !empty($get_most_active))
    {
        foreach($get_most_active as $kys=>$row)
        {
            $user_name = $row['user_name'];
            // $meetup_date = $row['meetup_date'];
            $sum_rec = $row['sum_rec'];

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
         gridTextColor:"#000000",
        hideHover: 'auto'
    });
<?php
    }

$get_least_active=$this->dashboard_model->get_least_active($send_data);

    $i=0;
    if(isset($get_least_active) && !empty($get_least_active))
    {
        foreach($get_least_active as $kys=>$row)
        {
            $user_name = $row['user_name'];
            $sum_rec = $row['sum_rec'];

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
         gridTextColor:"#000000",
        hideHover: 'auto'
    });
<?php
    }
    $get_least_residents=$this->dashboard_model->get_least_residents($send_data); 
    $color=$colorcode;
    
    $i=0;
    if(isset($get_least_residents) && !empty($get_least_residents))
    {
        foreach($get_least_residents as $kys=>$row)
        {
            $user_name = $row['user_name'];
            $sum_rec = $row['sum_rec'];

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
    $get_planned_activity=$this->dashboard_model->get_planned_activity($send_data);
    $piearray=array();
    $piecolor=array();
    $color2=$colorcode;
    
    $i=0;
    if(isset($get_planned_activity) && !empty($get_planned_activity))
    {
        foreach($get_planned_activity as $kys=>$row)
        {
            $event_name = $row['name'];
            $sum_rec = $row['sum_rec'];

            $piearray[]="{ label: '$event_name',value: $sum_rec}";
            $piecolor[]="'$color2[$i]'";
            
            $i++;
            $piearrayregion2=implode(", ",$piearray);
            $piecolorregion2=implode(", ",$piecolor);
        }
        $piearradata2="[ $piearrayregion2 ]"; 
        $piearracolor2="[ $piecolorregion2 ]";
    
?>
    Morris.Donut({
        element: 'pie_activity',
        data: <?php echo isset($piearradata2)?$piearradata2:'';?>,
        colors: <?php echo isset($piearracolor2)?$piearracolor2:'';?>
    });
<?php 
} 
$get_dayplanned_activity=$this->dashboard_model->get_dayplanned_activity($send_data,7);
$piearray2=array();
$piecolor2=array();
if(isset($get_dayplanned_activity) && !empty($get_dayplanned_activity))
{
    $color2=$colorcode;
    
    $i=0;
        foreach($get_dayplanned_activity as $kys=>$row)
        {
            $event_name = $row['name'];
            $sum_rec = $row['sum_rec'];

            $piearray2[]="{ label: '$event_name',value: $sum_rec}";
            $piecolor2[]="'$color2[$i]'";
            
            $i++;
            $piearrayregion=implode(", ",$piearray2);
            $piecolorregion=implode(", ",$piecolor2);
        }
        $mydata="[ $piearrayregion ]"; 
        $mycolor="[ $piecolorregion ]";
?>
Morris.Donut({
        element: 'day_pie_activity',
        data: <?php echo isset($mydata)?$mydata:'';?>,
        colors: <?php echo isset($mycolor)?$mycolor:'';?>
    });
<?php 

}

$planned_data=$this->dashboard_model->todayplanned_activity($send_data);
$piearray3=array();
$piecolor3=array();
if(isset($planned_data) && !empty($planned_data))
{
  $color2=$colorcode;
    
    $i=0;
  foreach($planned_data as $key=>$rows)
        {
            $event_name = $rows['name'];
            $sum_rec = $rows['sum_rec'];

            $piearray3[]="{ label: '$event_name',value: $sum_rec}";
            $piecolor3[]="'$color2[$i]'";
            
            $i++;
            $data_arr=implode(", ",$piearray3);
            $color_arr=implode(", ",$piecolor3);
        }
        $piedata="[ $data_arr ]"; 
        $piecolor="[ $color_arr ]";
?>
Morris.Donut({
        element: 'today_pie_activity',
        data: <?php echo isset($piedata)?$piedata:'';?>,
        colors: <?php echo isset($piecolor)?$piecolor:'';?>
    });

<?php 

}

?>

});
</script>