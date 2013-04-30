<?php

Class ListController extends Controller {

	var $lists;

	function __construct() {

		// Call base class constructor
		parent::__construct($this->lists);

		// Load list model
		$this->load_model('list_model');

		// Enable session support
		session_start();

		// Restore saved list or create new
 		if (!(isset($_SESSION['lists']))) {
			// Create new session
			$_SESSION['lists'] = array();
		}

		$this->lists = &$_SESSION['lists'];
	}

	function indexAction() {
		// Default action is readAction
		$this->readAction();
	}

	// Create list
	function createAction() {

		// Read input
		$data = array (
			'id' => time(),
			'name' => $this->sanitize($this->post('name')),
			'due_date' => $this->sanitize($this->post('due_date')),
		);

		// Create a new list
		$list = new ListModel();
		$list->set($data);

		// Save list to lists array
		array_push($this->lists, $list);

		// Return added list
		echo json_encode($list);
	}

	// Read lists
	function readAction() {

		echo json_encode($this->lists);
	}

	// Update list
	function updateAction() {
		// Read input
		$id = (int) $this->sanitize($this->post('id'));
		$name = $this->sanitize($this->post('name'));
		$due_date = $this->sanitize($this->post('due_date'));
		
		$idx = $this->find($id);
		if ($idx === false) {
			$this->print_error('Invalid List');
			return false;
		} else {
			// Perform update
			$this->lists[$idx]->set(array('id' => $id, 'name' => $name, 'due_date' => $due_date));

			// Return updated
			echo json_encode($this->lists[$idx]);
		}
	}

	// Delete list
	function deleteAction() {
		// Read input
		$id = (int) $this->sanitize($this->post('id'));

		$idx = $this->find($id);
		if ($idx === false) {
			$this->print_error('Invalid List');
			return false;
		} else {
			// Return deleted
			echo json_encode($this->lists[$idx]);

			// Perform delete
			unset($this->lists[$idx]);

			// Vacuum array to reindex
			$this->lists = array_values($this->lists);
		}
	}

	// Find list from lists
	function find($id) {

		foreach ($this->lists as $idx => $obj) {
			if ($obj->id == $id) {
				return $idx;
			}
		}

		return false;
	}

}

