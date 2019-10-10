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

      <div class="list-group" style="max-width: 400px;">

        <h5 class="mb-1 rank-title">人気の記事</h5>
        <a href="#" class="list-group-item list-group-item-action d-flex ranking-list">
          <div class="d-inline-block position-relative">
            <div class="rank-item rank-1"> </div>
            <?php
            $thumbId = $posts[0]['Thumbnail']['id'];
            $thumbName = $posts[0]['Thumbnail']['thumbnailimage'];
            $thumbPath = $posts[0]['Thumbnail']['dir'];
            echo $this->element('displayThumbnail', ['thumbId' => $thumbId, 'thumbName' => $thumbName, 'thumbPath' => $thumbPath]);
            ?>
          </div>
          <div class="d-inline-block">
            <h5 class="mb-1"> <?php echo $this->Text->truncate($posts[0]['Post']['title'], 20, array('ellipsis' => '...',)); ?></h5>
            <small class="text-muted">
              <?php
              $date = $posts[0]['Post']['created'];
              echo date('Y-m-d', strtotime(str_replace('-', '/', $date)));
              ?>
            </small>
          </div>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex ranking-list">
          <div class="d-inline-block position-relative">
            <div class="rank-item rank-2"> </div>
            <?php
            $thumbId = $posts[1]['Thumbnail']['id'];
            $thumbName = $posts[1]['Thumbnail']['thumbnailimage'];
            $thumbPath = $posts[1]['Thumbnail']['dir'];
            echo $this->element('displayThumbnail', ['thumbId' => $thumbId, 'thumbName' => $thumbName, 'thumbPath' => $thumbPath]);
            ?>
          </div>
          <div class="d-inline-block">
            <h5 class="mb-1"> <?php echo $this->Text->truncate($posts[1]['Post']['title'], 20, array('ellipsis' => '...',)); ?></h5>
            <small class="text-muted">
              <?php
              $date = $posts[1]['Post']['created'];
              echo date('Y-m-d', strtotime(str_replace('-', '/', $date)));
              ?>
            </small>
          </div>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex ranking-list">
          <div class="d-inline-block position-relative">
            <div class="rank-item rank-3"> </div>
            <?php
            $thumbId = $posts[2]['Thumbnail']['id'];
            $thumbName = $posts[2]['Thumbnail']['thumbnailimage'];
            $thumbPath = $posts[2]['Thumbnail']['dir'];
            echo $this->element('displayThumbnail', ['thumbId' => $thumbId, 'thumbName' => $thumbName, 'thumbPath' => $thumbPath]);
            ?>
          </div>
          <div class="d-inline-block">
            <h5 class="mb-1"> <?php echo $this->Text->truncate($posts[2]['Post']['title'], 20, array('ellipsis' => '...',)); ?></h5>
            <small class="text-muted">
              <?php
              $date = $posts[2]['Post']['created'];
              echo date('Y-m-d', strtotime(str_replace('-', '/', $date)));
              ?>
            </small>
          </div>
        </a>
      </div>

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
