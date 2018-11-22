<style>
    #tbl1 td {
        border: 2px solid #d0d0d0;
    }

    #tableStyle td {
        padding-top: 5px;
        padding-bottom: 5px;
        vertical-align: top;
    }
     #tableStyle th {
        padding-top: 5px;
        padding-bottom: 5px;
        vertical-align: top;
    }

</style>

<section class="invoice" style="margin-top: -5px; padding-left: 15px; padding-right: 15px;">
    <div class="row no-print">
        <div class="col-xs-12" style="margin-top:10px;">

            <a href="<?php echo site_url('LessonplanController/lessonplanlist'); ?>" class="btn btn-danger btn-sm pull-right"
               style="margin-left:5px;"><i class="glyphicon glyphicon-backward"></i> Back</a>
            <button class="btn btn-primary btn-sm pull-right" onclick="window.print();">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>
    <div class="row" style="font-size: 13px;height:970px;">
        <div class="col-xs-12">
            <div style="font-size: 16px; border-bottom: 0px;text-align: center;  margin-bottom: 0px;"
                 class="page-header">

                <img src="<?php echo base_url(); ?>assets/img/header.png" style="width:100%;height:130px;">
                <span style="position: absolute;top:80px;">
                <?php
                    if (!empty($companyInfo)) {
                        echo  $companyInfo->address ;
                    }

                    ?>
                    Phone: +88 01755559301
                Email: info@bu.edu.bd
                </span>
            </div>
            <h4 style="text-align:center"><b>Lesson Plan</b></h4>
            <br/>
        </div>
        <!-- Table row -->

        <div class="col-xs-12 " style="margin-top: 5px;">
            <table class="table table-bordered">

                <tr>
                    <th>Lesson Title</th>
                    <td colspan="3" ><?php echo $lesson_info->lecture_title ?></td>
                    <th >Lecture Hour</th>
                    <td><?php echo $lesson_info->lecture_hour; echo ($lesson_info->lecture_hour_postfix==1)?" Hours":" Minutes" ?></td>
                </tr>
                <tr>
                    <th style="width:100px;">Session</th>
                    <td style="width:140px;"><?php echo $lesson_info->session_name; ?></td>
                    <th  style="width:100px;">Batch</th>
                    <td style="width:120px;"><?php echo $lesson_info->batch_name;?></td>
                     <th  style="width:100px;">Shift</th>
                    <td><?php echo $lesson_info->shift_name ?></td>

                </tr>
                <tr>
                    <th>Course</th>
                    <td colspan="3" ><?php echo $lesson_info->course_name ?>

                    <th>Course Code</th>
                    <td><?php echo $lesson_info->course_code ?></td>
                </tr>

                <tr>

                    <th>Room No</th>
                    <td colspan="3"><?php echo $lesson_info->room_name ?></td>

                    <th>Credit</th>
                    <td><?php echo $lesson_info->credit ?></td>

                </tr>
                <tr>
                    <th>Description</th>
                    <td colspan="5" ><?php echo $lesson_info->description ?></td>
                </tr>
                <tr>
                    <th>Topics</th>
                    <td colspan="5" >
                        <table id="tableStyle" class="table table-bordered">
                            <tr>
                                <th style="width:10px;">SL</th>
                                <th>Topics Information</th>
                            </tr>
                            <?php

                            if(!empty($topics_info)){
                                $i=1;
                                foreach ($topics_info as $topics) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $topics->topics_title ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th >Activities</th>
                    <td colspan="5"  >
                        <table id="tableStyle" class="table table-bordered">
                            <tr>
                                <th style="width:10px;">Step</th>
                                <th>Activity</th>
                                <th style="width:100px;">Time</th>
                            </tr>
                            <?php

                            if(!empty($activity_info)){
                                $i=1;
                                $toalMin=0;
                                foreach ($activity_info as $activity) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $activity->activity_title ?></td>
                                        <td><?php echo $activity->activity_time ; $toalMin+=$activity->activity_time ;?></td>
                                    </tr>
                                    <?php
                                }
                                echo "<tr><td colspan='2'>Total</td><td>$toalMin</td></tr>";
                                }
                                ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Assessment</th>
                    <td colspan="5" >
                        <?php
                        $assment_type=explode(",",$lesson_info->assesment_type);
                        if(!empty($assment_type)) {
                            if (in_array('1', $assment_type)) {
                                echo "Quiz Test. ";
                            }
                            if (in_array('2', $assment_type)) {
                                echo "Practical. ";
                            }
                            if (in_array('3', $assment_type)) {
                                echo "Class Test. ";
                            }
                            if (in_array('4', $assment_type)) {
                                echo "Spot Test. ";
                            }
                        }


                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Assessment Description</th>
                    <td colspan="5" ><?php echo $lesson_info->assesment_details ?></td>
                </tr>
                <tr>
                    <th>Comments</th>
                    <td colspan="5" ><?php echo $lesson_info->comments ?></td>
                </tr>
                <tr>
                    <th>Reference</th>
                    <td colspan="5" ><?php echo $lesson_info->reference ?></td>
                </tr>








            </table>
        </div>





    </div>

<!--    <div style=" border-top: 1px solid lightgray; text-align: center;">-->
<!--        Software Developed By Md Omar Faruk(Shohag)-->
<!--    </div>-->
    <!-- this row will not appear when printing -->

</section>