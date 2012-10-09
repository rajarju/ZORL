<?php if (!defined('BASEPATH')) die();

class Mail_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	public $fromMail = 'mail@zorl.com';
	public $fromName = 'ZORL';

	//Sends out registration mails
	function registrationMail($to, $subject, $data){

		$this->load->library('email');

		$this->email->from($this->fromMail, 'sender');
		$this->email->to($to); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 

		$this->email->subject($subject);
		

		//$email = $this->load->view('emails/template', $data, TRUE); 
		$this->email->message('Testing the email class.');	
		
		//echo $this->email->print_debugger();
		//die;
		return	$this->email->send();

	}

}