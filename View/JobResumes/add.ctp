<div class="jobs resumes add form">
	<h1>Apply to <?php echo $job['Job']['name']; ?></h1>
	<?php echo $job['Job']['description']; ?>
	<?php echo $this->Form->create('JobResume', array('type' => 'file')); ?>
	<hr>
	<fieldset>
		<?php echo $this->Form->hidden('JobResume.job_id', array('value' => $this->params['pass'][0])); ?>
		<div class="row">
			<div class="col-md-4">
				<?php echo $this->Form->input('JobResume.name', array('default' => $this->Session->read('Auth.User.full_name'))); ?>
			</div>
			<div class="col-md-4">
				<?php echo $this->Form->input('JobResume.email', array('default' => $this->Session->read('Auth.User.email'))); ?>
			</div>
			<div class="col-md-4">
				<?php echo $this->Form->input('JobResume.phone', array('default' => $this->Session->read('Auth.User.phone'))); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<?php echo $this->Form->hidden('Media.0.code', array('type' => 'text', 'value' => 'cover-letter')); ?>
				<?php echo $this->Form->input('Media.0.filename', array('type' => 'file', 'label' => 'Cover Letter')); ?>
			</div>
			<div class="col-md-9">
				<?php echo $this->Form->input('JobResume.cover', array('type' => 'textarea', 'label' => 'Cover Letter')); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<?php echo $this->Form->hidden('Media.1.code', array('type' => 'text', 'value' => 'resume')); ?>
		<?php echo $this->Form->input('Media.1.filename', array('type' => 'file', 'label' => 'Resume')); ?>
			</div>
			<div class="col-md-9">
				<?php echo $this->Form->input('JobResume.addon', array('type' => 'textarea', 'label' => 'Resume')); ?>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4">
				<?php echo $this->Form->input('JobResume.street'); ?>
			</div>
			<div class="col-md-4">
				<?php echo $this->Form->input('JobResume.city'); ?>
			</div>
			<div class="col-md-4">
				<?php echo $this->Form->input('JobResume.state', array('options' => states())); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?php echo $this->Form->input('JobResume.zip'); ?>
			</div>
			<div class="col-md-6">
				<?php echo $this->Form->input('JobResume.country', array('options' => Zuha::enum('COUNTRIES', null, array('fields' => array('Enumeration.name', 'Enumeration.name'))))); ?>
			</div>
		</div>
		<?php //echo CakePlugin::loaded('Categories') ? $this->Form->input('Category', array('multiple' => 'checkbox')) : null; ?>
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