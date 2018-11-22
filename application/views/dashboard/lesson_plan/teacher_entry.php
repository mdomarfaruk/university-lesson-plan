<?php
$user_role = $this->session->userdata('shohozit_role');
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
        </div><!-- /.box-body col-md-offset-2-->
    </div>
    <?php
}
?>
<div class="box ">
    <div class="box-header">
        <h3 class="box-title pull-left"><?php echo ucwords($title_info); ?> </h3>

        <?php   if($user_role == "super_admin" || $user_role == "superadmin"){ ?>
        <h3 class="box-title pull-right" style="padding-right:10px;"><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#setting-modal" onclick="addFloor()"><i class="glyphicon glyphicon-plus"></i> Add New</button></h3>
        <?php } ?>
    </div>


    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SL</th>
                <th>Code</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Status</th>
                <?php

                if($user_role == "super_admin" || $user_role == "superadmin"){ ?>
                    <th></th>
                <?php }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $si = 1;
            if(!empty($viewInfo)){
                foreach ($viewInfo as $row) {
                    ?>
                    <tr>
                        <td><?php echo $si; ?></td>
                        <td><?php echo $row->teacher_code; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->mobile; ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo $row->address; ?></td>
                        <td><?php echo ($row->status==1)?"Active":"Inactive"; ?></td>

                        <?php
                        if ($user_role == "super_admin" || $user_role == "superadmin") {
                            ?>
                            <td>
                                <a class="btn btn-info btn-sm" onclick="updateFloorInfo('<?php echo $row->id ?>');"

                                   data-toggle="modal" data-target="#setting-modal">
                                    <i class="glyphicon glyphicon-pencil"></i> Edit
                                </a>
                            </td>
                            <?php
                        }
                        ?>

                    </tr>
                    <?php
                    $si++;
                }
            }
            ?>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div><!-- /.box-body -->
</div>

<!-- COMPOSE MESSAGE MODAL -->


<script>

    function addFloor(){
        $("#teacher_name").val('');
        $("#teacher_code").val('');
        $("#mobile").val('');
        $("#email").val('');
        $("#address").val('');
        $("#teacher_details").val('');
        $("#status").val(1);
        $("#title_id").val('');

        $("#saveBtn").show();
        $("#updateBtn").hide();
        $("#hideUserInfo").show();
        $("#hideUserInfoAll").show();
        $("#title").html('Add');
    }
    function updateFloorInfo(id){
        $("#saveBtn").hide();
        $("#updateBtn").show();
        $("#title").html('Update');
        $("#hideUserInfo").hide();
        $("#hideUserInfoAll").hide();
        $('#user_name').prop('required',false);
        $('#password').prop('required',false);


        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>LessonplanController/get_teacher_info/",
            data: 'teacher_id=' + id,
            dataType: 'json',
            success: function (data) {
                $("#teacher_name").val(data.name);
                $("#teacher_code").val(data.teacher_code);
                $("#mobile").val(data.mobile);
                $("#email").val(data.email);
                $("#address").val(data.address);
                $("#teacher_details").val(data.details);
                $("#status").val(data.status);
                $("#title_id").val(data.id);
            }
        });






    }
</script>

<div class="modal fade" id="setting-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span id="title"></span> <?php echo ucwords($title_info); ?> Information</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-md-3"> Teacher Name</label>
                        <div class="col-md-9">
                            <input name="teacher_name"  type="text" class="form-control" id="teacher_name" placeholder="Teacher Name" required>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="control-label col-md-3">Teacher Code</label>
                        <div class="col-md-9">
                            <input name="teacher_code"  type="text" class="form-control" id="teacher_code" placeholder="Teacher Code" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Mobile</label>
                        <div class="col-md-9">
                            <input name="mobile"  type="text" class="form-control" id="mobile" placeholder="Mobile" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3"> Email</label>
                        <div class="col-md-9">
                            <input name="email"  type="text" class="form-control" id="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"> Address</label>
                        <div class="col-md-9">
                            <textarea type="text" class="form-control" id="address" name="address" placeholder="Teacher address" required></textarea>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"> Details</label>
                        <div class="col-md-9">
                            <textarea type="text" class="form-control" id="teacher_details" name="teacher_details" placeholder="Teacher Details" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" > Status</label>
                        <div class="col-md-9" >
                            <select  class="form-control" name="status" id="status" >
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="control-label col-md-3" id="hideUserInfo">Login Information</label>

                    </div>
                    <div class="form-group" id="hideUserInfoAll" >
                        <label class="control-label col-md-3" >User Name</label>
                        <div class="col-md-3">
                            <input name="user_name"  type="text" class="form-control" id="user_name" placeholder="User Name" required>
                        </div>
                        <label class="control-label col-md-2" >Password</label>
                        <div class="col-md-4">
                            <input name="password"  type="password" class="form-control" id="password" placeholder="Passowrd" required>
                        </div>
                    </div>



                    <div class="modal-footer clearfix">
                        <button type="submit" id="saveBtn" class="btn btn-primary btn-sm" name="saveBtn" ><i class="fa fa-ok"></i>Save</button>
                        <button type="submit" id="updateBtn"  name="updateBtn" class="btn btn-primary btn-sm"><i class="fa fa-ok"></i>Update</button>
                        <button type="button" class="btn btn-danger btn-sm pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <input type="hidden" name="title_id" id="title_id" >
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">



    function checkadd() {
        var chk = confirm("Are you sure to add this record ?");
        if (chk) {
            return true;
        } else {
            return false;
        }
        ;
    }

    function checkupd() {
        var chk = confirm("Are you sure to update this record ?");
        if (chk) {
            return true;
        } else {
            return false;
        }
        ;
    }

    function checkdel() {
        var chk = confirm("Are you sure to delete this record ?");
        if (chk) {
            return true;
        } else {
            return false;
        }
        ;
    }

</script>