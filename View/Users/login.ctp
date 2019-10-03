<?php echo $this->Html->meta(array('name' => 'viewport', "content" => array("width=device-width, initial-scale=1"))); ?>

<?php $this->Html->css('signin.css', null, array('inline' => false))
?>
<?php
echo $this->Form->create('User', array(
  'url' => array(
    'controller' => 'users',
    'action' => 'login',
  )
), array('class' => "form-signin"));
?>
<div class="my-body">
  <div class="text-center">
    <!-- <form class="form-signin"> -->
    <div class="form-signin">
      <h1 class="h3 mb-3 font-weight-normal">ログイン</h1>
      <label class="sr-only">ユーザーIDまたはEmailアドレス</label>
      <input name="data[User][username]" class="form-control" placeholder="ユーザーIDまたはEmailアドレス" required autofocus>
      <label for="inputPassword" class="sr-only">パスワード</label>
      <input type="password" name="data[User][password]" id="inputPassword" class="form-control mt-4" placeholder="パスワード" required>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="remember-me" id="rememberCheck">
        <label class="form-check-label" for="rememberCheck">
          次回から自動的にログイン
        </label>

      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>
    </div>
  </div>
</div>
