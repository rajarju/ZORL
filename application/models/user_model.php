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

		$sha = sha1($pass);

		$query = $this->db->query("SELECT uid FROM user WHERE name = '$username' AND pass = '$sha' AND status = 1");

		if($query->num_rows() > 0){

			$row = $query->row();

			return (object) array(
				'name' => $username,
				'uid' => $row->uid
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

	//Create new session token
	function newSession(){
		return md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']); 
	}

	//Load and set the login for the user with given uid
	function login($user){		
		//Create new session
		$session = $this->newSession();
		$user->session = $session;
		$time = time();
		//Update DB
		$sql = "UPDATE user SET cookie = '$session',  accessed_at = '$time' WHERE uid = $user->uid";

		$this->db->query($sql);
		//Set Cookie	
		setcookie('user', $session,  time() + (86400 * 7), '/'); 
	}

	//Logout the given user
	function logout($uid = null){
		//Clear session in db
		//Remove cookie
		setcookie('user', '',  time() - (86400 * 7), '/'); 
	}



	//REGISTRATION
	//Check valid username
	function checkValidName($name){
	// regular expression for validating username  
		$valid_username = "/^[a-z0-9_-]{3,16}$/";    

	// using ‘preg_match’ to validate user input against the expression.  
		if(preg_match($valid_username, $name)){  
			return TRUE;
		}else{  
			return FALSE;
		}  
	}

	//Check if the username is unique
	function checkNameUnique($name){

		$query = $this->db->query("SELECT COUNT(*) FROM user WHERE name = '$name'");

		if ($query->num_rows() > 0)
			return TRUE;
		else 
			return FALSE;
	}

	//Check if the mail is unique
	function checkMailUnique($mail){
		
		$query = $this->db->query("SELECT COUNT(*) FROM user WHERE email = '$mail'");
		if ($query->num_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	//Check if the passwords match
	function checkPass($pass1, $pass2){
		if($pass1 == $pass2)
			return TRUE;
		else
			return FALSE;
	}

	//Add new user
	//Takes user object as parameter
	function addUser($user){
		//Add user to database
		//redirect to dashboard
		$time = time();
		$sha = sha1($user->password);


		$data = array(
               'name' => $user->name,
               'email' => $user->mail,

               'created_at' => $time, //Time stamp of creation
               //'accessed_at' => $time, //Time stamp of creation //Will be added by login function

               'pass' => $sha,
               //Cookie will be added by login function
               'status' => 1 //TRUE for accounts not blocked
            );

		$this->db->insert('user', $data); 

		//Get the user id

		$query = $this->db->query("SELECT uid FROM user WHERE name = '$user->name' LIMIT 1");
		$row = $query->row();
		$user->uid = $row->uid;
		return $user;
	}


	//Create URL token for registration check
	function addUrlToken($user){
		//Check if the userid already has a token built
		$query_remove = $this->db->query('');
		//If it does then remove it and create a new token

		//Create a new token

	}


	//Check URL token 
	//Return $user if token exists
	//Else return FALSE
	function checkUrlToken($token){

	}



}

?>