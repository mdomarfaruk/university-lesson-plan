<?php
class Smodel extends CI_Model {
	public function _construct(){
          parent::_construct();
    }
	public function index(){
		return false;
	}
	
	public  function whereOrderDataSelect($select,$table,$orderbyField,$type,$whereField,$whereVal){
		$this->db->select($select);
		$this->db->where($whereField,$whereVal);
		$this->db->order_by($orderbyField,$type);
		$this->db->from($table);
		$query=$this->db->get();
		if($query->num_rows()>0) {
            return $query->result();
        }else{
		    return false;
        }
	}
	public  function whereOrderDataSelectWithMd5($select,$table,$orderbyField,$type,$whereField,$whereVal){
		$this->db->select($select);
		$this->db->where("md5(".$whereField.")",$whereVal);
		$this->db->where("status","1");
		$this->db->order_by($orderbyField,$type);
		$this->db->from($table);
		$query=$this->db->get();
		if($query->num_rows()>0) {
            return $query->result();
        }else{
		    return false;
        }
	}

	function whereOrderData($table,$orderbyField,$type,$whereField,$whereVal,$select=null){
		$this->db->select($select);
		$this->db->where($whereField,$whereVal);
		$this->db->order_by($orderbyField,$type);
		$this->db->from($table);
		$query=$this->db->get();
		return $query->result();
	}
	function getCouseInfo($table,$orderbyField,$type,$whereField,$whereVal){
		$this->db->select("$table.*");
		$this->db->where($whereField,$whereVal);
		$this->db->order_by($orderbyField,$type);

		$this->db->from($table);
		$query=$this->db->get();
		return $query->result();
	}
	function whereOrderDataMultiple($table,$orderbyField,$type,$whereField,$whereVal,$whereField1,$whereVal1,$select=null){
		$this->db->select($select);
		$this->db->where($whereField,$whereVal);
        $this->db->where($whereField1,$whereVal1);
		$this->db->order_by($orderbyField,$type);
		$this->db->from($table);
		$query=$this->db->get();
		return $query->result();
	}
	function whereOrderData2($table,$orderbyField,$whereField,$whereVal,$whereField1,$whereVal1,$type){
		$this->db->select('*');
		$this->db->where($whereField1,$whereVal1);
		$this->db->where($whereField,$whereVal);
		$this->db->order_by($orderbyField,$type);
		$this->db->from($table);
		$query=$this->db->get();
		return $query->result();
	}
	function whereOrderData3($table,$orderbyField,$whereField,$whereVal,$whereField1,$whereVal1,$whereField2,$whereVal2,$type){
		$this->db->select('*');
		$this->db->where($whereField2,$whereVal2);
		$this->db->where($whereField1,$whereVal1);
		$this->db->where($whereField,$whereVal);
		$this->db->order_by($orderbyField,$type);
		$this->db->from($table);
		$query=$this->db->get();
		return $query->result();
	}

	
	function orderByData($table,$orderbyField,$type){
		$this->db->select('*');
		$this->db->order_by($orderbyField,$type);
		$this->db->from($table);
		$query=$this->db->get();
		return $query->result();
	}
    function orderByDataTwoField($table,$orderbyField,$type,$orderbyField1,$type1){
        $this->db->select('*');
        $this->db->order_by($orderbyField,$type);
        $this->db->order_by($orderbyField1,$type1);
        $this->db->from($table);
        $query=$this->db->get();
        return $query->result();
    }
	
	function whereData($table,$whereField,$whereVal){
		$this->db->select('*');
		$this->db->where($whereField,$whereVal);
		$this->db->from($table);
		$query=$this->db->get();
		return $query->result();
	}
	function tableData($table){
		$this->db->select('*');
		$this->db->from($table);
		$query=$this->db->get();
		return $query->result();
	}
	
