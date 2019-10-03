<?php
App::uses('AppModel', 'Model');
/**
 * Profileimage Model
 *
 * @property  $
 */
class Profileimage extends AppModel
{

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	public $actsAs = array(
		'Upload.Upload' => array(
			'profile' => [
				'thumbnailSizes' => [
					'profile150' => '150x150',
				],
				'thumbnailMethod' => 'php'
			],
			'thumbnail' => [
				'thumbnailSizes' => [
					'profile150' => '150x150',
				],
				'thumbnailMethod' => 'php'
			],
		)
	);

	public $validate = array(
		'profile' => array(
			'extension' => array(
				'rule' => array(
					'extension', array(
						'jpg', 'jpeg', 'png', 'gif'
					)  // 拡張子を配列で定義
				),
				'message' => array('file extension error')
			)
		)
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
}
