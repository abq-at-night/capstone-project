<?php
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * API for signing out
 *
 * @author Hunter Callaway <jcallaway3@cnm.edu>
 **/
//Verify the XSRF challenge.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//Prepare the default error message.
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//Grab the mySQL connection.
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort23/atnight.ini");
	//Determine which HTTP method was used.
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "GET") {
		$_SESSION = [];
		$reply->message = "You are now signed out.";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
	header("Content-type: application/json");
	if($reply->data === null) {
		unset($reply->data);
	}
	//Encode and return reply to front-end caller.
	echo json_encode($reply);