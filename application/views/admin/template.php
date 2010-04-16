<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php echo $head ?>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<?php echo $header ?>
		</div>
		<div id="sidebar">
			<?php echo $sidebar ?>
		</div>
		<div id="content">
			<?php echo $content ?>
		</div>
		<div id="footer">
			<?php echo $footer ?>
		</div>
	</div>

</body>
</html>
<?php if ( ! IN_PRODUCTION) echo View::factory('profiler/stats') ?> 