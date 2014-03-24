<div class="list-group">
<?php 
	/* $jid = '';
	foreach ($jobResumes as $resume) {
	
	$jobid = $resume[a]['id'];
	if($jobid != $jid)
	{
	  echo "<b>".$resume[a]['name']."</b>";
	  $jid = $jobid;
	}
	echo "<br />";
	echo "----".$resume[b]['email'];
	echo "<br />";
	}
	exit;
	$jid = '';
	foreach ($jobResumes as $k=>$v) {
	$jobid = $v[a]['id'];
	if($jobid != $jid)
	{
	  echo "<b>".$v[a]['name']."</b>";
	  $jid = $jobid;
	}
	
	echo "----".$v[b]['email'];
	echo "<br />";
	}
	
	exit; */
	$jid = ''; ?>
	<div class="list-group-item clearfix"><div class="media">
	<div style="float:right;"><b><?php echo $this->Html->link('Download CSV', array('controller' => 'jobs', 'action' => 'getcsv')); ?></b></div>
<?php	foreach ($jobResumes as $resume) : ?>
		
			
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
				<p style="margin-top:5px;">- <b><?php echo $resume[b]['jrname'];?></b>&nbsp;&nbsp;<?php echo $this->Html->link('Click to view resume', array('action' => 'view', $resume['b']['jrid'])); ?></p>
				
					<?php //echo $this->Html->link($resume['JobResume']['name'], array('action' => 'view', $resume['JobResume']['id'])); ?>
				</div>
			
			
		
	<?php endforeach; ?>
</div></div></div>

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