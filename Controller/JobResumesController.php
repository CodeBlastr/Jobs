<?php
class JobResumesController extends JobsAppController {

	public $name = 'JobResumes';
	
	public $uses = array('Jobs.JobResume');
	
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
		if (CakePlugin::loaded('Categories')) {
			$this->paginate['contain'][] = 'Category';
			
			if(isset($this->request->query['categories'])) {
				$this->set('title_for_layout', $this->request->query['categories'] . ' < ' . __('Job Resumes') . ' | ' . __SYSTEM_SITE_NAME);
				$categoriesParam = explode(';', rawurldecode($this->request->query['categories']));
				$this->set('selected_categories', json_encode($categoriesParam));
				$joins = array(
			           array('table'=>'categorized', 
			                 'alias' => 'Categorized',
			                 'type'=>'left',
			                 'conditions'=> array(
			                 	'Categorized.foreign_key = JobResume.id'
			           )),
			           array('table'=>'categories', 
			                 'alias' => 'Category',
			                 'type'=>'left',
			                 'conditions'=> array(
			                 	'Category.id = Categorized.category_id'
					   ))
			         );
				$this->paginate['joins'] = $joins;
				$this->paginate['order']['JobResume.created'] = 'DESC';
				$this->paginate['conditions']['Category.name'] = $categoriesParam;
				$this->paginate['fields'] = array(
					'DISTINCT JobResume.id',
					'JobResume.name',
					'JobResume.leadin',
					'JobResume.search_tags'
					
					);
			}
		}

		if(isset($this->request->query['q'])) {
			$this->set('title_for_layout', $this->request->query['q'] . ' < ' . __('Job Resumes') . ' | ' . __SYSTEM_SITE_NAME);
			$categoriesParam = explode(';', rawurldecode($this->request->query['categories']));
			$this->paginate['conditions']['Category.name'] = $categoriesParam;
			$this->paginate['conditions']['JobResume.country'] = $this->request->query['country'];
			$this->paginate['conditions']['OR'] = array(
				'JobResume.name LIKE' => '%' . $this->request->query['q'] . '%',
				//'JobResume.leadin LIKE' => '%' . $this->request->query['q'] . '%',
				'JobResume.search_tags LIKE' => '%' . $this->request->query['q'] . '%'
			); 
		}//

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
