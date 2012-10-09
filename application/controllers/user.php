<?php

if (!defined('BASEPATH'))
  die();

class User extends Main_Controller {

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

    $this->load->view('dashboard', $data);

    $this->load->view('include/footer');
  }

  //Login page with form and basic validation
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

  //Registration page
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
      if (!valid_email($form['mail'])) {
        $error[] = "The email that you have entered is Invalid";
      }

      //Check if email is not already in use
      if (!$this->User_model->checkMailUnique($form['mail'])) {
        $error[] = "This email " . $form['mail'] . " already has an account here";
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
            'mail' => check_plain($form['mail'])
        );

        $user = $this->User_model->addUser((object) $user);

        //Generate URL token for login
        $token = $this->User_model->addUrlToken($user);
        //Send Email
        $this->Mail_model->registrationMail($user, array(
            'token' => $token
        ));

        //No Immediate Login
        //Login User
        //$this->User_model->login($user);
        //Redirect
        redirect('user');
      } else {
        foreach($error as $i)
          set_message ($i, 'error');
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

  //One time login with url
  public function onetime($token = null) {

    $this->load->model('User_model');
    $this->load->helper('url_helper');
    //Check if the token is valid 
    if ($user = $this->User_model->checkUrlToken(check_plain($token))) {
      //If valid user then login the user and send to dash
      $this->User_model->login($user);
      redirect('user');
    } else {
      //Show error message

      set_message('The url token has expired', 'error');
      set_message('Try generating a new one at <a href="' . base_url('user/forgot') . '"> Forgot Password</a>', 'error');      
    }

    
    /*** PAGE TEMPLATING ***/
    $this->load->view('include/header', array(
        'scripts' => array(
            'assets/js/register.js'
        )
    ));
    $data['messages'] += get_messages();
    
    $this->load->view('templates/login', $data);
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

