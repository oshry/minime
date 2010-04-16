<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<h1><?php echo html::chars($title) ?></h1>

<?php echo form::open() ?>
	<?php echo form::hidden('update_roles', 'true') ?>

	<?php include Kohana::find_file('views', 'admin/system/errors') ?>
	<fieldset>
		<legend>Roles</legend>
		<?php foreach ($roles as $role): ?>
			<div class="line">
				<?php echo form::label('role'.$role->id, ucwords($role->name)) ?>
				<p>
					<?php echo form::checkbox('roles['.$role->id.']', $role->name, isset($post[$role->id]), array('id'=>'role'.$role->id, 'class'=>'auto')) ?>
					<?php echo $role->description ?>
				</p>
			</div>
		<?php endforeach ?>
		<div class="controls">
			<?php echo form::button(NULL, 'Save', array('type' => 'submit')) ?>
		</div>
	</fieldset>

<?php echo form::close() ?>