<?php
App::uses('JobResume', 'Jobs.Model');

/**
 * JobResume Test Case
 *
 */
class JobResumeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
        'plugin.Jobs.JobResume'
        );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->JobResume = ClassRegistry::init('Jobs.JobResume');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->JobResume);

		parent::tearDown();
	}
    
    
	public function testSave() {
		debug('no tests!!!');
		exit;
	}
}
