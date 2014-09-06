<?php
class AppJobsController extends JobsAppController {

	public $name = 'Jobs';
	
	public $uses = array('Jobs.Job');
	
	 public function __construct($request = null, $response = null) {
		 if (CakePlugin::loaded('Categories')) {
		 	$this->components[] = 'Categories.Categories';
		 }
		parent::__construct($request, $response);
	 
	}

/**
 * Index method
 * 
 */
	public function index() {
		$this->paginate['contain'][] = 'Creator';
		$this->paginate['order']['Job.created'] = 'DESC';
		$this->paginate['conditions']['Job.is_public'] = 1;

		// Categories support			
		if(isset($this->request->query['categories'])) {
			// example url = /jobs/jobs/index/?categories=Auburn;California (will only return jobs that are in BOTH categories)
			$categoryNames = explode(';', rawurldecode($this->request->query['categories']));
			$this->set('categories', $categories = $this->Job->Category->find('all', array(
				'conditions' => array(
					'Category.name' => $categoryNames
					),
				'order' => array(
					'Category.lft' => 'DESC'
					)
				))); // children first so that the 0 element is the youngest child (for use on the jobs index, when you choose Alabma > Auburn for example)
			$categoryIds = Set::extract('/Category/id', $categories);
			for ($i = 0; $i < count($categoryIds); $i++) {
				$joins[] = array(
					'table' => 'categorized',
					'alias' => 'Categorized' . $i,
					'type' => 'INNER',
					'conditions' => array(
						"Categorized{$i}.foreign_key = Job.id",
						"Categorized{$i}.model = 'Job'",
						'Categorized' . $i . '.category_id' => $categoryIds[$i]
					)
				);
			}
			$this->paginate['joins'] = $joins;
			$this->paginate['contain'][] = 'Category';
			$this->set('childCategories', $childCategories = $this->Job->Category->find('all', array('conditions' => array('Category.parent_id' => $categoryIds))));
		}
		
		if (isset($this->request->query['q']) && !empty($this->request->query['q'])) {
			$this->paginate['conditions']['OR'] = array(
				'Job.name LIKE' => '%' . $this->request->query['q'] . '%',
				'Job.description LIKE' => '%' . $this->request->query['q'] . '%'
			);
		}
		$pageTitle = '';
		$pageTitle .= (!empty($this->request->query['q'])) ? $this->request->query['q'] : '';
		if (!empty($pageTitle)) {
			$pageTitle .= ' < ';
		}
		$this->set('title_for_layout', $pageTitle . __('Jobs') . ' | ' . __SYSTEM_SITE_NAME);
		$this->set('jobs', $this->request->data = $this->paginate());
		return $this->request->data;
	}

/**
 * View method
 * 
 * @param uuid $id
 * @throws NotFoundException
 */
 	public function view($id = null) {
		if ($id == 'my') {
			return $this->_getMy(array('action' => 'view'));
		}
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Job not found'));
		}
		
		$contain[] = 'Creator';
		$this->Job->contain($contain);
		$job = $this->Job->read();
		$this->set('job', $job);
		$this->set('page_title_for_layout', $job['Creator']['full_name'] . ' < Job | ' . __SYSTEM_SITE_NAME);
 	}
	
	/**
 * View My
 */
 	protected function _getMy($url = array()) {
 		$id = $this->Job->field('id', array('Job.creator_id' => $this->Session->read('Auth.User.id')), 'created DESC');
		if ($id) {
			$this->redirect($url + array($id));
		} else {
			$this->redirect(array('action' => 'add'));
		}
 	}
	
	public function add() {
		if ($this->request->is('post')) {
			if ($this->Job->saveAll($this->request->data)) {
				$this->Session->setFlash(__('Job saved'), 'flash_success');
				$this->redirect(array('action' => 'view', $this->Job->id));
			}
		}
		
		if (CakePlugin::loaded('Categories')) {
			$this->set('categories', $this->Job->Category->generateTreeList(array('Category.model' => 'Job')));
		}
		$this->set('page_title_for_layout', 'Add a Job | ' . __SYSTEM_SITE_NAME);
	}
	
	/**
 * Edit method
 * 
 * @param uuid $id
 */
	public function edit($id = null) {
		if ($id == 'my') {
			return $this->_getMy(array('action' => 'edit'));
		}
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Job not found'));
		}
		

		if ($this->request->is('put') || $this->request->is('post')) {
			if ($this->Job->saveAll($this->request->data)) {
				$this->Session->setFlash(__('Job saved'), 'flash_success');
				$this->redirect(array('action' => 'view', $this->Job->id));
			}
		}
		
		if (CakePlugin::loaded('Categories')) {
			$this->set('categories', $this->Job->Category->generateTreeList(array('Category.model' => 'Job')));
			$contain[] = 'Category';
		}
		$contain[] = 'Creator';
		$this->Job->contain($contain);
		$this->request->data = $this->Job->read();		
		$this->set('page_title_for_layout', 'Job Editor | ' . __SYSTEM_SITE_NAME);
	}

/**
 * Delete method
 */
	public function delete($id = null) {
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Job not found'));
		}
		if ($this->Job->delete($id)) {
			$this->Session->setFlash(__('Job deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Job was not deleted'), 'flash_warning');
	}
	
	public function getcsv($id = null) {
	
	 $jobs = $this->Job->query('SELECT  a.name,a.id,b.id as jrid,b.name as jrname,b.email,b.phone,b.street,b.city,b.state,b.zip,b.country
FROM jobs a
        INNER JOIN job_resumes b
            ON  a.id = b.job_id 
  ORDER BY b.job_id');
	
	$this->set('jobsdata', $jobs);
	
	}
}


if (!isset($refuseInit)) {
	class JobsController extends AppJobsController {
	}

}
