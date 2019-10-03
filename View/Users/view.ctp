<?php
echo $this->Form->create('User', array(

	'type' => 'file', 'entype' => 'multipart/form-data'
), array('class' => "form-signin"));
?>
<div class="user-view">
	<div class="text-center">
		<div class="profile-view">
			<h2 class="mb-2">プロフィール</h2>
			<?php
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->input('username', array('type' => 'hidden'));
			echo $this->Form->input('password', array('type' => 'hidden'));
			echo $this->Form->input('group_id', array('type' => 'hidden'));
			?>
			<?php
			echo $this->element('profileimage');
			?>

			<h3><?php echo $user['User']['username']; ?></h3>
			<?php if ($isOwner) {
				// echo $this->Html->link(__('プロフィールを編集する'), array('action' => 'edit', $user['User']['id']), array('class' => 'fas fa-cog mb-4'));
			}
			?>
			<?php
			$introduction = $user['User']['introduction'];
			if ($introduction !== null) { ?>
				<p class="text-left"> <?php echo $introduction; ?></p>
			<?php
			}
			?>
			<a href="http://blog.dev1/cakephp/users/edit/<?php echo $user['User']['id'] ?>">
				<p>
					プロフィールを編集する<ion-icon name="cog"></ion-icon>
				</p>
			</a>

		</div>
	</div>
</div>
<?php foreach ($posts as $post_) : ?>
	<?php $id = $post_['Post']['id']; ?>
	<div class="blog-post" href=<?php echo "http://blog.dev1/cakephp/posts/view/${id}" ?>>
		<!--  投稿記事のユーザーがログインしているユーザーと一緒なら編集と削除ボタンを表示する -->
		<div class="card mb-n4 mx-auto" style="max-width: 700px;">
			<div class="row no-gutters">
				<div class="col-md-4">
					<?php
						if (!empty($post_['Thumbnail'])) {
							$thumbId = $post_['Thumbnail']['id'];
							$thumbName = $post_['Thumbnail']['thumbnailimage'];
							$thumbPath = $post_['Thumbnail']['dir'];
							$base_ = "../files/thumbnail/thumbnailimage/";

							echo $this->html->image($base_ . $thumbPath . DS . 'normal_' . $thumbName, array('class' => 'card-img', 'alt' => '...'));
						} else {
							echo $this->html->image("noimage_midium.png", array('class' => 'card-img', 'alt' => '...'));
						}
						?>
				</div>
				<div class="col-md-8">
					<div class="card-body">
						<h5 class="card-title blog-post-title">
							<?php

								echo $this->Text->truncate($post_['Post']['title'], 32, array('ellipsis' => '...', 'class' => 'text-dark', 'style' => 'text-decoration: none'))

								?>
						</h5>
						<div class="card-text">

							<p class="pt-4 card-body-text"><?php echo h($this->Text->truncate($post_['Post']['body'], 20, array('ellipsis' => '...',))); ?></p>

							<small class="text-muted card-bottom-text">
								<?php
									$date = $post_['Post']['created'];
									echo date('Y-m-d', strtotime(str_replace('-', '/', $date)));
									?>
							</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.blog-post -->

<?php endforeach; ?>

<!-- ページネーション -->
<nav aria-label="Page navigation example" class="blog-pagination row">
	<ul class="pagination mx-auto">
		<?php
		if (count($posts) >= $paginateLimit) {
			$this->Paginator->options(array('class' => 'page-link'));
			echo $this->Paginator->prev(__('Previous'), array('tag' => 'li class="page-item"'));
			echo $this->Paginator->numbers(array('currentTag' => 'a class="page-link"', 'separator' => ''));
			echo $this->Paginator->next(__('Next'), array('tag' => 'li class="page-item"'));
		}
		?>
	</ul>
</nav>
</div>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Posts'); ?></h3>
	<?php if (!empty($user['Post'])) : ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('User Id'); ?></th>
				<th><?php echo __('Title'); ?></th>
				<th><?php echo __('Body'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th><?php echo __('Modified'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($user['Post'] as $post) : ?>
				<tr>
					<td><?php echo $post['id']; ?></td>
					<td><?php echo $post['user_id']; ?></td>
					<td><?php echo $post['title']; ?></td>
					<td><?php echo $post['body']; ?></td>
					<td><?php echo $post['created']; ?></td>
					<td><?php echo $post['modified']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $post['id'])); ?>
						<?php echo $this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $post['id'])); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $post['id']), array('confirm' => __('Are you sure you want to delete # %s?', $post['id']))); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
