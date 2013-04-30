<?php

Class ListModel extends Model {

	var $id,
		$user_id,	// reserved for future
		$name,
		$due_date;

	function __construct() {
		parent::__construct();
	}
}
