<div class="subnav" style="margin-bottom: 10px;">
  <ul class="nav nav-pills">
    <li <?php if (is_active()): ?>class="active"<?php endif; ?>><a href="<?= site_url() ?>">Home</a></li>

    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="">Item</a></li>
      </ul>
    </li> 

    <ul class="nav nav-pills pull-right">
      <?php if ($user->uid): ?>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown"><?= $user->name ?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?= base_url('user/settings/') ?>">Change Password</a></li>
          </ul>
        </li>
        <li><a href="<?= base_url('user/logout') ?>">Logout</a></li>
      <?php endif; ?>
    </ul>
  </ul>
</div>
