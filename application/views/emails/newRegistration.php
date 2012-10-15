<?php
	//Include CSS
?>
<div id='zorl-mail'>
	<p>Hi <?php $user->name ?></p>
  <p>Welcome to Zorl</p>
  <p>Click here to verify your account</p>
  <p><a href='<?= base_url('user/onetime/' . $token) ?>'>Login</a></p>
</div> 
