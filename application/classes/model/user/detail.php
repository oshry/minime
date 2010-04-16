<?php

class Model_User_Detail extends ORM {
	protected $_has_one = array('user' => array('model' => 'user', 'foreign_key' => 'id'));
	protected $_belongs_to = array(
								'user' => array('model' => 'user', 'foreign_key' => 'user_id')
							);
	protected $_rules = array(
							'user_id' => array('not_empty' => NULL),
							'first_name' => array('not_empty' => NULL),
						);
	protected $_filters = array(TRUE => array('trim' => NULL));
};

// /model/user/detail.php
// end