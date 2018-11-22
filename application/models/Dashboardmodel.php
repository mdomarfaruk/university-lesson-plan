<?php
class Dashboardmodel extends CI_Model {
    public function hash($string) {
        return hash('sha512', $string);
    }

    public function viewuserlist() {
        $role = $this->session->userdata('shohozit_role');
        $this->db->select('*');
        $this->db->from('user');
            if($role != "super_admin"){
                $this->db->where('role !=', "super_admin");
            }
            $this->db->order_by("id","ASC");
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function activateuser($id, $info_data) {
        $this->db->where('id', $id);
        $this->db->update('user', $info_data);
        return TRUE;
    }

    public function inactivateuser($id, $info_data) {
        $this->db->where('id', $id);
        $this->db->update('user', $info_data);
        return TRUE;
    }

    public function changepassword($id, $data) {
        $this->db->where('id', $id);
        $result = $this->db->update('user', $data);
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function querytotalsale() {
        $this->db->select('SUM(sub_total)+ sum(vat_amount) as grand_total', FALSE);
        $this->db->from('invoice');
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }

    public function querytotaldue($data) {
        if(!empty($data)) {
            $values = array_map('array_pop', $data);
            $this->db->select('SUM(invoice.due_amount) as due_amount');
            $this->db->from('invoice');
            $this->db->join('customer', 'invoice.cst_id = customer.cst_id', 'left');
            $this->db->where_in('invoice.id', $values);
            $this->db->order_by("invoice.id", "desc");
            $query_results = $this->db->get();
            $results = $query_results->row();
            return $results;
        }
    }

    public function querytotaloverdue($enddate) {
        $this->db->select('SUM(due_amount) as due_amount', FALSE);
        $this->db->from('invoice');
        $this->db->where('due_date <', $enddate);
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }

    public function querycurrenttotalsale($first_date, $last_date) { 
       $this->db->select('SUM(sub_total)+ sum(vat_amount) as grand_total', FALSE);
        $this->db->from('invoice');
        $this->db->where('due_date >=', $first_date);
        $this->db->where('due_date <=', $last_date);
        return $this->db->get()->row();
        
    }

    public function querycurrenttotaldue($data,$first_date, $last_date) {
        if(!empty($data)) {
            $values = array_map('array_pop', $data);
            $this->db->select('SUM(invoice.due_amount) as due_amount');
            $this->db->from('invoice');
            if ($first_date != '') {
                $this->db->where('invoice_date >=', $first_date);
                $this->db->where('invoice_date <=', $last_date);
            }
            $this->db->join('customer', 'invoice.cst_id = customer.cst_id', 'left');
            $this->db->where_in('invoice.id', $values);
            $this->db->order_by("invoice.id", "desc");
            $query_results = $this->db->get();
            $results = $query_results->row();
            return $results;
        }else{
            return 0;
        }
        
    }
    function collection($first_date=null, $last_date=null) {
        $this->db->select('SUM(first_payment) as collection');
        $this->db->from('dues');
        if($first_date){
            $this->db->where('dues.payment_date >=', $first_date);
            $this->db->where('dues.payment_date <=', $last_date);
        }
        return $this->db->get()->row();  
    }

    public function querytotalinvoicehistory($first_date, $last_date) {
        $this->db->select('invoice.*,customer.cst_company');
        $this->db->from('invoice');
        $this->db->join('customer', 'invoice.cst_id = customer.cst_id', 'left');
        $this->db->where('invoice.due_date >=', $first_date);
        $this->db->where('invoice.due_date <=', $last_date);
        $this->db->order_by("invoice.id", "DESC");
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function querytotalinvoicehistory2() {
        $this->db->select('invoice.*,customer.cst_company');
        $this->db->from('invoice');
        $this->db->join('customer', 'invoice.cst_id = customer.cst_id', 'left');
        $this->db->order_by("invoice.id", "DESC");
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function companylist() {
        $this->db->select('*');
        $this->db->from('company');
        $this->db->order_by("id", "desc");
        $this->db->where("status", "1");
        $this->db->limit(1);
        $query_results = $this->db->get();
        $results = $query_results;
        if($results->num_rows()>0) {
            return $results->row();
        }else{
            return false;
        }
    }

    public function ck_existing_com($data) {
        $this->db->select('id');
        $this->db->from('company');
        $this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query_results = $this->db->get();
        $results = $query_results->row();
        if (count($results) > 0) {
            $this->db->where("id",$results->id);
            $update=$this->db->update("company",$data);
            if($update){
                return 'Update';
            }
        } else {
            $insert=$this->db->insert("company",$data);
            if($insert){
                return 'insert';
            }
        }
    }

    public function insert_company($data) {
        $this->db->insert('company', $data);
        return true;
    }

    public function update_company($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('company', $data);
        return TRUE;
    }

    public function ck_com_existing($id) {
//        $this->db->select('*');
//        $this->db->from('employee');
//        $this->db->where('dep_id', $id);
//        $query_results = $this->db->get();
//        $results = $query_results->row();
//        if (count($results) > 0) {
//            return FALSE;
//        } else {
//            return TRUE;
//        }
    }

    public function deletecompany_byid($id) {
        $this->db->where('id', $id);
        $this->db->delete('company');
    }

    public function duplicateUserChecker($name) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('name', $name);
        $query_results = $this->db->get();
        $results = $query_results->row();

        if (count($results) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insertUserInfo($data) {
        $this->db->insert('user', $data);
        return true;
    }

    public function storeInfo() {
        $this->db->select('*');
        $this->db->from('app_config');
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }public function companyInfo() {
        $this->db->select('*');
        $this->db->from('company');
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }

    public function insertstoreinfo($data) {
        $this->db->insert('app_config', $data);
        return true;
    }

    public function viewstoreinfo() {
        $this->db->select('*');
        $this->db->from('app_config');
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function bankavailableblance($bid) {
        $this->db->select('SUM(tr_amount) as bavbalance', FALSE);
        $this->db->from('transaction_summary');
        $this->db->where('b_id', $bid);
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }

    public function viewbankbalanceinfo() {
        $this->db->select('bank_details.*,SUM(transaction_summary.tr_amount) as ttlbalance');
        $this->db->from('transaction_summary');
        $this->db->join('bank_details', 'transaction_summary.b_id = bank_details.id', 'left');
        $this->db->group_by("transaction_summary.b_id");
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function viewbankinfo() {
        $this->db->select('*');
        $this->db->from('bank_details');
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function viewbankname($id) {
        $this->db->select('*');
        $this->db->from('bank_details');
        $this->db->where('id', $id);
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }

    function viewbankstatementinfo($first_date, $last_date, $b_id=null, $order_by=null, $method=null) {
        $this->db->query("SET SQL_BIG_SELECTS=1");
        $this->db->select('t.tr_type, t.tr_method, t.tr_amount, t.tr_date, t.b_id, b.b_name, b.b_branch, b.acc_no, c.cst_company, c.cst_name customer_name, s.supplier_name, ex.sub_expense_name,'
            .' c2.cst_company as cst_company2, s2.supplier_name as supplier_name2, c3.cst_company as cst_company3, la.name as loanAuthor, la2.name as loanAuthor2, c4.cst_company as cst_company4,cust.cst_name salePersonName');
        $this->db->from('transaction_summary as t');
        $this->db->join('bank_details as b', 't.b_id = b.id', 'left');
        
        $this->db->join('dues as d', 't.trans_id = d.trans_id', 'left');
        $this->db->join('invoice as i', 'd.invoice_id = i.id', 'left');
        $this->db->join('customer as c', 'd.customer_id = c.id', 'left');
        
        $this->db->join('purchase_dues as pd', 't.trans_id = pd.trans_id', 'left');
        $this->db->join('purchase as p', 'pd.purchase_id = p.purchase_id', 'left');
        $this->db->join('supplier as s', 'p.sup_id = s.supplier_id', 'left');
        
        $this->db->join('expense_history as eh', 't.trans_id = eh.trans_id', 'left');
        $this->db->join('sub_expense as ex', 'eh.sub_expense_id = ex.sub_expense_id', 'left');
        
        $this->db->join('advance_payment_info as a', 't.id = a.summery_id', 'left');
        $this->db->join('customer as c2', 'a.suppler_client_id = c2.id', 'left');
        $this->db->join('supplier as s2', 'a.suppler_client_id = s2.supplier_id', 'left');
        
        $this->db->join('refund as r', 't.trans_id = r.trans_id', 'left');
        $this->db->join('invoice as i2', 'r.invoice_id = i2.invoice_id', 'left');
        $this->db->join('customer as c3', 'i2.cst_id = c3.cst_id', 'left');

        $this->db->join('loan as l', 't.id = l.transId', 'left');
        $this->db->join('loan_authority as la', 'l.authId = la.id', 'left');
        $this->db->join('loan_authority as la2', 't.purposeId = la2.id', 'left');
        
        $this->db->join('dues as d2', 't.trans_id = d2.trans_id', 'left');
        $this->db->join('customer as c4', 'd2.customer_id = c4.id', 'left');
        $this->db->join('sales_person_commission as salesPerson', 'salesPerson.invoice_id = t.id', 'left');

        $this->db->join('customer as cust', 'salesPerson.sales_person_id = cust.id', 'left');

        if($method != ''){               
            if($method =="Cash"){
                $this->db->where('t.b_id', 0);
            }else{
                $this->db->where('t.tr_method', $method);
            }       
        }
        if ($b_id != '') { $this->db->where('t.b_id', $b_id); }
        if ($first_date != '') {
            $this->db->where('t.tr_date >=', $first_date);
            $this->db->where('t.tr_date <=', $last_date);
        }
        $this->db->where('t.tr_amount !=', 0);
        if($order_by){ $this->db->order_by($order_by); }
        return $this->db->get()->result(); 
    }
    function get_forward_blance($first_date, $b_id=null) {;
        $this->db->select('sum( t.tr_amount) as forward_blance ',false);
        if ($b_id != '') { $this->db->where('t.b_id', $b_id); }
        if ($first_date != '') {
            $this->db->where('t.tr_date <', $first_date);

        }
        $this->db->where('t.tr_amount !=', 0);
        $row_data=$this->db->get('transaction_summary t')->row();
        if($this->db->affected_rows()>0){
            return $row_data->forward_blance;
        }else{
            return '0.00';
        }

    }
    function payOpBalHistory($where){
        $this->db->select('d.first_payment, d.payment_date, b.b_name, b.acc_no, c.cst_company as cst_company');
        $this->db->from('dues as d');
        $this->db->join('bank_details as b', 'd.bank_id = b.id', 'left');
        $this->db->join('customer as c', 'd.customer_id = c.id', 'left');
        $this->db->where('d.trans_type', 5);
        $this->db->order_by("d.id DESC");
        return $this->db->get()->result_array(); 
    }
    function viewbalanceinfo($first_date, $last_date, $method, $b_id) {
        $this->db->select('t.*, b.b_name, b.b_branch, b.acc_no, c.cst_company');
        $this->db->from('transaction_summary as t');
        $this->db->join('bank_details as b', 't.b_id = b.id', 'left');
        $this->db->join('dues as d', 't.trans_id = d.trans_id', 'left');
        $this->db->join('customer as c', 'd.trans_id = d.trans_id', 'left');
        if ($first_date != '') {
            $this->db->where('t.tr_date >=', $first_date);
            $this->db->where('t.tr_date <=', $last_date);
        }
        if ($method != ''){ $this->db->where('t.tr_method', $method); }
        if ($b_id != ''){ $this->db->where('t.b_id', $b_id); }
        $this->db->order_by("t.id", "DESC");
        $this->db->where('t.tr_amount >', 0);
        return $this->db->get()->result();
    }
    public function noninvoicecompany($id) {
        $this->db->select('company.*');
        $this->db->from('company');
        $this->db->join('transaction_summary', 'company.id = transaction_summary.non_c_id', 'left');
        $this->db->where('transaction_summary.trans_id', $id);
        return $this->db->get()->row();
    }

    public function noninvoice($id) {
        $this->db->select('transaction_summary.*,bank_details.b_name,bank_details.b_branch,bank_details.acc_no');
        $this->db->from('transaction_summary');
        $this->db->join('bank_details', 'transaction_summary.b_id = bank_details.id', 'left');
        $this->db->where('transaction_summary.trans_id', $id);
        $this->db->order_by("transaction_summary.id", "ASC");
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function viewbankinfo2() {
        $this->db->select('*');
        $this->db->from('bank_details');
        $this->db->where('status', 0);
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function cashbalance() {
        $this->db->select('SUM(tr_amount) as cashbalance');
        $this->db->from('transaction_summary');
        $this->db->where('tr_method', 'Cash');
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }

    public function ckbank_existing($bank, $acc_no) {
        $this->db->select('*');
        $this->db->from('bank_details');
        $this->db->where('acc_no', $acc_no);
        $this->db->where('b_name', $bank);
        $query_results = $this->db->get();
        $results = $query_results->row();
        if (count($results) > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function insertbankinfo($data) {
        $this->db->insert('bank_details', $data);
        return true;
    }

    public function updatebankinfo($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('bank_details', $data);
        return TRUE;
    }

    public function ck_existing_use($id) {
        $this->db->select('*');
        $this->db->from('transaction_summary');
        $this->db->where('b_id', $id);
        $query_results = $this->db->get();
        $results = $query_results->row();
        if (count($results) > 0) {

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletebankinfo($id) {
        $this->db->where('id', $id);
        $update=$this->db->update('bank_details',['status'=>2]);
        if($update){
            return true;
        }else{
            return false;
        }
    }

    public function getbankdetail() {
        $this->db->select("id,CONCAT(b_name,',',acc_no) as b_acc_name", FALSE);
        $this->db->from('bank_details');
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function getbankinfo($b_id) {
        $this->db->select("CONCAT(b_name,',',acc_no) as b_acc_name", FALSE);
        $this->db->from('bank_details');
        $this->db->where('bank_details.id', $b_id);
        $query_results = $this->db->get();
        $results = $query_results->row();
        return $results;
    }

    public function viewtransferbalanceinfo() {
        $values = array(4, 5, 6);
        $this->db->select('transaction_summary.*,bank_details.b_name,bank_details.b_branch,bank_details.acc_no');
        $this->db->from('transaction_summary');
        $this->db->join('bank_details', 'transaction_summary.b_id = bank_details.id', 'left');
        $this->db->where_in('transaction_summary.tr_type', $values);
        $this->db->order_by("transaction_summary.id", "ASC");
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function viewopeningbalanceinfo() {
        $values = array(0, 8);
        $this->db->select('transaction_summary.*,bank_details.b_name,'
                . 'bank_details.b_branch,bank_details.acc_no,company.com_name');
        $this->db->from('transaction_summary');
        $this->db->join('bank_details', 'transaction_summary.b_id = bank_details.id', 'left');
        $this->db->join('company', 'transaction_summary.non_c_id = company.id', 'left');
        $this->db->where_in('transaction_summary.tr_type', $values);
        $this->db->order_by("transaction_summary.id", "DESC");
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function updatebankobl($b_id, $bdata) {
        $this->db->where('id', $b_id);
        $this->db->update('bank_details', $bdata);
        return TRUE;
    }

    public function duplicatecashob($tr_type, $tr_method) {
        $this->db->select('*');
        $this->db->from('transaction_summary');
        $this->db->where('tr_type', $tr_type);
        $this->db->where('tr_method', $tr_method);
        $query_results = $this->db->get();
        $results = $query_results->row();

        if (count($results) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function inserttrnsinfo($data) {
        $this->db->insert('transaction_summary', $data);
        return true;
    }

    public function updatetrnsinfo($transid, $bdata) {
        $this->db->where('trans_id', $transid);
        $this->db->update('transaction_summary', $bdata);
        return TRUE;
    }

    public function deletestoreinfo($id) {
        $this->db->where('id', $id);
        $this->db->delete('app_config');
    }

    public function insertvat($data) {
        $this->db->insert('vat_info', $data);
        return true;
    }

    public function viewvatinfo() {
        $this->db->select('*');
        $this->db->from('vat_info');
        $query_results = $this->db->get();
        $results = $query_results->result();
        return $results;
    }

    public function deletevatinfo($id) {
        $this->db->where('id', $id);
        $this->db->delete('vat_info');
    }

    public function deletenoninvinfo($id) {
        $this->db->where('trans_id', $id);
        $this->db->delete('transaction_summary');
    }

    public function insertcurrencyinfo($data) {
        $this->db->insert('currency_info', $data);
        return true;
    }

    public function querycurrencytag() {
        $this->db->select('currency_tag');
        $this->db->from('currency_info');
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        return $this->db->get()->row();
    }
  
    //for dashboard inventory value
    public function inventory_val($select, $table) {
        $this->db->select($select);
        $this->db->from($table);
        return $this->db->get()->row_array();
    }
    
    public function inventory_all_item() { 
        $this->db->select('SUM(inventory.qty) AS quantity, SUM(inventory.purchasing_price)AS p_price');
        $this->db->from('inventory');
        //$this->db->group_by("inventory.product_id");
         return $this->db->get()->row_array(); 
    }
    
    public function total_val_inv() { 
        $this->db->select('SUM(inventory.qty) AS quantity,'
                . 'AVG(inventory.purchasing_price)AS avg_price');
        $this->db->from('inventory');
        $this->db->join('item', 'inventory.product_id = item.item_id', 'left');
        $this->db->group_by("inventory.product_id");
        $results=  $this->db->get()->result_array(); //echo "<pre>";print_r($results);
        $val = 0;
            for($i=0; $i<count($results); $i++){
                $val+=  $results[$i]['avg_price'] * $results[$i]['quantity'];
            } 
        return $val;
    }
    public function directorCurrentMonthInvest() {
        $this->db->select('SUM(director_installment) as cashbalance');
        $this->db->from('rs_director_info');
        $query_results = $this->db->get();
        $results = $query_results->row()->cashbalance;
        return $results;
    }
    public function directorCurrentMonthInvestColl($from,$to) {
        $this->db->select('SUM(amount) as cashbalance');
        $this->db->from('rs_director_ledger');
        $this->db->where("trans_date >= ",$from);
        $this->db->where("trans_date <= ",$to);
        $query_results = $this->db->get();
        $results = $query_results->row()->cashbalance;
        return $results;
    }

}