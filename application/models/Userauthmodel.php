<?php

/**
 * 
 */
class Userauthmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function check_login($user_name, $password) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('name', $user_name);
        $this->db->where('password', $password);
        $this->db->where('status', "active");
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function hash($string) {
        return hash('sha512', $string);
    }

}