	function whereOrderLimit($table,$orderbyField,$whereField,$whereVal,$type,$limit,$start){
		$this->db->select('*');
		$this->db->where($whereField,$whereVal);
		$this->db->order_by($orderbyField,$type);
		$this->db->from($table);
		$this->db->limit($limit,$start);
		$query=$this->db->get();
		return $query->result();
	}
	function fetchData($table,$whereMatchField,$whereMatchValue){
		return $row = $this->db->get_where($table, array($whereMatchField => $whereMatchValue))->row();
	}
	function fetchData2($table,$whereMatchField,$whereMatchValue,$whereMatchField1,$whereMatchValue1){
		return $row = $this->db->get_where($table, array($whereMatchField => $whereMatchValue,$whereMatchField1 => $whereMatchValue1))->row();
	}
    public  function getRow($table,$whereMatchField,$whereMatchValue){
         $row = $this->db->get_where($table, array($whereMatchField => $whereMatchValue));
         if($row->num_rows()>0){
             return $row->row();
         }else{
             return false;
         }

    }
    public  function existFoundProject($table,$whereMatchField,$whereMatchValue){
         $row = $this->db->get_where($table, array($whereMatchField => $whereMatchValue,'status !='=>3));
         if($row->num_rows()>0){
             return true;
         }else{
             return false;
         }

    }
    public  function count_floor_ctg_unit($project_id,$unit_ctg){
         $row = $this->db->select('count(rs_floor_unit.id) as count_ctg_id',false)->join("rs_project_floor","rs_project_floor.id=rs_floor_unit.floor_id","inner")->get_where('rs_floor_unit', array('rs_floor_unit.unit_category' => $unit_ctg,'rs_floor_unit.status'=>1,'rs_project_floor.project_id'=>$project_id));
         if($row->num_rows()>0){
             return $row->row()->count_ctg_id;
         }else{
             return false;
         }

    }

    function fetchDataHits($table,$whereMatchField,$whereMatchValue){
	    $this->db->where($whereMatchField,$whereMatchValue);
	    $this->db->from($table);
	    $this->db->limit('1');
	    $this->db->order_by("id","DESC");
	    $query=$this->db->get();
        return $query->row();

    }
    function md5ToPlanText($table,$whereMatchField,$whereMatchValue){
        $this->db->select($whereMatchField);
        $this->db->where('md5('.$whereMatchField.')', $whereMatchValue);
        $row = $this->db->get($table)->row();
        return $row->$whereMatchField;
    }
	function fetchDataOne($table,$whereMatchField,$whereMatchValue,$fetchField){
		return $row = $this->db->get_where($table, array($whereMatchField => $whereMatchValue))->row()->$fetchField;
	}
	function statusView($status){
		if($status==1){
			return "<p style='color:green;font-weight:bold'>Active</p>";
		}elseif($status==2){
			return "<p style='color:red;font-weight:bold'>Inactive</p>";
		}else{
			return "No Select";
		}
		
	}function statusViewDirector($status){
		if($status==1){
			return "<p style='color:green;font-weight:bold'>Running</p>";
		}elseif($status==2){
			return "<p style='color:red;font-weight:bold'>Inactive</p>";
		}elseif($status==3){
			return "<p style='color:red;font-weight:bold'>Closed</p>";
		}else{
			return "No Select";
		}

	}function directorType($status){
		if($status==1){
			return "<p >Director</p>";
		}elseif($status==2){
			return "<p >Share Holder</p>";
		}else{
			return "No Select";
		}

	}
	public function SearchingName($userName){
		$qu=$this->db->query("select user_name from all_admin where user_name='$userName'");
		$num_rows=$qu->num_rows();
		if($num_rows>0){
			return true;
		}
	}
	
	public function tkconvert($number){
		if (($number < 0) || ($number > 999999999)) {
			throw new Exception("Number is out of range");
		}
		$Gn = floor($number / 1000000);
		$number -= $Gn * 1000000;
		$kn = floor($number / 1000);
		$number -= $kn * 1000;
		$Hn = floor($number / 100);
		$number -= $Hn * 100;
		$Dn = floor($number / 10);
		$n = $number % 10;
		$res = "";

		if ($Gn) {
			$res .= $this->tkconvert($Gn) .  "Million";
		}

		if ($kn) {
			$res .= (empty($res) ? "" : " ") .$this->tkconvert($kn) . " Thousand";
		}

		if ($Hn) {
			$res .= (empty($res) ? "" : " ") .$this->tkconvert($Hn) . " Hundred";
		}

		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
		$tens = array("", "", "Twenty", "Twenty One", "Twenty Two", "Twenty Three", "Twenty Four","Twenty Five","Twenty Six", "Twenty Seven", "Twenty Seven", "Twenty Nine");

		if ($Dn || $n) {
			if (!empty($res)) {
				$res .= " ";
			}
			if ($Dn < 2) {
				$res .= $ones[$Dn * 10 + $n];
			} else {
				$res .= $tens[$Dn];
				if ($n) {
					$res .= "-" . $ones[$n];
				}
			}
		}
		if (empty($res)) {
			$res = "Zero";
		}
		return $res;
	}
	
