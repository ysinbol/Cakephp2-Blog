<div class="thumbnails index">
	<h2><?php echo __('Thumbnails'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('    “id”'); ?></th>
			<th><?php echo $this->Paginator->sort('    “model”'); ?></th>
			<th><?php echo $this->Paginator->sort('    “foreign_key”'); ?></th>
			<th><?php echo $this->Paginator->sort('    “thumbnail”'); ?></th>
			<th><?php echo $this->Paginator->sort('    “dir”'); ?></th>
			<th><?php echo $this->Paginator->sort('    “type”'); ?></th>
			<th><?php echo $this->Paginator->sort('    “size”'); ?></th>
			<th><?php echo $this->Paginator->sort('    “active”'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($thumbnails as $thumbnail): ?>
	<tr>
		<td><?php echo h($thumbnail['Thumbnail']['    “id”']); ?>&nbsp;</td>
		<td><?php echo h($thumbnail['Thumbnail']['    “model”']); ?>&nbsp;</td>
		<td><?php echo h($thumbnail['Thumbnail']['    “foreign_key”']); ?>&nbsp;</td>
		<td><?php echo h($thumbnail['Thumbnail']['    “thumbnail”']); ?>&nbsp;</td>
		<td><?php echo h($thumbnail['Thumbnail']['    “dir”']); ?>&nbsp;</td>
		<td><?php echo h($thumbnail['Thumbnail']['    “type”']); ?>&nbsp;</td>
		<td><?php echo h($thumbnail['Thumbnail']['    “size”']); ?>&nbsp;</td>
		<td><?php echo h($thumbnail['Thumbnail']['    “active”']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $thumbnail['Thumbnail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $thumbnail['Thumbnail']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $thumbnail['Thumbnail']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $thumbnail['Thumbnail']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Thumbnail'), array('action' => 'add')); ?></li>
	</ul>
</div>
