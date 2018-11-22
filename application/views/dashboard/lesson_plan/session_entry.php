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

        <?php   //if($user_role == "super_admin" || $user_role == "superadmin"){ ?>
            <h3 class="box-title pull-right" style="padding-right:10px;"><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#setting-modal" onclick="addFloor()"><i class="glyphicon glyphicon-plus"></i> Add New</button></h3>
        <?php //} ?>
    </div>


    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SL</th>
                <th>Session Info</th>
                <th>Batch</th>
                <th>Shift</th>
                <th>Status</th>
                <th></th>

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
                        <td><?php echo $row->session_name; ?></td>
                        <td><?php echo $row->batch_name; ?></td>
                        <td><?php echo ($row->shift_name==1)?"Day":"Evening"; ?></td>
                        <td><?php echo ($row->status==1)?"Active":"Inactive"; ?></td>


                        <?php
                      //  if ($user_role == "super_admin" || $user_role == "superadmin") {
                            ?>
                            <td>
                                <a class="btn btn-info btn-sm" onclick="updateFloorInfo('<?php echo $row->id ?>');"

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
        $("#session_name").val('');
        $("#batch_name").val('');
        $("#shift").val(2);
        $("#status").val(1);
        $("#title_id").val('');

        $("#saveBtn").show();
        $("#updateBtn").hide();
        $("#title").html('Add');
    }
    function updateFloorInfo(id){
        $("#saveBtn").hide();
        $("#updateBtn").show();
        $("#title").html('Update');
        $("#title_id").val(id);


        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>LessonplanController/get_session_info/",
            data: 'session_id=' + id,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $("#session_name").val(data.session_name);
                $("#batch_name").val(data.batch_name);
                $("#shift").val(data.shift_name);
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
                        <label class="control-label col-md-3"> Session Name</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Session Name" name="session_name"  class="form-control" id="session_name"  required>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Bacth</label>
                        <div class="col-md-9">
                            <input name="batch_name"  type="text" class="form-control" id="batch_name" placeholder="Batch Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" > Shift </label>
                        <div class="col-md-9" >
                            <select  class="form-control" name="shift" id="shift" >
                                <option value="">Select</option>
                                <option value="1">Day</option>
                                <option value="2">Evening</option>
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
