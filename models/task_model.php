<?php

interface I_Task {
	function set($data);
	function set_alarm($interval);
}

Class TaskDefaultModel extends Model implements I_Task {
	var $id,
		$list_id,
		$name,
		$description,
		$completed,
		$due_date,
		$alarm_interval;

	function __construct() {
		parent::__construct();
	}

	function set_alarm($interval) {
		// Validate there is a due date
		if (!$this->due_date) {
			return false;
		}

		// Validate interval to be 15, 30 or 24
		if ($interval != 15 && $interval != 30 && $interval != 24) {
			return false;
		}

		// Set the alarm interval
		$this->alarm_interval = $interval;
		return true;
	}

}

Class TaskModel {

	public static function create ($type = 'default') {
		switch ($type) {
			case 'default':
				return new TaskDefaultModel();

			case 'email':
				// todo: Implement me
				break;

		}

	}

}

