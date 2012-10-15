
<div id="messages">

  <?php if (isset($error)): ?>
    <?php if (count($error)): ?>
      <?php foreach ($error as $e): ?>
        <div class="alert alert-error"><?= $e ?></div>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endif; ?>
  <?php if (isset($status)): ?>
    <?php if (count($status)): ?>
      <?php foreach ($status as $i): ?>
        <div class="alert alert-info"><?= $i ?></div>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endif; ?>
</div>