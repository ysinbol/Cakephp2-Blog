<?php
App::uses('AppModel', 'Model');
/**
 * Test Model
 *
 */
class Test extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'test';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

}
