<div class="posts form">
	<?php echo $this->Form->create(
		'Post',
		array('type' => 'file', 'entype' => 'multipart/form-data')
	); ?>
	<fieldset>
		<h1 class="pb-4 pt-4 text-center mb-5"><?php echo __('記事の編集'); ?></h1>

		<h2 class="text-center">サムネイル</h2>

		<?php
		echo $this->Form->input('id');
		$this->Form->input('user_id');

		$thumbId = $post['Thumbnail']['id'];
		$thumbName = $post['Thumbnail']['thumbnailimage'];
		$thumbPath = $post['Thumbnail']['dir'];
		$base_ = "../files/thumbnail/thumbnailimage/";
		?>


		<div class="d-flex justify-content-center">
			<?php
			if ($thumbName !== null) {
				echo $this->Html->image($base_ . $thumbPath . DS . $thumbName);
				?>
		</div>
		<div class="d-flex justify-content-center">
		<?php
			echo $this->Form->submit($thumbName . 'を削除する', array('name' => "${thumbId}", "class" => "btn btn-outline-secondary mt-4"));
		}
		?>
		</div>
</div>
</div>
<br>
<h2>タイトル</h2>
<?php
echo $this->Form->input('title', array('class' => 'w-50', 'label' => false));
?>
<h2>本文</h2>
<?php
echo $this->Form->input('body', array('class' => 'w-100 p-3', 'label' => false));
?>
<br>
<br>
<h2><?php echo __('カテゴリーの設定') ?></h2>

<?php echo $this->Form->input('categorie_id', array('class' => 'custom-select', 'label' => false)); ?>

<h2><?php echo __('タグの設定'); ?></h2>

<?php
echo $this->Form->input('Tag', array(
	'type' => 'select',
	'options' => $tags, 'multiple' => 'checkbox',
	'label' => false
));
?>
<br>


<?php
// 画像の数を取得
$photoCount = count($post['Attachment']);
?>
<?php if ($photoCount !== 0) {
	?>
	<h2>画像の削除</h2>
<?php
}
?>

<div class="parent">
	<?php
	for ($i = 0; $i < $photoCount; $i++) {
		$imgId = $post['Attachment'][$i]['id'];
		$imgName = $post['Attachment'][$i]['attachment'];
		$imgPath = $post['Attachment'][$i]['dir'];
		$base = "../files/attachment/attachment/";
		?>
		<div class="d-inline-block w-25 mb-4">
			<img src=<?php echo "/cakephp/img/" . $base . $imgPath . DS . 'normal_' . $imgName ?> name=<?php echo $imgId ?> alt="" class="" />
			<input name=<?php echo $imgId ?> class="submit btn btn-outline-secondary mt-2 deleteImg" id=<?php echo $imgId ?> type="submit" value=<?php echo $imgName . 'を削除する' ?> />
		</div>
	<?php
	}
	?>
</div>
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
</fieldset>
<div class="row">
	<div class="col-0 mx-auto">
		<?php echo $this->Form->submit(__('記事を保存する'), array("class" => "btn btn-outline-primary rounded-pill mt-5")); ?>
	</div>
</div>
</div>

<style>
	h2 {
		margin-top: 1.75em;
		margin-bottom: 1em;
	}
</style>
