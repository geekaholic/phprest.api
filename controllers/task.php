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

		// Call base class constructor
		parent::__construct($this->tasks);
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
		$task = TaskModel::create();
		$task->set($data);

		// Save task to tasks array
		array_push($this->tasks, $task);

		// Return added task
		echo json_encode($task);
	}

	// Read task
	function readAction() {

		// Read optional list_id
		$list_id = (int) $this->sanitize($this->post('list_id'));

		if ($list_id && $this->exists_list($list_id)) {
			// Filter by list_id
			echo json_encode($this->filter_tasks($list_id));
		} else {
			// Return all tasks
			echo json_encode($this->tasks);
		}
	}

	// Update task
	function updateAction() {

		// Read input
		$data = array (
			'id' => (int) $this->sanitize($this->post('id')),
			'name' => $this->sanitize($this->post('name')),
			'list_id' => (int) $this->sanitize($this->post('list_id')),
			'description' => $this->sanitize($this->post('description')),
			'due_date' => $this->sanitize($this->post('due_date')),
			'completed' => $this->sanitize($this->post('completed')),
			);

		// Check required
		if (!$data['id']) {
			$this->print_error('Required field id missing');
			return false;
		}

		// Check if list_id exists if we're modifying it
		if ($data['list_id'] && !$this->exists_list($data['list_id'])) {
			$this->print_error('Invalid List');
			return false;
		}

		// Sanitize completed
		$data['completed'] =  ($data['completed']=='true') ? true : false;
		
		$idx = $this->find($data['id']);
		if ($idx === false) {
			$this->print_error('Invalid Task');
			return false;
		} else {
			// Perform update
			$this->tasks[$idx]->set($data);

			// Return updated
			echo json_encode($this->tasks[$idx]);
		}
	}

	// Delete Tasks
	function deleteAction() {
		// Read input
		$id = (int) $this->sanitize($this->post('id'));

		$idx = $this->find($id);
		if ($idx === false) {
			$this->print_error('Invalid Task');
			return false;
		} else {
			// Return deleted
			echo json_encode($this->tasks[$idx]);

			// Perform delete
			unset($this->tasks[$idx]);

			// Vacuum array to reindex
			$this->tasks = array_values($this->tasks);
		}
	}

	// Complete Task
	function completeAction() {
		// Read input
		$id = (int) $this->sanitize($this->post('id'));

		$idx = $this->find($id);
		if ($idx === false) {
			$this->print_error('Invalid Task');
			return false;
		} else {
			// Perform update
			$this->tasks[$idx]->set(array('id' => $id, 'completed' => true));

			// Return updated
			echo json_encode($this->tasks[$idx]);
		}

	}

	// Set Alarm interval
	function alarmAction() {
		// Read input
		$id = (int) $this->sanitize($this->post('id'));
		$interval = (int) $this->sanitize($this->post('interval'));

		$idx = $this->find($id);
		if ($idx === false) {
			$this->print_error('Invalid Task');
			return false;
		} else {
			// Set alarm 
			if(!$this->tasks[$idx]->set_alarm($interval)) {
				$this->print_error('Invalid Alarm Interval');
				return false;
			}

			// Return updated
			echo json_encode($this->tasks[$idx]);
		}

	}

	// Extra : Clone task
	function cloneAction() {
		// Read input
		$id = (int) $this->sanitize($this->post('id'));

		$idx = $this->find($id);
		if ($idx === false) {
			$this->print_error('Invalid Task');
			return false;
		} else {
			// Clone found array
			$data = get_object_vars($this->tasks[$idx]);

			// Create new id
			$data['id'] = time();

			$cloned_task = TaskModel::create();
			$cloned_task->set($data);

			// Save task to tasks array
			array_push($this->tasks, $cloned_task);

			// Return clone
			echo json_encode($cloned_task);
		}
	}

	// Check if list exists and return it
	function exists_list($id) {
		foreach ($this->lists as $idx => $obj) {
			if ($obj->id == $id) {
				return true;
			}
		}

		return false;
	}

	// Return tasks of a given list
	function filter_tasks($list_id) {
		$filtered_tasks = array();

		foreach ($this->tasks as $idx => $obj) {
			if ($obj->list_id == $list_id) {
				array_push($filtered_tasks, $obj);
			}
		}

		return $filtered_tasks;
	}
}

