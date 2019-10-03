    <aside class="col-md-4 blog-sidebar">
      <div class="p-4 mb-3 rounded">
        <!-- <h4 class="font-italic">About</h4> -->
        <!-- <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p> -->
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
