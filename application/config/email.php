<?php

/*
 * What protocol to use?
 * mail, sendmail, smtp
 */
$config['protocol'] = 'C:\xampp\mailtodisk\mailtodisk.exe';

/*
 * SMTP server address and port
 */
$config['smtp_host'] = 'localhost';
$config['smtp_port'] = '25';

/*
 * SMTP username and password.
 */
$config['smtp_user'] = 'test@localhost.localmail';
$config['smtp_pass'] = 'password';

/*
 * Heroku Sendgrid information.
 */
/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;
$config['smtp_user'] = $_SERVER['SENDGRID_USERNAME'];
$config['smtp_pass'] = $_SERVER['SENDGRID_PASSWORD'];
*/


