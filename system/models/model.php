<?php

class Model {

	// Constructor
	function __construct() {

	}

	// Set properties
	function set($data) {
		foreach ($data as $attr=>$val) {
			if (property_exists($this, $attr)) {
				$this->$attr = $data[$attr];
			}
		}
	}
}
