<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Lesson Plan Management Login</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico" type="image/x-icon">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div style="background-color: #fff;" class="header"><img src="<?php echo base_url(); ?>assets/img/invoiser-v1.1.png"></div>
            <form action="<?php echo base_url(); ?>authenticationcontroller/checkuser" method="post">
                <div class="body bg-gray">
                    <?php 
                        $exception = $this->session->flashdata('exception');
                        if (isset($exception)) {
                            echo "<p style='text-align: center; color: red; padding-top: 10px; font-size: 16px;'>".$exception."</p>";
                        }

                        $success = $this->session->userdata('session_destroy_message');
                        if (isset($success)) {
                            echo "<p style='text-align: center;color: green;padding-top: 0px;font-size: 16px;'>".$success."</p>";
                            $this->session->unset_userdata('session_destroy_message');
                        }
                    ?>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="User Name"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                </div>
                <div class="footer">                                                               
                    <button style="background-color: #0dbf54 !important;" type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                </div>
            </form>

            
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>        
    </body>
</html>