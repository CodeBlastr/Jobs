<h1><?php echo $jobResumes[0]['Job']['name']; ?> Applications</h1> 
<div class="list-group">
	<?php // echo $this->Html->link('Download CSV', array('controller' => 'jobs', 'action' => 'getcsv')); ?>
	<?php foreach ($jobResumes as $resume) : ?>
		<div class="list-group-item clearfix">
			<div class="row">
				<div class="col-xs-3">
					<?php echo $this->Html->link($resume['JobResume']['name'], array('action' => 'view', $resume['JobResume']['id'])); ?>
				</div>
				<div class="col-xs-6">
					<?php echo $this->Text->truncate($resume['JobResume']['cover']); ?>
				</div>
				<div class="col-xs-3">
					<?php echo !empty($resume['_Media']['cover-letter']) ? $this->Media->display($resume['_Media']['cover-letter']) : '<p>No Cover Letter Attachment</p>'; ?>
					<?php echo !empty($resume['_Media']['resume']) ? $this->Media->display($resume['_Media']['resume']) : '<p>No Resume Attachment</p>'; ?>
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
		'heading' => 'Job Resumes',
		'items' => array(
			$this->Html->link(__('Add'), array('action' => 'add'))
			)
		)
	)));