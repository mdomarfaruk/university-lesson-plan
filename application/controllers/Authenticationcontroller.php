<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authenticationcontroller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Userauthmodel', 'USERAUTHMODEL', TRUE);
    }

    function index() {
        $id = $this->session->userdata('shohozit_user_id');
        if(!empty($id)){
            redirect("dashboardcontroller");
        }else{ redirect('ext'); }
    }
    function checkuser() {

        $user_name = $this->input->post('name');
        $password = $this->USERAUTHMODEL->hash($this->input->post('password'));
        $result = $this->USERAUTHMODEL->check_login($user_name, $password);
        if ($result) {
         if ($result->role == "super_admin") {
                $superadmindata['master_id'] = $result->master_id;
                $super_admindata['shohozit_user_id'] = $result->id;
                $super_admindata['abhinvoiser_1_1_user_name'] = $result->name;
                $super_admindata['shohozit_role'] = $result->role;
                $this->session->set_userdata($super_admindata);
                
            } elseif ($result->role == "superadmin") {
                 $superadmindata['master_id'] = $result->master_id;
                $superadmindata['shohozit_user_id'] = $result->id;
                $superadmindata['abhinvoiser_1_1_user_name'] = $result->name;
                $superadmindata['shohozit_role'] = $result->role;
                $this->session->set_userdata($superadmindata);                
            } elseif ($result->role == "teacher") {
                $superadmindata['master_id'] = $result->master_id;
                $superadmindata['shohozit_user_id'] = $result->id;
                $superadmindata['abhinvoiser_1_1_user_name'] = $result->name;
                $superadmindata['shohozit_role'] = $result->role;
                $this->session->set_userdata($superadmindata);
            }
            if ($result->role == "teacher") {
                redirect("dashboardcontroller/teacher_dashboard");
            }else{
                redirect("dashboardcontroller");
            }
        } else {
            $this->session->set_flashdata('exception', "Invalid Username or Password!"); 
            redirect("authenticationcontroller");
        }
    }
    function userLogout() {
        session_destroy();
        $this->session->unset_userdata('shohozit_user_id');
        $this->session->unset_userdata('abhinvoiser_1_1_user_name');
        $this->session->unset_userdata('shohozit_role');

        $data['session_destroy_message'] = 'You are successfully logout';
        $this->session->set_userdata($data);
        redirect("authenticationcontroller");
    }

}