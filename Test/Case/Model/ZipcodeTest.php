<?php
App::uses('Zipcode', 'Model');

/**
 * Zipcode Test Case
 */
class ZipcodeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.zipcode'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Zipcode = ClassRegistry::init('Zipcode');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Zipcode);

		parent::tearDown();
	}

}
