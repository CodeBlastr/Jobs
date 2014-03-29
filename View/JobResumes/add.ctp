<div class="jobs resumes add form">
	<h1>Apply to <?php echo $job['Job']['name']; ?></h1>
	<?php echo $this->Form->create('JobResume'); ?>
	<fieldset>
		<?php echo $this->Form->hidden('JobResume.job_id', array('value' => $this->params['pass'][0])); ?>
		<?php echo $this->Form->input('JobResume.name', array('default' => $this->Session->read('Auth.User.full_name'))); ?>
		<?php echo $this->Form->input('JobResume.email'); ?>
		<?php echo $this->Form->input('JobResume.phone'); ?>
		<?php echo $this->Form->input('JobResume.cover', array('type' => 'simpletext')); ?>
		<?php echo $this->Form->input('JobResume.addon', array('type' => 'simpletext', 'label' => 'Resume')); ?>
		<?php echo $this->Form->input('JobResume.street'); ?>
		<?php echo $this->Form->input('JobResume.city'); ?>
		<?php echo $this->Form->input('JobResume.state', array('options' => states())); ?>
		<?php echo $this->Form->input('JobResume.zip'); ?>
		<?php echo $this->Form->input('JobResume.country', array('options' => Zuha::enum('COUNTRIES', null, array('fields' => array('Enumeration.name', 'Enumeration.name'))))); ?>
		<?php echo CakePlugin::loaded('Categories') ? $this->Form->input('Category', array('multiple' => 'checkbox')) : null; ?>
	</fieldset>
	<?php echo $this->Form->end('Save'); ?>	
</div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
		'items' => array(
			$this->Html->link(__('Resumes'), array('action' => 'index')),
			)
		)
	)));