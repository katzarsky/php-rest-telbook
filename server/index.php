<?php

error_reporting(E_ALL | E_STRICT & ~E_DEPRECATED);

// Include all needed classes
include 'include/JsonRequest.php';
include 'include/JsonResponse.php';
include 'include/MysqliBinder.php';

// Create response. if something is wrong - at least we can tell the client.
$response = new JsonResponse();

// Handle all php-errors and display them in JSON
ini_set('display_errors', 0);

set_error_handler(function($errno, $errstr, $errfile, $errline) use ($response) {
	//$response->code(500);
	$response->error("[$errfile LINE:$errline] $errstr");
	return true;
}, E_ALL | E_NOTICE);

register_shutdown_function(function() use ($response) {
	if(!is_null($error = error_get_last())) {
		$response->error('['.$error['file'].' LINE:'.$error['line'].'] '.$error['message']);
		$response->code(500);
		echo $response->render();
	}
});

// Create request, and db-connection
$request = new JsonRequest();
$db = new MysqliBinder('127.0.0.1:3306', 'root', '', 'telbook');
if($db->connect_errno) {
	$response->code(500);
	$response->error('Cannot connect to database.');
	echo $response->render();
	exit();
}

$db->response = $response;

include 'router.php';
