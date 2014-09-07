<div class="jobs dashboard clearfix">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>
					<?php echo $this->Paginator->sort('name', 'Name'); ?>
				</th>
				<th class="text-center">
					<?php echo $this->Paginator->sort('created', 'Created'); ?>
				</th>
				<th class="text-right">
					Actions
				</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($jobs as $job) : ?>
			<tr>
				<td>
					<?php echo $this->Html->link($this->Text->truncate($job['Job']['name'], 30), array('admin' => false, 'plugin' => 'jobs', 'controller' => 'jobs', 'action' => 'view', $job['Job']['id'])); ?>
					<small class="muted"><?php echo $this->Text->truncate(strip_tags($job['Job']['text']), 25); ?></small>
				</td>
				<td class="text-center">
					<span class="label label-default"><?php echo ZuhaInflector::datify($job['Job']['created']); ?></span>
				</td>
				<td class="text-right">
					<?php echo $this->Html->link('Edit', array('plugin' => 'jobs', 'controller' => 'jobs', 'action' => 'edit', $job['Job']['id']), array('escape' => false, 'class' => 'btn btn-xs btn-default')); ?>
					<?php echo $job['Job']['is_public'] ? $this->Html->link('Archive', array('plugin' => 'jobs', 'controller' => 'jobs', 'action' => 'archive', $job['Job']['id']), array('escape' => false, 'class' => 'btn btn-xs btn-warning')) : $this->Html->link('Publish', array('plugin' => 'jobs', 'controller' => 'jobs', 'action' => 'publish', $job['Job']['id']), array('escape' => false, 'class' => 'btn btn-xs btn-success')); ?>
					<?php echo $this->Html->link('Delete', array('plugin' => 'jobs', 'controller' => 'jobs', 'action' => 'delete', $job['Job']['id']), array('escape' => false, 'class' => 'btn btn-xs btn-danger'), 'Are you sure?'); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	'Jobs Dashboard'
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array('heading' => 'Jobs',
		'items' => array(
			 $this->Html->link(__('Add', true), array('controller' => 'jobs', 'action' => 'add'), array('class' => 'add')),
			 )
		)
	)));
