<!-- メニューバー -->
<div class="nav-scroller py-1 mb-2 ">
  <nav class="nav d-flex justify-content-between">
    <?php foreach ($categorieList as $category) : ?>
      <?php $id = $category['Category']['id']; ?>
      <a class="p-2 text-muted" href=<?php echo "http://blog.dev1/cakephp/categories/view/${id}" ?>>
        <?php echo h($category['Category']['name']); ?>
      </a>
    <?php endforeach; ?>
  </nav>
</div>


<!-- ブログ記事たち -->
<main role="main" class="container">
  <div class="row">
    <div class="col-md-8 blog-main">

      <?php
      if (!empty($this->params['pass'])) {
        $addUrl = "http://blog.dev1/cakephp/posts/add/" . $this->params['pass'][0];
      } else {
        $addUrl = "http://blog.dev1/cakephp/posts/add/";
      }
      ?>
      <a href=<?php echo $addUrl ?>>


        <button class="btn-sm fas fa-pencil-alt float-right mt-4" style="text-color:white">記事を投稿する</button>
      </a>
      <!-- <div class="border-bottom"></div> -->
      <br>
      <?php if (!empty($posts)) { ?>
        <h1 class="pb-4 mb-4 pt-4 text-center post-list">
          投稿記事一覧
        </h1>
      <?php } else { ?>
        <h1 class="pb-4 mt-4 pt-4 text-center post-list">
          投稿記事がありません
        </h1>
      <?php } ?>

      <?php foreach ($posts as $post_) : ?>
        <?php $id = $post_['Post']['id']; ?>
        <div class="blog-post" href=<?php echo "http://blog.dev1/cakephp/posts/view/${id}" ?>>
          <!--  投稿記事のユーザーがログインしているユーザーと一緒なら編集と削除ボタンを表示する -->
          <div class="card mb-n4" style="max-width: 700px;">
            <div class="row no-gutters">
              <div class="col-md-4">
                <?php
                  $thumbId = $post_['Thumbnail']['id'];
                  $thumbName = $post_['Thumbnail']['thumbnailimage'];
                  $thumbPath = $post_['Thumbnail']['dir'];
                  $base_ = "../files/thumbnail/thumbnailimage/";
                  if ($thumbName !== null) {
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
          if ($isPaginationDisplay) {
            $this->Paginator->options(array('class' => 'page-link'));
            echo $this->Paginator->prev(__('Previous'), array('tag' => 'li class="page-item"'));
            echo $this->Paginator->numbers(array('currentTag' => 'a class="page-link"', 'separator' => ''));
            echo $this->Paginator->next(__('Next'), array('tag' => 'li class="page-item"'));
          }
          ?>
        </ul>
      </nav>
    </div><!-- /.blog-main -->
    <?php echo $this->element('sidebar'); ?>

  </div><!-- /.row -->

</main><!-- /.container -->
