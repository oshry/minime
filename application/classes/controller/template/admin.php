<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Template_Admin extends Controller_Template {

	public $template = 'admin/template'; 

	/**
	 * Pass the request to the true template controller,
	 * then initialize the template and session.
	 * 
	 * @param	Request	page request
	 * @return 
	 */
	public function __construct(Request $req)
	{
		// Pass the request to the template controller
		parent::__construct($req);
	}

	public function before()
	{
		
		parent::before();

		// Load all elements of admin template except sidebar
		$this->template->head = View::factory('admin/elements/head');
		$this->template->header = View::factory('admin/elements/header');
		$this->template->sidebar = '';
		$this->template->content = '';
		$this->template->footer = View::factory('admin/elements/footer');

		// Set default template settings for admin panel
		$this->template->head->title = '';
		$this->template->head->meta_tags = array();
		$this->template->head->styles = array('media/css/front.css'); 
		$this->template->head->scripts = array('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js'); 

		$auth = Auth::instance();
		if ($this->request->action !== 'login' AND ! $auth->logged_in()) {
			// Redirect to the login page
			$this->request->redirect(Route::get('admin')->uri(array('action' => 'login')));
		}
		// Load the sidebar view if not login or logout
		elseif ($this->request->action !== 'login' AND $this->request->action !== 'logout')
		{
			// Load navigation according to logged on user role
			//echo '<pre>'; var_dump();echo '</pre>';
			 
			if (in_array('admin', Session::instance()->get('user_roles'))) {
				$this->template->sidebar = View::factory('admin/elements/navigation');
			} else {
				$this->template->sidebar = View::factory('admin/elements/agent_nav');
			}
		}
	}

	public function after()
	{

		parent::after();
		
		// If meta title was not defined, use the template title
		if ( ! $this->template->head->title AND isset($this->template->content->title))
		{
			$this->template->head->title = $this->template->content->title;
		}
	}

	public function action_login()
	{
		// Set the login page
		$this->template->content = View::factory('admin/login')
			->bind('post', $post)
			->bind('errors', $errors);
		
		$this->template->content->title = 'Login';

		if ( ! empty($_POST)) {
			// Sanitize user input
			$_POST['username'] = security::xss_clean($_POST['username']);
			$_POST['password'] = security::xss_clean($_POST['password']);
			$_POST['remember'] = (bool) (isset($_POST['remember']) ? security::xss_clean($_POST['remember']) : FALSE);

			$auth = Auth::instance();
			// Try to login using username
			if ($auth->login($_POST['username'], $_POST['password'], $_POST['remember']))
			{
				// get user role
				$user_roles = $auth->get_user()->roles->where('name', '!=', 'login')->find_all()->as_array('id', 'name');
				// store in session
				$_SESSION['user_roles'] = $user_roles; 
				// If succeed, redirect to home (dashboard)
				$this->request->redirect(Route::get('admin')->uri(array('controller' => 'home')));
			}
			else
			{
				$errors[] = 'Invalid username or password';
			}
		}
	}
	
	public function action_logout()
	{
		$auth = Auth::instance();
		// Completely destroy session and tokens
		$auth->logout(TRUE, TRUE);
		// Set the logout view
		$this->template->content = View::factory('admin/logout');
		$this->template->content->title = 'You\'re out!';
	}

	public function action_notowner()
	{
		$this->template->content = '<h1>You are not the owner of this object!</h1>';
	}


}

// controller/template/admin.php
// End Controller_Template_Admin