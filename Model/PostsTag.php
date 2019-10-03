<?php
App::uses('AppModel', 'Model');
/**
 * PostsTag Model
 *
 * @property Post $Post
 * @property Tag $Tag
 */
class PostsTag extends AppModel
{

	public $actsAs = array('Search.Searchable', 'Containable');	//Searchableビヘイビアの読み込み設定

	// 検索タイプの指定
	public $filterArgs = array(
		'name' => array('type' => 'like', 'field' => 'Tag.name')
	);
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'post_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tag_id' => array(
			'numeric' => array(
				'rule' => array('numeric', 'multiple', array('min' => 1)),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'post_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
