<?php
class JobsController extends JobsAppController {

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
				$this->paginate['fields'] = array(
					'DISTINCT Job.id',
					'Job.name',
					'Job.description',
					'Job.created'
					);
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

		$this->set('job', $this->paginate());
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
			
			if ($this->Job->save($this->request->data)) {
				$this->Session->setFlash(__('Job saved'), 'flash_success');
				$this->redirect(array('action' => 'view', $this->Job->id));
			}
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
		if ($this->Job->save($this->request->data)) {
				$this->Session->setFlash(__('Job saved'), 'flash_success');
				$this->redirect(array('action' => 'view', $this->Job->id));
			}
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
