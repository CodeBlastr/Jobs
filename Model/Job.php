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

	public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
		$recursive = -1;
		$contain = $extra['contain'];
		$joins = $extra['joins'];
		$dbJobs = $this->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive', 'contain', 'joins'));
		if (!array_key_exists('indeed', ConnectionManager::enumConnectionObjects())) {
			return $dbJobs;
		}

		if ($extra['extra']['jobtype']) {
			if ($extra['extra']['jobtype'] === 'Part-time') {
				$jobTypeIndeed = 'parttime';
			} else {
				$jobTypeIndeed = 'fulltime';
			}
		} else {
			$jobTypeIndeed = '';
		}

		if($page == 1) {
			$indeedStart = 0;
		} elseif ($page > 1) {
			$indeedStart = $limit * ($page - 1) - count($dbJobs) + ($page - 1);
		}
		App::uses('Indeed', 'Jobs.Model');
		$this->Indeed = new Indeed();
		$indeedJobs = $this->Indeed->find('all', array(
			'keywords' => $extra['extra']['keywords'],
			'jobtype' => $jobTypeIndeed,
			'location' => $extra['extra']['location'],
			'country' => 'us',
			'start' => $indeedStart,
			'limit' => $limit - count($dbJobs),
			'sort' => 'date'
		));
		return array_merge($dbJobs, $indeedJobs);
	}
	
    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        $this->recursive = $recursive;
        $jobsindb = count($this->find('all', compact('conditions', 'recursive')));
		if (!array_key_exists('indeed', ConnectionManager::enumConnectionObjects())) {
			return $jobsindb;
		}

        $indeedjobs = ConnectionManager::getDataSource('indeed')->numResults;
        return $jobsindb + $indeedjobs;
    }

}


if (!isset($refuseInit)) {
	class Job extends AppJob {
	}
}
