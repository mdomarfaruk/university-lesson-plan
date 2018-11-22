<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>
            <?php 
                if(!empty($title)){ echo $title; }else{ echo "ABC World"; }
            ?>
        </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
        <center>
            <font size="5" color="red">
            <?php 
                if(empty($msg)){
                    echo $title;
                }
            ?>
            <br>
            Contact to Shohozit
        </center>
    
        <?php 
            if(empty($msg)){ ?>
                <div class="form-box" id="login-box">
                    <div style="background-color: #0dbf54;" class="header">
                        <img src="<?php echo base_url(); ?>assets/img/trialExpired.jpg" alt="Extension Key">
                    </div>
                    <form action="<?php echo site_url('trialExpired/trialExpired/updateTrial'); ?>" method="post">
                        <div class="body bg-gray">
                            <?php 
                                $exception = $this->session->flashdata('failed');
                                if (isset($exception)) { ?>
                                    <p style='text-align: center;color: red;padding-top: 10px;font-size: 16px;'>
                                        <?php echo $exception; ?>
                                    </p>
                            <?php }                       
                            ?>

                            <div class="form-group">
                                <font size='3'>Enter Key to continue
                                <input name="code" required="" class="form-control" placeholder="Licence Key"/>
                            </div>

                        </div>

                        <div class="footer">                                                               
                            <button style="background-color: #0dbf54 !important;" type="submit" class="btn bg-olive btn-block">
                                Activate
                            </button>  
                        </div>

                    </form>


                </div>
        <?php }else{
            echo '<br><br><br><br><h1 align="center">'.$msg.'</h1>';
        }
        ?>

        <!-- jQuery 2.0.2 -->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>