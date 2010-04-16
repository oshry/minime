<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User {

	protected $_has_one = array('details' => array('model' => 'user_detail', 'foreign_key' => 'user_id'));

	static function get_list($page = 1, $sort = '', $order = 'ASC')
	{
		// Default values
		$limit = (int) Kohana::config('minime')->admin['items_per_page'];
		($page > 0) or $page = 1;
		($limit > 0) or $limit = 5;
		($sort) or $sort = 'id';
		($order == 'ASC' || $order == 'DESC') or $order = 'ASC';
		$offset = ($page === 1) ? 0 : (int) (($page - 1) * $limit);

		// Setup table header titles
		$header = array(
			'id'			=> array('title' => 'ID'),
			'first_name'	=> array('title' => 'Name'),
			'email'			=> array('title' => 'Email'),
			'city'			=> array('title' => 'City'),
			'company'		=> array('title' => 'Company'),
			'phone_mobile'	=> array('title' => 'Mobile'),
			'logins'		=> array('title' => 'Logins'),
			'created_on'	=> array('title' => 'Joined'),
		);

		// Setup table header title links
		foreach ($header as $key => $vars)
		{
			if ($key == $sort) {
				$header[$key]['link'] = URL::site(Request::instance()->uri).URL::query(array('s' => $key, 'o' => ($order=='ASC') ? 'DESC' : 'ASC'));
			} else {
				$header[$key]['link'] = URL::site(Request::instance()->uri).URL::query(array('s' => $key));
			}
		}

		return array(
			'header' => $header,
			'list' => ORM::factory('user')
						->with('details')
						->order_by($sort, $order)
						->limit($limit)
						->offset($offset)
						->find_all(),
			'paging' => Pagination::factory(array(
				'items_per_page' => $limit,
				'total_items'    => ORM::factory('user')->count_all(),
			))->render()
		);
	}

	public function save()
	{
		if ( ! $this->id)
		{
			// Set join date
			$this->created_on = time(); 
		}
		return parent::save();
	}
}

// model/user.php
// End Model_User