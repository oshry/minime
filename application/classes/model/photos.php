<?php

class Controller_Admin extends Controller_Template {

	function action_index()
	{
		/*
		 * METHOD 1
		   DB::select(array('COUNT("*")', 'total_count'))
						->from($this->_table_name)
						->where($this->unique_key($value), '=', $value)
						->execute($this->_db)
						->get('total_count');
		*/

		/*
		 * METHOD 2
		$query = DB::query(Database::SELECT, '
			SELECT WEEK(FROM_UNIXTIME(created_on)) AS w, count(id) as total
			FROM posts
			WHERE datediff(now(), FROM_UNIXTIME(created_on)) <= :days
			GROUP BY WEEK(FROM_UNIXTIME(created_on))
		')->param(':days', $days);

		 $query->execute()
		 */

		/**
		 * METHOD 3
		 */
		$groups = DB::select('*')->from('settings')->execute();
		$content = '';
		foreach ($groups as $group)
		{
			$content .= $group['id'].' '.$group['name'].'<br />';
		}

		$pagination = Pagination::factory(array('total_items' => 20));

		$content = $content . $pagination;

		// Assign the content to the view
		$this->template->content = $content;
	}
}
?>
