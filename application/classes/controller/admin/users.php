<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Users extends Controller_Template_Admin {

	public function action_index()
	{
		// make sure agents cannot access this action
		if ( ! in_array('admin', Session::instance()->get('user_roles')))
		{
			$this->request->redirect(Route::get('admin')->uri(array('action' => 'notowner')));
		}

		// get pagination values from querystring
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		$sort = (isset($_GET['s'])) ? $_GET['s'] : false;
		$order = (isset($_GET['o'])) ? $_GET['o'] : false;

		$this->template->head->title = 'Admin | Users';
		$this->template->content = new View('admin/user/read');
		$this->template->content->title = 'Users management';
		$this->template->content->data = Model_User::get_list($page, $sort, $order);
	}

	public function action_register()
	{
		// make sure agents cannot access this action
		if ( ! in_array('admin', Session::instance()->get('user_roles')))
		{
			$this->request->redirect(Route::get('admin')->uri(array('action' => 'notowner')));
		}

		$this->template->content = View::factory('admin/user/register')
			->bind('post', $post)
			->bind('errors', $errors);
		$this->template->content->title = 'User management > Register new user';
		
		$user = ORM::factory('user');
		if ( ! empty($_POST))
		{
			// get post values, load into object and check validation
			$post = $_POST;
			$user->values($post);
			if ($user->check() AND $user->save())
			{
				// add the basic login role
				$user->add('roles', ORM::factory('role', array('name' => 'login')));

				$details = $user->details;
				arr::unshift($post, 'user_id', $user->id);
				$details->values($post);
				if ($details->check() AND $details->save())
				{
					//cookie::set('message', 'Updated user '.$user->username);
					// save and redirect to index
					$this->request->redirect(Route::get('admin')->uri(array('controller' => 'users')));
				}
				else
				{
					$errors = $details->validate()->errors('admin_errors'); 
				}
			}
			else
			{
				// get errors to show in form
				$errors = $user->validate()->errors('admin_errors'); 
			}
		}
		// shuffle up values for form
		$post = $user->as_array();
		arr::unshift($post, 'password_confirm', NULL);
		arr::unshift($post, 'first_name', NULL);
		arr::unshift($post, 'last_name', NULL);
	}

	public function action_roles($id = null)
	{
		// make sure agents cannot access this action
		if ( ! in_array('admin', Session::instance()->get('user_roles')))
		{
			$this->request->redirect(Route::get('admin')->uri(array('action' => 'notowner')));
		}

		$this->template->content = View::factory('admin/user/roles')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('roles', $roles);
		$this->template->content->title = 'User management > User roles';
		
		$user = ORM::factory('user', (int) $id);
		// get all roles
		$roles = ORM::factory('role')->find_all();
		// get all user roles
		$user_roles = $user->roles->find_all()->as_array('id', 'name');
		
		if ( ! empty($_POST))
		{
			$post = $_POST;
			if ( ! isset($post['roles']))
			{
				// If role array in post is not set, it means that no role has been selected!
				$remove = $user_roles;
			}
			else
			{
				// add all selected roles
				foreach ($post['roles'] as $role_id => $role_name)
				{
					if ( ! arr::get($user_roles, $role_id)) {
						$user->add('roles', ORM::factory('role', array('name' => $role_name)));
					}
				}

				// get all roles that were not selected for this user
				$remove = array_diff_key($roles->as_array('id', 'name'), $post['roles']);
			}

			// remove them
			foreach ($remove as $role_id => $role_name)
			{
				if (arr::get($user_roles, $role_id)) {
					$user->remove('roles', ORM::factory('role', array('name' => $role_name)));
				};
			}
			//cookie::set('message', 'Updated user '.$user->username);
			// redirect to index
			$this->request->redirect(Route::get('admin')->uri(array('controller' => 'users')));
		}
		// shuffle up values for form
		$post = $user_roles;
	}

	public function action_edit($id = null)
	{
		// make sure agents can only edit their profile
		if ( ! in_array('admin', Session::instance()->get('user_roles')))
		{
			$id = Auth::instance()->get_user()->id;
		}

		$this->template->content = View::factory('admin/user/form')
			->bind('post', $post)
			->bind('errors', $errors);

		$this->template->content->title = 'User management > User edit';

		// get user details to be edited
		$user_detail = ORM::factory('user', (int) $id)->details;
		
		if ( ! empty($_POST))
		{
			// get post values, load into object and check validation
			$post = $_POST;
			$user_detail->values($post);
			if ($user_detail->check())
			{
				if ($user_detail->save()) {
					//cookie::set('message', 'Updated user '.$user->username);
					// save and redirect to index
					$this->request->redirect(Route::get('admin')->uri(array('controller' => 'users')));
				}
			}
			else
			{
				// get errors to show in form
				$errors = $user_detail->validate()->errors('admin_errors'); 
			}
		}
		// shuffle up values for form
		$post = $user_detail->as_array();
	}

	public function action_delete($id = null)
	{
		// make sure agents cannot access this action
		if ( ! in_array('admin', Session::instance()->get('user_roles')))
		{
			$this->request->redirect(Route::get('admin')->uri(array('action' => 'notowner')));
		}

		$this->template->content = View::factory('admin/system/delete')
			->bind('desc', $desc);

		$this->template->content->title = 'User management > Delete User';

		// prepare description for user confirmation
		$desc = '"User: '.ORM::factory('user', (int) $id)->username.'"';
		if ( ! empty($_POST))
		{
		}
	}

}

// controller/admin/users.php
// End Controller_Admin_Users