<?php

class Model_City extends ORM {
	protected $_has_many = array('properties' => array('model' => 'property', 'foreign_key' => 'city_id'));
	protected $_belongs_to = array(
								'areas' => array('model' => 'area', 'foreign_key' => 'area_id'),
								'created_by' => array('model' => 'user', 'foreign_key' => 'created_by_id')
							);
	protected $_rules = array('name' => array('not_empty' => NULL), 'area_id' => array('not_empty' => NULL));
	protected $_filters = array(TRUE => array('trim' => NULL));

	public function save() {
		// check if this is a new item created, and add timestamp and user_id
		if ( ! $this->id) {
			$this->created_on = date('Y-m-d H:i:s');
			$this->created_by_id = Auth::instance()->get_user()->id;
		};
		return parent::save();
	}
};

// /model/city.php
// end