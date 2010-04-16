<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Types extends Controller_Template_Admin {

	public function action_index()
	{
		// prepare list of all property types
		$types = ORM::factory('type')->find_all()->as_array('name');

		$this->template->content = new View('admin/type/read');
		$this->template->content->title = 'Property Types management';
		$this->template->content->types = $types;
	}

	public function action_edit($id = null)
	{
		$this->template->content = View::factory('admin/type/form')
			->bind('post', $post)
			->bind('errors', $errors);

		$this->template->content->title = 'Type management > '.($id ? "Type Edit ($id)" : 'Type new');

		// get item to be edited, or an empty object if creating new item
		$type = ORM::factory('type', (int) $id);
		
		if ( ! empty($_POST))
		{
			// get post values, load into object and check validation
			$post = $_POST; 
			$type->values($post);
			if ($type->check())
			{
				//cookie::set('message', 'Updated city '.$city->name);
				// save and redirect to index
				if ($type->save()) {
					$this->request->redirect(Route::get('admin')->uri(array('controller' => 'types')));
				}
			}
			else
			{
				// get errors to show in form
				$errors = $type->validate()->errors('admin_errors'); 
			}
		}
		// shuffle up values for form
		$post = $type->as_array('name');
	}

	public function action_delete($id = null)
	{
		$this->template->content = View::factory('admin/system/delete')
			->bind('desc', $desc);

		$this->template->content->title = "Type management > Delete Type";

		// prepare description for user confirmation
		$desc = '"Type: '.ORM::factory('type', (int) $id)->name.'"';
		if ( ! empty($_POST))
		{
		}
	}

}

// End Controller_Admin_Types