<?php $this->load->view('templates/menubar', array(	'user' => $user)); ?>
<?php $this->load->view('partials/_messages', $messages); ?>
<div class="container">
   <div class="">
      
   </div>
  <div class="dash-feeds ">
    <div class="span3 ">
      <h4><?= $user->name ?></h4>
    </div>
    <div class="span8 ">
      <h2>Feeds</h2>
    </div>
  </div>
</div>
