<?php $user_role = $this->session->userdata('shohozit_role'); ?>
<ul class="sidebar-menu">

    <?php if ($user_role == "teacher") { ?>

        <li class="active">
            <a href="<?php echo site_url('dashboardcontroller/teacher_dashboard'); ?>">
                <i class="fa fa-dashboard"></i><span>Dashboard</span>
            </a>
        </li>
    <?php }else{ ?>
        <li class="active">
            <a href="<?php echo site_url(); ?>">
                <i class="fa fa-dashboard"></i><span>Dashboard</span>
            </a>
        </li>
    <?php } ?>



        <li class="treeview">
            <a href="#">
                <i class="fa fa-folder"></i>Lesson Plan
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <?php if ($user_role == "teacher") { ?>
                <li>
                    <a href="<?php echo site_url('LessonplanController/createlessonplan'); ?>">
                        New Lesson Plan
                    </a>
                </li>
                <?php } ?>
                <li>
                    <a href="<?php echo site_url('LessonplanController/lessonplanlist'); ?>">
                         Lesson Plan List
                    </a>
                </li>
            </ul>
        </li>


        <li class="treeview">
            <a href="#">
                <i class="fa fa-folder"></i>Configuration
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="<?php echo site_url('LessonplanController/course_assign'); ?>">
                        <?php if(!in_array($user_role,['super_admin','superadmin'])){ echo "My "; } ?>Course Assign
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('LessonplanController/session_entry'); ?>">
                        Session
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('LessonplanController/course_entry'); ?>">
                        Course Info
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('LessonplanController/teacher_entry'); ?>">
                        Teacher
                    </a>
                </li>

                <li>
                    <a href="<?php echo site_url('LessonplanController/setting/room'); ?>">
                        Room
                    </a>
                </li>
                 <li>
                    <a href="<?php echo site_url('LessonplanController/setting/activity'); ?>">
                       Activity
                    </a>
                </li>
                <?php if (($user_role == "superadmin") || ($user_role == "super_admin")|| ($user_role == "admin")) { ?>
                <li>
                    <a href="<?php echo site_url('dashboardcontroller/viewcompany'); ?>">
                      Institute Info.
                    </a>
                </li>



                <li>
                    <a href="<?php echo base_url(); ?>dashboardcontroller/viewuserlist">
                        User
                    </a>
                </li>

        <?php } ?>





</ul>