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
			echo $this->element('profileimage');
			?>
			<h3 class="mb-4"><?php echo $user['User']['username']; ?></h3>

			<div class="custom-file">
				<?php echo $this->Form->create('Profileimage', array('type' => 'file', 'entype' => 'multipart/form-data'));
				?>

				<input type="file" class="custom-file-input w-75 mx-auto profile" id="customFile" name="data[Profileimage][profile]">
				<label class="custom-file-label w-75 mx-auto text-left" for="customFile" data-browse="参照">プロフィール画像を選択...</label>
				<?php echo $this->Form->input("Profileimage.model", array('type' => 'hidden', 'value' => 'User')); ?>
			</div>
			<?php
			echo $this->Form->create('User', array(

				'type' => 'file', 'entype' => 'multipart/form-data'
			), array('class' => "form-signin"));
			?>

			<label class="float-left mb-n1 mt-5">自己紹介文</label>

			<?php
			echo $this->Form->input('introduction', array('class' => 'w-100 p-3 mb-4 mt-4', 'label' => false, 'placeholder' => 'プロフィールの自己紹介文です。', 'rows' => 5));
			?>
			<?php
			echo $this->Form->input('id', array('type' => 'hidden'));
			?>
			<label class="float-left">ユーザーID</label>
			<?php
			echo $this->Form->input('username', array('class' => 'form-control mb-4', 'placeholder ' => 'ユーザー名', 'size' => '30', 'style' => 'margin-bottom: 1em', 'label' => false));
			?>
			<label class="float-left">パスワード</label>
			<?php
			echo $this->Form->input('password', array('class' => 'form-control mb-4', 'placeholder' => 'パスワード', 'style' => 'margin-bottom: 1em', 'label' => false));
			?>
			<div class="row">

				<div class="col-6">
					<label class="float-left">郵便番号</label>
					<input name="data[User][zipcode]" id="zipcode" class="form-control " value=<?php echo $user['User']['zipcode'] ?> placeholder="郵便番号" required label="郵便番号" label=true>
				</div>
				<div class="col-6">
					<label class="float-left">都道府県</label>
					<?php
					echo $this->Form->input('pref', array('id' => 'pref', 'class' => 'custom-select select-list mb-4', 'type' => 'select', 'options' => $prefList, 'label' => false));
					?>
				</div>
			</div>
			<label class="float-left">市区町村・番地</label>
			<?php
			echo $this->Form->input('city', array('id' => 'adress', 'class' => 'form-control mb-4', 'size' => '40', 'placeholder' => '市区町村', 'label' => false));
			?>
			<label class="float-left">マンション名・部屋番号名</label>
			<?php
			echo $this->Form->input('apartmentName', array('class' => 'form-control mb-4', 'placeholder' => 'マンション名・部屋番号等', 'label' => false));
			echo $this->Form->input('group_id', array('type' => 'hidden'));
			?>
			<button class=" btn btn-lg btn-success btn-block mt-4" type="submit">編集を保存</button>
		</div>
	</div>
</div>
