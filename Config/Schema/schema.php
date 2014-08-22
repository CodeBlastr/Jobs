<?php 
class JobsSchema extends CakeSchema {

	public $renames = array();

	public function __construct($options = array()) {
		parent::__construct($options);
	}

	public function before($event = array()) {
	    $db = ConnectionManager::getDataSource('default');
	    $db->cacheSources = false;
		App::uses('UpdateSchema', 'Model'); 
		$this->UpdateSchema = new UpdateSchema;
		$before = $this->UpdateSchema->before($event);
		return $before;
	}

	public function after($event = array()) {
		$this->_installData($event);
		$this->UpdateSchema->rename($event, $this->renames);
		$this->UpdateSchema->after($event);
	}

	public $jobs = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'compensation' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_featured' => array('type' => 'boolean', 'null' => false, 'default' => 0),
		'creator_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'Creator', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'Modifier', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'Created Date'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'Modified Date'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $job_resumes = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'job_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cover' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'street' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'state' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'zip' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'country' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'leadin' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'addon' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'creator_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'Creator', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'Modifier', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'Created Date'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'Modified Date'),
		'search_tags' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'), 
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Install Data Method
 *
 * @param string $event
 */
	protected function _installData($event) {
		if (isset($event['create'])) {
			switch ($event['create']) {
	            case 'jobs':
	                $Model = ClassRegistry::init('Jobs.Job');
					$Model->create();
					$Model->saveAll(array(
						'Job' => array(
							'name' => 'Sales Representative',
							'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla varius, lectus vulputate accumsan dapibus, mauris tortor ullamcorper dolor, pellentesque pulvinar tellus neque sit amet sapien. Nunc non dapibus tellus. Etiam luctus velit eget tellus vestibulum, sagittis faucibus erat aliquet. Curabitur fermentum massa dapibus auctor elementum. Cras feugiat semper accumsan. Aenean fringilla ut ipsum quis molestie. In ultrices massa risus, vitae dictum dui porttitor at. Aliquam erat volutpat. Integer mattis, neque varius pharetra cursus, neque lacus adipiscing massa, id mollis urna tortor eget risus. Aliquam blandit ipsum id scelerisque auctor.',
							'created' => date('Y-m-d h:i:s'),
							'modified' => date('Y-m-d h:i:s'),
						)
					));
				break;
			}
		}
	}
}
