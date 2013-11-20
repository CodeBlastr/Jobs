<?php
class JobResumesController extends JobsAppController {

	public $name = 'JobResumes';
	
	public $uses = array('Jobs.JobResume');
	
	// public function __construct($request = null, $response = null) {
		// parent::__construct($request, $response);
	// }

/**
 * Index method
 * 
 */
	public function index() {
		$this->paginate['contain'][] = 'Creator';
		if (CakePlugin::loaded('Categories')) {
			$this->paginate['contain'][] = 'Category';
		}
		$this->set('jobResumes', $this->paginate());
	}

/**
 * View method
 * 
 * @param uuid $id
 */
 	public function view($id = null) {
		if ($id == 'my') {
			return $this->_getMy(array('action' => 'view'));
		}
		$this->JobResume->id = $id;
		if (!$this->JobResume->exists()) {
			throw new NotFoundException(__('Resume not found'));
		}
		if (CakePlugin::loaded('Categories')) {
			$contain[] = 'Category';
			$this->JobResume->contain(array('Category'));
		}
		$contain[] = 'Creator';
		$this->JobResume->contain($contain);
		$this->set('jobResume', $this->JobResume->read());
 	}

/**
 * View My
 */
 	protected function _getMy($url = array()) {
 		$id = $this->JobResume->field('id', array('JobResume.creator_id' => $this->Session->read('Auth.User.id')), 'created DESC');
		$this->redirect($url + array($id));
 	}
	
/**
 * Add method
 * 
 */
	public function add() {
		if ($this->request->is('post')) {
			if ($this->JobResume->save($this->request->data)) {
				$this->Session->setFlash(__('Resume saved'));
				$this->redirect(array('action' => 'view', $this->JobResume->id));
			}
		}
		if (CakePlugin::loaded('Categories')) {
			$this->set('categories', $this->JobResume->Category->find('list', array('conditions' => array('Category.model' => 'JobResume'))));
		}
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
		$this->JobResume->id = $id;
		if (!$this->JobResume->exists()) {
			throw new NotFoundException(__('Resume not found'));
		}
		if ($this->request->is('put')) {
			if ($this->JobResume->save($this->request->data)) {
				$this->Session->setFlash(__('Resume saved'));
				$this->redirect(array('action' => 'view', $this->JobResume->id));
			}
		}
		if (CakePlugin::loaded('Categories')) {
			$this->set('categories', $this->JobResume->Category->find('list', array('conditions' => array('Category.model' => 'JobResume'))));
			$contain[] = 'Category';
			$this->JobResume->contain(array('Category'));
		}
		$contain[] = 'Creator';
		$this->JobResume->contain($contain);
		$this->request->data = $this->JobResume->read();
	}

/**
 * Delete method
 */
	public function delete($id = null) {
		$this->JobResume->id = $id;
		if (!$this->JobResume->exists()) {
			throw new NotFoundException(__('Resume not found'));
		}
		if ($this->JobResume->delete($id)) {
			$this->Session->setFlash(__('Resume deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Resume was not deleted'));
	}

}
