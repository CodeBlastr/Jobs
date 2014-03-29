<div class="jobs view">
	<h1><?php echo $job['Job']['name']; ?></h1>
	<?php echo $job['Job']['description']; ?>
	<?php echo $this->Html->link(__('Apply'), array('controller' => 'job_resumes','action' => 'add', $job['Job']['id']), array('class' => 'btn btn-primary'));?>
</div>
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
		'items' => array(
			$this->Html->link(__('Jobs'), array('action' => 'index')),
			$this->Html->link(__('Add'),  array('admin' => true,'plugin' => 'jobs','controller' => 'jobs', 'action' => 'add')),
			$this->Html->link(__('Edit'), array('admin' => true,'plugin' => 'jobs','controller' => 'jobs','action' => 'edit', $job['Job']['id'])),
			$this->Html->link(__('Delete'), array('admin' => true,'plugin' => 'jobs','controller' => 'jobs', 'action' => 'delete', $job['Job']['id']), array(), 'Are you sure you want to delete "'.strip_tags($job['Job']['name']).'"')
			)
		),
	)));