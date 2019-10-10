SELECT
zipcode,
jiscode
, pref
, city
, street
FROM zipcode
WHERE
pref = '沖縄県'
OR city = '市';
SELECT DISTINCT pref FROM zipcode
SELECT DISTINCT city FROM zipcode ORDER BY city ASC limit 10;
SELECT DISTINCT city FROM zipcode WHERE pref = '沖縄県' ;
SELECT DISTINCT street FROM zipcode WHERE city = '石垣市' ;

LOAD DATA LOCAL INFILE '/home/testTempfolder/x-ken-all.csv'
INTO TABLE zipcode
FIELDS
TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY ''
LINES
STARTING BY ''
TERMINATED BY '\r\n'
(
jiscode,
zipcode_old,
zipcode,
pref_kana,
city_kana,
street_kana,
pref,
city,
street,
flag1,
flag2,
flag3,
flag4,
flag5,
flag6
);
ALTER TABLE zipcode ADD INDEX zipcode(zipcode)
LOAD DATA LOCAL INFILE '/home/testTempfolder/x-ken-all.csv' IGNORE INTO TABLE zipcode FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
SELECT
zipcode,
jiscode
, pref
, city
, street
FROM zipcode
WHERE
jiscode = 07561;

truncate table zipcode;

CREATE TABLE test (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(50),
text VARCHAR(50),
);

ALTER TABLE users ADD zipcode INT(11) NOT NULL;
ALTER TABLE users ADD pref VARCHAR(10) NOT NULL;
ALTER TABLE users MODIFY city VARCHAR(30) NOT NULL;
ALTER TABLE users MODIFY apartmentName VARCHAR(50) NOT NULL;
ALTER TABLE posts ADD deleted_date datetime DEFAULT NULL;
ALTER TABLE users ADD introduction VARCHAR(300);
ALTER TABLE posts MODIFY deleted TINYINT(1);
alter table profileimage drop introduction;
alter table profileimages change foreign_key user_id int(11) NOT NULL;

alter table profileimages drop introduction;
ALTER TABLE users ADD introduction VARCHAR(300);
CREATE table profileimages (
`id` int(10) unsigned NOT NULL auto_increment,
`model` varchar(20) NOT NULL,
`foreign_key` int(11) NOT NULL,
`name` varchar(32) NOT NULL,
`profileimage` varchar(255) NOT NULL,
`dir` varchar(255) DEFAULT NULL,
`type` varchar(255) DEFAULT NULL,
`size` int(11) DEFAULT 0,
`active` tinyint(1) DEFAULT 1,
PRIMARY KEY (`id`)
);

SELECT id,
user_id,
title,
body,
created,
modified,
categorie_id,
deleted,
deleted_date,
FROM posts
WHERE user_id ==
SELECT id, dir ,thumbnailimage FROM thumbnailimage WHERE post_id = ${post_id}
SELECT * FROM thumbnails
WHERE post_id = (SELECT post_id FROM posts WHERE user_id = ${id})
SELECT * FROM thumbnails
WHERE post_id IN (SELECT post_id FROM posts WHERE user_id = 1)

SELECT * FROM posts WHERE categorie_id = 1 AND NOT id = 326 AND (id = 268 OR id = 270 OR id = 279);

./Console/cake AclExtras.AclExtras aco_sync

wget https://raw.githubusercontent.com/CakeDC/utils/master/Model/Behavior/SoftDeleteBehavior.php
SHOW TABLES LIKE ‘%time_zone%’;