	public function todayPatienEntry($tableName,$sumField,$whereField){
		$date=date("Y-m-d");
		$this->db->select('count('.$sumField.') as total');
		$this->db->where('date('.$whereField.')', $date);
		$q=$this->db->get($tableName);
		$row=$q->row();
		if($row->total!=''){
			return $row->total;
		}else{
			return 0;
		}
	}
	public function total_count($tableName,$sumField,$whereField,$type=NULL){

		$this->db->select('count('.$sumField.') as total');
		if(!empty($whereField)) {
            $this->db->where($whereField.'!=', 3);
        }if(!empty($type)) {
            $this->db->where($type);
        }
		$q=$this->db->get($tableName);
		$row=$q->row();
		if($row->total!=''){
			return $row->total;
		}else{
			return 0;
		}
	}
	public function totalPatienEntry($tableName,$sumField,$whereField){
		$this->db->select('count('.$sumField.') as total');
		$q=$this->db->get($tableName);
		$row=$q->row();
		if($row->total!=''){
			return $row->total;
		}else{
			return 0;
		}
	}
	
	function translate_to_words($number) {
        $max_size = pow(10, 18);
        if (!$number)
            return "zero";
        if (is_int($number) && $number < abs($max_size)) {
            $prefix = '';
            $suffix = '';
            switch ($number) {
                // setup up some rules for converting digits to words
                case $number < 0:
                    $prefix = "negative";
                    $suffix = $this->translate_to_words(-1 * $number);
                    $string = $prefix . " " . $suffix;
                    break;
                case 1:
                    $string = "one";
                    break;
                case 2:
                    $string = "two";
                    break;
                case 3:
                    $string = "three";
                    break;
                case 4:
                    $string = "four";
                    break;
                case 5:
                    $string = "five";
                    break;
                case 6:
                    $string = "six";
                    break;
                case 7:
                    $string = "seven";
                    break;
                case 8:
                    $string = "eight";
                    break;
                case 9:
                    $string = "nine";
                    break;
                case 10:
                    $string = "ten";
                    break;
                case 11:
                    $string = "eleven";
                    break;
                case 12:
                    $string = "twelve";
                    break;
                case 13:
                    $string = "thirteen";
                    break;
                // fourteen handled later
                case 15:
                    $string = "fifteen";
                    break;
                case $number < 20:
                    $string = $this->translate_to_words($number % 10);
                    // eighteen only has one "t"
                    if ($number == 18) {
                        $suffix = "een";
                    } else {
                        $suffix = "teen";
                    }
                    $string .= $suffix;
                    break;
                case 20:
                    $string = "twenty";
                    break;
                case 30:
                    $string = "thirty";
                    break;
                case 40:
                    $string = "forty";
                    break;
                case 50:
                    $string = "fifty";
                    break;
                case 60:
                    $string = "sixty";
                    break;
                case 70:
                    $string = "seventy";
                    break;
                case 80:
                    $string = "eighty";
                    break;
                case 90:
                    $string = "ninety";
                    break;
                case $number < 100:
                    $prefix = $this->translate_to_words($number - $number % 10);
                    $suffix = $this->translate_to_words($number % 10);
                    //$string = $prefix . "-" . $suffix;
                    $string = $prefix . " " . $suffix;
                    break;
                // handles all number 100 to 999
                case $number < pow(10, 3):
                    // floor return a float not an integer
                    $prefix = $this->translate_to_words(intval(floor($number / pow(10, 2)))) . " hundred";
                    if ($number % pow(10, 2))
                        $suffix = " and " . $this->translate_to_words($number % pow(10, 2));
                    $string = $prefix . $suffix;
                    break;
                case $number < pow(10, 6):
                    // floor return a float not an integer
                    $prefix = $this->translate_to_words(intval(floor($number / pow(10, 3)))) . " thousand";
                    if ($number % pow(10, 3))
                        $suffix = $this->translate_to_words($number % pow(10, 3));
                    $string = $prefix . " " . $suffix;
                    break;
            }
        } else {
            echo "ERROR with - $number Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
        }
        return $string;
    }
    function get_bd_amount_in_text($amount) {

        $output_string = '';

        $tokens = explode('.', $amount);
        $current_amount = $tokens[0];
        $fraction = '';
        if (count($tokens) > 1) {
            $fraction = (double) ('0.' . $tokens[1]);
            $fraction = $fraction * 100;
            $fraction = round($fraction, 0);
            $fraction = (int) $fraction;
            $fraction = $this->translate_to_words($fraction) . ' Poisa';
            $fraction = ' Taka & ' . $fraction;
        }

        $crore = 0;
        if ($current_amount >= pow(10, 7)) {
            $crore = (int) floor($current_amount / pow(10, 7));
            $output_string .= $this->translate_to_words($crore) . ' crore ';
            $current_amount = $current_amount - $crore * pow(10, 7);
        }

        $lakh = 0;
        if ($current_amount >= pow(10, 5)) {
            $lakh = (int) floor($current_amount / pow(10, 5));
            $output_string .= $this->translate_to_words($lakh) . ' lac ';
            $current_amount = $current_amount - $lakh * pow(10, 5);
        }

        $current_amount = (int) $current_amount;
        $output_string .= $this->translate_to_words($current_amount);

        $output_string = $output_string . ' taka only';
        $output_string = ucwords($output_string);
        return $output_string;
    }
	public function getLastData($table,$maxField){
		$lastId=$this->db->query("select max($maxField) as maxId from $table ")->row()->maxId;
		return $finalId=$lastId+1;
	}
	public function checkGender($status){
		if($status==1){
			return "Male";
		}elseif($status==2){
			return "Female";
		}elseif($status==3){
			return "Other";
		}
	}
	public function deleteUserInfo($table,$field,$val){
		$this->db->where($field,$val);
		$del=$this->db->delete($table);
		if($del){
			return true;
		}
	}
	public function memberShipStatus($status){
		if($status==1){
			return "<span style='color:red;font-weight:bold'>Waiting for Approval</span>";
		}else{
			return "<span style='color:green;font-weight:bold'>Approved</span>";
		}
	}
	
