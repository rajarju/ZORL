<div style="width: 320px; margin: 0 auto;">
   <h3>Forgot Password</h3>
   
   <?php $this->load->view('partials/_messages', $messages); ?>
   
   <form class="well" method="POST" id="forgot-form" name="login">
      <label>Email</label>
      <input type="email" name="email" style="width: 260px;" maxlength="30" minlength="4" required/>      
      <button type="submit" class="btn btn-primary">Reset Password</button>
      <a href="<?= base_url('user/login')?>" class="btn">Login</a>
   </form>
</div>
