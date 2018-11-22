<?php
class Common_model extends CI_Model {

    public function duplicate_check($table, $column, $name) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($column, $name);
        $query_results = $this->db->get();
        $results = $query_results->row();
        if (count($results) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function duplicateGroupChecker($table, $id, $where_array, $extra = null) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where_array);
        if($id!=''){
            if($extra){
                $this->db->where($extra.' !=', $id);
            }else{
                $this->db->where('id !=', $id);
            }
        }
        $query_results = $this->db->get();
        $results = $query_results->row(); 

        if (count($results) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function duplicate_check_where_array($table, $where_array) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where_array);
        $query_results = $this->db->get();
        $results = $query_results->row();
        if (count($results) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
    public function get($table, $column, $order){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($column, $order);
        return $this->db->get()->result_array();
    }
    
    public function edit($table, $column, $id, $data) {
        $this->db->where($column, $id);
        $this->db->update($table, $data);
        return TRUE;
    }
    public function deleteitem($id) {
        $this->db->where('item_id', $id);
        $this->db->delete('item');
    }
    public function delete($table, $column, $id) {
        $this->db->where($column, $id);
        $this->db->delete($table);
    }
   
    public function get_group_by($table, $column, $order_by, $order){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order_by, $order);
        $this->db->group_by($column);
        return $this->db->get()->result_array();
    }
   
    public function get_where($table,$array){
        return $this->db->get_where($table,$array)->row_array();
    }
    public function get_where_all($table,$array){
        return $this->db->get_where($table,$array)->result_array();
    }
 
    function getRow($object=null, $select, $table, $where = null){ 
        $this->db->select($select);
        $this->db->from($table);
        if($where){ $this->db->where($where); }   
        if($object){ return $this->db->get()->row(); }
        return $this->db->get()->row_array(); 
    }
    
    //from travel kites
    function get_row($select, $table, $where=null, $order_by=null, $limit=null){
        $this->db->select($select);
        $this->db->from($table);
        if($where){ $this->db->where($where); }        
        if($order_by){ $this->db->order_by($order_by); }        
        if($limit){ $this->db->limit($limit); }        
        return $this->db->get()->row_array();  
    }
    function get_result($select, $table, $order_by=null, $where=null, $group_by=null){
        $this->db->select($select);
        $this->db->from($table);
        if($order_by){ $this->db->order_by($order_by); }
        if($where){ $this->db->where($where); }        
        if($group_by){ $this->db->group_by($group_by); }        
        return $this->db->get()->result_array();
    }
    function update($table, $where, $data) {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function deleteRow($table, $where) {
        $this->db->where($where);
        $this->db->delete($table); 
    }
     // converting number to words
    function getStringOfAmount($num) {
        $count = 0;
        global $ones, $tens, $triplets;
        $ones = array(
            '', ' One', ' Two', ' Three', ' Four', ' Five',
            ' Six',  ' Seven', ' Eight', ' Nine', ' Ten',
            ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen',
            ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'
          );
        
        $tens = array(
          '',  '', ' Twenty',  ' Thirty', ' Forty',  ' Fifty',
          ' Sixty', ' Seventy', ' Eighty', ' Ninety'
        );

        $triplets = array(
          '', ' Thousand', ' Million', ' Billion', ' Trillion',
          ' Quadrillion', ' Quintillion', ' Sextillion',
          ' Septillion', ' Octillion', ' Nonillion'
        );
        return $this->convertNum($num);
    }
    function commonloop($val, $str1 = '', $str2 = '') {
        global $ones, $tens;
        $string = '';
        if ($val == 0)
            $string .= $ones[$val];
        else if ($val < 20)
            $string .= $str1.$ones[$val] . $str2;  
        else
            $string .= $str1 . $tens[(int) ($val / 10)] . $ones[$val % 10] . $str2;
        return $string;
      }
    function convertNum($num) { 
        $num = (int) $num;
        if ($num < 0)
          return 'negative' . $this->convertTri(-$num, 0);

        if ($num == 0)
          return 'Zero';
        return $this->convertTri($num, 0);
    }
    function convertTri($num, $tri) {
        global $ones, $tens, $triplets, $count;
        $test = $num;
        $count++;
        $str = '';

        if ($count == 1) {
            $r = (int) ($num / 1000);
            $x = ($num / 100) % 10;
            $y = $num % 100;
            if ($x > 0) {
                $str = $ones[$x] . ' Hundred';
                $str .= $this->commonloop($y, ' and ', '');
            }
            else if ($r > 0) {
                $str .= $this->commonloop($y, ' and ', '');
            }
            else {
                $str .= $this->commonloop($y);
            }
        }
        else if($count == 2) {
            $r = (int) ($num / 10000);
            $x = ($num / 100) % 100;
            $y = $num % 100;
            $str .= $this->commonloop($x, '', ' Lakh ');
            $str .= $this->commonloop($y);
            if ($str != '')
                $str .= $triplets[$tri];
        }
        else if($count == 3) {
            $r = (int) ($num / 1000);
            $x = ($num / 100) % 10;
            $y = $num % 100;
            if ($x > 0) {
                $str = $ones[$x] . ' Hundred';
                $str .= $this->commonloop($y,' and ',' Crore ');
            }
            else if ($r > 0) {
                $str .= $this->commonloop($y,' and ',' Crore ');
            }
            else {
                $str .= $this->commonloop($y);
            }
        }
        else {
            $r = (int) ($num / 1000);
        }
        if ($r > 0)
            return $this->convertTri($r, $tri+1) . $str;
        else
            return $str;
        }
        
    function insertUpdateCstLedger($cstId, $date, $invoiceId=null, $dueId=null, $opBal=null, $where=null, $advanceId=null) {
        $cstLedger['cstId'] = $cstId;
        $cstLedger['date'] = $date; 
        if($invoiceId){ $cstLedger['invoiceId'] = $invoiceId; }
        if($dueId){ $cstLedger['dueId'] = $dueId; }
        if($opBal){ $cstLedger['opBal'] = $opBal; }
        if($advanceId){ $cstLedger['advanceId'] = $advanceId; }
        if($where){
            $this->db->where($where);
            //$this->db->update('client_ledger', $cstLedger);
        }else{ 
            //$this->db->insert('client_ledger', $cstLedger);            
        }
    }

}