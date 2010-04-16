<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Areas extends Controller_Template_Admin {

	public function action_index()
	{
		// prepare list of all cities
		$areas = ORM::factory('area')->find_all()->as_array('name');

		$this->template->content = new View('admin/area/read');
		$this->template->content->title = 'Area management';
		$this->template->content->areas = $areas;
	}

	public function action_edit($id = null)
	{
		$this->template->content = View::factory('admin/area/form')
			->bind('post', $post)
			->bind('errors', $errors);
		
		$this->template->content->title = 'Area management > '.($id ? "Area Edit ($id)" : 'Area new');

		// get item to be edited, or an empty object if creating new item
		$area = ORM::factory('area', (int) $id);

		if ( ! empty($_POST))
		{
			// get post values, load into object and check validation
			$post = $_POST; 
			$area->values($post);
			if ($area->check())
			{
				//cookie::set('message', 'Updated city '.$city->name);
				// save and redirect to index
				if ($area->save()) {
					$this->request->redirect(Route::get('admin')->uri(array('controller' => 'areas')));
				}
			}
			else
			{
				// get errors to show in form
				$errors = $area->validate()->errors('admin_errors'); 
			}
		}
		// shuffle up values for form
		$post = $area->as_array('name');
	}

	public function action_delete($id = null)
	{
		$this->template->content = View::factory('admin/system/delete')
			->bind('desc', $desc);

		$this->template->content->title = "Area management > Delete Area";

		// prepare description for user confirmation
		$desc = '"Area: '.ORM::factory('area', (int) $id)->name.'"';
		if ( ! empty($_POST))
		{
		}
	}

}

// End Controller_Admin_Areas