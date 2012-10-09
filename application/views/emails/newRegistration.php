<?php
	//Include CSS
?>
<div id='zorl-mail'>
	<p>Hi <?php $user->name ?></p>
  <p>Welcome to Zorl</p>
  <p>Click here to verify your account</p>
  <p><?= base_url('user/onetime/' . $token) ?></p>
</div> 
