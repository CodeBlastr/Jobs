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
			
			if (isset($this->request->query['categories']) && !empty($this->request->query['categories'])) {
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

		if (isset($this->request->query['country']) && !empty($this->request->query['country'])) {
			$this->paginate['conditions']['JobResume.country'] = $this->request->query['country'];	
		}

		if (isset($this->request->query['q']) && !empty($this->request->query['q'])) {
			$this->paginate['conditions']['OR'] = array(
				'JobResume.name LIKE' => '%' . $this->request->query['q'] . '%',
				//'JobResume.leadin LIKE' => '%' . $this->request->query['q'] . '%',
				'JobResume.search_tags LIKE' => '%' . $this->request->query['q'] . '%'
			);
		}

		$pageTitle = '';
		$pageTitle .= (!empty($this->request->query['q'])) ? $this->request->query['q'] : '';
		$pageTitle .= (!empty($this->request->query['categories'])) ? ' '.$this->request->query['categories'] : '';
		$pageTitle .= (!empty($this->request->query['country'])) ? ' '.$this->request->query['country'] : '';
		if (!empty($pageTitle)) {
			$pageTitle .= ' < ';
		}
		$this->set('title_for_layout', $pageTitle . __('Resumes') . ' | ' . __SYSTEM_SITE_NAME);

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
		$jobResume = $this->JobResume->read();
		$this->set('jobResume', $jobResume);
		$this->set('page_title_for_layout', $jobResume['Creator']['full_name'] . ' < Resume | ' . __SYSTEM_SITE_NAME);
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
			if (!empty($this->request->data['Media'])) {
				foreach ($this->request->data['Media'] as $file) {
					if (!empty($file['filename']['tmp_name'])) {
						$media['Media'] = array(
							'user_id' => CakeSession::read('Auth.User.id'),
							'filename' => $file['filename'],
							'title' => $file['title']
						);
						App::uses('Media', 'Media.Model');
						$this->Media = new Media;
						$this->Media->create();
						$media = $this->Media->save($media);
						$this->request->data['MediaAttachment'][] = array(
							'model' => 'User',
							'foreign_key' => $this->Auth->user('id'),
							'media_id' => $this->Media->id
						);
					}
				}
			}
			if ($this->JobResume->save($this->request->data)) {
				$this->Session->setFlash(__('Resume saved'));
				$this->redirect(array('action' => 'view', $this->JobResume->id));
			}
		}
		if (CakePlugin::loaded('Categories')) {
			$this->set('categories', $this->JobResume->Category->find('list', array('conditions' => array('Category.model' => 'JobResume'))));
		}
		$this->set('page_title_for_layout', 'Add a Resume | ' . __SYSTEM_SITE_NAME);
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
		if ($this->request->is('put') || $this->request->is('post')) {
			
			if (!empty($this->request->data['Media'])) {
				foreach ($this->request->data['Media'] as $file) {
					if (!empty($file['filename']['tmp_name'])) {
						$media['Media'] = array(
							'user_id' => CakeSession::read('Auth.User.id'),
							'filename' => $file['filename'],
							'title' => $file['title']
						);
						App::uses('Media', 'Media.Model');
						$this->Media = new Media;
						$this->Media->create();
						$media = $this->Media->save($media);
						$this->request->data['MediaAttachment'][] = array(
							'model' => 'User',
							'foreign_key' => $this->Auth->user('id'),
							'media_id' => $this->Media->id
						);
					}
				}
			}
			
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
		$this->set('page_title_for_layout', 'Resume Editor | ' . __SYSTEM_SITE_NAME);
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
