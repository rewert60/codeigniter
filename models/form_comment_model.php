<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Form_comment_model extends CI_Model {
	   
       function view_comment_block($full_link, $item_id){
        
            $this->load->helper('string');
            $this->load->helper('captcha');
            
            //Генерируем капчу
            $_SESSION['captcha_string'] = random_string('numeric', 5);
            
            $vals = array(
        	'word' => $_SESSION['captcha_string'],
        	'img_path' => './img/captcha/',
        	'img_url' => base_url().'img/captcha/',
        	'font_path' => './path/to/fonts/texb.ttf',
        	'img_width' => 120,
        	'img_height' => 30,
        	'expiration' => 10
        	);
            
            $cap = create_captcha($vals);
            $data['captcha_img'] = $cap['image'];
            $data['full_link'] = $full_link;
            $data['item_id'] = $item_id;
            
            return $this->load->view('comment_view', $data); 
        }
        
        
        // Проверка формы и добавление комментария
    	function my_form_validation($full_link, $type){
    	   
    		$this->load->helper('form');
    		
    		$this->load->library('form_validation');
    		
    		$config = array(
    		array(
    		'field'   => 'name',
    		'label'   => 'Ваше имя',
    		'rules'   => 'required|xss_clean|min_length[2]|max_length[100]'
    		),
    		array(
    		'field'   => 'text',
    		'label'   => 'Текст',
    		'rules'   => 'required|xss_clean|min_length[2]|max_length[2000]'
    		),
    		array(
    		'field'   => 'captcha',
    		'label'   => 'Капча',
    		'rules'   => 'required|trim|max_length[10]|xss_clean'
    		)
            );
    		$this->form_validation->set_message('required', 'Поле %s обязательное');
    		$this->form_validation->set_message('min_length', 'Минимальная длинна поля 2 символа');
    		$this->form_validation->set_message('max_length', 'Превышена максимальная длинна поля');
    		
    		$this->form_validation->set_rules($config); 
    		
    		if($this->form_validation->run() and $_SESSION['captcha_string'] == $_POST['captcha']){
    		  
    			$this->comments($type);
    			$_SESSION['captcha_error'] = '';
    			header('Location: '.base_url().$full_link);
                
    		} elseif($_SESSION['captcha_string'] != $_POST['captcha']) {
    		  
    			$_SESSION['captcha_error'] = 'Неверный код с картинки';
                
    		}
    	}
        
        // Добавляет комментарий
    	function comments($type){
    	   
    		$name = $_POST['name'];
    		$text = $_POST['text'];
    		$post_id = $_POST['post_id'];
    		$this->load->model('comment_model');
    		$this->comment_model->add_comment($name, $text, $post_id, $type);
            
    	}       
	}	