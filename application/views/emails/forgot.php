<?php
	//Include CSS
?>
<div id='zorl-mail'>
	<p>Hi <?php $user->name ?></p>
  <p>We got a password reset request</p>
  <p>Click the link below to login to the site & reset your password</p>
  <p><?= base_url('user/onetime/' . $token) ?></p>
</div> 
