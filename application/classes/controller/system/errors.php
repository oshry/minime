<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_System_Errors extends Controller_Template_Site {

	public function action_404()
	{
		$this->template->content = '<h1>Page not found!</h1> <p>We are very sorry. But we cannot find the page you requested.</p>';
	}

} // End Home Controller