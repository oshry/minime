<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Properties extends Controller_Template_Admin {

	public function action_index($results = FALSE)
	{
		// get pagination values from querystring
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		$sort = (isset($_GET['s'])) ? $_GET['s'] : FALSE;
		$order = (isset($_GET['o'])) ? $_GET['o'] : FALSE;
		$user_id = (isset($_GET['u'])) ? (int) $_GET['u'] : FALSE;
		($user_id > 0) or $user_id = FALSE;

		// make sure agents see only their properties
		if ( ! in_array('admin', Session::instance()->get('user_roles')))
		{
			$user_id = Auth::instance()->get_user()->id;
		}

		// get search values from querystring
		$post = $_GET;
		$post['type_id'] = (isset($_GET['t']) AND ! empty($_GET['t'])) ? (int) $_GET['t'] : FALSE;
		$post['city_id'] = (isset($_GET['c']) AND ! empty($_GET['c'])) ? (int) $_GET['c'] : FALSE;
		$post['pmin'] = (isset($_GET['pmin']) AND ! empty($_GET['pmin'])) ? (int) $_GET['pmin'] : FALSE;
		$post['pmax'] = (isset($_GET['pmax']) AND ! empty($_GET['pmax'])) ? (int) $_GET['pmax'] : FALSE;

		if ( ! $results) {
			$content = &$this->template->content;
			$content = new View('admin/property/read');
			$content->title = 'Property management';
		} else {
			$this->template->content->post = $post;
			$content = &$this->template->content->results;
		}
		$content->data = Model_Property::get_list(array(
													array('properties.created_by_id', '=', $user_id),
													array('type_id', '=', $post['type_id']),
													array('city_id', '=', $post['city_id']),
													array('price1', '>=', $post['pmin']),
													array('price1', '<=', $post['pmax']),
												), $page, $sort, $order);
	}

	public function action_search()
	{
		// Setting up price range search
		$price_min = array();
		for ($i=100000; $i<=10000000; $i += 100000) {
			$price_min[$i] = '$ '.number::humanReadable($i);
			if ($i >= 1000000) $i += 400000;
		}
		$price_max = $price_min;
		arr::unshift($price_min, '', 'Minimum');
		arr::unshift($price_max, '', 'Maximum');

		// Setting types
		$types = ORM::factory('type')->find_all()->as_array('id', 'name');
		arr::unshift($types, '', '-- Select --');
		
		// Setting cities
		$cities = ORM::factory('city')->find_all()->as_array('id', 'name');
		arr::unshift($cities, '', '-- Select --');
		
		$this->template->content = new View('admin/property/search');
		$this->template->content->title = 'Property Search';
		$this->template->content->types = $types;
		$this->template->content->cities = $cities;
		$this->template->content->price_min = $price_min;
		$this->template->content->price_max = $price_max;
		$this->template->content->post = array('type_id' => '', 'city_id' => '', 'pmin' => '', 'pmax' => '');

		if ( ! empty($_GET))
		{
			$this->template->content->results = new View('admin/property/read');
			$this->template->content->results->title = 'Search Results';
			$this->action_index(TRUE);
		}
	}

	public function action_edit($id = null)
	{
		// Add the controller js file to head scripts
		array_push($this->template->head->scripts, 'media/js/property.js', 'media/js/swfobject.js', 'media/js/jquery.uploadify.js');
		array_push($this->template->head->styles, 'media/css/uploadify.css');

		// Setup view		
		$this->template->content = View::factory('admin/property/form')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('types', $types)
			->bind('cities', $cities);

		$this->template->content->title = 'Property management > '.($id ? "Property Edit ($id)" : 'Property new');

		// get all cities and add first option as blank
		$cities = ORM::factory('city')->find_all()->as_array('id', 'name');
		arr::unshift($cities, NULL, '-- Select --');

		// get all types and add first option as blank
		$types = ORM::factory('type')->find_all()->as_array('id', 'name');
		arr::unshift($types, NULL, '-- Select --');

		// get item to be edited, or an empty object if creating new item
		$property = ORM::factory('property', (int) $id);

		// make sure agents can only edit their own property
		if ($id AND ! in_array('admin', Session::instance()->get('user_roles')))
		{
			// if authenticate user id doesn't match the property created by id, redirect
			if (Auth::instance()->get_user()->id != $property->created_by_id) {
				$this->request->redirect(Route::get('admin')->uri(array('action' => 'notowner')));
			}
		}

		if ( ! empty($_POST))
		{
			// get post values, load into object and check validation
			$post = $_POST; 
			$property->values($post);
			if ($property->check())
			{
				//cookie::set('message', 'Updated city '.$city->name);
				// save and redirect to index
				if ($property->save()) {
					$this->request->redirect(Route::get('admin')->uri(array('controller' => 'properties')));
				}
			}
			else
			{
				// get errors to show in form
				$errors = $property->validate()->errors('admin_errors'); 
			}
		}
		// shuffle up values for form
		$post = $property->as_array('type_id', 'city_id', 'name', 'body', 'bedrooms', 'bathrooms', 'sqft', 'image');
	}

	public function action_delete($id = null)
	{
		$property = ORM::factory('property', (int) $id);

		// make sure agents can only edit their own property
		if ( ! in_array('admin', Session::instance()->get('user_roles')))
		{
			// if authenticate user id doesn't match the property created by id, redirect
			if (Auth::instance()->get_user()->id != $property->created_by_id) {
				$this->request->redirect(Route::get('admin')->uri(array('action' => 'notowner')));
			}
		}

		// Setup view
		$this->template->content = View::factory('admin/system/delete')
			->bind('desc', $desc);

		$this->template->content->title = "Property management > Delete Property";

		// prepare description for user confirmation
		$desc = '"Property: '.$property->name.'"';
		if ( ! empty($_POST))
		{
		}
	}

} // End Admin_Properties Controller