	public function latestMemberId(){
		$lasMemberId=$this->db->query("select * from  general_info order by member_id desc limit 1")->row();
		$finalId=$lasMemberId->member_id;
		$latestMember=$finalId+1;
		return $memberId=date('Ymd').$latestMember;
	}

	public function viewMaxIdCertifcate(){
        $lastId=$this->db->query("select max(certificate_id) as maximuId from student_certificate ")->row();
        return $finalId=$lastId->maximuId+1;
	}
	public  function employerInformation(){
        $mem_id=$this->session->userdata('memberId');
        return $this->sm->fetchData("employers","id",$mem_id);
	}public  function jobsCat(){
        return $this->orderByData("jobscat","id","ASC");
	}public  function joblevel(){
        return $this->orderByData("joblevel","id","ASC");
	}

    public function jobsSts($id){
        if ($id==1) $var='<a href="javascript:void(0);" style="color:green">Published</a>';
        if ($id==2) $var='<a href="javascript:void(0);">Waiting for Approval</a>';
        if ($id==3) $var='<a href="javascript:void(0);">Pending</a>';
        if ($id==4) $var='<a href="javascript:void(0);">Canceled</a>';
        if ($id==5) $var='<a href="javascript:void(0);">Drafted</a>';
        return $var;
    }
    public function JobByEmphome($id){
        $cDate=date('Y-m-d');
        $q=$this->db->query("SELECT id,title FROM jobs WHERE employee_id='$id' AND status=1 and  date(deadline)>='$cDate' ORDER BY id DESC");
        return $q->result();
    }
    public function totJobsbyCat($cid){
        $cdate=date('Y-m-d');
        $query=$this->db->query("SELECT count(*) as Total FROM jobs WHERE job_ctg='$cid' AND status='1' and deadline>='$cdate'");
        $row=$query->row();
        return $row->Total;
    }
    public function jobscatbyid($id){
        $query=$this->db->query("SELECT jobscat as title FROM jobscat WHERE id='$id' LIMIT 1");
        $row=$query->row();
        if ($query->num_rows()==0) $title='';
        else $title=$row->title;
        return $title;
    }
    public function jobscatbyidMd52($id){
        $query=$this->db->query("SELECT jobscat as title FROM jobscat WHERE md5(md5(id))='$id' LIMIT 1");
        $row=$query->row();
        if ($query->num_rows()==0) $title='';
        else $title=$row->title;
        return $title;
    }
    public function jobCtgCountLiveJostPost($table,$whereField,$whereData,$whereField1,$whereData1){
        $this->db->where($whereField1, $whereData1);
        $this->db->where($whereField, $whereData);
        return  $this->db->count_all_results($table);
    }
    public function isApplied($jid){
        $uid=$this->session->userdata('memberId');
        $this->db->select('*')->from('jobapplied')->where('jobs_seeker_id',$uid)->where('job_post_Id',$jid)->limit('1')->get()->row();
        $aff_row=$this->db->affected_rows();
        if($aff_row==1){ return TRUE; }else{ return FALSE; }
    }
    public function applyByJob($jid){
        $query=$this->db->query("SELECT COUNT(*) as TOTAL FROM jobapplied WHERE job_post_Id='$jid'");
        $row=$query->row();
        return $row->TOTAL;
    }
    public  function totalApplyJob($jid){
        return $this->db->select('COUNT(id) AS countData', false)
                    ->from('jobapplied')
                    ->where('job_post_Id', $jid)
                    ->get()->row()->countData;
    }
    public  function vList($jid){
        return $this->db->select('COUNT(id) AS countData', false)
                    ->from('jobapplied')
                    ->where('job_post_Id', $jid)
                    ->where('vlist', '1')
                    ->get()->row()->countData;
    }
//id, emp_id, jobs_seeker_id, job_post_Id, slist, wlist, rlist, vlist, downoad_cv, up_date, status, esallery, apply_date
    public  function shortList($jid){
        return $this->db->select('COUNT(id) AS countData', false)
                    ->from('jobapplied')
                    ->where('job_post_Id', $jid)
                    ->where('slist', '1')
                    ->get()->row()->countData;
    }public  function watchList($jid){
        return $this->db->select('COUNT(id) AS countData', false)
                    ->from('jobapplied')
                    ->where('job_post_Id', $jid)
                    ->where('wlist', '1')
                    ->get()->row()->countData;
    }public  function rlist($jid){
        return $this->db->select('COUNT(id) AS countData', false)
                    ->from('jobapplied')
                    ->where('job_post_Id', $jid)
                    ->where('rlist', '1')
                    ->get()->row()->countData;
    }
    public  function nvList($jid){
        return $this->db->select('COUNT(id) AS countData', false)
                    ->from('jobapplied')
                    ->where('job_post_Id', $jid)
                    ->where('slist', '0')
                    ->where('rlist', '0')
                    ->where('wlist', '0')
                    ->where('vlist', '0')
                    ->get()->row()->countData;
    }
    public function getTitle($id){
        $query=$this->db->query("SELECT title FROM jobs WHERE id='$id' LIMIT 1");
        $row=$query->row();
        return $row->title;
    }
    function calculate_age($birthday){
        $today = new DateTime();
        $diff = $today->diff(new DateTime($birthday));

        if ($diff->y)
        {
            return $diff->y . ' yrs';
        }
        elseif ($diff->m)
        {
            return $diff->m . ' months';
        }
        else
        {
            return $diff->d . ' days';
        }
    }

