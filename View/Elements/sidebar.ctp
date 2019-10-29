<?php App::import('Vendor', 'util/datecalc'); ?>
<aside class="col-md-4 blog-sidebar">
  <div class="p-4 mb-3 rounded">
    <div class="d-flex justify-content-center">
      <?php
      if (!empty($user)) {
        echo $this->element('profileimage');
        ?>
    </div>
    <h3 class="text-center"><?php echo $this->Html->link(__($user['User']['username']), array('controller' => 'users', 'action' => 'view', $user['User']['id'])); ?></h3>
    <?php
      $introduction = $user['User']['introduction'];
      if ($introduction !== null) { ?>
      <p class="text-center"> <?php echo $introduction; ?></p>
  <?php
    }
  }
  ?>
  </div>

  <?php echo $this->element('articleranking'); ?>

  <h5 class="mb-1 rank-title mt-5">新着の記事</h5>
  <?php foreach ($newArticles as $newArticle) : ?>
    <?php $id = $newArticle['Post']['id']; ?>
    <a href=<?php echo "http://blog.dev1/cakephp/posts/view/${id}" ?> class="list-group-item list-group-item-action d-flex">
      <div class="d-inline-block position-relative">
        <?php
          $thumbId = $newArticle['Thumbnail']['id'];
          $thumbName = $newArticle['Thumbnail']['thumbnailimage'];
          $thumbPath = $newArticle['Thumbnail']['dir'];
          echo $this->element('displayThumbnail', ['thumbId' => $thumbId, 'thumbName' => $thumbName, 'thumbPath' => $thumbPath]);
          ?>
      </div>
      <div class="d-inline-block">
        <h5 class="mb-1"> <?php echo $this->Text->truncate($newArticle['Post']['title'], 15, array('ellipsis' => '...',)); ?>
        </h5><span class="badge badge-light">New</span>
        <small class="text-muted">
          <?php
            $date = $newArticle['Post']['created'];
            $dateCalc = new util\DateCalc();
            echo $dateCalc->convert_to_fuzzy_time($date);
            ?>
        </small>
      </div>
    </a>
  <?php endforeach; ?>
  <div class="p-4">
    <h4 class="font-italic">Archives</h4>
    <ol class="list-unstyled mb-0">
      <li><a href="#">March 2014</a></li>
      <li><a href="#">February 2014</a></li>
      <li><a href="#">January 2014</a></li>
      <li><a href="#">December 2013</a></li>
      <li><a href="#">November 2013</a></li>
      <li><a href="#">October 2013</a></li>
      <li><a href="#">September 2013</a></li>
      <li><a href="#">August 2013</a></li>
      <li><a href="#">July 2013</a></li>
      <li><a href="#">June 2013</a></li>
      <li><a href="#">May 2013</a></li>
      <li><a href="#">April 2013</a></li>
    </ol>
  </div>

  <div class="p-4">
    <h4 class="font-italic">Elsewhere</h4>
    <ol class="list-unstyled">
      <li><a href="https://github.co.jp/">GitHub</a></li>
      <li><a href="https://twitter.com/">Twitter</a></li>
      <li><a href="https://www.facebook.com/FacebookJapan/">Facebook</a></li>
    </ol>
  </div>
</aside><!-- /.blog-sidebar -->
