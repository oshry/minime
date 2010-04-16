<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<h1><?php echo html::chars($title) ?></h1>

<?php echo form::open() ?>

	<?php include Kohana::find_file('views', 'admin/system/errors') ?>
	<fieldset>
		<legend>Information</legend>
		<div class="line">
			<?php echo form::label('company', 'Company name') ?>
			<?php echo form::input('company', $post['company'], array('id'=>'company')) ?>
		</div>
		<div class="line">
			<?php echo form::label('title', 'Title') ?>
			<?php echo form::input('title', $post['title'], array('id'=>'title')) ?>
		</div>
		<div class="line">
			<?php echo form::label('first_name', 'First name') ?>
			<?php echo form::input('first_name', $post['first_name'], array('id'=>'first_name')) ?>
		</div>
		<div class="line">
			<?php echo form::label('last_name', 'Last name') ?>
			<?php echo form::input('last_name', $post['last_name'], array('id'=>'last_name')) ?>
		</div>
		<div class="line">
			<?php echo form::label('phone_home', 'Phone Home') ?>
			<?php echo form::input('phone_home', $post['phone_home'], array('id'=>'phone_home')) ?>
		</div>
		<div class="line">
			<?php echo form::label('phone_work', 'Phone Work') ?>
			<?php echo form::input('phone_work', $post['phone_work'], array('id'=>'phone_work')) ?>
		</div>
		<div class="line">
			<?php echo form::label('phone_work_ext', 'Phone Work Ext#') ?>
			<?php echo form::input('phone_work_ext', $post['phone_work_ext'], array('id'=>'phone_work_ext')) ?>
		</div>
		<div class="line">
			<?php echo form::label('phone_mobile', 'Phone Mobile') ?>
			<?php echo form::input('phone_mobile', $post['phone_mobile'], array('id'=>'phone_mobile')) ?>
		</div>
		<div class="line">
			<?php echo form::label('fax', 'Fax') ?>
			<?php echo form::input('fax', $post['fax'], array('id'=>'fax')) ?>
		</div>
		<div class="line">
			<?php echo form::label('website', 'Website') ?>
			<?php echo form::input('website', $post['website'], array('id'=>'website')) ?>
		</div>
		<div class="line">
			<?php echo form::label('gender', 'Gender') ?>
			<?php echo form::input('gender', $post['gender'], array('id'=>'gender')) ?>
		</div>
		<div class="line">
			<?php echo form::label('dob', 'Date of birth') ?>
			<?php echo form::input('dob', $post['dob'], array('id'=>'dob')) ?>
		</div>
	</fieldset>
	<fieldset>
		<legend>Address</legend>
		<div class="line">
			<?php echo form::label('address', 'Address') ?>
			<?php echo form::input('address', $post['address'], array('id'=>'address')) ?>
		</div>
		<div class="line">
			<?php echo form::label('city', 'City') ?>
			<?php echo form::input('city', $post['city'], array('id'=>'city')) ?>
		</div>
		<div class="line">
			<?php echo form::label('zip', 'Zip') ?>
			<?php echo form::input('zip', $post['zip'], array('id'=>'zip')) ?>
		</div>
		<div class="line">
			<?php echo form::label('country', 'Country') ?>
			<?php echo form::input('country', $post['country'], array('id'=>'country')) ?>
		</div>
		<div class="controls">
			<?php echo form::button(NULL, 'Save', array('type' => 'submit')) ?>
		</div>
	</fieldset>

<?php echo form::close() ?>