    function viewAllApplicantInfo($id){
        $this->db->select('general_info.*,jobapplied.*');
        $this->db->from('jobapplied');
        $this->db->join('general_info', 'general_info.member_id = jobapplied.jobs_seeker_id', 'left');
        $this->db->where('jobapplied.job_post_Id',$id);
        $query = $this->db->get();
        return $query->result();

    }
    public function viewMemberType($status){
        if($status=='1'){
            return "Professional";
        }elseif($status=='2'){
            return "Student";
        }elseif($status=='3'){
            return "General Job Seeker";
        }
    }

    public function currentJobInfo($cDate){

        return $this->db->query("select j.id, e.id, e.company_name, e.logo,e.is_custom_logo,e.custom_logo , j.deadline from   jobs j left join employers e   on e.id=j.employee_id  where  j.status='1' and date(j.deadline)>='$cDate' group by e.id order by j.id desc ");
    }

    public function viewUser($id,$cid){
        $this->db->select('*')
                 ->where('jobs_seeker_id',$id)
                 ->where('emp_id',$cid)
                 ->where('vlist','1');
        $query=$this->db->from("jobapplied");
        $getData=$query->get();
        $getData->row();
        return $count_row=$this->db->affected_rows();
        if($count_row > 0){ return 1; }else{ return 0; }

    }
    public  function differenceTwodate($start,$end){
        $date3 = date_create($start);
        $date4 = date_create($end);
        $diff34 = date_diff($date4, $date3);
        $days = $diff34->d;
        $months = $diff34->m;
        $years = $diff34->y;
        if($months!='0'){
            $monthCal= ', '.$months . ' month ';
        }else{
            $monthCal='';
        }
        if($years!='0'){
            $yearCal=', '.$years . ' year';
        }else{
            $yearCal='';
        }
        return   $days . ' day ' . $monthCal . $yearCal ;
    }
    public function memberLoginStatusCheck(){
        $userType=$this->session->userdata('userType');
        $logonStatus=$this->session->userdata('loged_in');
        if($logonStatus==1 && ($userType==1 || $userType==2 || $userType==3)){
            return true;
        }else{
            return false;
        }
    }

