<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Home extends Controller_Template_Admin {

	public function action_index()
	{
		$this->template->content = new View('admin/dashboard');
		$this->template->content->title = 'Dashboard';
	}

}

// controller/admin/home.php
// End Controller_Admin_Home