<div class="row">
  <div class="col-sm-8 blog-main">
    <div class="table-responsive">
      <h2><?php echo __('Posts'); ?></h2>
      <table class="table table-striped" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('categorie_id'); ?></th>
            <th><?php echo $this->Paginator->sort('tag_id') ?></th>
            <th><?php echo $this->Paginator->sort('title'); ?></th>
            <th><?php echo $this->Paginator->sort('body'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th><?php echo $this->Paginator->sort('modified'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($posts as $post) : ?>
            <tr>
              <td><?php echo h($post['Post']['id']); ?>&nbsp;</td>
              <td>
                <?php echo h($post['User']['username']); ?>&nbsp;
              </td>
              <td><?php echo h($post['Category']['name']); ?>&nbsp;</td>
              <?php ?>
              <td>
                <?php
                  $tagCount = count($post['Tag']);
                  for ($i = 0; $i < $tagCount; $i++) {
                    echo h($post['Tag'][$i]['name'] . ' ');
                  }
                  ?>
              </td>
              <td><?php echo h($post['Post']['title']); ?>&nbsp;</td>
              <td><?php echo h($this->Text->truncate($post['Post']['body'], 10, array('ellipsis' => '...',))); ?>&nbsp;</td>
              <td><?php echo h($post['Post']['created']); ?>&nbsp;</td>
              <td><?php echo h($post['Post']['modified']); ?>&nbsp;</td>
              <td class="actions">
                <?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?>
                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $post['Post']['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $post['Post']['id']))); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p>
      <?php
      echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
      ));
      ?> </p>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php
        $this->Paginator->options(array('class' => 'page-link'));
        echo $this->Paginator->prev(__('<'), array('tag' => 'li class="page-item"'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a class="page-link"', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
        echo $this->Paginator->next(__('>'), array('tag' => 'li class="page-item"', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        ?>
      </ul> <!-- </div> -->
    </nav>
  </div>

  <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    <div class="actions">
      <h3><?php echo __('Actions'); ?></h3>
      <ul>
        <li><?php echo $this->Html->link(__('New Post'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Post'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
      </ul>
    </div>
  </div>
</div>


<div class="tags view">
  <h2><?php echo __('Tag'); ?></h2>
  <dl>
    <dt><?php echo __('Id'); ?></dt>
    <dd>
      <?php echo h($tag['Tag']['id']); ?>
      &nbsp;
    </dd>
    <dt><?php echo __('Name'); ?></dt>
    <dd>
      <?php echo h($tag['Tag']['name']); ?>
      &nbsp;
    </dd>
  </dl>
</div>
<div class="actions">
  <h3><?php echo __('Actions'); ?></h3>
  <ul>
    <li><?php echo $this->Html->link(__('Edit Tag'), array('action' => 'edit', $tag['Tag']['id'])); ?> </li>
    <li><?php echo $this->Form->postLink(__('Delete Tag'), array('action' => 'delete', $tag['Tag']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tag['Tag']['id']))); ?> </li>
    <li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?> </li>
    <li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
  </ul>
</div>
<div class="related">
  <h3><?php echo __('Related Posts'); ?></h3>
  <?php if (!empty($tag['Post'])) : ?>
    <table cellpadding="0" cellspacing="0">
      <tr>
        <th><?php echo __('Id'); ?></th>
        <th><?php echo __('User Id'); ?></th>
        <th><?php echo __('Title'); ?></th>
        <th><?php echo __('Body'); ?></th>
        <th><?php echo __('Created'); ?></th>
        <th><?php echo __('Modified'); ?></th>
        <th><?php echo __('Categorie Id'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
      </tr>
      <?php foreach ($tag['Post'] as $post) : ?>
        <tr>
          <td><?php echo $post['id']; ?></td>
          <td><?php echo $post['user_id']; ?></td>
          <td><?php echo $post['title']; ?></td>
          <td><?php echo $post['body']; ?></td>
          <td><?php echo $post['created']; ?></td>
          <td><?php echo $post['modified']; ?></td>
          <td><?php echo $post['categorie_id']; ?></td>
          <td class="actions">
            <?php echo $this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $post['id'])); ?>
            <?php echo $this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $post['id'])); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $post['id']), array('confirm' => __('Are you sure you want to delete # %s?', $post['id']))); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>

  <div class="actions">
    <ul>
      <li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
    </ul>
  </div>
</div>

<!-- edit -->
<div class="users form">
  <?php echo $this->Form->create('User'); ?>
  <fieldset>
    <legend><?php echo __('Edit User'); ?></legend>
    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    echo $this->Form->input('group_id');
    echo $this->Form->input('zipcode');
    echo $this->Form->input('pref');
    echo $this->Form->input('city');
    echo $this->Form->input('apartmentName');
    ?>
  </fieldset>
  <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
  <h3><?php echo __('Actions'); ?></h3>
  <ul>

    <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('User.id')))); ?></li>
    <li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
    <li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
    <li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
    <li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
  </ul>
</div>


.popupbg {
position: fixed;
width: 100%;
height: 100%;
background: rgba(0, 0, 0, 0.5);
z-index: 9;
top: 0;
left: 0;
display: none;
}

.popup_wrapper {
width: 500px;
height: 600px;
position: fixed;
top: 50%;
left: 50%;
margin: -300px 0 0 -250px;
z-index: 11;
text-align: center;
display: none;
}

.popup_wrapper .popup {
position: relative;
}

.popup_wrapper .img {
display: inline-block;
width: 500px;
height: 500px;
border: 10px white solid;
border-radius: 9px;
}

.popup_wrapper .caption {
padding: 10px;
font-size: 18px;
color: #FFF;
float: left;
}

.popup_wrapper .next_btn {
/* top: 40%; */
right: 0;
position: absolute;
opacity: 0.5;
}

.popup_wrapper .prev_btn {
/* top: 40%; */
left: 0;
position: absolute;
opacity: 0.5;
}

.background-img {
background-color: white;
z-index: 10;
display: none;
width: 500px;
height: 500px;
position: fixed;
top: 50%;
left: 50%;
margin: -300px 0 0 -250px;
border: 10px white solid;
border-radius: 9px;
}

.close_image {
width: 35px;
float: right;
padding-bottom: 0.7em;
outline: none;
margin-top: 0.7em;
}

/* line 117, ../sass/lightbox.sass */

.close_image:hover {
cursor: pointer;
}

.spiner_wrapper {
position: fixed;
top: 50%;
left: 50%;
text-align: center;
z-index: 12;
display: none;
}

.spiner_wrapper .spiner {
position: absolute;
margin: auto;
top: 0;
left: 0;
right: 0;
bottom: 0;
}
