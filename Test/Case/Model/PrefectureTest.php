<?php
App::uses('Prefecture', 'Model');

/**
 * Prefecture Test Case
 */
class PrefectureTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.prefecture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Prefecture = ClassRegistry::init('Prefecture');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Prefecture);

		parent::tearDown();
	}

}
