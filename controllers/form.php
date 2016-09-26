<?php

class Form extends CI_Controller {

	function index()
	{
		$this->load->helper('form');

		$this->load->library('form_validation');
        
        $config = array(
               array(
                     'field'   => 'username',
                     'label'   => 'Имя пользователя',
                     'rules'   => 'trim|required|min_length[5]|max_length[12]|xss_clean'
                  ),
               array(
                     'field'   => 'password',
                     'label'   => 'Пароль',
                     'rules'   =>  'trim|required|matches[passconf]|md5'
                  ),
               array(
                     'field'   => 'passconf',
                     'label'   => 'Подтверждение пароля',
                     'rules'   => 'trim|required'
                  ),   
               array(
                     'field'   => 'email',
                     'label'   => 'Email адрес',
                     'rules'   => 'trim|required|valid_email'
                  )
            );
        
        $this->form_validation->set_message('required', 'Поле %s обязательное');

        $this->form_validation->set_rules($config); 

		if ($this->form_validation->run() == FALSE)
		{
		  
			$this->load->view('myform');
            
		}
		else
		{
		  
			$this->load->view('formsuccess');
            
		}
	}
}
?>