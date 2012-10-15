<?php $this->load->view('templates/menubar', array(	'user' => $user)); ?>
<div style="width: 320px; margin: 0 auto;">
  <h3>Reset Password</h3>

  <?php $this->load->view('partials/_messages', $messages); ?>

  <form class="well" method="POST" id="login-form" name="login">
    <label>Old Password</label>
    <input type="password" name="oldpassword" style="width: 260px;" maxlength="10" minlength="4" required/>
    <label>New Password</label>
    <input type="password" name="password" style="width: 260px;" minlength="6" required/>
    <label>New Password Again</label>
    <input type="password" name="password2" style="width: 260px;" minlength="6" required/>    

    <button type="submit" class="btn btn-primary">Reset</button>    

  </form>
</div>
