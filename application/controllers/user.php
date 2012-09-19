<?php if (!defined('BASEPATH')) die();

class User extends Main_Controller {


	public function index(){

   	//Redirect if not logged in
		$this->load->model('User_model');

		$user = $this->User_model->checkSession(); 

		if($user){
   		//Do Nothing   	
		}
		else{   		
			redirect('user/login');
		}   	
    //Show Dashboard
		$data = array(
			'messages' => array(
				'error' => array(),
				'info' => array(),
				)
			);

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

		$data = array(
			'messages' => array(
				'error' => array(),
				'info' => array(),
				)
			);

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
				$data['messages']['error'][] = "Wrong username or password";
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

		$data = array(
			'messages' => array(
				'error' => array(),
				'info' => array(),
				)
			);

		if($this->input->post()){
			$form = $this->input->post(NULL, TRUE);
			$this->load->model('User_model');			
			$error = array();
			//Check if username is vaid
			if(!$this->User_model->checkValidName($form['username'])){				
				$message = "Inavlid Username. ";  
				$message .= "Username should contain only alphabets, numbers, underscores or hyphens. ";  
				$message .= "Should be between 3 to 16 characters long. ";  
				$error[] = $message;
			}

			//Check if username is unique
			if(!$this->User_model->checkNameUnique($form['username'])){
				$error[] = "Username is already in use";
			}
			
			//Check if email is unique
			$this->load->helper('email');
			if (!valid_email($form['mail'])){
				$error[] = "The email that you have entered is Invalid";
			}

			//Check if email is not already in use
			if(!$this->User_model->checkMailUnique($form['mail'])){
				$error[] = "This email " . $form['mail'] . " already has an account here";
			}
			//Check if passwords are same
			if(!$this->User_model->checkPass($form['password'], $form['password2'])){
				$error[] = "The passwords that you have entered dont match";
			}

			if(!count($error)){
				//Add User
				$user = array(
						'name' => $form['username'],
						'password' => $form['password'],
						'mail' => $form['mail']
					);
				
				$user = $this->User_model->addUser((object) $user);

				//Login User
				$this->User_model->login($user);
				//Redirect
				redirect('user');
			}
			else{
				$data['messages']['error'] += $error;
			}


		}



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
