<div class="jobResumes add form">
	<?php echo $this->Form->create('JobResume'); ?>
	<fieldset>
		<?php echo $this->Form->input('name'); ?>
		<?php echo $this->Form->input('JobResume.name'); ?>
		<?php echo $this->element('Media.selector'); ?>
		<?php echo $this->Form->input('JobResume.email'); ?>
		<?php echo $this->Form->input('JobResume.phone'); ?>
		<?php echo $this->Form->input('JobResume.cover', array('type' => 'richtext')); ?>
		<?php echo $this->Form->input('JobResume.street'); ?>
		<?php echo $this->Form->input('JobResume.city'); ?>
		<?php echo $this->Form->input('JobResume.state', array('options' => states())); ?>
		<?php echo $this->Form->input('JobResume.zip'); ?>
		<?php echo $this->Form->input('JobResume.country'); ?>
		<?php echo $this->Form->input('JobResume.leadin'); ?>
		<?php echo $this->Form->input('JobResume.addon'); ?>
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
		),
	)));