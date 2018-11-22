<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TrialExpired extends CI_Controller {

    function __construct() { 
        parent::__construct();
        $this->load->model('common_model/common_model');
        date_default_timezone_set('Asia/Dhaka');
    }
    
    function index() { 
        $this->timebomb();
    }
    
    function timebomb(){
      //  $this->load->view('auth/login');

        $today = date("Y-m-d");
        $trialPeriod = 20;
        $startDate = date("Y-m-d");
        $getExpiryDate = strtotime('+'.$trialPeriod."days", strtotime($startDate));
        $expiryDate = date("Y-m-d", $getExpiryDate);

        $checkStatus = $this->common_model->get_row('*', 'timebomb');


        if(!$checkStatus){
            $this->redirect();
        }else{
            if($checkStatus['id'] != 1 || empty($checkStatus['StartDate']) || empty($checkStatus['ExpiryDate']) || empty($checkStatus['code']) || empty($checkStatus['status'])){
                $this->redirect();
            }else{
                $getPeriod = $this->common_model->get_row('*', 'timebomb');


                if(strlen($getPeriod['ExpiryDate']) != 16){
                    $this->redirect();
                }else{
                    if(substr($getPeriod['ExpiryDate'], -2) != '=='){
                        $this->redirect();
                    }else{
                        $endOfTrial = $this->textDecode($getPeriod['ExpiryDate']);
                       // $endOfTrial = "2017-10-10";
                        $explode = explode('-', $endOfTrial);


                        if(strlen($explode[0])!=4 && strlen($explode[1])!=2 && strlen($explode[2])!=2){
                            $this->redirect();
                        }else{
                            if(!is_numeric($explode[0]) || !is_numeric($explode[1]) || !is_numeric($explode[2])){
                                $this->redirect();
                            }else{
                                if($endOfTrial == $today || $endOfTrial < $today){
                                    $data['title'] = "Extension Required";
                                    $this->load->view('trialExpired/trialExpired', $data);
                                }else{
                                    $this->load->view('auth/login');
                                }
                            }

                        }
                    }
                }

            }

        }

    }    
    function updateTrial(){

        $input = $this->textDecode($this->input->post('code'));      
        $explode = (explode("-", $input));

        if(isset($explode[0]) && isset($explode[1]) && isset($explode[2]) && isset($explode[3])){
            $code = md5($this->textEncode($explode[0]."-".$explode[1]."-".$explode[3]));
        }else{
            $msg = "Invalid Code Format";
            $this->session->set_flashdata('failed', $msg);
            redirect('trialExpired/trialExpired');
        }
        
        $trialPeriod = $explode[2];               
        $row = $this->common_model->get_row('*', 'timebomb', array('code'=>$code));
        
        if($row){ 
            if($row['id'] != 1){
                $msg = "Modified the database table, please contact to Shohozit";
                $this->session->set_flashdata('failed', $msg);
                redirect('trialExpired/trialExpired');
            }

            $prev_date = $this->textDecode($row['ExpiryDate']);          
            $getExpiryDate = strtotime('+'.$trialPeriod."days", strtotime($prev_date));
            $expiryDate = $this->textEncode(date("Y-m-d", $getExpiryDate));
            $int = intval(preg_replace('/[^0-9]+/', '', $explode['1'])) + 1;
            $new_code = "a".$int."a"; 
            $update_code = $explode[0]."-".$new_code."-".$explode[3]; 
            $encoded = md5($this->textEncode($update_code)); 

            $data = array('ExpiryDate'=>$expiryDate, 'code'=>$encoded, 'status'=>$int);
            $this->common_model->update('timebomb', array('id'=>$row['id']), $data);
            
            $msg = "Congrats! your trial has been extended for $trialPeriod days";
            $this->session->set_flashdata('success', $msg);
            redirect('dashboardcontroller');
        }else{
            $msg = "Invalid Code";
            $this->session->set_flashdata('failed', $msg);
            redirect('trialExpired/trialExpired');
       }
    }
    function textEncode($string){
        return base64_encode($string);
    }
    function textDecode($string){
        return base64_decode($string);
    }
    function redirect(){
        $data['msg'] = "Extension Table has been modified";
        $this->load->view('trialExpired/trialExpired', $data);    
    }
    function newDecodeFile(){
        echo $date=("2018-11-11");
        echo "<br/>";
        echo base64_encode($date);
        // previous
        //MjAxNy0wNy0yMA==
    }

}