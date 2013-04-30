<?php

Class TaskModel extends Model {

	var $id,
		$list_id,
		$name,
		$description,
		$completed,
		$due_date;

	function __construct() {
		parent::__construct();
	}
}
