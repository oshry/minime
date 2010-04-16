<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Admin_Posts extends Controller_Template_Admin {

	protected $_type = 'post';

	public function action_index($results = FALSE)
	{
		// get pagination values from querystring
		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		$sort = (isset($_GET['s'])) ? $_GET['s'] : FALSE;
		$order = (isset($_GET['o'])) ? $_GET['o'] : FALSE;
		$user_id = (isset($_GET['u'])) ? (int) $_GET['u'] : FALSE;
		($user_id > 0) or $user_id = FALSE;

		// get search values from querystring
		$post = $_GET;
/*		$post['type_id'] = (isset($_GET['t']) AND ! empty($_GET['t'])) ? (int) $_GET['t'] : FALSE;
		$post['city_id'] = (isset($_GET['c']) AND ! empty($_GET['c'])) ? (int) $_GET['c'] : FALSE;
		$post['pmin'] = (isset($_GET['pmin']) AND ! empty($_GET['pmin'])) ? (int) $_GET['pmin'] : FALSE;
		$post['pmax'] = (isset($_GET['pmax']) AND ! empty($_GET['pmax'])) ? (int) $_GET['pmax'] : FALSE;*/

		if ( ! $results) {
			$content = &$this->template->content;
			$content = new View('admin/post/read');
			$content->title = ucwords($this->_type).' management';
		} else {
			$this->template->content->post = $post;
			$content = &$this->template->content->results;
		}
		$content->data = Model_Post::get_list(array(
													array('posts.type', '=', $this->_type),
													array('posts.created_by_id', '=', $user_id),
/*													array('type_id', '=', $post['type_id']),
													array('city_id', '=', $post['city_id']),
													array('price1', '>=', $post['pmin']),
													array('price1', '<=', $post['pmax']),*/
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
		$this->template->content->title = ucwords($this->_type).' Search';
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
/*			$this->template->content->results->data = Model_Property::get_list(0, 1, false, 'desc');*/
		}
	}

	public function action_edit($id = null)
	{
		// Setup view		
		$this->template->content = View::factory('admin/post/form')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('pages', $pages)
			->bind('cities', $cities);

		$this->template->content->title = ucwords($this->_type).' management > '.ucwords($this->_type).($id ? " edit ($id)" : ' new');

		// get all cities and add first option as blank
		$cities = ORM::factory('city')->find_all()->as_array('id', 'name');
		arr::unshift($cities, NULL, '-- None --');

		if ($this->_type == 'page') {
			// get all pages for parent_id and add first option as blank
			$pages = ORM::factory('post')->where('type', '=', $this->_type)->find_all()->as_array('id', 'title');
			arr::unshift($pages, NULL, '-- Root --');
		}

		// get item to be edited, or an empty object if creating new item
		$item = ORM::factory('post', (int) $id);
		
		if ( ! empty($_POST))
		{
			// get post values, load into object and check validation
			$post = $_POST; 
			$post['type'] = $this->_type;
			$item->values($post);
			if ($item->check())
			{
				//cookie::set('message', 'Updated city '.$city->name);
				// save and redirect to index
				if ($item->save()) {
					$this->request->redirect(Route::get('admin')->uri(array('controller' => $this->_type.'s')));
				}
			}
			else
			{
				// get errors to show in form
				$errors = $item->validate()->errors('admin_errors'); 
			}
		}
		// shuffle up values for form
		$post = $item->as_array('type_id', 'city_id', 'name', 'body', 'bedrooms', 'bathrooms', 'sqft', 'image');
	}

	public function action_delete($id = null)
	{
		// Setup view
		$this->template->content = View::factory('admin/system/delete')
			->bind('desc', $desc);

		$this->template->content->title = ucwords($this->_type).' management > Delete '.ucwords($this->_type);

		// prepare description for user confirmation
		$desc = '"'.ucwords($this->_type).': '.ORM::factory('post', (int) $id)->title.'"';
		if ( ! empty($_POST))
		{
		}
	}

} // End Admin_Posts Controller