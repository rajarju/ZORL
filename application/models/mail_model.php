<?php

if (!defined('BASEPATH'))
  die();

class Mail_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public $fromMail = 'mail@zorl.com';
  public $fromName = 'ZORL';

  /**
   * Sends out registration mails
   */
  function registrationMail($user, $data) {

    //Set headers
    $headers = "From: " . strip_tags($this->fromMail) . "\r\n";
    //$headers .= "Reply-To: " . strip_tags($_POST['req-email']) . "\r\n";
    $headers .= "CC: support@zorl.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    
    $data['user'] = $user;

    //Prepare template data

    $message = $this->load->view('emails/newRegistration', $data, TRUE);
	
    return mail($user->email, "Welcome to ZORL", $message, $headers);

  }
  
  function forgotMail($user, $data){
        //Set headers
    $headers = "From: " . strip_tags($this->fromMail) . "\r\n";
    //$headers .= "Reply-To: " . strip_tags($_POST['req-email']) . "\r\n";
    $headers .= "CC: support@zorl\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    
    $data['user'] = $user;

    //Prepare template data

    $message = $this->load->view('emails/forgot', $data, TRUE);
	
    return mail($user->email, "Welcome to ZORL", $message, $headers);
  }

}