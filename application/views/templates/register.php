<div style="width: 320px; margin: 0 auto;">
   <h3>Login</h3>
   <?php $this->load->view('partials/_messages', $messages); ?>
   <form class="well" method="POST" id="register-form" name="register">
      <label>Username</label>
      <input type="text" name="username" style="width: 260px;" maxlength="10" minlength="4" required/>
      <label>Email</label>
      <input type="email" name="mail" style="width: 260px;" maxlength="30" minlength="4" required/>
      <label>Password</label>
      <input type="password" name="password" style="width: 260px;" minlength="6" required/>
       <label>Password Again</label>
      <input type="password" name="password2" style="width: 260px;" minlength="6" required/>
      <button type="submit" class="btn btn-primary">Register</button>
      <a href="<?= base_url('user/login')?>" class="btn">Login</a>
   </form>
</div>
