<?php
$success = $this->session->flashdata('success');
if ($success) {
    ?>	
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
if ($failed) {
    ?>	
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
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Users</h3>
        <div class="box-title pull-right" style="padding-right:10px;"><a href="<?php echo site_url('dashboardcontroller/adduser');?>" class="btn btn-success btn-sm"  ><i class="glyphicon glyphicon-plus"></i> Add New</a></div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table  class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S/L</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach ($viewuserlist as $viewuser) { ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $viewuser->name; ?></td>
                    <td>
                        <?php if($viewuser->role=='admin'){ echo "Finance Head";}else if($viewuser->role=='accounts'){ echo "Project Director";}else{ echo $viewuser->role; }?></td>
                    <td>
                        <?php
                            if ($viewuser->status == "inactive") { ?>
                                <input name="'id" value="<?php echo $viewuser->id; ?>" type="hidden">
                                <a href="<?php echo base_url(); ?>dashboardcontroller/activateuser/<?php echo $viewuser->id; ?>" class="btn btn-success btn-xs btn-flat">
                                    Active
                                </a>
                            <?php
                            } else { ?>
                                <input name="'id"  value="<?php echo $viewuser->id; ?>" type="hidden" >
                                <a href="<?php echo base_url(); ?>dashboardcontroller/inactivateuser/<?php echo $viewuser->id; ?>" class="btn btn-danger btn-xs btn-flat">
                                    Inactive
                                </a>
                            <?php }
                        ?>
                        <a class="btn btn-primary btn-xs btn-flat"  data-toggle="modal" data-target="#changePassword-modal<?php echo $viewuser->id; ?>">
                            Change Password
                        </a>
                        <?php
                            $role = $this->session->userdata("shohozit_role");
                            if($role == "super_admin" || $role == "superadmin"){
                                if($viewuser->role !="superadmin" || $viewuser->role !="super_admin"){  ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--                                    <a href="--><?php //echo base_url(); ?><!--dashboardcontroller/delete_user/--><?php //echo $viewuser->id; ?><!--" class="btn btn-danger btn-xs btn-flat">-->
<!--                                        Delete-->
<!--                                    </a>-->
                                <?php } 
                            }                        
                        ?>
                    </td>
                </tr>
                    <!-- COMPOSE MESSAGE MODAL -->
                <div class="modal fade" id="changePassword-modal<?php echo $viewuser->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><!--<i class="fa fa-envelope-o"></i>--> Change Password</h4>
                            </div>
                            <form action="<?php echo base_url(); ?>dashboardcontroller/changepassword/<?php echo $viewuser->id; ?>" method="post">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Username <sup>*</sup></label>
                                        <input name="name" readonly type="text" class="form-control" placeholder="User Name" value="<?php echo $viewuser->name;?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">New Password</label>
                                        <input name="id" type="hidden" class="form-control" placeholder="" value="<?php echo $viewuser->id; ?>">
                                        <input name="new_password" type="password" class="form-control" placeholder="New Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">New Password Again</label>
                                        <input name="new_password_again" type="password" class="form-control" placeholder="New Password Again">
                                    </div>


                                </div>
                                <div class="modal-footer clearfix">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                                    <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Save</button>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <!-- COMPOSE MESSAGE MODAL -->
                <div class="modal fade" id="changePassword-modal<?php echo $viewuser->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Change Password</h4>
                            </div>
                            <form action="<?php echo base_url(); ?>dashboardcontroller/changepassword/<?php echo $viewuser->id; ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">New Password:</span>
                                            <input name="id" type="hidden" class="form-control" placeholder="" value="<?php echo $viewuser->id; ?>">
                                            <input name="new_password" type="password" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">New Password Again:</span>
                                            <input name="new_password_again" type="password" class="form-control" placeholder="">
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer clearfix">

                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>

                                    <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Save</button>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            <?php } ?>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>
<!-- page script -->