<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index()
	{
		$this->load->model('index_model');
        $data['index_text'] = $this->index_model->get_index_text();
        $this->load->view('home_view', $data);
        $this->load->view('footer_view');
	}
    
    function blog(){
        
       //Pagination settings 
       $config['base_url'] = base_url().'home/blog/';
       $config['total_rows'] =  $this->db->count_all('blog');;
       $config['per_page'] = '4';
       $config['full_tag_open'] = "<div class='pagination'>";
       $config['full_tag_close'] = '</div>';
       $config['next_link'] = '&#9658;';
       $config['next_tag_open'] = '<span>';
       $config['next_tag_close'] = '</span>';
       $config['prev_link'] = '&#9668;';
       $config['prev_tag_open'] = '<span>';
       $config['prev_tag_close'] = '</span>';
       $config['cur_tag_open'] = '<strong>';
       $config['cur_tag_close'] = '</strong>';
       $config['first_link'] = 'В начало';
       $config['first_tag_open'] = '<span>';
       $config['first_tag_close'] = '</span>';
       $config['last_link'] = 'Вконец';
       $config['last_tag_open'] = '<span>';
       $config['last_tag_close'] = '</span>';
       
       $this->pagination->initialize($config);
       
       $this->load->model('blog_model');
       
       $data['posts'] = $this->blog_model->get_posts($config['per_page'], $this->uri->segment(3));
       
       $this->load->view('blog_view', $data);
       
       $this->load->view('footer_view');
    }
    
    function post($link){
        
        $this->load->helper('string');
        $this->load->helper('captcha');
        $this->load->model('blog_model');
        $this->load->model('comment_model');
        
        $full_link = "blog/$link";
        $type = 'post';
        
        session_start();
        
        $_SESSION['captcha_error'] = '';
        
        $this->load->model('form_comment_model');
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $this->form_comment_model->my_form_validation($full_link, $type);
            $data['validation_errors'] = true;
            
        }
        
        $data['post'] = $this->blog_model->get_post($link);
        $data['comments'] = $this->comment_model->get_comments($data['post'][0]['id'], $type);
        
        $this->load->view('post_view', $data);
        $this->form_comment_model->view_comment_block($full_link, $data['post'][0]['id']);
        $this->load->view('footer_view'); 
    }
}