
<?php debug($jobResumes); ?>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
		'items' => array(
			$this->Html->link(__('Add'), array('action' => 'add'))
			)
		),
	)));