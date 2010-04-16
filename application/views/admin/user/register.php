<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<h1><?php echo html::chars($title) ?></h1>

<?php echo form::open() ?>

	<?php include Kohana::find_file('views', 'admin/system/errors') ?>
	<fieldset>
		<legend>Account</legend>
		<div class="line">
			<?php echo form::label('email', 'Email *') ?>
			<?php echo form::input('email', $post['email'], array('id'=>'email')) ?>
		</div>
		<div class="line">
			<?php echo form::label('username', 'Username *') ?>
			<?php echo form::input('username', $post['username'], array('id'=>'username')) ?>
		</div>
		<div class="line">
			<?php echo form::label('password', 'Password *') ?>
			<?php echo form::password('password', $post['password'], array('id'=>'password')) ?>
		</div>
		<div class="line">
			<?php echo form::label('password_confirm', 'Password confirmation *') ?>
			<?php echo form::password('password_confirm', $post['password_confirm'], array('id'=>'password_confirm')) ?>
		</div>
	</fieldset>

	<fieldset>
		<legend>Information</legend>
		<div class="line">
			<?php echo form::label('first_name', 'First name') ?>
			<?php echo form::input('first_name', $post['first_name'], array('id'=>'first_name')) ?>
		</div>
		<div class="line">
			<?php echo form::label('last_name', 'Last name') ?>
			<?php echo form::input('last_name', $post['last_name'], array('id'=>'last_name')) ?>
		</div>
		<div class="controls">
			<?php echo form::button(NULL, 'Save', array('type' => 'submit')) ?>
		</div>
	</fieldset>

<?php echo form::close() ?>
