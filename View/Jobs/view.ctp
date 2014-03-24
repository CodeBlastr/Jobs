
<?php //echo $this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $job['Creator']['id'])); ?>
<?php echo $job['Creator']['full_name']; ?>
<?php echo "<br />"; ?>
<?php echo $job['Job']['name']; ?>
<?php echo $job['Job']['description']; ?>
<?php if($job['Job']['is_featured'] == 1)
           {
		    echo "Featured Job";
		   }
		   else
		   {
		   echo "Non Featured Job";
		   }

 ?>
<div style="float:right">
				<?php echo $this->Html->link(__('Apply to this job'), array('controller' => 'job_resumes','action' => 'add', $job['Job']['id']));?>
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