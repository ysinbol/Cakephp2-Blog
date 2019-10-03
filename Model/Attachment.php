<?php
App::uses('AppModel', 'Model');
/**
 * Attachment Model
 *
 */
class Attachment extends AppModel
{

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';
	public $actsAs = array(
		'Upload.Upload' => array(
			'attachment' => [
				'thumbnailSizes' => [
					'small' => '150x150',
					'normal' => '200x200',
				],
				'thumbnailMethod' => 'php'
			]

		)
	);

	public $belongsTo = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'foreign_key',
			'dependent' => true,
		),
	);
}
