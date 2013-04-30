<?php

Class TaskController extends Controller {

	var $tasks,
		$lists;

	function __construct() {

		// Load task & list models
		$this->load_model('task_model');
		$this->load_model('list_model');

		// Enable session support
		session_start();

		// Restore saved list or can't continue
 		if (!(isset($_SESSION['lists']))) {
			$this->print_error('No lists found');
			exit;
		}

		$this->lists = &$_SESSION['lists'];

		// Restore saved task or create new
 		if (!(isset($_SESSION['tasks']))) {
			// Create new session
			$_SESSION['tasks'] = array();
		}

		$this->tasks = &$_SESSION['tasks'];
	}

	function indexAction() {
		// Default action is readAction
		$this->readAction();
	}

	// Create task
	function createAction() {

		// Read input
		$data = array (
			'id' => time(),
			'name' => $this->sanitize($this->post('name')),
			'list_id' => (int) $this->sanitize($this->post('list_id')),
			'description' => $this->sanitize($this->post('description')),
			'due_date' => $this->sanitize($this->post('due_date')),
			'completed' => false,
			);

		// Check required
		if (!$data['name'] || !$data['list_id']) {
			$this->print_error('Required fields name or list_id missing');
			return false;
		}

		// Check if list_id exists
		if (!$this->exists_list($data['list_id'])) {
			$this->print_error('Invalid List');
			return false;
		}

		// Create a new task
		$task = new TaskModel();
		$task->set($data);

		// Save task to tasks array
		array_push($this->tasks, $task);

		// Return added task
		echo json_encode($task);
	}

	// Read tasks
	function readAction() {

		echo json_encode($this->tasks);
	}

	// Update task
	function updateAction() {
		// Read input
		$id = (int) $this->sanitize($this->post('id'));
		$name = $this->sanitize($this->post('name'));
		$due_date = $this->sanitize($this->post('due_date'));
		
		$idx = $this->find($id);
		if ($idx) {
			// Perform update
			$this->tasks[$idx]->set(array('id' => $id, 'name' => $name, 'due_date' => $due_date));

			// Return updated
			echo json_encode($this->tasks[$idx]);
		} else {
			$this->print_error('Invalid Task');
			return false;
		}
	}

	// Delete task
	function deleteAction() {
		// Read input
		$id = (int) $this->sanitize($this->post('id'));

		$idx = $this->find($id);
		if ($idx) {
			// Return deleted
			echo json_encode($this->tasks[$idx]);

			// Perform delete
			unset($this->tasks[$idx]);

			// Vacuum array to reindex
			$this->tasks = array_values($this->tasks);
		} else {
			$this->print_error('Invalid Task');
			return false;
		}
	}

	// Find task from tasks
	function find($id) {
		for ($i=0; $i < count($this->tasks); $i++) {
			if (isset($this->tasks[$i]) && $this->tasks[$i]->id == $id) {
				return $i;
			}
		}
		return false;
	}

	// Check if list exists and return it
	function exists_list($id) {
		for ($i=0; $i < count($this->lists); $i++) {
			if (isset($this->lists[$i]) && $this->lists[$i]->id == $id) {
				return $i;
			}
		}
		return false;
	}


}

