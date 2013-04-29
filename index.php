<?php

// Simple router to load what we need
// e.g: http://localhost/todo.api/index.php/foo/bar
// Create FooController class in controllers/foo.php
// with function barAction()

list($controller, $action) = preg_split('!/!', preg_replace('!.*index.php[^a-z]*!', '', $_SERVER['PHP_SELF']));

// set default controller / action
$controller = ($controller) ? $controller : 'main';
$action = ($action) ? $action : 'index';

// Include base model & controller
require('system/models/model.php');
require('system/controllers/controller.php');

// Include controller
$inc_file = "controllers/${controller}.php";
if (file_exists("$inc_file")) {
	include($inc_file);
}

// Call controller / action
$class = ucfirst($controller) . 'Controller';
$class_action = $action . 'Action';

$main = new $class;
$main->$class_action();


