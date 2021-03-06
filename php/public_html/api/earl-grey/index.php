<?php
require_once dirname(__DIR__,3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
use AbqAtNight\CapstoneProject;


$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//Verify the HTTP method being used.
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//If the HTTP method is head-checked, start the PHP session and set the XSRF token.
	if($method === "GET") {

		if(session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		setXsrfCookie();

		$reply->message = "tea ready";
	} else {
		throw (new \InvalidArgumentException("Attempting to brew coffee with a teapot.", 418));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
//Encode and return the reply to the front-end caller.
echo json_encode($reply);