<?php
App::uses('JobsAppModel', 'Jobs.Model');

class JobResume extends JobsAppModel {

	public $name = 'JobResume';

	public $displayField = 'name';
	
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a value for name'				
				),
			),
		'email' => array(
			'emailRequired' => array(
				'rule' => array('_emailRequired'),
				'message' => 'Email required.Please try again.',
				'allowEmpty' => true
				),
			),
			'email' => array(
        		'rule'    => array('email', true),
        		'message' => 'Please supply a valid email address.',
				'allowEmpty' => true
    		),
          'phone' => array(
			'notempty' => array(
				'rule' => 'numeric',
				'allowEmpty' => true,
				'message' => 'Phone number should be numeric',
				),
			),
        'street' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone enter street',
				),
			),
         'city' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone enter city',
				),
			),
        'city' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone enter city',
				),
			),
        'state' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone select state',
				),
			),
         'zip' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone enter zip',
				),
			),
        'country' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone select country',
				),
			),
        'leadin' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone enter leadin',
				),
			),
        'addon' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone enter addon',
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
	
	
	
}
