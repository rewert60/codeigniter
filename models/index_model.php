<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_model extends CI_Model {
	
    function get_index_text(){
        
        $query = $this->db->get("index_text");
        return $query->result_array();
        
    }
}