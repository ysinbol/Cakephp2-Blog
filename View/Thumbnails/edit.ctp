<div class="thumbnails form">
<?php echo $this->Form->create('Thumbnail'); ?>
	<fieldset>
		<legend><?php echo __('Edit Thumbnail'); ?></legend>
	<?php
		echo $this->Form->input('    “id”');
		echo $this->Form->input('    “model”');
		echo $this->Form->input('    “foreign_key”');
		echo $this->Form->input('    “thumbnail”');
		echo $this->Form->input('    “dir”');
		echo $this->Form->input('    “type”');
		echo $this->Form->input('    “size”');
		echo $this->Form->input('    “active”');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Thumbnail.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Thumbnail.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Thumbnails'), array('action' => 'index')); ?></li>
	</ul>
</div>
