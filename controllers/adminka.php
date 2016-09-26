<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Adminka extends CI_Controller {
	
	public function index()
	{
		$this->load->helper('form');
        $this->load->library('form_validation');
        
        $config = array(
               array(
                     'field'   => 'login',
                     'label'   => 'Логин',
                     'rules'   => 'trim|required|min_length[3]|max_length[50]|xss_clean'
                  ),
               array(
                     'field'   => 'pass',
                     'label'   => 'Пароль',
                     'rules'   =>  'trim|required|xss_clean'
                  )
            );
        
        $this->form_validation->set_message('required', 'Поле %s обязательное');
        $this->form_validation->set_message('min_length', 'Минимальная длинна поля 3 символа');
        $this->form_validation->set_message('max_length', 'Максимальная длинна поля 50 символов');

        $this->form_validation->set_rules($config); 
        
        $data['full_link'] = base_url().'adminka';

		if ($this->form_validation->run() == FALSE)
		{
			$data['validation_errors'] = true;
            $this->load->view('adminka_view', $data);
		}
		else
		{
            $this->login();
		}
	}
    
    function login(){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $this->load->model('adminka_model');
            
            $result = $this->adminka_model->login($_POST['login'], $_POST['pass']);
            
            if(!empty($result)){ 
                
                $_SESSION['id'] = $result[0]['id'];
                
                header('Location: '.base_url().'adminka/adminpanel');
                
            } else {
                
                $data['login_error'] = true;
                $data['full_link'] = base_url().'adminka';
                
                $this->load->view('adminka_view', $data);
            }
            
        } else {
            
            header('Location: '.base_url().'adminka');
            
        }
    }
    
    function adminpanel($get_param = ''){
        
        if(!empty($_SESSION['id'])){
            
            $data['full_link'] = base_url().'adminka/adminpanel';
            $this->load->view('adminpanel_view', $data);
            
            switch($get_param){
                
                case 'exit':
                    unset($_SESSION['id']);
                    header('Location: '.base_url().'adminka');
                    exit;
                    
                case 'posts':
                    $this->load->model('adminka_model');
                    $data['content'] = $this->adminka_model->get_content("blog");
                    $view = 'adminka_posts_view';
                    break;
                
                case 'goods':
                
                default:
                    $this->load->model('adminka_model');
                    $data['content'] = $this->adminka_model->get_content("goods");
                    $view = 'adminka_goods_view';
                    break; 
                     
            }
            
            $this->load->view($view, $data);
            $this->load->view('adminka_footer_view');
            
            
        } else {
            session_destroy();
            header('Location: '.base_url().'adminka');
        }
    }
 }