    public function viewDirectorLedger($table,$orderbyField,$type,$whereField,$whereVal,$first=Null,$last=Null){
        $this->db->select("$table.*,t.tr_method,t.b_id,t.chq_no,t.rec_no,b.acc_no,b.acc_no,b.b_branch,b.b_name,d.name directorName, d.mobile directorMobile");
        $this->db->from($table);
        $this->db->join('transaction_summary as t', "$table.reference_id = t.id", 'left');
        $this->db->join('bank_details as b', 'b.id = t.b_id', 'left');
        $this->db->join('rs_director_info as d', "d.director_id = $table.directorId", 'left');
        if($whereField!='') {
            $this->db->where($whereField, $whereVal);
        }
        if($first!=''){
            $this->db->where("$table.trans_date >=", $first);
            $this->db->where("$table.trans_date <=", $last);
        }
        $this->db->order_by($orderbyField,$type);

        $query=$this->db->get();
        return $query->result();
    }
    public  function directorPresentVal($jid){
         $val=$this->db->select('sum(amount) AS countData', false)
            ->from('rs_director_ledger')
            ->where('directorId', $jid)
            ->get()->row()->countData;
        if($val!=''){
            return $val;
        }else{
            return "0.00";
        }
    }
    public function insertIssueItem($new) {
        $this->db->insert('rs_issue_item', $new);
        return true;
    }
    public function viewIssueInvoiceDate($invoice_id) {
        $this->db->select('rs_issueinfo.*,rs_project_info.name proName,rs_project_info.address proAddress');
        $this->db->from('rs_issueinfo');
        $this->db->join('rs_project_info', 'rs_issueinfo.project_id = rs_project_info.project_id', 'left');

        $this->db->where('issue_id', $invoice_id);
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }
    public function viewAllIssue($first,$last,$project) {
        $this->db->select('rs_issueinfo.*,rs_project_info.name proName,rs_project_info.address proAddress');
        $this->db->from('rs_issueinfo');
        $this->db->join('rs_project_info', 'rs_issueinfo.project_id = rs_project_info.project_id', 'left');
        if($project!=''){
            $this->db->where("rs_issueinfo.project_id",$project);
        }
        if($first!=''){
            $this->db->where("rs_issueinfo.issue_date >= ",$first);
            $this->db->where("rs_issueinfo.issue_date <= ",$last);
        }
        $this->db->order_by("rs_issueinfo.issue_id","DESC");
         $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }
    public function issueItemInfo($invoice_id) {
        $this->db->select('purchase_item.*,item.item_name,item.item_code, item.model,item_unit_info.title');
        $this->db->from('purchase_item');
        $this->db->where('purchase_id', $invoice_id);
        $this->db->join('item', 'purchase_item.product_id = item.item_id', 'left');
        $this->db->join('item_unit_info', 'item_unit_info.unit_id = item.item_id', 'left');
        $this->db->order_by('purchase_item.id', 'ASC');
        return $this->db->get()->result();
    }
    public  function sumOfSale($jid){
        $val=$this->db->select('sum(grand_total) AS grand_total', false)
            ->from(' invoice')
            ->where('project_id', $jid)
            ->get()->row()->grand_total;
        if($val!=''){
            return $val;
        }else{
            return "0.00";
        }
    }
    public  function sumOfInvestment($jid){
        $val=$this->db->select('sum(amount) AS countData', false)
            ->from('rs_director_ledger')
            ->where('projectID', $jid)
            ->get()->row()->countData;
        if($val!=''){
            return $val;
        }else{
            return "0.00";
        }
    }public  function sumOfIssue($jid){
        $val=$this->db->select('sum(issue_amount) AS countData', false)
            ->from('rs_issueinfo')
            ->where('project_id', $jid)
            ->get()->row()->countData;
        if($val!=''){
            return $val;
        }else{
            return "0.00";
        }
    }
    public  function sumOfExpensOfProject($jid){
        $val=$this->db->select('sum(cash_amount) AS countData', false)
            ->from('expense_history')
            ->where('expense_type', "2")
            ->where('projectId', $jid)
            ->get()->row()->countData;
        if($val!=''){
            return $val;
        }else{
            return "0.00";
        }
    }
    public  function sumOfInvestmentDirctor($first,$last,$jid){
        $this->db->select('sum(amount) AS countData', false);
        $this->db->from('rs_director_ledger');
        if($first!=''){
            $this->db->where('trans_date >=', $first);
            $this->db->where('trans_date <=', $last);
        }
            $this->db->where('directorId', $jid);
        $val=$this->db->get()->row()->countData;
        if($val!=''){
            return $val;
        }else{
            return "0.00";
        }
    }
    public function insert_data($table, $data){
	    $this->db->db_debug==false;
	    if(!empty($data)){
            $this->db->trans_start();
	        $this->db->insert($table,$data);
            $inserted_id=$this->db->insert_id();
	        $this->db->trans_complete();
	        if($this->db->error()['code']>0){
                $this->db->trans_rollback();
	            return['status'=>'error','message'=>$this->db->error()['code'],'data'=>''];
            }else{
                $this->db->trans_commit();
                return['status'=>'success','message'=>'Successfully added information','data'=>$inserted_id];
            }

        }else{
            $this->db->trans_rollback();
            return['status'=>'error','message'=>$this->db->error()['code'],'data'=>''];
        }
    }
    public function update_data($table, $data,$where){
	    $this->db->db_debug==false;
	    if(!empty($data)){
            $this->db->trans_start();
            $this->db->where($where);
	        $this->db->update($table,$data);
	        $this->db->trans_complete();
	        if($this->db->error()['code']>0){
                $this->db->trans_rollback();
	            return['status'=>'error','message'=>$this->db->error()['code'],'data'=>''];
            }else{
                $this->db->trans_commit();
                return['status'=>'success','message'=>'Successfully update information','data'=>''];
            }

        }else{
            $this->db->trans_rollback();
            return['status'=>'error','message'=>$this->db->error()['code'],'data'=>''];
        }
    }

