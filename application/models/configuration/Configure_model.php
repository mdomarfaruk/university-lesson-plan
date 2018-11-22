<?php
class Configure_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insert($table,$data) {
        $this->db->insert($table, $data);
        return true;
    }
    
    public function get_sub_cat(){
        $this->db->select('sc.id as sc_id, sc.*, c.*, ');
        $this->db->from('sub_cats as sc');
        $this->db->join('item_group as c', 'sc.cat_id = c.id', 'left');
        $this->db->order_by('sc.sub_cat', 'ASC');
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
 
      

}