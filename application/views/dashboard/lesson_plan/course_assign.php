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
        </div>
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


            <h3 class="box-title pull-right" style="padding-right:10px;"><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#setting-modal" onclick="addFloor()"><i class="glyphicon glyphicon-plus"></i> Add New</button></h3>
    </div>


    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SL</th>
                <th>Teacher Name</th>
                <th>Session Info</th>
                <th>Course Name</th>
                <th>Status</th>
                <?php

               // if($user_role == "super_admin" || $user_role == "superadmin"){ ?>
                    <th></th>
                <?php
//}
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
                        <td><?php echo $row->teacher_name."[ ".$row->teacher_code."]"; ?></td>
                        <td><?php echo $row->session_name." [".$row->session_name."] [".$row->shift_name."]"; ?></td>
                        <td><?php echo $row->course_title." [".$row->course_code."]"; ?></td>
                        <td><?php echo ($row->status==1)?"Active":"Inactive"; ?></td>


                        <?php
                      //  if ($user_role == "super_admin" || $user_role == "superadmin") {
                            ?>
                            <td>
                                <a class="btn btn-info btn-sm" onclick="updateInfo('<?php echo $row->id ?>');"

                                   data-toggle="modal" data-target="#setting-modal">
                                    <i class="glyphicon glyphicon-pencil"></i> Edit
                                </a>
                            </td>
                            <?php
                       // }
                        ?>

                    </tr>
                    <?php
                    $si++;
                }
            }
            ?>
            </tbody>

        </table>
    </div>
</div>




<script>

    function addFloor(){
        $("#teacher_name").val('');
        $("#session_name").val('');
        $("#course_name").val('');
        $("#status").val(1);
        $("#title_id").val('');

        $("#saveBtn").show();
        $("#updateBtn").hide();
        $("#title").html('Add');
    }
    function updateInfo(id){
        $("#saveBtn").hide();
        $("#updateBtn").show();
        $("#title").html('Update');
        $("#title_id").val(id);


        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>LessonplanController/get_course_assing_info/",
            data: 'assing_id=' + id,
            dataType: 'json',
            success: function (data) {
                $("#teacher_name").val(data.teacher_id);
                $("#session_name").val(data.session_id);
                $("#course_name").val(data.course_id);
                $("#status").val(data.status);
            }
        });






    }
</script>

<div class="modal fade" id="setting-modal"  role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span id="title"></span> <?php echo ucwords($title_info); ?> Information</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="form-horizontal">
                    <?php  if($user_role == "super_admin" || $user_role == "superadmin"){ ?>
                    <div class="form-group">
                        <label class="control-label col-md-3">Teacher Name</label>
                        <div class="col-md-9">
                            <select name="teacher_name"  class="form-control " id="teacher_name"   style="width:100%">
                                <option value="">Select Teacher</option>
                                <?php
                                if(!empty($teacher_info)) {
                                    foreach($teacher_info as $teacher) {
                                        echo "<option value='$teacher->id'>$teacher->name[ $teacher->teacher_code ]</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3"> Session Name</label>
                        <div class="col-md-9">
                            <select name="session_name"  class="form-control " id="session_name"  required style="width:100%">
                                <option value="">Select Session[Batch][Shift]</option>
                                <?php

                                if(!empty($session_info)) {
                                    foreach($session_info as $session) {
                                        echo "<option value='$session->id'>$session->session_name[ $session->batch_name ][ $session->shift_name ]
</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                     <div class="form-group">
                        <label class="control-label col-md-3"> Course Name</label>
                        <div class="col-md-9">
                            <select name="course_name"  class="form-control " id="course_name"  required style="width:100%;">
                                <option value="">Select Course Name</option>
                                <?php
                                if(!empty($course_info)) {
                                    foreach($course_info as $course) {
                                        echo "<option value='$course->id'>$course->title[ $course->course_code ][ $course->credit ]
</option>";
                                    }
                                }
                                ?>
                            </select>
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
