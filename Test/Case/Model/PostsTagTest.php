<?php
App::uses('PostsTag', 'Model');

/**
 * PostsTag Test Case
 */
class PostsTagTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.posts_tag',
		'app.post',
		'app.user',
		'app.group',
		'app.category',
		'app.tag'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PostsTag = ClassRegistry::init('PostsTag');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PostsTag);

		parent::tearDown();
	}

}
