<div class="list-group">
	<?php foreach ($job as $jj) : ?>
		<div class="list-group-item clearfix">
			<div class="media">
				<div class="media-body col-md-8">
					Job Title: <?php echo $this->Html->link($jj['Job']['name'], array('action' => 'view', $jj['Job']['id'])); ?>
					 <br /> 
					 Job Description: <p class="truncate" data-truncate="100">
						 <?php echo strip_tags($jj['Job']['description']); ?>
					</p>
					Created Date: <?php echo date('d-m-Y',strtotime($jj['Job']['created'])); ?>
				</div>
				<div style="float:right">
				<?php echo $this->Html->link(__('View Job'), array('action' => 'view', $jj['Job']['id']));?>
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