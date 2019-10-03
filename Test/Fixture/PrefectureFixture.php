<?php
/**
 * Prefecture Fixture
 */
class PrefectureFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'prefecture';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'tinyinteger', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => true, 'key' => 'primary'),
		'region_id' => array('type' => 'tinyinteger', 'null' => true, 'default' => null, 'length' => 3, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'name_kana' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'id' => 1,
			'region_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'name_kana' => 'Lorem ipsum dolor sit amet'
		),
	);

}
