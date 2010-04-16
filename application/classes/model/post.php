<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Post extends ORM {

	protected $_type = 'post';
	protected $_belongs_to = array(
								'posts' => array('model' => 'post', 'foreign_key' => 'parent_id'),
								'cities' => array('model' => 'city', 'foreign_key' => 'city_id'),
								'created_by' => array('model' => 'user', 'foreign_key' => 'created_by_id'),
								'updated_by' => array('model' => 'user', 'foreign_key' => 'updated_by_id')
							);
	protected $_rules = array(
							'title' => array('not_empty' => NULL),
							'body' => array('not_empty' => NULL),
							'type' => array('in_array' => array(array('post', 'page')))
						);
	protected $_filters = array(TRUE => array('trim' => NULL));

	static function get_list($conditions = array(), $page = 1, $sort = '', $order = 'ASC')
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
			'id'							=> array('title' => 'ID'),
			'title'							=> array('title' => 'Title'),
			'created_by:details:first_name'	=> array('title' => 'Author'),
			'created_on'					=> array('title' => 'Created'),
			'version'						=> array('title' => 'Version'),
			'updated_on'					=> array('title' => 'Modified'),
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

		$list = ORM::factory('post');
		if ( ! empty($conditions)) {
			foreach ($conditions as $cond) {
				if (count($cond) == 3 && $cond[2] !== FALSE) {
					$list = $list->where($cond[0], $cond[1], $cond[2]);
				}
			}
		}
		
		$total_rows = $list->count_all();

		$list = ORM::factory('post');
		if ( ! empty($conditions)) {
			foreach ($conditions as $cond) {
				if (count($cond) == 3 && $cond[2] !== FALSE) {
					$list = $list->where($cond[0], $cond[1], $cond[2]);
				}
			}
		}
		
		return array(
			'header' => $header,
			'list' => $list
						->with('created_by')
						->with('created_by:details')
						->order_by($sort, $order)
						->limit($limit)
						->offset($offset)
						->find_all(),
			'paging' => Pagination::factory(array(
				'items_per_page' => $limit,
				'total_items'    => $total_rows,
			))->render()
		);
	}

	public function save() {
		// Get current logged in user
		$user = Auth::instance()->get_user();
		// check if this is a new item created,
		if ( ! $this->id) {
			$this->state = 1;
			$this->visibility = 1;
			$this->version = 1;
			$this->created_on = date('Y-m-d H:i:s');
			$this->created_by_id = $user->id;

		// otherwise, we're updating an existing item,
		} else {
			$this->version += 1;
			$this->updated_on = date('Y-m-d H:i:s');
			$this->updated_by_id = $user->id;
		}

		return parent::save();
	}
	
};

// model/post.php
// end Model_Post