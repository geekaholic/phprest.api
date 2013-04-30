<?php

class Controller {

	// Store controller object array
	var $obj_arr;

	// Constructor
	function __construct($obj_arr) {
		$this->obj_arr = &$obj_arr;
	}

	function indexAction() {
		// Default action is readAction
		$this->readAction();
	}

	// Read object
	function readAction() {

		echo json_encode($this->obj_arr);
	}

	// Find obj from obj array
	function find($id) {

		foreach ($this->obj_arr as $idx => $obj) {
			if ($obj->id == $id) {
				return $idx;
			}
		}

		return false;
	}

	// Utility function to load model
	function load_model($model) {
		$model_inc = 'models/' . $model . '.php';

		if (file_exists($model_inc)) {
			include_once($model_inc);
		} else {
			echo 'Unable to find model: ' . $model_inc;
		}
	}

	// Utility function to read posted input or else return empty
	function post($var) {
		if (isset($_POST["$var"])) {
			return $_POST["$var"];
		} else {
			return '';
		}
	}

	// Utility function to sanitize input
	function sanitize($input) {
		// strip any html tags
		$input = strip_tags($input);

		// escape any special chars such as &, "", ', <, >
		$input = htmlspecialchars($input);
		return $input;
	}

	// Utility function to return error
	function print_error($err) {
		echo "{\"error\": \"$err\"}";
	}
}
