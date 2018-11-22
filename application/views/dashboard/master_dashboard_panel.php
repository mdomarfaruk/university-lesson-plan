<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
    <meta charset="UTF-8">
    <title><?php if(!empty($title)){ echo $title; }else{ echo "Lesson Plan Management"; } ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2/select2.min.css">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <!-- bootstrap 3.0.2 -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- daterange picker -->
    <link href="<?php echo base_url(); ?>assets/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- date picker -->
    <link href="<?php echo base_url(); ?>assets/css/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?php echo base_url(); ?>assets/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- jQuery UI CSS -->
    <link href="<?php echo base_url(); ?>assets/css/jQueryUI/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <!-- jQuery 2.0.2 -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.js"></script>
    <!-- jQuery UI -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.3.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/validation/validation.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            var url = window.location;
            $('ul.sidebar-menu a').filter(function() {
                return this.href == url;
            }).parent().addClass('active');
            $('ul.treeview-menu a').filter(function() {
                return this.href == url;
            }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
            $('ul.treeview-menu a').filter(function() {
                return this.href == url;
            }).closest('ul.treeview-menu a').css({'background-color': '#64B0F2'});
        })
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css" media="print">
    @page
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>
<?php
$role = $this->session->userdata('shohozit_role');
$uname = $this->session->userdata('abhinvoiser_1_1_user_name');
$company_info=$this->db->select("*")->order_by("id","DESC")->limit(1)->get('company');
if($company_info->num_rows()>0){
    $company=$company_info->row();
}
?>
<body class="skin-blue">
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a style="font-size: 19px;background-color: #0dbf54 !important;" href="<?php echo base_url(); ?>" class="logo">
        Lesson Plan Management
    </a>
    <nav style="background-color: transparent;border-bottom: 1px solid #0dbf54 !important;" class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span style="background-color: #0dbf54 !important;" class="icon-bar"></span>
            <span style="background-color: #0dbf54 !important;" class="icon-bar"></span>
            <span style="background-color: #0dbf54 !important;" class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

                <li class="custom_hover dropdown messages-menu">
                    <a style="color: black ;" href="#" class=" dropdown-toggle" data-toggle="dropdown">
                        <p><b></b> <?php  $today=date("d-M-Y"); echo date('l, F jS, Y', strtotime($today)); ?></p>
                    </a>

                </li>
                <!-- Notifications: style can be found in dropdown.less -->

                <!-- Tasks: style can be found in dropdown.less -->

                <!-- User Account: style can be found in dropdown.less -->
                <li class="custom_hover dropdown user user-menu">
                    <a style="color: #0dbf54 ;"  href="#" class=" dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><?php echo ucwords($uname); ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li style="background: none !important;" class="user-header">
                            <img src="<?php echo base_url().$company->company_logo; ?>" class="img-circle" alt="User Image" />
                            <h6 style='font-family: "Kaushan Script",cursive;color: #0dbf54 !important;'><?php echo $company->com_name; ?></h6>
                            <h4 style='font-family: "Kaushan Script",cursive;color: #0dbf54 !important;'> Lesson Plan Management </h4>
                            <p style='font-family: "Kaushan Script",cursive;color:#000;text-shadow:none;color: #0dbf54 !important;'>Version 0.1</p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <a style="background-color: #0dbf54 !important;color: #fff;" href="<?php echo base_url(); ?>authenticationcontroller/userLogout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo base_url().$company->company_logo; ?>" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info" style="">

                    <p style="font-size:18px;padding-top:7px;"> <?php echo $company->com_name; ?></p>

                </div>
            </div>
            <?php
            $invalied_invoice = $this->session->userdata('invalied_invoice');
            if ($invalied_invoice) { ?>
                <div style="padding-left: 15px;color: red;"><?php echo $invalied_invoice; ?></div>
                <?php
                $this->session->unset_userdata('invalied_invoice');
            }
            ?>

            <?php include 'includes/left_menu.php'; ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h3><?php if(!empty($header)){ echo $title; }?></h3>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php echo $dashboardContent; ?>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>

<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- InputMask -->
<script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<!-- InputMask -->
<script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url(); ?>assets/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/js/AdminLTE/app.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/select2/select2.full.min.js"></script>
<script type="text/javascript">
    $(function () {
        //bootstrap WYSIHTML5 - text editor
        $(".textareawysihtml5").wysihtml5();
    });
</script>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        $(".select2").select2();
        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("yyyy/mm/dd", {"placeholder": "yyyy/mm/dd"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("yyyy/mm/dd", {"placeholder": "yyyy/mm/dd"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker({format: 'YYYY/MM/DD'});
        $('.dydaterange').daterangepicker({format: 'YYYY/MM/DD'});

        $(function () {
            $('.dynamic_date input').datepicker({
                format: 'yyyy-mm-dd',
                autoclose:true,
            });

        });
        $(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose:true,
            });

            var date = new Date();
            date.setDate(date.getDate());

            $('.datepicker_after_current_date').datepicker({
                format: 'yyyy-mm-dd',
//                startDate: date,
                changeYear: true,
                changeMonth: true,
                autoclose:true,
            });
        });

        $("#example1").dataTable();
        $('#example5').dataTable();
        $('#example3').dataTable();
        $('#example4').dataTable();
        $('#example5').dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
        $('#example22').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });$('#example222').dataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });

    });


    function elementId(id_arr){
        var id = id_arr.split("_");
        return id[id.length - 1];
    }
</script>
<style>
    td{
        font-size:12px;
    } th{
        font-size:12px;
    }
    .btn a{
        color:white !important;
    }
</style>
</body>
</html>