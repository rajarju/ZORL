
<div id="messages">
	<?php if(count($error)): ?>
		<?php foreach($error as $e): ?>
			<div class="alert alert-error"><?= $e ?></div>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if(count($info)): ?>
		<?php foreach($info as $i): ?>
			<div class="alert alert-info"><?= $i ?></div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>