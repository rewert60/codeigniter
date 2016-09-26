<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_model extends CI_Model {
    
    function get_goods(){
        
        $query = $this->db->get("goods");
        return $query->result_array();
        
    }
    
    function view_item($link, $item_id){
        
        $query = $this->db->get_where('goods', array('id' => $item_id, 'link' => $link));
        return $query->result_array();
        
    }
}