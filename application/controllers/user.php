<?php

if (!defined('BASEPATH'))
  die();

class User extends Main_Controller {

  /**
   * User Dashboard
   */
  public function index() {

    //Redirect if not logged in
    $this->load->model('User_model');

    $user = $this->User_model->checkSession();

    if ($user) {
      //Do Nothing   	
    } else {
      redirect('user/login');
    }
    //Show Dashboard

    $data['user'] = $user;

    $this->load->view('include/header');
    $data['messages'] = get_messages();
    $this->load->view('dashboard', $data);

    $this->load->view('include/footer');
  }

  /**
   * Login page with form and basic validation
   */
  public function login() {

    //Redirect if  logged in
    $this->load->model('User_model');
    if ($this->User_model->checkSession()) {
      redirect('user/index');
    }
    //Show Login Form
    $this->load->helper('form');
    $this->load->helper('cookie');


    //Check for POST
    if ($this->input->post()) {
      $form = $this->input->post(NULL, TRUE);
      $this->load->model('User_model');
      //TODO:Check for length of fields
      //Check for login
      if ($user = $this->User_model->checkLogin($form['username'], $form['password'])) {
        $this->User_model->login($user);
        redirect('user/index');
      } else {
        set_message("Wrong username or password", 'error');
      }
    }



    //Generate new token
    //Make the token global

    $this->load->view('include/header', array(
        'scripts' => array(
            'assets/js/login.js'
        )
    ));
    $data['messages'] = get_messages();
    //die('<pre>' . print_r($data));
    $this->load->view('templates/login', $data);
    //Show Footer
    $this->load->view('include/footer');
  }

  //page to logout user and redirect to login page
  public function logout() {
    $this->load->model('User_model');
    $this->User_model->logout();
    redirect('user');
  }

  /**
   * Registration page
   */
  public function register() {


    if ($this->input->post()) {
      $form = $this->input->post(NULL, TRUE);

      $this->load->model('User_model');
      $this->load->model('Mail_model');


      $error = array();
      //Check if username is vaid
      if (!$this->User_model->checkValidName($form['username'])) {
        $message = "Inavlid Username. ";
        $message .= "Username should contain only alphabets, numbers, underscores or hyphens. ";
        $message .= "Should be between 3 to 16 characters long. ";
        $error[] = $message;
      }

      //Check if username is unique
      if (!$this->User_model->checkNameUnique($form['username'])) {
        $error[] = "Username is already in use";
      }

      //Check if email is unique
      $this->load->helper('email');
      if (!valid_email($form['email'])) {
        $error[] = "The email that you have entered is Invalid";
      }

      //Check if email is not already in use
      if (!$this->User_model->checkMailUnique($form['email'])) {
        $error[] = "This email " . $form['email'] . " already has an account here";
      }
      //Check if passwords are same
      if (!$this->User_model->checkPass($form['password'], $form['password2'])) {
        $error[] = "The passwords that you have entered dont match";
      }

      if (!count($error)) {
        //Add User
        $user = array(
            'name' => check_plain($form['username']),
            'password' => ($form['password']),
            'email' => check_plain($form['email'])
        );

        $user = $this->User_model->addUser((object) $user);

        //Generate URL token for login
        $token = $this->User_model->addUrlToken($user);
        //Send Email
        $this->Mail_model->registrationMail($user, array(
            'token' => $token
        ));

        //No Immediate Login
        set_message('Please check your email to proceed with the registration');        
      } else {
        foreach ($error as $i)
          set_message($i, 'error');
      }
    }



    $this->load->view('include/header', array(
        'scripts' => array(
            'assets/js/register.js'
        )
    ));
    $data['messages'] = get_messages();
    $this->load->view('templates/register', $data);
    //Show Footer
    $this->load->view('include/footer');
  }

  /**
   * page to reset password
   */
  public function password() {
    //Redirect if  logged in
    $this->load->model('User_model');
    $user = $this->User_model->checkSession();
    if (!$user->uid) {
      //die('shoot');
      redirect('user');
    }

    //Check for post
    if ($this->input->post()) {

      $form = $this->input->post(NULL, TRUE);

      //Check if the new passwords match
      //Check if passwords are same
      if (!$this->User_model->checkPass($form['password'], $form['password2'])) {
        set_message("The passwords that you have entered dont match", 'error');
      }
      //Check if the old password is correct  
      elseif (!$this->User_model->checkLogin($user->name, $form['oldpassword'])) {
        set_message('The current password that you have entered is wrong', 'error');
      } else {
        //Change password to new one
        $this->User_model->setPassword($user->uid, $form['password']);
        set_message('Your password has been changed');
      }
    }

    $this->load->view('include/header', array(
        'scripts' => array(
            'assets/js/register.js'
        )
    ));
    $data['messages'] = get_messages();
    $data['user'] = $user;
    $this->load->view('templates/password', $data);
    //Show Footer
    $this->load->view('include/footer');
  }

  /**
   * One time login with url
   */
  public function onetime($token = null) {

    $this->load->model('User_model');
    $this->load->helper('url_helper');
    //Check if the token is valid 
    //die('checking');
    if ($user = $this->User_model->checkUrlToken(check_plain($token))) {
      //die('bitch');
      //Activate the user account, UNBLOCK
      $this->User_model->block($user->uid, TRUE);
      //If valid user then login the user and send to dash
      $this->User_model->login($user);

      set_message('Change your password');
      $this->password();
      //redirect('user/password');
    } else {
      //Show error message      
      set_message('The url token has expired', 'error');
      set_message('Try generating a new one at <a href="' . base_url('user/forgot') . '"> Forgot Password</a>', 'error');
      $this->login();
    }
  }

  /**
   * The forgot password page
   */
  public function forgot() {
    //Redirect if  logged in
    $this->load->model('User_model');
    if ($this->User_model->checkSession()) {
      redirect('user/index');
    }

    //Check for post
    if ($this->input->post()) {

      $form = $this->input->post(NULL, TRUE);

      //Check if email is unique
      $this->load->helper('email');
      //Check email
      if (!valid_email($form['email'])) {
        set_message("The email that you have entered is not Invalid", 'error');
      } else {
        $email = check_plain($form['email']);
        //Based on email generate new login url token
        $this->load->model('User_model');
        $this->load->model('Mail_model');
        $user = $this->User_model->loadFromMail($email);
        if ($user && $user->uid) {
          //Generate new token and add to system
          $token = $this->User_model->addUrlToken($user);
          //Send email
          $this->Mail_model->forgotMail($user, array(
              'token' => $token
          ));
          set_message("Check your mail to Reset your password");
        } else {
          set_message("We dont have records for the email that you have given", 'error');
        }
      }
    }

    $this->load->view('include/header', array(
        'scripts' => array(
            'assets/js/register.js'
        )
    ));
    $data['messages'] = get_messages();
    $this->load->view('templates/forgot', $data);
    //Show Footer
    $this->load->view('include/footer');
  }

  //Test mail page
  function testMail() {

    //mail('caffeinated@example.com', 'My Subject', "message");
    $this->load->model('Mail_model');

    $status = $this->Mail_model->registrationMail((object) array(
                'uid' => 1,
                'email' => 'admin@zorl.com'
            ), array(
        'token' => '123'
            ));

    print 'SENT ' . $status;
  }

}

