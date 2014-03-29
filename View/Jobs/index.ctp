<div class="list-group">
	<?php foreach ($jobs as $job) : ?>
		<div class="list-group-item clearfix">
			<div class="media">
				<div class="media-body col-md-8">
					<?php echo $this->Html->link($job['Job']['name'], array('action' => 'view', $job['Job']['id'])); ?>
					<p class="truncate" data-truncate="100">
						 <?php echo strip_tags($job['Job']['description']); ?>
					</p>
					<div class="label label-primary">
						Created : <?php echo ZuhaInflector::datify($job['Job']['created']); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<?php echo $this->element('paging'); ?>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
		'items' => array(
			$this->Html->link(__('Add'),  array('admin' => true,'plugin' => 'jobs','controller' => 'jobs', 'action' => 'add'))
			)
		),
	)));