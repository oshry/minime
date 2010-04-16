<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Cities extends Controller_Template_Admin {

	public function action_index()
	{
		// prepare list of all cities
		$cities = ORM::factory('city')->find_all()->as_array('name');

		$this->template->head->title = 'Admin | Cities';
		$this->template->content = new View('admin/city/read');
		$this->template->content->title = 'City management';
		$this->template->content->cities = $cities;
	}

	public function action_edit($id = null)
	{
		$this->template->content = View::factory('admin/city/form')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('areas', $areas);

		$this->template->content->title = 'City management > '.($id ? "City Edit ($id)" : 'City new');

		// get all areas and add first option as blank
		$areas = ORM::factory('area')->find_all()->as_array('id', 'name');
		arr::unshift($areas, NULL, '-- Select --');

		// get city to be edited, or an empty object if creating new item
		$city = ORM::factory('city', (int) $id);
		
		if ( ! empty($_POST))
		{
			// get post values, load into object and check validation
			$post = $_POST; 
			$city->values($post);
			if ($city->check())
			{
				//cookie::set('message', 'Updated city '.$city->name);
				// save and redirect to index
				if ($city->save()) {
					$this->request->redirect(Route::get('admin')->uri(array('controller' => 'cities')));
				}
			}
			else
			{
				// get errors to show in form
				$errors = $city->validate()->errors('admin_errors'); 
			}
		}
		// shuffle up values for form
		$post = $city->as_array('area_id', 'name');
	}

	public function action_delete($id = null)
	{
		$this->template->content = View::factory('admin/system/delete')
			->bind('desc', $desc);

		$this->template->content->title = "City management > Delete City";

		// prepare description for user confirmation
		$desc = '"City: '.ORM::factory('city', (int) $id)->name.'"';
		if ( ! empty($_POST))
		{
		}
	}

}

// controller/admin/cities.php
// End Controller_Admin_Cities