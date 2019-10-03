<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 */
class Category extends AppModel {
	public $actsAs = array('Search.Searchable');	//Searchableビヘイビアの読み込み設定

	// 検索タイプの指定
	public $filterArgs = array(
			'name' => array('type' => 'like')
	);
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'categorie_id'
		 ),
	);


}
