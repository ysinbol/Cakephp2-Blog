<div class="thumbnails view">
<h2><?php echo __('Thumbnail'); ?></h2>
	<dl>
		<dt><?php echo __('    “id”'); ?></dt>
		<dd>
			<?php echo h($thumbnail['Thumbnail']['    “id”']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('    “model”'); ?></dt>
		<dd>
			<?php echo h($thumbnail['Thumbnail']['    “model”']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('    “foreign Key”'); ?></dt>
		<dd>
			<?php echo h($thumbnail['Thumbnail']['    “foreign_key”']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('    “thumbnail”'); ?></dt>
		<dd>
			<?php echo h($thumbnail['Thumbnail']['    “thumbnail”']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('    “dir”'); ?></dt>
		<dd>
			<?php echo h($thumbnail['Thumbnail']['    “dir”']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('    “type”'); ?></dt>
		<dd>
			<?php echo h($thumbnail['Thumbnail']['    “type”']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('    “size”'); ?></dt>
		<dd>
			<?php echo h($thumbnail['Thumbnail']['    “size”']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('    “active”'); ?></dt>
		<dd>
			<?php echo h($thumbnail['Thumbnail']['    “active”']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Thumbnail'), array('action' => 'edit', $thumbnail['Thumbnail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Thumbnail'), array('action' => 'delete', $thumbnail['Thumbnail']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $thumbnail['Thumbnail']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Thumbnails'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Thumbnail'), array('action' => 'add')); ?> </li>
	</ul>
</div>
