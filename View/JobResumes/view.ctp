
<?php echo $this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $jobResume['Creator']['id'])); ?>
<?php echo $jobResume['Creator']['full_name']; ?>
<?php echo $jobResume['JobResume']['email']; ?>
<?php echo $jobResume['JobResume']['phone']; ?>
<?php echo $jobResume['JobResume']['cover']; ?>
<?php echo $jobResume['JobResume']['street']; ?>
<?php echo $jobResume['JobResume']['city']; ?>
<?php echo $jobResume['JobResume']['state']; ?>
<?php echo $jobResume['JobResume']['zip']; ?>
<?php echo $jobResume['JobResume']['country']; ?>
<?php echo $jobResume['JobResume']['leadin']; ?>
<?php echo $jobResume['JobResume']['addon']; ?>

<?php if (!empty($jobResume['Category'][0])) : ?>
	<?php foreach ($jobResume['Category'] as $category) : ?>
		<?php echo $category['name']; ?>
	<?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($jobResume['Media'][0])) : ?>
	<?php foreach ($jobResume['Media'] as $media) : ?>
		<?php echo $this->Media->display($media); ?>
	<?php endforeach; ?>
<?php endif; ?>

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
		),
	)));