<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Cart extends CI_Controller {
    
    public function index(){}
    
    function item_info($item_name, $item_id){
        
        $full_link = base_url().'cart/'.$item_name.'/'.$item_id;
        
        $this->load->model('shop_model');
        
        $data['item'] = $this->shop_model->view_item($item_name, $item_id);
       
        $data['path'] = $full_link;
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $data['validation_errors'] = true;
            
            $this->cart_form_validation();
            
            if ($this->form_validation->run() and $_SESSION['captcha_string_cart'] == $_POST['captcha']){
                
    			$_SESSION['captcha_error'] = '';
                
                $order['item_id'] = $item_id;
                $order['fio'] = $_POST['fio'];
                $order['phone'] = $_POST['phone'];
                $order['delivery'] = $_POST['delivery'];
                $order['text'] = $_POST['text'];
                $_SESSION['order'] = $order;
                
    			header('Location: '.base_url().'confirm');
                
    		} elseif ($_SESSION['captcha_string_cart'] != $_POST['captcha']) {
    		  
    			$_SESSION['captcha_error'] = 'Неверный код с картинки';
                
    		}
        }
        
        $data['captcha_img'] = $this->captcha();
        
        $this->load->view('cart_view', $data);
        $this->load->view('footer_view');
    }
    
    function captcha(){
        
        $this->load->helper('string');
        
        $this->load->helper('captcha');
        
        //Генерируем капчу
        $_SESSION['captcha_string_cart'] = random_string('numeric', 5);
        
        $vals = array(
        	'word' => $_SESSION['captcha_string_cart'],
        	'img_path' => './img/captcha/',
        	'img_url' => base_url().'img/captcha/',
        	'font_path' => './path/to/fonts/texb.ttf',
        	'img_width' => 120,
        	'img_height' => 30,
        	'expiration' => 10
    	);
        
        $cap = create_captcha($vals);
        
        return $cap['image']; 
    }
    
    function cart_form_validation(){
        
		$this->load->helper('form');		
		$this->load->library('form_validation');
		
		$config = array(
    		array(
        		'field'   => 'fio',
        		'label'   => 'ФИО',
        		'rules'   => 'required|xss_clean|min_length[2]|max_length[100]'
    		),
            array(
        		'field'   => 'phone',
        		'label'   => 'Телефон',
        		'rules'   => 'required|xss_clean|min_length[7]|max_length[20]'
    		),
    		array(
        		'field'   => 'text',
        		'label'   => 'Текст',
        		'rules'   => 'xss_clean|max_length[1000]'
    		),
    		array(
        		'field'   => 'captcha',
        		'label'   => 'Капча',
        		'rules'   => 'required|trim|max_length[10]|xss_clean'
    		)
        );
		$this->form_validation->set_message('required', 'Поле %s обязательное');
		$this->form_validation->set_message('min_length', 'Недостаточная длинна поля');
		$this->form_validation->set_message('max_length', 'Превышена максимальная длинна поля');
		
        $this->form_validation->set_error_delimiters('<p class="error-msg">', '</p>');
        
		$this->form_validation->set_rules($config);
	}
    
    function confirm(){
        echo '<pre>';
        var_export($_SESSION);
    }
}