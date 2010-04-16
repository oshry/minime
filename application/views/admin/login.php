<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<h1><?php echo html::chars($title) ?></h1>

<?php echo form::open() ?>

	<?php include Kohana::find_file('views', 'admin/system/errors') ?>
	<fieldset>
		<div class="line">
			<?php echo form::label('username', 'Username *') ?>
			<?php echo form::input('username', $post['username'], array('id'=>'username')) ?>
		</div>
		<div class="line">
			<?php echo form::label('password', 'Password *') ?>
			<?php echo form::password('password', $post['password'], array('id'=>'password')) ?>
		</div>
		<div class="line">
			<?php echo form::checkbox('remember', 'TRUE', FALSE, array('id'=>'remember','class'=>'auto')) ?>
			<?php echo form::label('remember', 'Remember me') ?>
		</div>
		<div class="controls">
			<?php echo form::button(NULL, 'Login', array('type' => 'submit')) ?>
		</div>
	</fieldset>

<?php echo form::close() ?>
