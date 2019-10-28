<?php $this->Html->script('users_add', array('inline' => false)) ?>

<?php echo $this->Html->meta(array('name' => 'viewport', "content" => array("width=device-width, initial-scale=1"))); ?>

<?php $this->Html->css('signin.css', null, array('inline' => false))
?>
<?php
echo $this->Form->create('User', array(
	'url' => array(
		'controller' => 'users',
		'action' => 'add',
	), 'type' => 'file', 'entype' => 'multipart/form-data'
), array('class' => "form-signin"));
?>

<div class="text-center">
	<div class="form-signin">
		<h1 class="h3 mb-3 font-weight-normal">新規登録</h1>
		<?php
		echo $this->Form->input('username', array('class' => 'form-control mb-4', 'placeholder ' => 'ユーザー名', 'size' => '30', 'style' => 'margin-bottom: 1em', 'label' => false));
		echo $this->Form->input('password', array('class' => 'form-control mb-4', 'placeholder' => 'パスワード', 'style' => 'margin-bottom: 1em', 'label' => false));
		?>
		<div class="d-flex justify-content-center align-items-center ">
			<p style="display:none" id="inputZipErrorMsg" class="mb-n2"></p>
		</div>
		<div class="row">
			<div class="col-6">
				<?php echo $this->Form->input('zipcode', array(
					'class' => 'form-control mb-4', 'placeholder' => '郵便番号', 'style' => 'margin-bottom: 1em', 'label' => false, 'id' => 'zipcode', 'type' => 'text'
				)); ?>
			</div>
			<div class="col-6">
				<?php
				echo $this->Form->input('pref', array('id' => 'pref', 'class' => 'custom-select select-list mb-4', 'type' => 'select', 'options' => $prefList, 'label' => false));
				?>
			</div>
		</div>
		<?php
		echo $this->Form->input('city', array('id' => 'adress', 'class' => 'form-control mb-4', 'size' => '40', 'placeholder' => '市区町村', 'label' => false));
		?>
		<?php
		echo $this->Form->input('apartmentName', array('class' => 'form-control mb-4', 'placeholder' => 'マンション名・部屋番号等', 'label' => false))
		?>

		<button class="btn btn-lg btn-success btn-block mt-4" type="submit">新規登録</button>
		<p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>
	</div>
</div>
