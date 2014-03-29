<div class="list-group">
	<?php echo $this->Html->link('Download CSV', array('controller' => 'jobs', 'action' => 'getcsv')); ?>
	
	<?php foreach ($jobResumes as $resume) : ?>
	<div class="list-group-item clearfix">
		<div class="media">
			<div class="media-body col-md-8">
			<?php
			$jobid = $resume[a]['id'];
			if($jobid != $jid)
			{
			echo "<br>";
			echo "<b>".$resume[a]['name']."</b>";
			$jid = $jobid;
			}
			?>
			<p><?php echo $resume[b]['jrname'];?></b>&nbsp;&nbsp;<?php echo $this->Html->link('Click to view resume', array('action' => 'view', $resume['b']['jrid'])); ?></p>
			
				<?php //echo $this->Html->link($resume['JobResume']['name'], array('action' => 'view', $resume['JobResume']['id'])); ?>
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
		),
	)));