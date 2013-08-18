<?php

Class HelloModel extends Model {

	var $id,
		$msg;

	function __construct() {
		parent::__construct();
		$this->id = time();
		$this->msg = 'Hello World!';
	}

	function greeting() {
		return $this->msg;
	}
}
