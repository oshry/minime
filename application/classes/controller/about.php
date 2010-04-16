<?php // defined('SYSPATH') OR die('No direct access allowed.');

class Controller_About extends Controller_Template_Site {

	public function action_index()
	{
		$this->template->content = View::factory('pages/about');
		//$this->template->title = 'About Us';
		//$this->template->content->body = 'Lorem ipsum';
	}

} // End Home Controller

?>