<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class LessonplanController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Smodel', 'sm', TRUE);
        $this->load->model('Dashboardmodel', 'DASHBOARDMODEL', TRUE);
        $id = $this->session->userdata('shohozit_user_id');
        if (empty($id)) {
            redirect("authenticationcontroller");
        }
    }
    public function setting() {

        if(isset($_POST['saveBtn'])){
            extract($_POST);
            $data=[
                'title'=>trim($title),
                'type'=>$title_type_id,
                'status'=>$status,
                'created_by'=>$this->session->userdata('shohozit_user_id'),
                'created_ip'=>NULL,
                'created_time'=>date('Y-m-d H:i:s'),
            ];
           $insert=$this->sm->insert_data("con_all_setting",$data);
           if($insert['status']=='error') {
               $this->session->set_flashdata('failed', $insert['message']);
               redirect('LessonplanController/setting/'.$title_type,"location");
           }else{
               $this->session->set_flashdata('success', $insert['message']);
               redirect('LessonplanController/setting/'.$title_type,"location");
           }
        }
        if(isset($_POST['updateBtn'])){
            extract($_POST);
            $data=[
                'title'=>trim($title),
                'status'=>$status,
                'updated_by'=>$this->session->userdata('shohozit_user_id'),
                'updated_ip'=>NULL,
                'updated_time'=>date('Y-m-d H:i:s'),
            ];
            $where=['id'=>$title_id];
            $update=$this->sm->update_data("con_all_setting",$data,$where);
            if($update['status']=='error') {
                $this->session->set_flashdata('failed', $update['message']);
                redirect('LessonplanController/setting/'.$title_type,"location");
            }else{
                $this->session->set_flashdata('success', $update['message']);
                redirect('LessonplanController/setting/'.$title_type,"location");
            }
        }

        $setting_info=[
            'semester'=>[
                            'type'=>1,
                            'title'=>'semester'
                        ],
            'room'=>[
                        'type'=>2,
                        'title'=>'room'
                    ],
            'activity'=>[
                            'type'=>3,
                            'title'=>'activity'
                        ],
        ];

        $data['title_type_id']=$setting_info[$this->uri->segment('3')]['type'];
        $data['title_info'] = $setting_info[$this->uri->segment('3')]['title'];
        $data['viewInfo']=$this->sm->whereOrderDataMultiple("con_all_setting","id","DESC","status != ",'0','type',$data['title_type_id'],'');
        $data['dashboardContent'] = $this->load->view('dashboard/lesson_plan/setting', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function createlessonplan(){
        if(isset($_POST['saveLessonPlan'])){
            extract($_POST);
            $data=[
               'lecture_title'=>$lecture_title,
               'lecture_hour'=>$lecture_hour,
               'lecture_hour_postfix'=>$lecture_hour_postfix,
               'session_id'=>$session_name,
               'course_id'=>$course,
               'room_no'=>$room,
               'course_teacher'=>(($this->session->userdata('master_id') !='-1')?$this->session->userdata('shohozit_user_id'):'-1'),
               'assesment_type'=>(isset($assesment_type) && ($assesment_type!='')? implode(',',$assesment_type):''),
               'assesment_details'=>$description,
               'reference'=>$reference,
               'comments'=>$comments,
               'created_by'=>$this->session->userdata('shohozit_user_id'),
               'created_ip'=> $_SERVER['REMOTE_ADDR'],
               'created_time'=>date('Y-m-d H:i:s'),
           ];
           $lesson_plan=$this->sm->insert_data("le_lesson_plan_info",$data);
            if($lesson_plan['status']=='error') {
                $this->db->trans_rollback();
                $this->session->set_flashdata('failed', $lesson_plan['message']);
                redirect('LessonplanController/setting/',"location");
            }else{
                $lesson_plan_id=$lesson_plan['data'];
            }


            /*----------------------------------------
                -----------------Activity add---------
              ----------------------------------------*/
            if(!empty($activity)) {
                foreach ($activity as $key=> $activity) {
                    $activity_data[] = [
                        'lesson_plan_id' => $lesson_plan_id,
                        'activity_title' => $activity,
                        'activity_time' => $activity_time[$key],
                        'created_by' => $this->session->userdata('shohozit_user_id'),
                        'created_ip' => $_SERVER['REMOTE_ADDR'],
                        'created_time' => date('Y-m-d H:i:s'),
                    ];
                }
                $this->db->insert_batch("activity_info",$activity_data);
            }
            /*----------------------------------------
               -----------------Topics inform.---------
             ----------------------------------------*/
             if(!empty($topics)) {
                foreach ($topics as $topic) {
                    $topics_data[] = [
                        'lesson_plan_id' => $lesson_plan_id,
                        'topics_title' => $topic,
                        'created_by' => $this->session->userdata('shohozit_user_id'),
                        'created_ip' => $_SERVER['REMOTE_ADDR'],
                        'created_time' => date('Y-m-d H:i:s'),
                    ];
                }
             $this->db->insert_batch("topics_info",$topics_data);
            }

            $this->session->set_flashdata('success', 'Successfully created a new lesson plan');
            redirect('LessonplanController/lessonplanlist',"location");



        }
        $data['title']='Lesson plan create';
        $data['session_info']=$this->sm->whereOrderDataSelect("id,session_name,batch_name,IF(shift_name=1,'Day','Evening') as shift_name","session_info","id","DESC","status ",'1');
        $data['room_info']=$this->sm->whereOrderDataMultiple("con_all_setting","id","DESC","status ",'1','type',2,'id,title');
        $data['activity_info']=$this->sm->whereOrderDataMultiple("con_all_setting","id","DESC","status ",'1','type',3,'id,title');

        $data['dashboardContent'] = $this->load->view('dashboard/lesson_plan/createlessonplan', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function lessonplanlist(){
        $data['title']='Lesson plan list';
        $data['lesson_info']=$this->sm->view_all_lesson_info();
        $data['dashboardContent'] = $this->load->view('dashboard/lesson_plan/lessonplanlist', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function lessonplan_view(){
        $data['title']='Lesson plan view';
        $lesson_plan_id=$this->uri->segment('3');
        $data['lesson_info']=$this->sm->view_single_lesson_info($lesson_plan_id);
        $data['companyInfo']=$this->sm->fetchData("company","id","6");
        $data['activity_info']=$this->sm->whereOrderDataSelectWithMd5("activity_title,activity_time","activity_info","id","ASC","lesson_plan_id",$lesson_plan_id);
        $data['topics_info']=$this->sm->whereOrderDataSelectWithMd5("topics_title"," topics_info","id","ASC","lesson_plan_id",$lesson_plan_id);


        $data['dashboardContent'] = $this->load->view('dashboard/lesson_plan/lessonplan_view', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    public function course_entry(){
        if(isset($_POST['saveBtn'])){
            extract($_POST);
            $data=[

                'title'=>trim($course_name),
                'course_short_name'=>trim($course_short_name),
                'course_code'=>trim($course_code),
                'credit'=>trim($course_credit),
                'status'=>$status,
                'created_by'=>$this->session->userdata('shohozit_user_id'),
                'created_ip'=>$_SERVER['REMOTE_ADDR'],
                'created_time'=>date('Y-m-d H:i:s'),
            ];
            $insert=$this->sm->insert_data("con_course_info",$data);
            if($insert['status']=='error') {
                $this->session->set_flashdata('failed', $insert['message']);
                redirect('LessonplanController/course_entry',"location");
            }else{
                $this->session->set_flashdata('success', $insert['message']);
                redirect('LessonplanController/course_entry',"location");
            }
        }
        if(isset($_POST['updateBtn'])){
            extract($_POST);
            $data=[
                'title'=>trim($course_name),
                'course_short_name'=>trim($course_short_name),
                'course_code'=>trim($course_code),
                'credit'=>trim($course_credit),
                'status'=>$status,
                'created_by'=>$this->session->userdata('shohozit_user_id'),
                'created_ip'=>$_SERVER['REMOTE_ADDR'],
                'created_time'=>date('Y-m-d H:i:s'),
            ];

            $where=['id'=>$title_id];
            $update=$this->sm->update_data("con_course_info",$data,$where);
            if($update['status']=='error') {
                $this->session->set_flashdata('failed', $update['message']);
                redirect('LessonplanController/course_entry',"location");
            }else{
                $this->session->set_flashdata('success', $update['message']);
                redirect('LessonplanController/course_entry',"location");
            }
        }

        $data['title']='Course Entry';
        $data['title_info']='Course Entry';
        $data['viewInfo']=$this->sm->getCouseInfo("con_course_info","con_course_info.id","DESC","con_course_info.status != ",'0');
        $data['dashboardContent'] = $this->load->view('dashboard/lesson_plan/course_entry', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function getAllCourse(){
        extract($_POST);
        $get_all_course=$this->sm->getSessionCourseInfo($session_id);
        if(!empty($get_all_course)) {
            echo "<option value=''>Select Semester</option>";
            foreach ($get_all_course as $course) {
                echo "<option value='$course->assign_id'>$course->courseTtile</option>";
            }
        }else{
            echo "<option value=''>Select Semester</option>";
        }
    }

    public function teacher_entry(){
        if(isset($_POST['saveBtn'])){
            extract($_POST);
            $data=[
                'teacher_code'=>$teacher_code,
                'name'=>trim($teacher_name),
                'mobile'=>trim($mobile),
                'email'=>trim($email),
                'address'=>trim($address),
                'details'=>$teacher_details,
                'created_by'=>$this->session->userdata('shohozit_user_id'),
                'created_ip'=>$_SERVER['REMOTE_ADDR'],
                'created_time'=>date('Y-m-d H:i:s'),
            ];
            $insert=$this->sm->insert_data("teacher_info",$data);
            if($insert['status']=='error') {
                $this->session->set_flashdata('failed', $insert['message']);
                redirect('LessonplanController/course_entry',"location");
            }else{
                $data_access['master_id']=$insert['data'];
                $data_access['name']=$user_name;
                $data_access['password'] = $this->DASHBOARDMODEL->hash($data['password']);
                $data_access['status']='active';
                $data_access['role']='teacher';

                $insert_user=$this->sm->insert_data("user",$data_access);
                if($insert_user['status']=='success') {
                    $this->session->set_flashdata('success', $insert['message']);
                    redirect('LessonplanController/teacher_entry', "location");
                }
            }
        }
        if(isset($_POST['updateBtn'])){
            extract($_POST);
            $data=[
                'teacher_code'=>$teacher_code,
                'name'=>trim($teacher_name),
                'mobile'=>trim($mobile),
                'email'=>trim($email),
                'address'=>trim($address),
                'details'=>$teacher_details,
                'updated_by'=>$this->session->userdata('shohozit_user_id'),
                'updated_ip'=>$_SERVER['REMOTE_ADDR'],
                'updated_time'=>date('Y-m-d H:i:s'),
            ];

            $where=['id'=>$title_id];
            $update=$this->sm->update_data("teacher_info",$data,$where);
            if($update['status']=='error') {
                $this->session->set_flashdata('failed', $update['message']);
                redirect('LessonplanController/teacher_entry',"location");
            }else{
                $this->session->set_flashdata('success', $update['message']);
                redirect('LessonplanController/teacher_entry',"location");
            }
        }

        $data['title']='Teacher Information';
        $data['title_info']='Teacher';
        $data['viewInfo']=$this->sm->whereOrderDataSelect("*","teacher_info","id","DESC","status != ",'0');
        $data['dashboardContent'] = $this->load->view('dashboard/lesson_plan/teacher_entry', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    public function get_teacher_info(){
        extract($_POST);
        $infofetchData=$this->sm->fetchData('teacher_info','id',$teacher_id);
        echo json_encode($infofetchData);
    }
    public function get_session_info(){
        extract($_POST);
        $infofetchData=$this->sm->fetchData('session_info','id',$session_id);
        echo json_encode($infofetchData);
    }



    public function session_entry(){
        if(isset($_POST['saveBtn'])){
            extract($_POST);
            $param=[
                'session_name'=>ucwords(trim($session_name)),
                'batch_name'=>ucwords(trim($batch_name)),
                'shift_name'=>trim($shift),
                'status'=>1,
            ];
            $duplicate_session=$this->sm->duplicate_session_name($param);
            if($duplicate_session['status']=='error') {
                $this->session->set_flashdata('failed', $duplicate_session['message']);
                redirect('LessonplanController/session_entry',"location");
            }

            $data=[
                'session_name'=>ucwords(trim($session_name)),
                'batch_name'=>ucwords(trim($batch_name)),
                'shift_name'=>trim($shift),
                'status'=>trim($status),
                'created_by'=>$this->session->userdata('shohozit_user_id'),
                'created_ip'=>$_SERVER['REMOTE_ADDR'],
                'created_time'=>date('Y-m-d H:i:s'),
            ];
            $insert=$this->sm->insert_data("session_info",$data);
            if($insert['status']=='error') {
                $this->session->set_flashdata('failed', $insert['message']);
                redirect('LessonplanController/session_entry',"location");
            }else{
                $this->session->set_flashdata('success', $insert['message']);
                redirect('LessonplanController/session_entry', "location");

            }
        }
        if(isset($_POST['updateBtn'])){
            extract($_POST);
            $param=[
                'session_name'=>ucwords(trim($session_name)),
                'batch_name'=>ucwords(trim($batch_name)),
                'shift_name'=>trim($shift),
                'status'=>1,
            ];
            $duplicate_session=$this->sm->duplicate_session_name($param,$title_id);
            if($duplicate_session['status']=='error') {
                $this->session->set_flashdata('failed', $duplicate_session['message']);
                redirect('LessonplanController/session_entry',"location");
            }
            $data=[
                'session_name'=>ucwords(trim($session_name)),
                'batch_name'=>ucwords(trim($batch_name)),
                'shift_name'=>trim($shift),
                'status'=>trim($status),
                'updated_by'=>$this->session->userdata('shohozit_user_id'),
                'updated_ip'=>$_SERVER['REMOTE_ADDR'],
                'updated_time'=>date('Y-m-d H:i:s'),
            ];

            $where=['id'=>$title_id];
            $update=$this->sm->update_data("session_info",$data,$where);
            if($update['status']=='error') {
                $this->session->set_flashdata('failed', $update['message']);
                redirect('LessonplanController/session_entry',"location");
            }else{
                $this->session->set_flashdata('success', $update['message']);
                redirect('LessonplanController/session_entry',"location");
            }
        }

        $data['title']='Session Information';
        $data['title_info']='Session';
        $data['viewInfo']=$this->sm->whereOrderDataSelect("*","session_info","id","DESC","status != ",'0');
        $data['dashboardContent'] = $this->load->view('dashboard/lesson_plan/session_entry', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function course_assign(){
        if(isset($_POST['saveBtn'])){
            extract($_POST);
            $user_role = $this->session->userdata('shohozit_role');
            $teacher=($user_role == "super_admin" || $user_role == "superadmin")?$teacher_name:$this->session->userdata('master_id');
            $param=[
              'session_id' => $session_name,
              'course_id' => $course_name,
              'teacher_id' => $teacher,
              'status' => 1,
            ];
            $duplicate_check=$this->sm->duplicate_course_assign_check($param);
            if($duplicate_check['status']=='error') {
                $this->session->set_flashdata('failed', $duplicate_check['message']);
                redirect('LessonplanController/course_assign',"location");
            }

            $data=[
                'teacher_id'=>$teacher,
                'session_id'=>trim($session_name),
                'course_id'=>trim($course_name),
                'status'=>trim($status),
                'created_by'=>$this->session->userdata('shohozit_user_id'),
                'created_ip'=>$_SERVER['REMOTE_ADDR'],
                'created_time'=>date('Y-m-d H:i:s'),
            ];
            $insert=$this->sm->insert_data("course_session_relation",$data);
            if($insert['status']=='error') {
                $this->session->set_flashdata('failed', $insert['message']);
                redirect('LessonplanController/course_assign',"location");
            }else{
                $this->session->set_flashdata('success', $insert['message']);
                redirect('LessonplanController/course_assign', "location");

            }
        }
        if(isset($_POST['updateBtn'])){
            extract($_POST);
            $user_role = $this->session->userdata('shohozit_role');
            $teacher=($user_role == "super_admin" || $user_role == "superadmin")?$teacher_name:$this->session->userdata('master_id');
            $param=[
                'session_id' => $session_name,
                'course_id' => $course_name,
                'teacher_id' => $teacher,
                'status' => 1,
            ];
            $duplicate_check=$this->sm->duplicate_course_assign_check($param,$title_id);
            if($duplicate_check['status']=='error') {
                $this->session->set_flashdata('failed', $duplicate_check['message']);
                redirect('LessonplanController/course_assign',"location");
            }
            $data=[
                'teacher_id'=>$teacher,
                'session_id'=>trim($session_name),
                'course_id'=>trim($course_name),
                'status'=>trim($status),
                'updated_by'=>$this->session->userdata('shohozit_user_id'),
                'updated_ip'=>$_SERVER['REMOTE_ADDR'],
                'updated_time'=>date('Y-m-d H:i:s'),
            ];

            $where=['id'=>$title_id];
            $update=$this->sm->update_data("course_session_relation",$data,$where);
            if($update['status']=='error') {
                $this->session->set_flashdata('failed', $update['message']);
                redirect('LessonplanController/course_assign',"location");
            }else{
                $this->session->set_flashdata('success', $update['message']);
                redirect('LessonplanController/course_assign',"location");
            }
        }

        $data['title']='Course Assing';
        $data['title_info']='Course Assign';

        $data['session_info']=$this->sm->whereOrderDataSelect("id,session_name,batch_name,IF(shift_name=1,'Day','Evening') as shift_name","session_info","id","DESC","status ",'1');
        $data['teacher_info']=$this->sm->whereOrderDataSelect("id,name,teacher_code","teacher_info","id","DESC","status ",'1');
        $data['course_info']=$this->sm->whereOrderDataSelect("id,title,course_code,credit","con_course_info","id","DESC","status ",'1');
        $data['viewInfo']=$this->sm->getCourseAssingInfo();

        $data['dashboardContent'] = $this->load->view('dashboard/lesson_plan/course_assign', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function get_course_assing_info(){
        extract($_POST);
        $infofetchData=$this->sm->fetchData('course_session_relation','id',$assing_id);
        echo json_encode($infofetchData);
    }



}