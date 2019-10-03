<?php
/**
 * Thumbnail Fixture
 */
class ThumbnailFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'    “id”' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'    “model”' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'    “foreign_key”' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'    “thumbnail”' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'    “dir”' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'    “type”' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'    “size”' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'    “active”' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => '    “id”', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'    “id”' => 1,
			'    “model”' => 'Lorem ipsum dolor ',
			'    “foreign_key”' => 1,
			'    “thumbnail”' => 'Lorem ipsum dolor sit amet',
			'    “dir”' => 'Lorem ipsum dolor sit amet',
			'    “type”' => 'Lorem ipsum dolor sit amet',
			'    “size”' => 1,
			'    “active”' => 1
		),
	);

}
