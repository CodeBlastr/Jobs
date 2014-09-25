<?php
class AppJobResumesController extends JobsAppController {

	public $name = 'JobResumes';
	
	public $uses = array('Jobs.JobResume', 'Jobs.Job');
	
	 // public function __construct($request = null, $response = null) {
	 	// if (CakePlugin::loaded('Categories')) {
	 		// $this->components[] = 'Categories.Categories';
	 	// }
		// parent::__construct($request, $response);
	// }

/**
 * Index method
 * 
 */
	public function index($jobId = null) {
		//$this->paginate['contain'][] = 'Creator';
		/* if (CakePlugin::loaded('Categories')) {
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
		} */
		
		//$this->loadModel("JobResume");
		
		$this->Job->id = $jobId;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Job not found'));
		}
		$this->set('title_for_layout', $pageTitle . __('Resumes') . ' | ' . __SYSTEM_SITE_NAME);
		$this->paginate['contain'][] = 'Job';
		$this->paginate['conditions']['JobResume.job_id'] = $jobId;
		$this->set('jobResumes', $jobResumes = $this->paginate('JobResume'));
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
		if ($id) {
			$this->redirect($url + array($id));
		} else {
			$this->redirect(array('action' => 'add'));
		}
 	}
	
/**
 * Add method
 * 
 */
	public function add($jobId = null) {
		$this->Job->id = $jobId;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Job not found'));
		}
		if ($this->request->is('post')) {
			if ($this->JobResume->save($this->request->data)) {
				$this->Session->setFlash(__('Application sent'), 'flash_success');
				$this->redirect(array('plugin' => 'jobs', 'controller' => 'jobs', 'action' => 'view', $this->request->data['JobResume']['job_id'])); // required on pj ^ RK
			} else {
				debug($this->JobResume->invalidFields());
				exit;
			}
		}
		
		if (CakePlugin::loaded('Categories')) {
			$this->set('categories', $this->JobResume->Category->find('list', array('conditions' => array('Category.model' => 'JobResume'))));
		}
		$this->set('job', $job = $this->Job->read());
		$this->set('page_title_for_layout', __('Apply to %s | %s ', $job['Job']['name'], __SYSTEM_SITE_NAME));
	}
	
/**
 * sorry... I needed to get the functionality of the single media inputs working.
 */
	protected function _updateAttachments($jobResumeId) {
			App::uses('Media', 'Media.Model');
			$this->Media = new Media;
			$attachedMediaIds = false;
			$currentAttachments = $this->Media->MediaAttachment->find('all', array(
					'conditions' => array(
					'model' => 'JobResume',
					'foreign_key' => $jobResumeId
				)
			));
			if (!empty($currentAttachments)) {
				$attachedMediaIds = Set::extract('/MediaAttachment/media_id', $currentAttachments);
			}
			
			if (!empty($this->request->data['Media'])) {
				foreach ($this->request->data['Media'] as $k => $file) {
					// check if they uploaded a file
					if (!empty($file['filename']['tmp_name'])) {
						$media['Media'] = array(
							'user_id' => CakeSession::read('Auth.User.id'),
							'filename' => $file['filename'],
							'title' => $file['title']
						);
						
						// find if this "title" was attached already..
						$replacing = $this->Media->find('first', array(
							'conditions' => array(
								'creator_id' => CakeSession::read('Auth.User.id'),
								'title' => $file['title'],
								'id' => $attachedMediaIds
							)
						));
				
						// save the newly submitted Media
						$this->Media->create();
						$media = $this->Media->upload($media);
						
						if (!empty($replacing)) {
							$replacements[] = array(
								$replacing['Media']['id'], // replace me
								$this->Media->id // with me
							);
						} else {
							// add it to the MediaAttachment array
							$this->request->data['MediaAttachment'][] = array(
								'MediaAttachment' => array(
									'model' => 'JobResume',
									'foreign_key' => $jobResumeId,
									'media_id' => $this->Media->id
								)
							);
						}
					} else {
						// there was no file, just tags, empty the array
						unset($this->request->data['Media'][$k]);
					}
				}
			}
			
			if (!empty($replacements)) {
				foreach ($currentAttachments as &$ca) {
					foreach ($replacements as $replacethis) {
						if ($ca['MediaAttachment']['media_id'] == $replacethis[0]) {
							$ca['MediaAttachment']['media_id'] = $replacethis[1];
						}
					}
				}
			}

			if (empty($this->request->data['MediaAttachment']) && !empty($currentAttachments)) {
				$this->request->data['MediaAttachment'] = array();
			}
			$this->request->data['MediaAttachment'] = array_merge($currentAttachments, $this->request->data['MediaAttachment']);
			
			return $this->request->data['MediaAttachment'];
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
			$this->request->data['MediaAttachment'] = $this->_updateAttachments($this->JobResume->id);
            }
			if ($this->JobResume->save($this->request->data)) {
				$this->Session->setFlash(__('Resume saved'), 'flash_success');
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
			$this->Session->setFlash(__('Resume deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Resume was not deleted'), 'flash_warning');
	}

}


if (!isset($refuseInit)) {
	class JobResumesController extends AppJobResumesController {
	}

}
