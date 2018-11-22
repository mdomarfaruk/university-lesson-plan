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
        </div>
    </div>
    <?php
}

$failed = $this->session->flashdata('failed');
if ($failed) {
    ?>
    <div class="box box-info">
        <div class="box-body">
            <div class="callout callout-danger">
                <?php
                echo $failed;
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="box ">
    <div class="box-header">
        <h3 class="box-title pull-left"><?php echo ucwords($title); ?></h3>
        <?php if ($this->session->userdata('shohozit_role') == "teacher") { ?>
            <h3 class="box-title pull-right" style="padding-right:10px;"><a class="btn btn-success btn-sm" href="<?php echo site_url('LessonplanController/createlessonplan'); ?>"><i class="glyphicon glyphicon-plus"></i> Add New</a></h3>
        <?php } ?>
    </div>


    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>SL</th>
                <th>Lesson Title</th>
                <th>Semester Title</th>
                <th>Course</th>
                <th>Time</th>
                <th>Status</th>
                <?php
                $user_role = $this->session->userdata('shohozit_role');
                ?>
               <th></th>

            </tr>
            </thead>
            <tbody>
            <?php
            $si = 1;
            if(!empty($lesson_info)){
                foreach ($lesson_info as $row) {
                    ?>
                    <tr>
                        <td><?php echo $si; ?></td>
                        <td><?php echo $row->lecture_title; ?></td>
                        <td><?php echo $row->session_name.'[ '.$row->batch_name.' ]'.'[ '.$row->shift_name.' ]'; ?></td>
                        <td><?php echo $row->course_name; ?></td>
                        <td><?php   echo $row->lecture_hour; echo ($row->lecture_hour_postfix == 1)?" Hours":" Minutes";?></td>
                        <td><?php echo ($row->status==1)?"Active":"Inactive"; ?></td>

                        <td>
                            <a href="<?php echo site_url('LessonplanController/lessonplan_view/'.md5($row->id)); ?>" class="btn btn-info btn-sm">
                                <i class="glyphicon glyphicon-pencil"></i> View
                            </a>
                        </td>


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

