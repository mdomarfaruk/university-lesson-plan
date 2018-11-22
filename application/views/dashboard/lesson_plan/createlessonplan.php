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
        <h3 class="box-title">Create lesson plan</h3>
        <div class="box-title pull-right" style="padding-right:10px;"><a href="<?php echo site_url('LessonplanController/lessonplanlist');?>"  style="color:white" class="btn btn-success btn-sm"  ><i class="glyphicon glyphicon-backward"></i> Lesson plan List </a></div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="col-sm-12">
        <form action="" method="post" class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 levalRight" for="lectureTtile">Lecture Title </label>
                    <div class="col-sm-4">
                        <input name="lecture_title" required type="text" class="form-control" id="lecture_title" placeholder="Lecture Title">
                    </div>
                    <label class="col-sm-2 levalRight" for="lectureHour">Lecture Hour </label>
                    <div class="col-lg-2 col-md-2  col-sm-6 ">
                        <input name="lecture_hour" required type="text" class="form-control" id="lecture_hour" placeholder="Lecture Hour">
                    </div>
                    <div class="col-lg-2 col-md-2  col-sm-6">
                        <select name="lecture_hour_postfix" required  class="form-control" id="lecture_hour_postfix" >
                            <option value="1">Hour</option>
                            <option value="2">Minutes</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 levalRight" for="lectureTtile">Semester </label>
                    <div class="col-sm-4">
                        <select name="session_name"  class="form-control " id="session_name"  required style="width:100%" onchange="showCouseInfo(this.value)">
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
                    <label class="col-sm-2 levalRight" for="lectureHour">Course </label>
                    <div class="col-lg-4 col-md-4  col-sm-6">
                        <select name="course"  class="form-control" id="course" >
                            <option value="">Select Semester</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 levalRight" for="lectureTtile">Room No </label>
                    <div class="col-lg-4 col-md-4  col-sm-6">
                        <select name="room"  class="form-control" id="room" >
                            <option value="">Select Room</option>
                            <?php
                            if(!empty($room_info)){
                                foreach ($room_info as $room){
                                    echo "<option value='$room->id'>$room->title</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-1 col-lg-11 col-md-11  col-sm-11">
                        <table style="width: 100%;" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th  style="width: 2%;">#</th>
                                    <th>Topics Ttile</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableDynamic">
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <textarea name="topics[]"  class="form-control" id="topics" placeholder="Topics"></textarea>
                                    </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3"><a href="javascript:void(0);" id="addRow" class="btn btn-info  btn-sm"><i class="glyphicon glyphicon-plus"></i> Add</a></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-1 col-lg-11 col-md-11  col-sm-11">
                        <table style="width: 100%;" class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 2%;">#</th>
                                <th>Activity</th>
                                <th  style="width: 20%;">Time</th>
                                <th  style="width: 10%;">Action</th>
                            </tr>
                            </thead>

                            <?php
                            if(!empty($activity_info)){
                                $i=1;
                                foreach ($activity_info as $activity){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <input type="text" name="activity[]" type="text" class="form-control" id="activity_<?php echo $i;?>" value="<?php echo $activity->title; ?>" placeholder="activity">
                                             <input type="hidden" name="activity_id[]" type="text" class="form-control" id="activity_id_<?php echo $i;?>" value="<?php echo $activity->id; ?>" >

                                        </td>
                                        <td>
                                            <input type="text" name="activity_time[]" type="text" class="form-control" id="activity_time_<?php echo $i;?>" placeholder=" Time">
                                        </td>
                                        <td>
                                            <?php
                                            if($i>1){
                                            ?>
                                            <a href="javascript:void(0);" id="deleteRowActivity_'<?php echo $i; ?>"  class="deleteRowActivity btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i>Drop</a>
                                                <?php } ?>
                                        </td>

                                    </tr>



                            <?php
                            $i++;
                                }
                            }
                            ?>
                            <tbody id="activityTbody">
                            </tbody>
                            <tfoot>
                            <tr>
                                <td  colspan="4"><a href="javascript:void(0);" id="addRowActivity" class="btn btn-info  btn-sm"><i class="glyphicon glyphicon-plus"></i> Add</a> </td>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
                <input type="hidden" id="gettotalActivity" value="<?php  echo $activity_count=count($activity_info); ?>">

                <div class="form-group">
                    <label class="col-sm-2 levalRight" for="lectureTtile">Description </label>
                    <div class="col-sm-10">
                        <textarea rows="4" name="description" type="text" class="form-control" id="description" placeholder="description"></textarea>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 levalRight" for="lectureTtile">Assesment </label>
                    <div class="col-sm-10">
                        <div class="checkbox">
                            <label><input type="checkbox" name="assesment_type[]" value="1"> Quiz Test</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="assesment_type[]" value="2"> Practical</label>
                        </div>
                         <div class="checkbox">
                            <label><input type="checkbox" name="assesment_type[]" value="3"> Class Test</label>
                        </div>
                         <div class="checkbox">
                            <label><input type="checkbox" name="assesment_type[]" value="4"> Spot Test</label>
                        </div>

                    </div>

                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2 ">
                        <textarea rows="4" name="assesment_description" type="text" class="form-control" id="assesment_description" placeholder="assesment_description"></textarea>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 levalRight" for="Comments">Comments </label>
                    <div class="col-sm-4">
                        <textarea name="comments" type="text" class="form-control" id="comments" placeholder="comments"></textarea>
                    </div>
                    <label class="col-sm-2 levalRight" for="Reference">Reference </label>
                    <div class="col-sm-4">
                        <textarea name="reference" type="text" class="form-control" id="reference" placeholder="Reference"></textarea>
                    </div>


                </div>

            </div><!-- /.box-body -->

            <div class="col-sm-offset-2  box-footer">
                <button type="submit" name="saveLessonPlan" class="btn btn-primary" onclick="return checkadd();">Save</button>
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
    <style>
        .levalRight{
            text-align: right;
        }
    </style>

    <script>

        var scntDiv = $('#tableDynamic');
        var j = $('#tableDynamic tr').size() + 1;
        console.log(j);
        $('#addRow').on('click', function () {
            $('<tr><td>'+ j +'</td><td><textarea name="topics[]"  class="form-control" id="topics_'+ j +'" placeholder="Topics"></textarea></td><td><a href="javascript:void(0);" id="deleteRow_' + j +'"  class="deleteRow btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i>Drop</a></td></tr>').appendTo(scntDiv);
            j++;
            return false;
        });

        $(document).on("click", ".deleteRow", function (e) {
            if ($('#tableDynamic tr').size() > 1) {
                var target = e.target;
                $(target).closest('tr').remove();
            }
        });



        // this for activity

        var scntDivActivity = $('#activityTbody');
        var i = parseInt($('#gettotalActivity').val()) + parseInt(1);
        $('#addRowActivity').on('click', function () {
            $('<tr><td>'+ i +'</td><td><textarea name="activity[]"  class="form-control" id="activity_'+ i +'" placeholder="activity"></textarea></td><td><input type="text" name="activity_time[]" type="text" class="form-control" id="activity_time_'+ i +'" placeholder=" Time"></td><td><a href="javascript:void(0);" id="deleteRowActivity_' + i + '"  class="deleteRowActivity btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i>Drop</a></td></tr>').appendTo(scntDivActivity);
            i++;
            return false;
        });
        $(document).on("click", ".deleteRowActivity", function (e) {
            var target = e.target;
            $(target).closest('tr').remove();
        });


        function showCouseInfo(session_id) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('LessonplanController/getAllCourse'); ?>",
                data: {session_id: session_id},
                success: function (data) {
                    console.log(data);
                    if (data != null) {
                        $('#course').html(data);
                    } else {
                        $('#course').html("<option value=''>Select Semester</option>");
                    }
                }
            });
        }
    </script>