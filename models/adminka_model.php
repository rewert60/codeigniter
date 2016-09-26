<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminka_model extends CI_Model {
    
    function login($login, $pass){
        
        $this->db->where('login', $login);
        $this->db->where('pass', $pass);
        $query = $this->db->get('users');
        return $query->result_array();
        
    }
    
    function get_content($type){
        
        $this->db->order_by("id", "desc"); 
        $query = $this->db->get($type);
        return $query->result_array();
        
    }    
}