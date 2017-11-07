
<body style="background:#F7F7F7;">
    
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <?php echo form_open('authorize/admin_login_process','class="form-signin"');?> 
                        <h1>Login Form</h1>

                        <?php
                        echo "<div class='flash error'>";
                        if (isset($error)) {
                            echo $error;
                        }
                        echo validation_errors();
                        echo "</div>";
                        ?>
                        <?php if($this->session->flashdata('flash_message')){
                            echo "<div class='flash success'>".$this->session->flashdata('flash_message')."</div>";
                        } ?>
                        <?php if($this->session->flashdata('flash_error')){
                            echo "<div class='flash error'>".$this->session->flashdata('flash_error')."</div>";
                        } ?>
                        <div class="flash success"><?php echo $message;?></div>
                        <div>
                            <?php echo form_input(array('name'=>'email','type'=>'email','class'=>'form-control','id'=>'email','placeholder'=>'Email'));?>
                        </div>
                        <div>
                            <?php echo form_input(array('name'=>'password','type'=>'password','class'=>'form-control','id'=>'password','placeholder'=>'Password'));?>
                        </div>
                        <div>
                            <?php echo form_submit(array('name' =>'submit','class' =>'btn btn-default submit','value' => 'Log in')); ?>
                            <a class="reset_pass" href="javascript:void(0);">Lost your password?</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                            <!-- <p class="change_link">New to site?
                                <a href="#toregister" class="to_register"> Create Account </a>
                            </p>  -->
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Community Scheduling!</h1>

                                <p>©2015 All Rights Reserved. Community Scheduling! is a Bootstrap 3 template. Privacy and Terms</p>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>