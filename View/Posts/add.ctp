<?php echo $this->Form->create(
	'Post',
	array('type' => 'file', 'entype' => 'multipart/form-data')
); ?>
<fieldset>
	<h1 class="pb-4 pt-4"><?php echo __('記事の投稿'); ?></h1>

	<h2>タイトル</h2>
	<?php
	echo $this->Form->input('title', array('class' => 'w-50', 'label' => false));
	?>
	</div>
	<h2>本文</h2>
	<?php
	echo $this->Form->input('body', array('class' => 'w-100 p-3', 'label' => false));
	?>

	<h2><?php echo __('カテゴリーの設定') ?></h2>

	<?php echo $this->Form->input('categorie_id', array('class' => 'custom-select', 'label' => false, 'value' => $value)); ?>

	<h2><?php echo __('タグの設定'); ?></h2>

	<?php
	echo $this->Form->input('Tag', array(
		'type' => 'select',
		'options' => $tags, 'multiple' => 'checkbox',
		'label' => false
	));
	?>


	<h2>画像の投稿</h2>

	<div class="custom-file">
		<?php echo $this->Form->create('Attachment', array('type' => 'file', 'entype' => 'multipart/form-data')); ?>
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="customFile" name="data[Attachment][Attachment][]" multiple>
			<label class="custom-file-label" for="customFile" data-browse="参照">記事に挿入する画像を選択...</label>
		</div>
	</div>
	<h2>サムネイルの設定</h2>

	<div class="custom-file">
		<?php echo $this->Form->create('Thumbnail', array('type' => 'file', 'entype' => 'multipart/form-data'));
		?>
		<input type="file" class="custom-file-input" id="customFile" name="data[Thumbnail][thumbnailimage]">
		<label class="custom-file-label" for="customFile" data-browse="参照">サムネイル画像選択...</label>
		<?php echo $this->Form->input("Thumbnail.model", array('type' => 'hidden', 'value' => 'Post')); ?>

	</div>
	※サムネイル画像は横700pxでお願いします。

</fieldset>
<div class="row">
	<div class="col-0 mx-auto">
		<?php echo $this->Form->submit(__('記事を投稿する'), array("class" => "btn btn-outline-primary rounded-pill mt-5")); ?>
	</div>
</div>


<style>
	h2 {
		margin-top: 1.8em;
		margin-bottom: 1em;
	}
</style>

</div>
