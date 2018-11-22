<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboardcontroller extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Dashboardmodel', 'DASHBOARDMODEL', TRUE);
        $this->load->model('Smodel', 'sm', TRUE);
        $id = $this->session->userdata('shohozit_user_id');
        if(empty($id)){ redirect("authenticationcontroller"); }
    }

    function index() { 

        $data['title'] = 'Dashboard';
        $data['shopName'] = 'Bangladesh University(CSE Department)';
        $data['lesson_plan_count']=$this->sm->total_count("le_lesson_plan_info","id","status");
        $data['teacher_count']=$this->sm->total_count("teacher_info","id","status");
        $data['course_count']=$this->sm->total_count("con_course_info","id","status");
        $type=['type'=>1];
        $data['semester_count']=$this->sm->total_count("session_info","id","status");
        $type_room=['type'=>2];
        $data['room_count']=$this->sm->total_count("con_all_setting","id","status",$type_room);
        $type_activity=['type'=>3];
        $data['activity_count']=$this->sm->total_count("con_all_setting","id","status",$type_activity);


        $data['dashboardContent'] = $this->load->view('dashboard/frontpage', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function teacher_dashboard(){

        $type_lesson_plan=['created_by'=>$this->session->userdata('shohozit_user_id')];
        $data['lesson_plan_count']=$this->sm->total_count("le_lesson_plan_info","id","status",$type_lesson_plan);
        $data['teacher_count']=$this->sm->total_count("teacher_info","id","status");
        $data['course_count']=$this->sm->total_count("con_course_info","id","status");
        $type=['type'=>1];
        $data['semester_count']=$this->sm->total_count("con_all_setting","id","status",$type);
        $type_room=['type'=>2];
        $data['room_count']=$this->sm->total_count("con_all_setting","id","status",$type_room);
        $type_activity=['type'=>3];
        $data['activity_count']=$this->sm->total_count("con_all_setting","id","status",$type_activity);
        $data['title'] = 'Teacher Dashboard ';
        $data['shopName'] = 'Bangladesh University(CSE Department)';
        $data['dashboardContent'] = $this->load->view('dashboard/frontpage', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    function directorDashboard() {
        $dt = new DateTime();
        $today = $dt->format('Y/m/d');
        $year = $dt->format('Y');
        $month = $dt->format('m');
        $first_date = $year . "-" . $month . "-" . "01";
        $last_date = $year . "-" . $month . "-" . "31";
        $data['first_date'] = $first_date;
        $data['last_date'] = $last_date;
        $enddate = date('Y-m-d', strtotime($today) + strtotime("-30 day", 0));
        $directorId=$this->session->userdata('master_id');
        $data['querycurrencytag'] = $this->DASHBOARDMODEL->querycurrencytag();
        $data['viewDirectorInfo'] = $this->INVOICEMODEL->viewDirectorInfo($directorId);
        $data['viewDirectorStatement'] = $this->INVOICEMODEL->viewDirectorStatement($directorId);

        $data['directorTotalInvest'] = $this->sm->sumOfInvestmentDirctor("","",$directorId);
        $data['directorTotalInvestCurrent'] = $this->sm->sumOfInvestmentDirctor($first_date,$last_date,$directorId);

        $data['title'] = 'Dashboard(Director)';
        $data['dashboardContent'] = $this->load->view('dashboard/frontpage_director', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function directorInvestmentStatement()
    {
        $directorId=$this->uri->segment('3');
        if(isset($_POST['searchDateRange'])){
            extract($_POST);
            $expDate=explode("-",$date_range);
            $firstDate=$expDate[0];
            $lastDate=$expDate[1];
        }else{
            $firstDate='';
            $lastDate='';
        }
        $data['viewDirectorInfoLedger'] = $this->sm->viewDirectorLedger("rs_director_ledger", "director_ledger_id", "ASC", "directorId", $directorId,$firstDate,$lastDate);
        $data['title'] = "Director Statement";

        $data['dashboardContent'] = $this->load->view('dashboard/projectFolder/directorInvestmentStatement', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function adduser() {
        $data = array();
        $data['dashboardContent'] = $this->load->view('dashboard/adduser', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    function useraccesslist() {
        $data = array();
        $data['dashboardContent'] = $this->load->view('dashboard/useraccesslist', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function insertuser() {
        $data['name'] = $this->input->post('name');
        $data['password'] = $this->DASHBOARDMODEL->hash($this->input->post('password'));
        $data['status'] = $this->input->post('status');
        $data['role'] = $this->input->post('role');

        if (empty($data['name']) || empty($data['password']) || empty($data['status']) || empty($data['role'])) {
            $failed = "Please enter Required Fields";
            $this->session->set_flashdata('failed', $failed);
            redirect('dashboardcontroller/adduser');
        }

        $duplicate = $this->DASHBOARDMODEL->duplicateUserChecker($data['name']);

        if ($duplicate) {
            $failed = "Please enter Unique Username";
            $this->session->set_flashdata('failed', $failed);
            redirect('dashboardcontroller/adduser');
        } else {
            $result = $this->DASHBOARDMODEL->insertUserInfo($data);
        }

        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $role = $this->input->post('role');

        if ($result) {
            $success = "Data successfully inserted!<br>
                        Username : $name<br>
                        Password : $password<br>
                        Status : $status<br>
                        Role : $role<br>";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/adduser');
        }
    }

    function viewuserlist() {
        $data['viewuserlist'] = $this->DASHBOARDMODEL->viewuserlist();

        $data['dashboardContent'] = $this->load->view('dashboard/viewuserlist', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function activateuser($id) {
        $info_data['status'] = "active";
        $result = $this->DASHBOARDMODEL->activateuser($id, $info_data);
        redirect("dashboardcontroller/viewuserlist");
    }

    function inactivateuser($id) {
        $info_data['status'] = "inactive";
        $result = $this->DASHBOARDMODEL->inactivateuser($id, $info_data);
        redirect("dashboardcontroller/viewuserlist");
    }

    function changepassword($id) {
        $data['name'] = $this->input->post('name');
        $data['password'] = $this->input->post('new_password');
        $new_password = $this->input->post('new_password_again');

        if (empty($data['name'])) {
            $success = "Please enter User Name!!";
            $this->session->set_flashdata('success', $success);
            redirect("dashboardcontroller/viewuserlist");
        }
        if (empty($data['password']) || empty($new_password)) {
            $success = "Please enter Password Twice!!";
            $this->session->set_flashdata('success', $success);
            redirect("dashboardcontroller/viewuserlist");
        } else {
            if ($data['password'] == $new_password) {
                $data['password'] = $this->DASHBOARDMODEL->hash($data['password']);
                $result = $this->DASHBOARDMODEL->changepassword($id, $data);
                $success = "Password changed successfully!";
                $this->session->set_flashdata('success', $success);
                redirect("dashboardcontroller/viewuserlist");
            } else {
                $failed = "Password does not match!";
                $this->session->set_flashdata('failed', $failed);
                redirect("dashboardcontroller/viewuserlist");
            }
        }
    }

    function viewcompany() {
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y/m/d');
        $data['current_date_my'] = $dt->format('m-Y');
        $data['companylist'] = $this->DASHBOARDMODEL->companylist();
        $data['dashboardContent'] = $this->load->view('dashboard/company', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function insertcompany() {
        if(isset($_POST['saveBtn'])){
            extract($_POST);

            $file_name = $_FILES['picture']['name'];
            $file_tmp = $_FILES['picture']['tmp_name'];

            if (isset($file_name) && $file_name != '') {
                if(file_exists($comapany_old_logo)){
                    unlink($comapany_old_logo);
                }
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $file = date('ymdhis') . "." . $ext;
                move_uploaded_file($file_tmp, "assets/img/company_image/" . $file);
                $pic = "assets/img/company_image/" . $file;
            } else {
                $pic = trim($comapany_old_logo);
            }
            $data['com_name'] = trim($com_name);
            $data['address'] = trim($address);
            $data['type_company'] = trim($company_type);
            $data['reg_no'] = trim($reg_no);
            $data['trade_licence'] = trim($trade_licence);
            $data['vat_reg_no'] = trim($vat_reg_no);
            $data['tax_reg_no'] = trim($tax_reg_no);
            $data['vat_per'] = trim($vat_per);
            $data['tax_per'] = trim($tax_per);
            $data['special_discount_per'] = trim($special_discount_per);
            $data['company_sologan'] = trim($company_sologan);
            $data['ins_date'] = date('Y-m-d');
            $data['company_logo'] = $pic;

            $ck_existing_com = $this->DASHBOARDMODEL->ck_existing_com($data);
            if($ck_existing_com=='insert') {
                $success_saved = "Company Information successfully insert!<br>";
                $this->session->set_flashdata('success', $success_saved);
                redirect("dashboardcontroller/viewcompany");
            }else if($ck_existing_com=='Update'){
                $success_updated = "Company Information successfully  updated!<br>";
                $this->session->set_flashdata('success', $success_updated);
                redirect("dashboardcontroller/viewcompany");
            }else {
                $failed = "Sorry Failed to company information!<br>";
                $this->session->set_flashdata('failed', $failed);
                redirect("dashboardcontroller/viewcompany");
            }

        }
    }


    function addbank() {
        $data['viewbankinfo'] = $this->DASHBOARDMODEL->viewbankinfo();
        $data['title'] = "Accounts";
        $data['dashboardContent'] = $this->load->view('dashboard/viewbank', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function insertbank() {
        $data['b_name'] = $this->input->post('b_name');
        $data['b_branch'] = $this->input->post('b_branch');
        $data['acc_no'] = $this->input->post('acc_no');
        $data['b_date'] = $this->input->post('b_date');

        $bank = $this->input->post('b_name');
        $acc_no = $this->input->post('acc_no');
        $ck_existing = $this->DASHBOARDMODEL->ckbank_existing($bank, $acc_no);

        if (!$ck_existing) {
            $failed = "Duplicate Bank Account No.!<br>";
            $this->session->set_flashdata('failed', $failed);
            redirect("dashboardcontroller/addbank");
        }

        $result = $this->DASHBOARDMODEL->insertbankinfo($data);

        if ($result) {
            $success = "Data successfully inserted!<br>";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/addbank');
        }
    }

    function editbank() {
        $data['b_name'] = $this->input->post('b_name');
        $data['b_branch'] = $this->input->post('b_branch');
        $data['acc_no'] = $this->input->post('acc_no');
        $data['b_date'] = $this->input->post('b_date');
        $bank = $this->input->post('b_name');
        $acc_no = $this->input->post('acc_no');
        $ck_existing = $this->DASHBOARDMODEL->ckbank_existing($bank, $acc_no);
        if (!$ck_existing) {
            $failed = "Duplicate Bank Account No.!<br>";
            $this->session->set_flashdata('failed', $failed);
            redirect("dashboardcontroller/addbank");
        }

        $id = $this->input->post('id');

        $result = $this->DASHBOARDMODEL->updatebankinfo($id, $data);

        if ($result) {
            $success = "Data successfully inserted!<br>";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/addbank');
        }
    }

    function bankstatement() {
        $dt = new DateTime();
        $id = $this->input->post('id');
        $dateexplode = explode("-", $this->input->post('date_range'));
        $first_date = $dateexplode[0];
        $last_date = $dateexplode[1];
        $data['first_date'] = $dateexplode[0];
        $data['last_date'] = $dateexplode[1];

        $data['companyInfo'] = $this->DASHBOARDMODEL->companyInfo();
        $data['viewbankname'] = $this->DASHBOARDMODEL->viewbankname($id);
        $data['get_forward_blance'] = $this->DASHBOARDMODEL->get_forward_blance($first_date, $id);
        $data['viewbankstatementinfo'] = $this->DASHBOARDMODEL->viewbankstatementinfo($first_date, $last_date, $id);
        //echo '<pre>';print_r($data['viewbankstatementinfo']);die;
        $data['title'] = "Statement";
        $data['dashboardContent'] = $this->load->view('dashboard/bankstatement', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function deletebankbyid($id) {

        $ck_existing = $this->DASHBOARDMODEL->ck_existing_use($id);
        if ($ck_existing) {
            $this->session->set_flashdata('failed', "Can't Delete Bank Info already use!");
            redirect("dashboardcontroller/addbank");
        }
        $this->DASHBOARDMODEL->deletebankinfo($id);
        $this->session->set_flashdata('success', 'Deleted Bank Info Successfully !!!');
        redirect('dashboardcontroller/addbank');
    }

    function addobl() {
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y/m/d');
        $data['viewbankinfo1'] = $this->DASHBOARDMODEL->viewbankinfo();
        $data['viewbankinfo2'] = $this->DASHBOARDMODEL->viewbankinfo2();
        $data['cashbalance'] = $this->DASHBOARDMODEL->cashbalance();
        $first_date = '';
        $last_date = '';
        $method = '';
        $b_id = '';

        $data['viewbalanceinfo'] = $this->DASHBOARDMODEL->viewbalanceinfo($first_date, $last_date, $method, $b_id);
        $data['dashboardContent'] = $this->load->view('dashboard/viewbalance', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    function getbankdetail() {
        $method = $this->input->post('method');
        if ($method == 'Bank') {
            $data = $this->DASHBOARDMODEL->getbankdetail();
            echo json_encode($data);
        }
    }

    function transactionhistory() {
        $dt = new DateTime();
        if ($this->input->post('date_range')) {
            if ($this->input->post('date_range')) {
                $dateexplode = explode("-", $this->input->post('date_range'));
                $first_date = $dateexplode[0];
                $last_date = $dateexplode[1];
                $data['first_date'] = $dateexplode[0];
                $data['last_date'] = $dateexplode[1];
            } else {
                $first_date = '';
                $last_date = '';
            }
        } else {
            $first_date = '';
            $last_date = '';
        }
        
        if ($this->input->post('method')){
            $method = $this->input->post('method');
            $data['method'] = $method;
        }else{
            $method = '';
            $data['method'] = $method;
        }

        if ($this->input->post('b_id')) {
            $b_id = $this->input->post('b_id');
            $data['b_name'] = $this->DASHBOARDMODEL->getbankinfo($b_id);
            $data['b_id'] = $b_id;
        } else {
            $b_id = '';
            $data['b_id'] = $b_id;
        }

        $data['viewbalanceinfo'] = $this->DASHBOARDMODEL->viewbankstatementinfo($first_date, $last_date, $b_id, "t.id DESC", $method);
        $data['title'] = "Transaction History";
        $data['dashboardContent'] = $this->load->view('dashboard/transactionhistory', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function balance_status() {
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y/m/d');
        $data['viewbankinfo'] = $this->DASHBOARDMODEL->viewbankbalanceinfo();
        $data['dashboardContent'] = $this->load->view('dashboard/balance_status', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function balance_transfer() {
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y/m/d');
        $data['viewbankinfo1'] = $this->DASHBOARDMODEL->viewbankinfo();
        $data['cashbalance'] = $this->DASHBOARDMODEL->cashbalance();

        $data['viewbalanceinfo'] = $this->DASHBOARDMODEL->viewtransferbalanceinfo();
        $data['dashboardContent'] = $this->load->view('dashboard/balance_transfer', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function opening_balance() {
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y/m/d');
        $data['companylist'] = $this->DASHBOARDMODEL->companylist();
        $data['viewbankinfo2'] = $this->DASHBOARDMODEL->viewbankinfo2();
        $data['viewbalanceinfo'] = $this->DASHBOARDMODEL->viewopeningbalanceinfo();
        $data['dashboardContent'] = $this->load->view('dashboard/opening_balance', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function getbankavailable() {
        $id = $this->input->post('bank_id');
        if ($id != '') {
            $data = $this->DASHBOARDMODEL->bankavailableblance($id);
            echo json_encode($data);
        }
    }

    function insertbankobl() {
        $dt = new DateTime();
        $data['trans_id'] = $dt->format('ymdHis');
        $data['b_id'] = $this->input->post('b_id');
        $data['tr_type'] = 0;
        $data['tr_method'] = 'Bank';
        $data['tr_amount'] = $this->input->post('tr_amount');
        $data['tr_date'] = $this->input->post('tr_date');
        $data['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');

        $id = $this->input->post('b_id');
        $udata['status'] = 1;

        $update = $this->DASHBOARDMODEL->updatebankobl($id, $udata);
        $result = $this->DASHBOARDMODEL->inserttrnsinfo($data);
        if ($result) {
            $this->session->set_flashdata('success', "Data successfully inserted!");
            redirect('dashboardcontroller/opening_balance');
        }
    }

    function insertcashobl() {
        $dt = new DateTime();
        $data['trans_id'] = $dt->format('ymdHis');
        $data['tr_type'] = 0;
        $data['tr_method'] = 'Cash';
        $data['tr_amount'] = $this->input->post('tr_amount');
        $data['tr_date'] = $this->input->post('tr_date');
        $data['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');

        $tr_type = $data['tr_type'];
        $tr_method = $data['tr_method'];

        $dupcash = $this->DASHBOARDMODEL->duplicatecashob($tr_type, $tr_method);

        if ($dupcash) {
            $failed = "Cash Opening Balance Already Added.";
            $this->session->set_flashdata('failed', $failed);
            redirect('dashboardcontroller/opening_balance');
        } else {
            $result = $this->DASHBOARDMODEL->inserttrnsinfo($data);
        }

        if ($result) {
            $success = "Data successfully inserted!<br>";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/opening_balance');
        }
    }
    
    function viewnoninvoice($id) {
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y/m/d');

        $data['storeInfo'] = $this->DASHBOARDMODEL->storeInfo();
        
        $data['viewcompanyinfo'] = $this->DASHBOARDMODEL->noninvoicecompany($id);
        
        $data['viewbankstatementinfo'] = $this->DASHBOARDMODEL->noninvoice($id);

        $data['dashboardContent'] = $this->load->view('dashboard/printviewnoninvoice', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function insertnoninvbl() {
        $dt = new DateTime();       
        $transid = $dt->format('ymdHis');

        $data['trans_id'] = $transid;
        $data['tr_type'] = 8;
        $data['tr_method'] = $this->input->post('method');
        $data['rec_no'] = $this->input->post('rec_no');
        $data['non_c_id'] = $this->input->post('non_c_id');
        $data['tr_note'] = $this->input->post('tr_note');
        if ($this->input->post('tr_method') == 'Cash') {
            $data['b_id'] = 0;
            $data['chq_no'] = '';
        } else {
            $data['b_id'] = $this->input->post('b_id');
            $data['chq_no'] = $this->input->post('chq_no');
        }

        $data['tr_amount'] = $this->input->post('tr_amount');
        $data['tr_date'] = $this->input->post('tr_date');
        $data['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');

        $result = $this->DASHBOARDMODEL->inserttrnsinfo($data);

        if ($result) {
            $success = "
				Data successfully inserted!<br>
				";
            $this->session->set_flashdata('success', $success);
            redirect("dashboardcontroller/viewnoninvoice/$transid");
        } else {
            $failed = "Non Invoice Income not Added.";
            $this->session->set_flashdata('success', $failed);
            redirect('dashboardcontroller/opening_balance');
        }
    }
        
    function updatenoninvbl() {
        $dt = new DateTime();       
        $transid = $this->input->post('trans_id');
        $data['trans_id'] = $this->input->post('trans_id');
        $data['tr_type'] = 8;
        $data['tr_method'] = $this->input->post('method');
        $data['rec_no'] = $this->input->post('rec_no');
        $data['non_c_id'] = $this->input->post('non_c_id');
        $data['tr_note'] = $this->input->post('tr_note');
        if ($this->input->post('method') == 'Cash') {
            $data['b_id'] = 0;
            $data['chq_no'] = '';
        } else {
            $data['b_id'] = $this->input->post('b_id');
            $data['chq_no'] = $this->input->post('chq_no');
        }

        $data['tr_amount'] = $this->input->post('tr_amount');
        $data['tr_date'] = $this->input->post('tr_date');
//        $data['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');

        $result = $this->DASHBOARDMODEL->updatetrnsinfo($transid,$data);

        if ($result) {
            $success = "Data successfully Updated!<br>";
            $this->session->set_flashdata('success', $success);
            redirect("dashboardcontroller/viewnoninvoice/$transid");
        } else {
            $failed = "Non Invoice Income not Updated.";
            $this->session->set_flashdata('success', $failed);
            redirect('dashboardcontroller/opening_balance');
        }
    }    
    
    function deletenoninvoice($id) {
        $this->DASHBOARDMODEL->deletenoninvinfo($id);
        $success = 'Non Invoice Income Successfully Deleted!!!';
        $this->session->set_flashdata('success', $success);
        redirect('dashboardcontroller/opening_balance');
    }

    function insertbanktocashtransfer() {
        $dt = new DateTime();
        $trans = $dt->format('ymdHis');
        $bdata['trans_id'] = $trans;
        $cdata['trans_id'] = $trans;

        $bdata['b_id'] = $this->input->post('bank_id');
        $cdata['b_id'] = 0;
        $bdata['tr_type'] = 4;
        $cdata['tr_type'] = 4;
        $bdata['tr_method'] = 'Bank';
        $cdata['tr_method'] = 'Cash';
        $bdata['tr_amount'] = -$this->input->post('trans_amount');
        $cdata['tr_amount'] = $this->input->post('trans_amount');
        $bdata['tr_date'] = $this->input->post('tr_date');
        $cdata['tr_date'] = $this->input->post('tr_date');
        $bdata['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');
        $cdata['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');


        if ($this->input->post('trans_amount') > $this->input->post('av_amount')) {
            $failed = "Invalid amount.";
            $this->session->set_flashdata('failed', $failed);
            redirect('dashboardcontroller/balance_transfer');
        }


        $result1 = $this->DASHBOARDMODEL->inserttrnsinfo($bdata);

        $result2 = $this->DASHBOARDMODEL->inserttrnsinfo($cdata);

        if ($result1 && $result2) {
            $success = "Data successfully inserted!<br>
				";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/balance_transfer');
        }
    }

    function insertcashtobanktransfer() {
        $dt = new DateTime();
        $trans = $dt->format('ymdHis');
        $bdata['trans_id'] = $trans;
        $cdata['trans_id'] = $trans;

        $bdata['b_id'] = 0;
        $cdata['b_id'] = $this->input->post('bank_id');
        $bdata['tr_type'] = 5;
        $cdata['tr_type'] = 5;
        $bdata['tr_method'] = 'Cash';
        $cdata['tr_method'] = 'Bank';
        $bdata['tr_amount'] = -$this->input->post('trans_amount');
        $cdata['tr_amount'] = $this->input->post('trans_amount');
        $bdata['tr_date'] = $this->input->post('tr_date');
        $cdata['tr_date'] = $this->input->post('tr_date');
        $bdata['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');
        $cdata['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');

        if ($this->input->post('trans_amount') > $this->input->post('cashbalance')) {
            $failed = "Invalid amount.";
            $this->session->set_flashdata('failed', $failed);
            redirect('dashboardcontroller/balance_transfer');
        }

//        print_r($cdata); exit();
        $result1 = $this->DASHBOARDMODEL->inserttrnsinfo($bdata);

        $result2 = $this->DASHBOARDMODEL->inserttrnsinfo($cdata);

        if ($result1 && $result2) {
            $success = "Data successfully inserted!<br>
				";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/balance_transfer');
        }
    }

    function insertbanktobanktransfer() {
        $dt = new DateTime();
        $trans = $dt->format('ymdHis');

        $bdata['trans_id'] = $trans;
        $cdata['trans_id'] = $trans;

        $bdata['b_id'] = $this->input->post('bank_id');
        $cdata['b_id'] = $this->input->post('bank_id2');
        $bdata['tr_type'] = 6;
        $cdata['tr_type'] = 6;
        $bdata['tr_method'] = 'Bank';
        $cdata['tr_method'] = 'Bank';
        $bdata['tr_amount'] = -$this->input->post('trans_amount');
        $cdata['tr_amount'] = $this->input->post('trans_amount');
        $bdata['tr_date'] = $this->input->post('tr_date');
        $cdata['tr_date'] = $this->input->post('tr_date');
        $bdata['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');
        $cdata['tr_by'] = $this->session->userdata('abhinvoiser_1_1_user_name');


        if ($this->input->post('bank_id') == $this->input->post('bank_id2')) {
            $failed = "Please Select different bank accounts.";
            $this->session->set_flashdata('failed', $failed);
            redirect('dashboardcontroller/balance_transfer');
        }


        if ($this->input->post('trans_amount') > $this->input->post('av_amount')) {
            $failed = "Invalid amount.";
            $this->session->set_flashdata('failed', $failed);
            redirect('dashboardcontroller/balance_transfer');
        }


        $result1 = $this->DASHBOARDMODEL->inserttrnsinfo($bdata);

        $result2 = $this->DASHBOARDMODEL->inserttrnsinfo($cdata);

        if ($result1 && $result2) {
            $success = "Data successfully inserted!<br>
				";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/balance_transfer');
        }
    }

    function addstoreinfo() {
        $data = array();
        $data['dashboardContent'] = $this->load->view('dashboard/addstoreinfo', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function insertstoreinfo() {
        $data['company_info'] = $this->input->post('company_info');

        $result = $this->DASHBOARDMODEL->insertstoreinfo($data);

        if ($result) {
            $success = "
				Data successfully inserted!<br>
				";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/addstoreinfo');
        }
    }

    function viewstoreinfo() {
        $data['viewstoreinfo'] = $this->DASHBOARDMODEL->viewstoreinfo();
        $data['dashboardContent'] = $this->load->view('dashboard/viewstoreinfo', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function deletestoreinfo($id) {
        $this->DASHBOARDMODEL->deletestoreinfo($id);
        $success = 'Deleted Store Info Successfully !!!';
        $this->session->set_flashdata('success', $success);
        redirect('dashboardcontroller/viewstoreinfo');
    }

    function addvatrate() {
        $data['vatRate'] = $this->common_model->get_row('*', 'vat_info');
        $data['title'] = 'Add VAT Rate';
        $data['dashboardContent'] = $this->load->view('dashboard/addvatrate', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    function insertvat() {
        $data['vat_rate'] = $this->input->post('vat_rate');
        $result = $this->common_model->update('vat_info', array('id'=>$this->input->post('id')), $data);
        $this->session->set_flashdata('success', 'VAT has been updated');
        redirect('dashboardcontroller/viewvatinfo');
    }

    function viewvatinfo() {
        $data['title'] = 'VAT Info';
        $data['viewvatinfo'] = $this->DASHBOARDMODEL->viewvatinfo();
        $data['dashboardContent'] = $this->load->view('dashboard/viewvatinfo', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function deletevatinfo($id) {
        $this->DASHBOARDMODEL->deletevatinfo($id);
        $success = 'Deleted Store Info Successfully !!!';
        $this->session->set_flashdata('success', $success);
        redirect('dashboardcontroller/viewvatinfo');
    }

    function addcurrencyinfo() {
        $data['querycurrencytag'] = $this->DASHBOARDMODEL->querycurrencytag();
        $data['dashboardContent'] = $this->load->view('dashboard/addcurrencyinfo', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }

    function insertcurrencyinfo() {
        $data['currency_tag'] = $this->input->post('currency_tag');
        if (empty($data['currency_tag'])) {
            $failed = "
				Please enter Currency Sign!<br>
				";
            $this->session->set_flashdata('failed', $failed);
            redirect('dashboardcontroller/addcurrencyinfo');
        }

        $result = $this->DASHBOARDMODEL->insertcurrencyinfo($data);

        if ($result) {
            $success = "
				Data successfully inserted!<br>
				";
            $this->session->set_flashdata('success', $success);
            redirect('dashboardcontroller/addcurrencyinfo');
        }
    }

    function viewdashboarddata() {
        $directorId=$this->uri->segment('3');
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y-m-d');
        $today = $dt->format('Y/m/d');
        $year = $dt->format('Y');
        $month = $dt->format('m');
        $first_date = $year . "/" . $month . "/" . "01";
        $last_date = $year . "/" . $month . "/" . "31";


        $data['viewDirectorInfoLedger'] = $this->sm->viewDirectorLedger("rs_director_ledger", "director_ledger_id", "ASC", "directorId", $directorId,$first_date,$last_date);
        $data['title'] = "Director Statement(Current Month)";

        $this->load->view('dashboard/projectFolder/directorStatementDirectorPanel', $data);
    }
    function directorInstallment() {
        $data['viewdirectorInfo'] = $this->sm->orderByDataTwoField("rs_director_info", "director_id", "DESC", "Status", "ASC");
        $this->load->view('dashboard/projectFolder/directorInstallmentDashboard', $data);
    }
    function directorInstallmentCol() {
        $dt = new DateTime();
        $year = $dt->format('Y');
        $month = $dt->format('m');
        $first_date = $year . "/" . $month . "/" . "01";
        $last_date = $year . "/" . $month . "/" . "31";
        $data['viewDirectorInfoLedger'] = $this->sm->viewDirectorLedger("rs_director_ledger", "director_ledger_id", "ASC", "", "",$first_date,$last_date);
       $this->load->view('dashboard/projectFolder/directorInstallmentColDashboard', $data);
    }
    function directorMonthlyDue() {
        $dt = new DateTime();
        $year = $dt->format('Y');
        $month = $dt->format('m');
        $first_date = $year . "/" . $month . "/" . "01";
        $last_date = $year . "/" . $month . "/" . "31";
        $data['viewdirectorInfo'] = $this->sm->directorDueCal("rs_director_info", "director_id", "DESC", "Status", "ASC",$first_date,$last_date);
       $this->load->view('dashboard/projectFolder/directorMonthlyDueDashboard', $data);
    }

    function directorStatement() {
        $directorId=$this->uri->segment('3');
        if(isset($_POST['searchDateRange'])){
            extract($_POST);
            $expDate=explode("-",$date_range);
            $firstDate=$expDate[0];
            $lastDate=$expDate[1];
        }else{
            $firstDate='';
            $lastDate='';
        }
        $data['viewDirectorInfoLedger'] = $this->sm->viewDirectorLedger("rs_director_ledger", "director_ledger_id", "ASC", "directorId", $directorId,$firstDate,$lastDate);
        $data['title'] = "Director Statement";

       $this->load->view('dashboard/projectFolder/directorStatementDirectorPanel', $data);
    }

    function viewdashboarddata2($type) {
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y-m-d');
        $today = $dt->format('Y/m/d');
        $year = $dt->format('Y');
        $month = $dt->format('m');

        $first_date = $year . "/" . $month . "/" . "01";
        $last_date = $year . "/" . $month . "/" . "31";

        $data['first_date'] = $first_date;
        $data['last_date'] = $last_date;
        $data['type'] = $type;
        $data['querydueinvoiceid'] = $this->INVOICEMODEL->querydueinvoiceid();
        if($data['querydueinvoiceid']){
            $data['querytotalinvoicehistory'] = $this->INVOICEMODEL->queryinvoice($data['querydueinvoiceid'],$data['first_date'], $data['last_date']);    
        }else{
            $data['querytotalinvoicehistory'] = array();    
        }
        print $this->load->view('dashboard/viewdashboarddata', $data, TRUE);
    }
    
    //delete user
    function delete_user($id) {
        $this->common_model->delete('user', 'id', $id);
        $success = 'Data has been deleted';
        $this->session->set_flashdata('success', $success);
        redirect('dashboardcontroller/viewuserlist');
    }
    public function customerInvoiceInfo(){
        $dt = new DateTime();
        $data['current_date'] = $dt->format('Y-m-d');
        $customer_id=$this->session->userdata('master_id');
        $data['queryinvoice'] = $this->INVOICEMODEL->queryinvoice('',$customer_id,'','');
        $data['title'] = "View Invoice History";
        $data['dashboardContent'] = $this->load->view('dashboard/invoice/viewinvoice', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }
    public function installmentHistory(){
        $data['current_date'] = date('Y-m-d');
        $customer_id=$this->session->userdata('master_id');
        $data['get_installment_info'] = $this->INVOICEMODEL->get_all_installment_info('',$customer_id);
        $data['title'] = 'All Installment History';
        $data['dashboardContent'] = $this->load->view('dashboard/invoice/get_all_installment_info', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }public function customerDashboard(){
        $data['current_date'] = date('Y-m-d');
        $data['title'] = 'Customer Dashboard';
        $data['dashboardContent'] = $this->load->view('dashboard/customerDashboard', $data, TRUE);
        $this->load->view('dashboard/master_dashboard_panel', $data);
    }



}