    public function view_all_lesson_info(){
	    $this->db->select("le_lesson_plan_info.*,session_info.session_name session_name,session_info.batch_name,IF(session_info.shift_name=1,'Day','Evening') as shift_name,room_info.title room_name,teacher_info.teacher_code,teacher_info.name,teacher_info.mobile,con_course_info.title course_name");
        $this->db->where("le_lesson_plan_info.status",1);
        $this->db->order_by("le_lesson_plan_info.id","DESC");
        $this->db->join("session_info","session_info.id=le_lesson_plan_info.session_id","left");
        $this->db->join("con_course_info","con_course_info.id=le_lesson_plan_info.course_id","left");
        $this->db->join("con_all_setting room_info","room_info.id=le_lesson_plan_info.room_no","left");
        $this->db->join("teacher_info","teacher_info.id=le_lesson_plan_info.course_teacher","left");
        if($this->session->userdata('master_id') != '-1'){
            $this->db->where("course_teacher",$this->session->userdata('shohozit_user_id'));
        }
        $this->db->from("le_lesson_plan_info");
        $query=$this->db->get();
        if($query->num_rows()>0) {
            return $query->result();
        }else{
            return false;
        }
    }

    public function view_single_lesson_info($lesson_plan_id){
        $this->db->select("le_lesson_plan_info.*,session_info.session_name session_name,session_info.batch_name,IF(session_info.shift_name=1,'Day','Evening') as shift_name,room_info.title room_name,teacher_info.teacher_code,teacher_info.name,teacher_info.mobile,con_course_info.title course_name,con_course_info.credit,con_course_info.course_code");
        $this->db->where("md5(le_lesson_plan_info.id)",$lesson_plan_id);
        $this->db->order_by("le_lesson_plan_info.id","DESC");
        $this->db->join("session_info","session_info.id=le_lesson_plan_info.session_id","left");
        $this->db->join("con_course_info","con_course_info.id=le_lesson_plan_info.course_id","left");
        $this->db->join("con_all_setting room_info","room_info.id=le_lesson_plan_info.room_no","left");
        $this->db->join("teacher_info","teacher_info.id=le_lesson_plan_info.course_teacher","left");
        $this->db->from("le_lesson_plan_info");
        $query=$this->db->get();
        if($query->num_rows()>0) {
            return $query->row();
        }else{
            return false;
        }
    }
    public function getCourseAssingInfo(){
        $user_role = $this->session->userdata('shohozit_role');
		$this->db->select("course_session_relation.id,course_session_relation.teacher_id,course_session_relation.session_id,course_session_relation.course_id,course_session_relation.status ,session_info.session_name,session_info.batch_name,IF(session_info.shift_name=1,'Day','Evening') as shift_name,con_course_info.title as course_title,con_course_info.course_code,con_course_info.credit,teacher_info.teacher_code,teacher_info.name teacher_name",false);
        $this->db->join("teacher_info","teacher_info.id=course_session_relation.teacher_id","left");
        $this->db->join("con_course_info","con_course_info.id=course_session_relation.course_id","left");
        $this->db->join("session_info","session_info.id=course_session_relation.session_id","left");
        if(!in_array($user_role,['super_admin','superadmin'])){
        	$this->db->where("course_session_relation.teacher_id",$this->session->userdata('master_id'));
		}
		$this->db->order_by("id","DESC");
		$row_data=$this->db->get("course_session_relation");
		if($row_data->num_rows()>0){
			return $row_data->result();
		}else{
			return false;
		}
	}

