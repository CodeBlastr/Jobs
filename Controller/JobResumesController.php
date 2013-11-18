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
		debug($this->paginate());
	}

/**
 * View method
 * 
 * @param uuid $id
 */
 	public function view($id = null) {
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
		}
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
