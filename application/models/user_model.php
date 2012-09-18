<?php if (!defined('BASEPATH')) die();
	
class User_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}


	function checkSession(){
	 	$this->load->helper('cookie');
	 	$session = get_cookie('user'); 
	 	 	
		if(isset($session)){      	      				
			if(!$this->validateCookie($session)){
				return FALSE;
			}
			else{
				return $this->loadFromSession($session);
			}
		}
		else{
			return FALSE;
		}	 
	}

	//Load user object based on uid
	//Returns user object
	function load($uid){

	}
	//Load User from Session value
	function loadFromSession($session){
		return (object) array(
			'name' => 'admin',
			'uid' => 1
		);
	}

	//Remove User from DB based on uid
	function delete($uid){

	}

	//Checks if the credentials are correct
	//$pass will be hashed before checking it
	//Returns $user object or false
	function checkLogin($username, $pass){
		if($username == 'admin' && $pass == 'pass'){
			return (object) array(
				'name' => $username,
				'uid' => 1
			);
		}
		else{
			return FALSE;
		}
	}

	//Check the current cookie hash is valid,
	//Else logout the user
	function validateCookie($session){
		if($session)
			return TRUE;
		else
			return FALSE;
	}

	//Load and set the login for the user with given uid
	function login($user){
		//Create new session
		$session = md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']); 
		$user->session = $session;
		//Update DB
		//Set Cookie
		$this->load->helper('cookie');
		$cookie = array(
		  'name'   => 'user',
		  'value'  => $session
		  //'expire' => 86500, // have a high cookie time till you make sure you actually set the cookie
		  //'domain' => '.example.org', // the first . to make sure subdomains isn't a problem
		  //'path' => '/',
		  //'secure' => TRUE
		);
		set_cookie('user', $cookie, -1, '/'); 
	}

	//Logout the given user
	function logout($uid = null){
		//Clear session in db
		//Remove cookie
		$this->load->helper('cookie');
		delete_cookie('user');
	}

}

?>