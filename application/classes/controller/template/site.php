<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Template_Site extends Controller_Template {

	protected $_ajax = FALSE;
	protected $_languages = array();
	protected $_user;

	public function before()
	{
		// Open remote URLs in a new window
		html::$windowed_urls = TRUE;

		parent::before();

		$this->template->title =
		$this->template->content = '';
		
		// setting up template
		$this->template->header = View::factory('header');
		$this->template->footer = View::factory('footer');
		$this->template->nav = View::factory('nav');
		$this->template->panel = View::factory('panel');
		$this->template->scripts = array('media/js/init.js');
		$this->template->styles = array();
		$this->template->controller = Request::instance()->controller;
	}

	public function after()
	{
		if ($this->_ajax === TRUE)
		{
			// Use the template content as the response
			$this->request->response = $this->template->content;
		}
		else
		{
			parent::after();
			
			// Delete any existing message cookie
			cookie::delete('message');
		}
	}

}

// end Controller_Template_Site