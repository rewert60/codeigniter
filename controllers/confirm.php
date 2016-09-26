<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Confirm extends CI_Controller {
    
    public function index(){}
    
    function confirm_order(){
        
        $this->load->model('order_model');
        
        $data['item'] = $this->order_model->get_item_by_id($_SESSION['order']['item_id']);        
        $data['order'] = $_SESSION['order'];
        
        if($data['order']['delivery'] == 'np'){
            
            $data['order']['delivery'] = 'Новой почтой';
            
        } else {
            
            $data['order']['delivery'] = 'в Харькове';
            
        }
        
        $this->load->view('confirm_view', $data);
        $this->load->view('footer_view');
    }
    function add_order(){
        
        $this->load->model('order_model');
        $this->order_model->add_order();
        $this->load->view('confirm_msg_view');
        $this->load->view('footer_view');
        
        unset($_SESSION['order']);
    }
}