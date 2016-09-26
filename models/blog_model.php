<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model {
	
    function get_posts($num = '', $offset = ''){
        
        $this->db->order_by("id", "desc"); 
        $query = $this->db->get("blog", $num, $offset);
        return $query->result_array();
        
    }
    
    function get_post($link){
        
        $this->db->where("link", $link);
        $query = $this->db->get("blog");
        return $query->result_array();
        
    }
}