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
		setcookie('user', $session,  time() + (86400 * 7), '/'); 
	}

	//Logout the given user
	function logout($uid = null){
		//Clear session in db
		//Remove cookie
		setcookie('user', '',  time() - (86400 * 7), '/'); 
	}

}

?>