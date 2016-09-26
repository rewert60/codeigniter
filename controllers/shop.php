<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

$_SESSION['captcha_error'] = '';

class Shop extends CI_Controller {
    
    public function index()
	{
	   $this->load->model('shop_model');
       $data['goods'] = $this->shop_model->get_goods();
       $this->load->view('shop_view', $data);
       $this->load->view('footer_view');
	}
    
    function view_good($link, $item_id){
        
        $this->load->model('shop_model');
        $data['item'] = $this->shop_model->view_item($link, $item_id);
        
        $full_link = "shop/$link/$item_id";
        $type = 'item';
        
        $this->load->model('form_comment_model');
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $this->form_comment_model->my_form_validation($full_link, $type);
            $data['validation_errors'] = true;
            
		}
        
        $this->load->model('comment_model');
        $data['comments'] = $this->comment_model->get_comments($item_id, 'item');
        
        $this->load->view('item_view', $data);
        $this->form_comment_model->view_comment_block($full_link, $item_id);
        $this->load->view('footer_view');
    }
}