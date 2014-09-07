<?php
App::uses('JobsAppModel', 'Jobs.Model');

class AppJob extends JobsAppModel {

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
			)		
		);

	public $belongsTo = array(
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id'
			)
		);

/**
 * Has many
 * 
 * @var array $hasMany
 */
	public $hasMany = array(
		'JobResume' => array(
			'className' => 'Jobs.JobResume',
			'foreignKey' => 'job_id',
			'dependent' => false
		)
	);

/**
 * Constructor
 */
	public function __construct($id = false, $table = null, $ds = null) {
		if (CakePlugin::loaded('Categories')) {
			$this->hasAndBelongsToMany['Category'] = array(
	            'className' => 'Categories.Category',
	       		'joinTable' => 'categorized',
	            'foreignKey' => 'foreign_key',
	            'associationForeignKey' => 'category_id',
	    		'conditions' => array('Categorized.model' => 'Job'),
	    		'counterCache' => 'record_count'
	    		// 'unique' => true,
	            );
			$this->actsAs['Categories.Categorizable'] = array('modelAlias' => 'Job');
		}
		parent::__construct($id, $table, $ds);
	}
}


if (!isset($refuseInit)) {
	class Job extends AppJob {
	}

}
