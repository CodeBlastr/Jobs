<?php
class JobsAppModel extends AppModel {
	
/**
 * Menu Init method
 * Used by WebpageMenuItem to initialize when someone creates a new menu item for the users plugin.
 * 
 */
 	public function menuInit($data = null) {
 		App::uses('Job', 'Jobs.Model');
		$Job = new Job();
		$job = $Job->find('first');
		if (!empty($job)) {
	 		// link to properties index and first property
			$data['WebpageMenuItem']['item_url'] = '/jobs/jobs/index';
			$data['WebpageMenuItem']['item_text'] = 'Jobs List';
			$data['WebpageMenuItem']['name'] = 'Jobs List';
			$data['ChildMenuItem'] = array(
				array(
					'name' => $job['Job']['name'],
					'item_text' => $job['Job']['name'],
					'item_url' => '/jobs/jobs/view/'.$job['Job']['id']
				),
				array(
					'name' => 'Post Job',
					'item_text' => 'Post Job',
					'item_url' => '/jobs/jobs/add'
				)
			);
		}
 		return $data;
 	}

}