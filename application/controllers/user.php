<?php if (!defined('BASEPATH')) die();

class User extends Main_Controller {
	 

   public function index(){
   	
   	//Redirect if not logged in
   	$this->load->model('User_model');
   	$user = $this->User_model->checkSession();   	
   	if($user){
   		
   	}
   	else{   		
   		redirect('user/login');
   	}   	
    //Show Dashboard
    $data = array();

    $data['user'] = $user;
   	$this->load->view('include/header');   	

    $this->load->view('dashboard', $data);
    $this->load->view('include/footer');
	}


	//Login page with form and basic validation
	public function login(){
		
		//Redirect if  logged in
   	$this->load->model('User_model');
   	if($this->User_model->checkSession()){
   		redirect('user/index');
   	}
		//Show Login Form
		$this->load->helper('form');
		$this->load->helper('cookie');		

		$data = array();

		//Check for POST
		if($this->input->post()){
			$form = $this->input->post(NULL, TRUE);
			$this->load->model('User_model');			
			//TODO:Check for length of fields

			//Check for login
			if($user = $this->User_model->checkLogin($form['username'], $form['password'])){				
				$this->User_model->login($user);
				redirect('user/index');
			}
			else{
				$data['error'][] = "Wrong username or password";
			}

		}



		//Generate new token

		//Make the token global

		$this->load->view('include/header', array(
				'scripts' => array(
					'assets/js/login.js'
				)
		));
		$this->load->view('templates/login', $data);
		//Show Footer
		$this->load->view('include/footer');	
	}


	//page to logout user and redirect to login page
	public function logout(){
		$this->load->model('User_model');
		$this->User_model->logout();
		redirect('user');
	}



	//Registration page
	public function register(){

		$data = array();

		$this->load->view('include/header', array(
				'scripts' => array(
					'assets/js/register.js'
				)
		));
		$this->load->view('templates/register', $data);
		//Show Footer
		$this->load->view('include/footer');	
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
