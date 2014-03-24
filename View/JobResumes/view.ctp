<?php //echo $this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $jobResume['Creator']['id'])); ?>
Full Name: <p><?php echo $jobResume['JobResume']['name']; ?></p>
Email: <p><?php echo $jobResume['JobResume']['email']; ?></p>
Phone: <p><?php echo $jobResume['JobResume']['phone']; ?></p>
Cover Letter: <p><?php echo $jobResume['JobResume']['cover']; ?></p>
Resume: <p><?php echo $jobResume['JobResume']['resume']; ?></p>
Street: <p><?php echo $jobResume['JobResume']['street']; ?></p>
City: <p><?php echo $jobResume['JobResume']['city']; ?></p>
State: <p><?php echo $jobResume['JobResume']['state']; ?></p>
Zip: <p><?php echo $jobResume['JobResume']['zip']; ?></p>
Country: <p><?php echo $jobResume['JobResume']['country']; ?></p>
<!--Lead In: <p><?php //echo $jobResume['JobResume']['leadin']; ?></p>
Add On: <p><?php //echo $jobResume['JobResume']['addon']; ?></p> -->

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