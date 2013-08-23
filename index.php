<?php

// Simple router to load what we need
// e.g: http://localhost/phprest.api/index.php/foo/bar
// Create FooController class in controllers/foo.php
// with function barAction()

// Author: Bud Siddhisena <bud@geekaholic.org>
// License: http://www.wtfpl.net/txt/copying/

// Extract URI components from path
$uri_parts = preg_split('!/!', preg_replace('!.*index.php[^a-z]*!', '', $_SERVER['PHP_SELF']));

// Assume the first two args as controller, action
$controller = array_shift($uri_parts); 
$action = array_shift($uri_parts); 

// Include base model & controller
require('system/models/model.php');
require('system/controllers/controller.php');

// Set default controller / action
$controller = ($controller) ? $controller : 'main';
$action = ($action) ? $action : 'index';

// Include controller
$inc_file = "controllers/${controller}.php";
if (file_exists("$inc_file")) {
	include($inc_file);
} else {
	die("Controller file " . $inc_file . ' not found!');
}

// Prevent caching
session_cache_limiter('nocache');

// Call controller / action
$class = ucfirst($controller) . 'Controller';
$class_action = $action . 'Action';

$main = new $class();
$main->$class_action($uri_parts);

