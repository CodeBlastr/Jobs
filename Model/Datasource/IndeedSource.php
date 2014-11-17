<?php

App::uses('HttpSocket', 'Network/Http');

class IndeedSource extends DataSource {

	protected $_schema = array(
		'indeeds' => array(
			'id' => array(
				'title' => 'integer',
				'null' => true,
				'key' => 'primary',
				'length' => 11,
			)
		)
	);
	var $numResults = 0;

	public function __construct($config) {
		$this->connection = new HttpSocket(
				"http://api.indeed.com/"
		);
		parent::__construct($config);
	}

	public function listSources() {
		return array('indeeds');
	}

	public function read($model, $conditions = array()) {
		$grabindeed = '/ads/apisearch?publisher=' . $this->config['publisher']
				. '&q=' . $conditions['keywords']
				. '&l=' . $conditions['location']
				. '&sort=' . $conditions['sort']
				. '&radius=' . $conditions['radius']
				. '&st=' // Site type. To show only jobs from job boards use "jobsite". For jobs from direct employer websites use "employer".
				. '&jt=' . $conditions['jobtype'] // Job type. Allowed values: "fulltime", "parttime", "contract", "internship", "temporary".
				. '&start=' . $conditions['start']
				. '&limit=' . $conditions['limit']
				. '&fromage=30' // Number of days back to search.
				. '&filter=' // Filter duplicate results. 0 turns off duplicate job filtering. Default is 1.
				. '&latlong=0' // If latlong=1, returns latitude and longitude information for each job result. Default is 0.
				. '&co=' . $conditions['country']
				. '&chnl=' . $this->config['channel']
				. '&userip=' . getenv("REMOTE_ADDR")
				. '&useragent=' . urlencode($_SERVER['HTTP_USER_AGENT'])
				. '&v=2';

		$response = simplexml_load_string($this->connection->get($grabindeed));

		$this->numResults = (int) $response->totalresults;

		$results = array();

		$i = 0;
		foreach ($response->results->result as $aJob) :
			$results[$i]['Job'] = array(
				'name' => (string) $aJob->jobtitle,
				'company' => (string) $aJob->company,
				'city' => (string) $aJob->city[0],
				'state' => (string) $aJob->state[0],
				'country' => (string) $aJob->country,
				'created' => (string) $aJob->date,
				'description' => (string) $aJob->snippet,
				'apply_url' => (string) $aJob->url,
				'onclick' => (string) $aJob->onmousedown,
				'timeAgo' => (string) $aJob->formattedRelativeTime
			);
			$results[$i]['Job']['Meta']['location'] = (string) $aJob->city[0];
			unset($aJob);
			++$i;
		endforeach;

		return $results;
	}

	public function describe($model) {
		return $this->_schema['indeeds'];
	}

}
