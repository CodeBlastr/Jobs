<?php
App::uses('JobsAppModel', 'Jobs.Model');

class AppJobResume extends JobsAppModel {

	public $name = 'JobResume';

	public $displayField = 'name';
	
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a value for name'				
				),
			)	
		);

	 public $belongsTo = array(
	 	'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
			),
		'Job' => array(
			'className' => 'Jobs.Job',
			'foreignKey' => 'job_id'
			)
		);

/**
 * Constructor
 */
	public function __construct($id = false, $table = null, $ds = null) {
		if(CakePlugin::loaded('Media')) {
			$this->actsAs[] = 'Media.MediaAttachable';
		}
		if (CakePlugin::loaded('Categories')) {
			$this->hasAndBelongsToMany['Category'] = array(
	            'className' => 'Categories.Category',
	       		'joinTable' => 'categorized',
	            'foreignKey' => 'foreign_key',
	            'associationForeignKey' => 'category_id',
	    		'conditions' => array('Categorized.model' => 'JobResume'),
	    		// 'unique' => true,
	            );
			$this->actsAs['Categories.Categorizable'] = array('modelAlias' => 'JobResume');
		}
		parent::__construct($id, $table, $ds);
	}

/**
 * Before save callback
 */
	public function beforeSave($options = array()){
		if (empty($this->data['JobResume']['search_tags'])) {
	        $this->data['JobResume']['search_tags'] = $this->data['JobResume']['leadin'];
		}
	   	return parent::beforeSave($options);
	}

/**
 * After save method
 * Use a job credit on creation
 */
 	public function afterSave($created, $options = array()) {
 		if ($created) {
 			$jobResume = $this->find('first', array('conditions' => array('JobResume.id' => $this->id), 'contain' => array('Job' => array('Creator'))));
			if (!empty($jobResume['Job']['Creator']['email'])) {
	 			$this->__sendMail($jobResume['Job']['Creator']['email'], 'Webpages.job-resume-notification', $jobResume);
	 		}
 		}
 	}
	
}


if (!isset($refuseInit)) {
	class JobResume extends AppJobResume {
	}

}
