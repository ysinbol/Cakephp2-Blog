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
<div class="my-body">
	<div class="text-center">
		<!-- <form class="form-signin"> -->
		<div class="form-signin">
			<h1 class="h3 mb-3 font-weight-normal">新規登録</h1>
			<!-- <label for="UserUsername">ユーザーIDまたはEmailアドレス</label>
			<div class="input text required">
				<input name="username" class="form-control" placeholder="ユーザーIDまたはEmailアドレス" type="text" id="UserUsername" required="required">
			</div>
			<label for="inputPassword" class="sr-only">パスワード</label>
			<input type="password" name="password" id="inputPassword" class="form-control mt-4" placeholder="パスワード" required> -->
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
					<!-- <label class="sr-only">郵便番号 -(ハイフン)なしで入力</label>
					<input name="data[User][zipcode]" id="zipcode" class="form-control " placeholder="郵便番号" required> -->
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
			<?php
			// echo $this->Form->input('group_id', array('class' => 'form-control mb-4', 'label' => false))
			?>

			<button class="btn btn-lg btn-success btn-block mt-4" type="submit">新規登録</button>
			<p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>


		</div>
	</div>
</div>

<!-- <div class="users form container"> -->
<?php //echo $this->Form->create('User');
?>
<fieldset>
	<legend><?php //echo __('Add User');
					?></legend>
	<?php
	// echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'ユーザー名', 'size' => '30', 'style' => 'margin-bottom: 1em'));
	// echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'パスワード', 'style' => 'margin-bottom: 1em'));
	?>

	<div class="form-row">
		<div class="form-group col-md-3">
			<?php
			//	echo $this->Form->input('zipcode', array('id' => 'zipcode', 'class' => 'form-control', 'label' => '郵便番号 -(ハイフン)なしで入力', 'placeholder' => '郵便番号'));
			?>
		</div>
		<div class="form-group col-md-3">
			<?php
			//	echo $this->Form->input('pref', array('id' => 'pref', 'class' => 'custom-select', 'label' => '都道府県', 'type' => 'select',  'options' => $prefList));
			?>
		</div>
		<div class="form-group col-md-6">
			<?php
			//	echo $this->Form->input('adress1', array('id' => 'adress', 'class' => 'form-control', 'label' => '市区町村・番地', 'size' => '40'));
			?>
		</div>
	</div>
	<?php //echo $this->Form->input('adress2', array('class' => 'form-control mb-3', 'label' => 'マンション名・部屋番号', 'placeholder' => 'マンション名・部屋番号等'))
	?>

	<div class="form-row">
		<div class="form-group col-md-4">
			<?php
			//	echo $this->Form->input('regionS', array('id' => 'regionSelect', 'class' => 'custom-select', 'label' => '地方', 'type' => 'select',  'options' => $regionList));
			?>
		</div>
		<div class="form-group col-md-4">
			<?php
			//	echo $this->Form->input('pref', array('id' => 'prefSelect', 'class' => 'custom-select', 'label' => '都道府県', 'type' => 'select', 'option' => ''));
			?>
		</div>
		<div class="form-group col-md-4">
			<?php
			//	echo $this->Form->input('city', array('id' => 'citySelect', 'class' => 'custom-select', 'label' => '市区町村', 'type' => 'select'));
			?>
		</div>
	</div>
</fieldset>
<!-- <div class="row">
		<div class="col-0 mx-auto">
			<?php echo $this->Form->submit(__('登録する'), array('class' => 'btn-sm btn-outline-primary mt-4')); ?>
		</div>
	</div> -->
</div>
