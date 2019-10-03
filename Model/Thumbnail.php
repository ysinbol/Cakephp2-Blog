<?php
App::uses('AppModel', 'Model');
/**
 * Thumbnail Model
 *
 */
class Thumbnail extends AppModel
{

	public $actsAs = array(
		'Upload.Upload' => array(
			'thumbnailimage' => [
				'thumbnailSizes' => [
					'small' => '150x150',
					'normal' => '200x200',
				],
				'thumbnailMethod' => 'php'
			],
			'thumbnail' => [
				'thumbnailSizes' => [
					'small' => '150x150',
					'normal' => '200x200',
				],
				'thumbnailMethod' => 'php'
			],
		)
	);

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'    “id”' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'    “model”' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'    “foreign_key”' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'    “thumbnail”' => array(
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
}
