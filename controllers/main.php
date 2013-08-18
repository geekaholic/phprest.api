<?php

Class MainController extends Controller {

	function __construct() {

		// Load model
		$this->load_model('hello_model');

		// Call base class constructor
		parent::__construct($this->lists);

	}

	// Default action
	function indexAction() {

		$hello_obj = new HelloModel();

		// Prepare output 
		$data_out = array (
			'id' => $hello_obj->id,
			'msg' => $hello_obj->greeting()
		);

		// Return data 
		echo header('Content-type: application/json');
		echo json_encode($data_out);
	}

	// Custom action
	function goodbyeAction() {
		
		// Prepare output 
		$data_out = array (
			'id' => time(),
			'msg' => 'Goodbye cruel World!'
		);

		// Return data as XML
		// Credit : http://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
		$xml = new SimpleXMLElement('<root/>');
		array_walk_recursive(array_flip($data_out), array ($xml, 'addChild'));
		echo header('Content-type: text/xml; charset=utf-8');
		echo $xml->asXML();
	}
}

