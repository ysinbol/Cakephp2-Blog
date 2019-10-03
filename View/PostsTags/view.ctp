<div class="postsTags view">
<h2><?php echo __('Posts Tag'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($postsTag['PostsTag']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post'); ?></dt>
		<dd>
			<?php echo $this->Html->link($postsTag['Post']['title'], array('controller' => 'posts', 'action' => 'view', $postsTag['Post']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tag'); ?></dt>
		<dd>
			<?php echo $this->Html->link($postsTag['Tag']['name'], array('controller' => 'tags', 'action' => 'view', $postsTag['Tag']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Posts Tag'), array('action' => 'edit', $postsTag['PostsTag']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Posts Tag'), array('action' => 'delete', $postsTag['PostsTag']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $postsTag['PostsTag']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Posts Tag'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
