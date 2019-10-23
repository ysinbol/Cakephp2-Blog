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
ALTER TABLE zipcode ADD INDEX index01(zipcode)
ALTER TABLE zipcode DROP INDEX zipcode

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
ALTER TABLE zipcode MODIFY zipcode INT(11) NOT NULL;
ALTER TABLE users MODIFY apartmentName VARCHAR(50) NOT NULL;
ALTER TABLE posts ADD accesscount INT(11) DEFAULT 0;
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







<div class="container">
  <div class="alert alert-success alert-dismissible fade show alert-uploaded" role="alert">
    <strong>報告:</strong> CSVインポートが完了しました！
    <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <?php echo $this->Form->create(
    'Post',
    array('type' => 'file', 'entype' => 'multipart/form-data')
  ); ?>

  <h2 class="mb-5 mt-5 text-center">csvファイルアップロード(DB更新)</h2>

  <?php
  echo $this->Form->input('table', array('class' => 'custom-select mb-4', 'label' => 'インポートするテーブル名', 'type' => 'select', 'options' => $tableList));
  ?>

  <div class="custom-file">
    <input type="file" class="custom-file-input" id="customFile" name="upfile">
    <label class="custom-file-label" for="customFile" data-browse="参照">csvファイルを選択...</label>
  </div>



  <div class="d-flex justify-content-center align-items-center">
    <?php echo $this->Form->submit(__('アップロード'), array('class' => 'btn btn-outline-primary mt-4', 'id' => 'upload', 'type' => 'button')); ?>
    <?php echo $this->Form->submit(__('キャンセル'), array('class' => 'btn btn-outline-success mt-4 ml-2', 'id' => 'uploadCansel', 'type' => 'button')); ?>
  </div>




</div>
</div>
<div class="csv-loader">
  <div class="row mt-4 ml-2">
    <div class="col-5">
      <div class="spinner-border text-secondary float-right" role="status">
        <span class="sr-only ">Loading...</span>
      </div>
    </div>

    <div class="col ml-n4">
      <h3 class="float-left">DBを更新中です...</h>
    </div>
  </div>
</div>
</div>
