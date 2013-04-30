<?php

interface I_Task {
	function set($data);
}

Class TaskDefaultModel extends Model implements I_Task {
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

Class TaskModel {

	function __construct($type = 'default') {
		switch ($type) {
			case 'default':
				return new TaskDefaultModel();
				break;

			case 'email':
				// todo: Implement me
				break;

		}
	}

}

