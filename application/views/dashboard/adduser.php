<?php 
$success = $this->session->flashdata('success');
if($success){?> 

    <div class="box box-info">
        <div class="box-body">
            <div class="callout callout-info">
                <?php 
                    echo $success;
                ?>
            </div>
        </div><!-- /.box-body -->
    </div>

<?php

}

$failed = $this->session->flashdata('failed');
if($failed){?>

    <div class="box box-info">
        <div class="box-body">
            <div class="callout callout-warning">
                <?php 
                    echo $failed;
                ?>
            </div>
        </div><!-- /.box-body -->
    </div>
 
<?php

}
?>

    <!-- general form elements -->
    <div class="box box-default">
        <div class="box-header">
            <h3 class="box-title">Add User</h3>
            <div class="box-title pull-right" style="padding-right:10px;"><a href="<?php echo site_url('dashboardcontroller/viewuserlist');?>" class="btn btn-success btn-sm"  ><i class="glyphicon glyphicon-backward"></i> User List </a></div>
        </div><!-- /.box-header -->
        <!-- form start -->
        <div class="col-sm-6">
        <form action="<?php echo base_url();?>dashboardcontroller/insertuser" method="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputPassword1">Username <sup>*</sup></label>
                    <input name="name" type="" class="form-control" id="" placeholder="User Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password <sup>*</sup></label>
                    <input name="password" type="password" class="form-control" id="" placeholder="Password">
                </div>
                <div class="form-group">
                    <label>Satus <sup>*</sup></label>
                    <select name="status" class="form-control">
                        <option value="">--- Select Status ---</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Role <sup>*</sup></label>
                    <select name="role" class="form-control">
                        <option value="">--- Select Role ---</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="admin">Finance Head</option>
                        <option value="accounts">Project director</option>
<!--                        <option value="bill_collector">Bill Collector</option>-->
<!--                        <option value="salesman">Salesman</option>-->
                    </select>
                </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" onclick="return checkadd();">Submit</button>
            </div>
        </form>
        </div>
        <div class="clearfix"></div>
<script type="text/javascript">
    function checkadd(){
        var chk = confirm("Are you sure to add this record ?");
        if (chk) {
            return true;
        } else{
            return false;
        };
    }
</script>