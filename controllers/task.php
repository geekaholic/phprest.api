<?php

Class TaskController extends Controller {

	var $tasks;

	function __construct() {

		// Load task model
		$this->load_model('task_model');

		// Enable session support
		session_start();

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
			echo json_encode('false');
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

			// Vacuum array for holes
			$this->tasks = array_values($this->tasks);
		} else {
			echo json_encode('false');
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

}