   public function getSessionCourseInfo($session_id){
        $this->db->select("con_course_info.title courseTtile,course_session_relation.id as assign_id");
        $this->db->where("course_session_relation.session_id",$session_id);
        $this->db->where("course_session_relation.status",1);
        $this->db->where("course_session_relation.teacher_id",$this->session->userdata('master_id'));
        $this->db->join("con_course_info","course_session_relation.course_id=con_course_info.id","INNER");
        $this->db->order_by("course_session_relation.id","DESC");
        $this->db->from("course_session_relation");
        $query=$this->db->get();
        if($query->num_rows()>0) {
            return $query->result();
        }else{
            return false;
        }
    }

    public function duplicate_course_assign_check($receive,$update_id=NULL){
	    $this->db->select('id');
	    $this->db->where($receive);
//	    todo: when Update
	    if(!empty($update_id)){
	        $this->db->where("id != ",$update_id);
        }
	    $query = $this->db->get("course_session_relation");
	    if($query->num_rows()>0){
//	        exist data found
	        return ['status'=>'error','message'=>'Already assigned this course in this teacher','data'=>''];
        }else{
            return ['status'=>'success','message'=>'Valid data,no assign person found ','data'=>''];
        }
    }
    public function duplicate_session_name($receive,$update_id=NULL){
	    $this->db->select('id');
	    $this->db->where($receive);
//	    todo: when Update
	    if(!empty($update_id)){
	        $this->db->where("id != ",$update_id);
        }
	    $query = $this->db->get("session_info");
	    if($query->num_rows()>0){
//	        exist data found
	        return ['status'=>'error','message'=>'Already added this session and batch','data'=>''];
        }else{
            return ['status'=>'success','message'=>'Valid data,no added  found ','data'=>''];
        }
    }







}
?>
