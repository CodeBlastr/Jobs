
<?php //echo $this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $jobResume['Creator']['id'])); ?>

<div class="list-group">
	<div class="list-group-item">
		<strong>Name :</strong> <?php echo $jobResume['JobResume']['name']; ?>
	</div>
	<div class="list-group-item">
		<strong>Email :</strong> <?php echo $jobResume['JobResume']['email']; ?>
	</div>
	<div class="list-group-item">
		<strong>Phone :</strong> <?php echo $jobResume['JobResume']['phone']; ?>
	</div>
	<div class="list-group-item">
		<strong>Cover Letter Text :</strong> <?php echo $jobResume['JobResume']['cover']; ?>
	</div>
	<div class="list-group-item">
		<strong>Resume Text :</strong> <?php echo $jobResume['JobResume']['addon']; ?>
	</div>
	<div class="list-group-item">
		<strong>Street :</strong> <?php echo $jobResume['JobResume']['street']; ?>
	</div>
	<div class="list-group-item">
		<strong>City :</strong> <?php echo $jobResume['JobResume']['city']; ?>
	</div>
	<div class="list-group-item">
		<strong>State :</strong> <?php echo $jobResume['JobResume']['state']; ?>
	</div>
	<div class="list-group-item">
		<strong>Zip :</strong> <?php echo $jobResume['JobResume']['zip']; ?>
	</div>
	<div class="list-group-item">
		<strong>Country :</strong> <?php echo $jobResume['JobResume']['country']; ?>
	</div>
	<?php if (!empty($jobResume['Category'][0]))  : ?>
		<?php foreach ($jobResume['Category'] as $category)  : ?>
			<div class="list-group-item">
				<?php echo $category['name']; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if (!empty($jobResume['Media'][0]))  : ?>
		<div class="list-group-item">
			<strong>Attachments :</strong> 
		<?php foreach ($jobResume['Media'] as $media)  : ?>
			<?php echo $this->Media->display($media); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Jobs',
		'items' => array(
			$this->Html->link(__('Resumes'), array('action' => 'index')),
			$this->Html->link(__('Add'), array('action' => 'add')),
			$this->Html->link(__('Edit'), array('action' => 'edit', $jobResume['JobResume']['id']))
			)
		)
	)));