<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {
    
    function get_item_by_id($id){
        
        $query = $this->db->get_where('goods', array('id' => $id));
        return $query->result_array();
        
    }
    
    function add_order(){
        
        $data = array(
           'item_id' => $_SESSION['order']['item_id'] ,
           'name' => $_SESSION['order']['fio'] ,
           'phone' => $_SESSION['order']['phone'],
           'delivery' => $_SESSION['order']['delivery'] ,
           'text' => $_SESSION['order']['text']
        );
        
        $this->db->insert('orders', $data); 
        return true;
        
    }
}