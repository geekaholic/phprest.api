<?php

Class MainController extends Controller {

// This is the default controller with default indexAction
// Other actions are examples and should be removed

	function __construct() {
		// Load model
		$this->load_model('hello_model');

		// Call base constructor
		parent::__construct();

	}

	// Default action
	function indexAction($uri_parts) {

		$hello_obj = new HelloModel();

		// Prepare output 
		$data_out = array (
			'id' => $hello_obj->id,
			'msg' => $hello_obj->greeting() . ' ' . implode(', ', $uri_parts)
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

	// Default action when no action specified in URI and REST verb is POST
	function postAction() {
		$data_out = array (
			'msg' => 'Default postAction called',
			'data' => $_POST
		);

		echo json_encode($data_out);
	}

	// Default action when no action specified in URI and REST verb is PUT
	function putAction() {
		// Since PHP doesn't have a native $_PUT the framework populates $_GET
		$data_out = array (
			'msg' => 'Default putAction called',
			'data' => $_GET
		);

		echo json_encode($data_out);
	}

	// Default action when no action specified in URI and REST verb is DELETE
	function deleteAction() {
		echo 'Default deleteAction called';
	}

}

