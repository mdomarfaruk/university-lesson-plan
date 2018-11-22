<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Configure_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('common_model/Common_model');
        $this->load->model('configuration/Configure_model');

        $id = $this->session->userdata('shohozit_user_id');
        if (empty($id)) {
            redirect("authenticationcontroller");
        }
    }
   


    
    public function insert_sub_cat() {

        $data['sub_cat'] = $this->input->post('sub_cat');
        $data['cat_id'] = $this->input->post('cat');
        $where_array= array('sub_cat'=>$data['sub_cat']);
        $duplicate = $this->Common_model->duplicateGroupChecker('sub_cats', '', $where_array);

        if ($duplicate) {
            $failed = "Please enter Unique Name";
            $this->session->set_flashdata('failed', $failed);
            redirect('configuration/configure_controller');
        } else {
            $result = $this->Common_model->insert('sub_cats', $data);
        }

        if ($result) {
            $success = "Data successfully inserted!";
            $this->session->set_flashdata('success', $success);
            redirect('configuration/configure_controller');
        }
    }
    public function update_sub_cat() {

        $id = $this->input->post('id');
        $data['sub_cat'] = $this->input->post('sub_cat');
        
        if($this->input->post('cat')){
           $data['cat_id'] = $this->input->post('cat'); 
        }else{
            $data['cat_id'] = $this->input->post('cat_id');
        }
        $where_array= array('sub_cat'=>$data['sub_cat']);
        $duplicate = $this->Common_model->duplicateGroupChecker('sub_cats', $id, $where_array);


        if ($duplicate == TRUE) {
            $failed = "Please enter Unique Name";
            $this->session->set_flashdata('failed', $failed);
            redirect('configuration/configure_controller');
        } else {
            $result = $this->Common_model->edit('sub_cats', 'id', $id, $data);
        }

        if ($result) {
            $success = "Data successfully updated!";
            $this->session->set_flashdata('success', $success);
            redirect('configuration/configure_controller');
        }
    }
    
    public function delete_sub_cat($id) {

        $check = $this->Common_model->duplicate_check('item', 'sub_cat_id', $id);
        if (!$check) {
            $this->Common_model->delete('sub_cats', 'id', $id);
            $success = 'Deleted Successfully !!!';
            $this->session->set_flashdata('success', $success);
            redirect('configuration/configure_controller');
        } else {
            $failed = 'already used !!!';
            $this->session->set_flashdata('failed', $failed);
            redirect('configuration/configure_controller');
        }
    }

}