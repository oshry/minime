<?php

class Model_Type extends ORM {
	protected $_table_name = 'property_types';
	protected $_has_many = array('properties' => array('model' => 'property', 'foreign_key' => 'type_id'));
	protected $_rules = array('name' => array('not_empty' => NULL));
	protected $_filters = array(TRUE => array('trim' => NULL));
};

// /model/property_type.php
// end