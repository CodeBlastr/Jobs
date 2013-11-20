<div class="list-group">
	<?php foreach ($jobResumes as $resume) : ?>
		<div class="list-group-item clearfix">
			<div class="media">
				<?php echo $this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $resume['Creator']['id'], 'thumbClass' => 'pull-left')); ?>
				<div class="media-body col-md-8">
					<?php echo $this->Html->link($resume['JobResume']['name'], array('action' => 'view', $resume['JobResume']['id'])); ?>
					<p class="truncate" data-truncate="100">
						<?php echo strip_tags($resume['JobResume']['leadin']); ?>
					</p>
				</div>
			</div>
			<span class="badge"><?php echo $resume['JobResume']['city']; ?></span>
			<span class="badge"><?php echo $resume['JobResume']['state']; ?></span>
			<span class="badge"><?php echo $resume['Category'][0]['name']; ?></span>
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
		),
	)));