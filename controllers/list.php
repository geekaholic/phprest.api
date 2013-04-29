<?php

Class ListController extends Controller {

	function __construct() {

	}

	function indexAction() {
		// Default action is readAction
		$this->readAction();
	}

	function readAction() {
		echo 'List World';
	}
}

