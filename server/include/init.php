<?php

error_reporting(E_ALL | E_STRICT & ~E_DEPRECATED);

// Include all needed classes
include 'JsonRequest.php';
include 'JsonResponse.php';
include 'MysqliBinder.php';

// Create request, response and db-connection
$request = new JsonRequest();
$response = new JsonResponse();
$db = new MysqliBinder('127.0.0.1:3306', 'root', 'plovdiv81', 'telbook');
$db->response = $response;

// Handle all php-errors and display them in JSON
ini_set('display_errors', 0);

set_error_handler(function($errno, $errstr, $errfile, $errline) use ($response) {
	//$response->code(500);
	$response->error("[$errfile:$errline] ($errno) $errstr");
	return true;
}, E_ALL);

register_shutdown_function(function() use ($response) {
	if(!is_null($error = error_get_last())) {
		$response->error('['.$error['file'].':'.$error['line'].'] '.$error['message']);
		$response->code(500);
	}
});
