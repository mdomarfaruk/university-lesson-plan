<?php
$success = $this->session->flashdata('success');
$user_role = $this->session->userdata('shohozit_role');
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
        <h3 class="box-title pull-left"><?php echo ucwords($title_info); ?> Setup</h3>
        <?php
        if($user_role == "super_admin" || $user_role == "superadmin"){ ?>
            <h3 class="box-title pull-right" style="padding-right:10px;"><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#setting-modal" onclick="addFloor()"><i class="glyphicon glyphicon-plus"></i> Add New</button></h3>
        <?php }
        ?>
    </div>


    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SL</th>
<!--                <th>Semester</th>-->
                <th>Course</th>
                <th>Course Short Name</th>
                <th>Course Code</th>
                <th>Course Credit</th>
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
<!--                        <td>--><?php //echo $row->semester_title; ?><!--</td>-->
                        <td><?php echo $row->title; ?></td>
                        <td><?php echo $row->course_short_name; ?></td>
                        <td><?php echo $row->course_code; ?></td>
                        <td><?php echo $row->credit; ?></td>
                        <td><?php echo ($row->status==1)?"Active":"Inactive"; ?></td>

                        <?php
                        if ($user_role == "super_admin" || $user_role == "superadmin") {
                            ?>
                            <td>
                                <a class="btn btn-info btn-sm"
                                   onclick="updateFloorInfo('<?php echo $row->id ?>','<?php echo $row->title ?>','<?php echo $row->course_short_name ?>','<?php echo $row->course_code ?>','<?php echo $row->credit ?>','<?php echo $row->status ?>')"
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
        $("#course_name").val('');
        $("#course_short_name").val('');
        $("#course_code").val('');
        $("#course_credit").val('');
        $("#status").val(1);
        $("#title_id").val('');

        $("#saveBtn").show();
        $("#updateBtn").hide();
        $("#title").html('Add');
    }
    function updateFloorInfo(id,title,course_short_name,course_code,credit,status){

        $("#course_name").val(title);
        $("#course_short_name").val(course_short_name);
        $("#course_code").val(course_code);
        $("#course_credit").val(credit);
        $("#status").val(status);
        $("#title_id").val(id);

        $("#saveBtn").hide();
        $("#updateBtn").show();
        $("#title").html('Update');



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
                        <label class="control-label col-md-3"> Course Name</label>
                        <div class="col-md-9">
                            <input name="course_name"  type="text" class="form-control" id="course_name" placeholder="Course Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Course Short Name</label>
                        <div class="col-md-9">
                            <input name="course_short_name"  type="text" class="form-control" id="course_short_name" placeholder="Course Short Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Course  Code</label>
                        <div class="col-md-9">
                            <input name="course_code"  type="text" class="form-control" id="course_code" placeholder="Course Code" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3"> Course Credit</label>
                        <div class="col-md-9">
                            <input name="course_credit"  type="text" class="form-control" id="course_credit" placeholder="Course Credit" required>
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



    //    $(function () {
    //        $("#emp_id").change(function () {
    //            var emp_id = $(this).val();
    //            $.ajax({
    //                type: "POST",
    //                url: "<?php echo base_url(); ?>employeecontroller/getempsalary/",
    //                data: 'emp_id=' + emp_id,
    //                dataType: 'json',
    //                success: function (data) {
    //                    $('#p_salary').val(data.b_salary);
    //                }
    //            });
    //        });
    //    });

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