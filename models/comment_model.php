<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment_model extends CI_Model {
	
    function add_comment($name, $text, $post_id, $type){
        
        $data = array(
           'post_id' => $post_id ,
           'name' => $name ,
           'comment' => $text,
           'type' => $type
        );
        
        $this->db->insert('comments', $data); 
        return true;
    }
    
    function get_comments($post_id, $type){
        
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where('comments', array('post_id' => $post_id, 'type' => $type));
        return $query->result_array();
        
    }
}