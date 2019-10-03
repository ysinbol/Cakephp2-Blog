<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property User $User
 */
class Post extends AppModel
{
	public $actsAs = array(
		'Search.Searchable',
		'SoftDelete',
		'Containable'
	);

	// 検索タイプの指定
	public $filterArgs = array(
		array('name' => 'keyword', 'type' => 'subquery', 'method' => 'multiWordSearch', 'field' => 'Post.id'),
	);

	// filterArgsで設定されたこのメソッドに飛ばされる。
	public function multiWordSearch($data = array())
	{
		// PostsTagにcontainableやsearchプラグインを使えるようにしてる。
		$this->PostsTag->Behaviors->attach('Containable', array('autoFields' => false));
		$this->PostsTag->Behaviors->attach('Search.Searchable');

		// 入力されたキーワードの全角スペースを半角スペースに直す
		$keyword = mb_convert_kana($data['keyword'], "s", "UTF-8");
		// 半角スペースでキーワードを分割して１つ１つを配列にする。
		$keywords = explode(' ', $keyword);

		// and検索の配列を定義する。
		$conditions['AND'] = array();
		foreach ($keywords as $keyword) {
			$condition = array(
				'OR' => array(
					array('Tag.name' => $keyword),
					$this->alias . '.title LIKE' => '%' . $keyword . '%', //%は0文字以上
					'Category.name LIKE' => '%' . $keyword . '%',			   //likeは部分一致
				)
			);
			// ANDの配列にOR検索のconditionを入れて行く。
			array_push($conditions['AND'], $condition);
		}

		$query = $this->PostsTag->getQuery('all', array(
			//conditionsは検索条件
			'conditions' => $conditions,
			// 取得するカラム
			'fields' => array('post_id'),
			// Tag以外のデータを取得する...かな、上の方でtagの検索条件を設定しているから被ら無いように避けてるのか
			// 'contain' => array('Tag')
		));
		// 設定した条件で探したデータを返す。
		return $query;
	}



	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'notBlank' => array(
				'rule' => array('notblank'),
			)
		),
		'Tag' => array(
			'Tag' => array(
				'rule' => array('multiple', array('min' => 1)),
				// 'required' => true,
				// // 'allowEmpty' => true,
				'message'  => 'タグを選択して下さい',
			)
		),
		// 'Image' => array(
		// 		// 'upload-file' => array(
		// 		// 		'rule' => array('uploadError'),
		// 		// 		'message' => array('Error uploading file')
		// 	  //  ),

		// 		'extension' => array(
		// 				'rule' => array('extension', array(
		// 						'jpg','jpeg','png','gif','') // 拡張子を配列で定義
		// 				),
		// 				'message' => array('ファイル形式が間違っています。')
		// 		 ),

		// 		// 'mimetype' => array(
		// 		// 		 'rule' => array('mimeType', array(
		// 		// 					'image/jpeg','image/png', 'image/gif')
		// 		// 			),
		// 		// 			'message' => array('MIME type error')
		// 		//  ),

		// 		 'size' => array(
		// 				'maxFileSize' => array(
		// 						'rule' => array('fileSize', '<=', '10MB'), // 10MB以下
		// 						'message' => array('file size error')
		// 			),
		// 		),
		//  ),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'categorie_id'
		)
	);

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Tag' =>
		array(
			'className' => 'Tag',
			'joinTable' => 'posts_tags',
			'foreignKey' => 'post_id',
			'associationForeignKey' => 'tag_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with' => 'PostsTag',
			'dependent' => true
		)
	);


	public $hasMany = array(
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'post_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'dependent' => true,
			'conditions' => array(
				'Image.post_id' => 'Post.id',
			),
		),
		'Attachment' => array(
			'className' => 'Attachment',
			'foreignKey' => 'foreign_key',
			'dependent' => true,
			'conditions' => array(
				'Attachment.model' => 'Post',
			),
		),
	);

	public $hasOne = array(
		'Thumbnail' => array(
			'className' => 'Thumbnail',
			'foreignKey' => 'post_id',
			'dependent' => true,
			'conditions' => array(
				'Thumbnail.model' => 'Post',
			),
		)
	);

	// バリテーション(Save)を行う前に呼び出される関数
	public function beforeValidate($options = array())
	{
		foreach ($this->hasAndBelongsToMany as $k => $v) {
			// ここではTagにデータが入ってるか
			if (isset($this->data[$k][$k])) {
				// PostモデルにTagモデルに入ってるフィールドを渡す。
				$this->data[$this->alias][$k] = $this->data[$k][$k];
			}
		}
		return true;
	}
}
