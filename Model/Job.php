<?php
App::uses('JobsAppModel', 'Jobs.Model');

class Job extends JobsAppModel {

	public $name = 'Job';

	public $displayField = 'name';
	
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a value for name'				
				),
			),
		'description' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a value for description',
				),
			),
          'is_featured' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please select radio button',
				),
			),			
		);

	public $belongsTo = array('Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		));
		
		

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}
	
	public function beforeSave($options = array()){
		
	   	return parent::beforeSave($options);
	}
}
