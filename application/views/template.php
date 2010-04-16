<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="keywords" content="<?php if ( ! empty($meta_keys)) echo $meta_keys ?>" />
<meta name="description" content="<?php if ( ! empty($meta_desc)) echo $meta_desc ?>" />
<title><?php if (!empty($meta_title)) echo "$meta_title ~ " ?>Photo Administration</title>
<!--[if lt IE 7]><?php echo HTML::style('media/css/ie6.css', array('media' => 'screen')) ?><![endif]--> 
<!--[if IE 7]><?php echo HTML::style('media/css/ie7.css', array('media' => 'screen')) ?><![endif]--> 
<!--[if IE]><?php echo HTML::style('media/css/ie.css', array('media' => 'screen')) ?><![endif]--> 
<?php
echo
	HTML::style('media/css/reset.css', array('media' => 'screen')),
	HTML::style('media/css/layout.css', array('media' => 'screen')),
	HTML::style('media/css/print.css', array('media' => 'print')),
	HTML::script('media/js/jquery-1.4.1.min.js');
	//HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
if (IN_PRODUCTION) echo 'yayy!!';
if (isset($styles)) foreach ($styles as $style) echo HTML::style($style, array('media'=>'screen'), TRUE), "\n";
if (isset($scripts)) foreach ($scripts as $script) echo HTML::script($script), "\n";
if (isset($metas)) foreach ($metas as $meta) echo HTML::meta($meta), "\n";
?>
<script type="text/javascript">var base_url = '<?php echo url::base() ?>';</script>
</head>
<body id="page-<?php echo $controller ?>">
	<div id="wrapper">
		<div id="header">
			<?php echo $header ?>
		</div>
		<div id="nav">
			<?php echo $nav ?>
		</div>
		<div id="content">
			<?php echo $content ?>
		</div>
		<div id="footer">
			<?php echo $footer ?>
		</div>
	</div>
	<?php // if ( ! IN_PRODUCTION) echo View::factory('profiler/stats') ?>
</body>
</html>